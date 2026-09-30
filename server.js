import fs from "node:fs";
import path from "node:path";
import http from "node:http";
import express from "express";

// Lightweight .env loader so the project does not need dotenv just to run locally.
const envFile = path.resolve(".env");
if (fs.existsSync(envFile)) {
  for (const line of fs.readFileSync(envFile, "utf8").split(/\r?\n/)) {
    const trimmed = line.trim();
    if (!trimmed || trimmed.startsWith("#")) continue;
    const i = trimmed.indexOf("=");
    if (i < 1) continue;
    const key = trimmed.slice(0, i).trim();
    let value = trimmed.slice(i + 1).trim();
    if ((value.startsWith('"') && value.endsWith('"')) || (value.startsWith("'") && value.endsWith("'"))) value = value.slice(1, -1);
    if (!(key in process.env)) process.env[key] = value;
  }
}

const { db, pool } = await import("./lib/db.js");
const { ensure, check, sign, verify } = await import("./lib/core.js");
const routeA = (await import("./lib/routes_a.js")).default;
const routeB = (await import("./lib/routes_b.js")).default;

const app = express();
const PORT = Number(process.env.PORT || 3000);

app.disable("x-powered-by");

// Public frontend configuration. Only non-secret display settings belong here.
app.get("/config.js", (_req, res) => {
  const donationUrl = String(process.env.DONATION_URL || "").trim();
  res.type("application/javascript").send(`window.APP_CONFIG=${JSON.stringify({ donationUrl })};`);
});
app.use(express.json({ limit: "10mb" }));
app.use(express.urlencoded({ extended: false, limit: "10mb" }));
app.use(express.static(path.resolve("public")));

const send = (res, data, status = 200) => res.status(status).json(data);

async function currentUser(req) {
  const header = req.get("authorization") || "";
  const token = header.startsWith("Bearer ") ? header.slice(7) : null;
  const payload = await check(token);
  if (!payload?.id) return null;
  const [user] = (await db.query(`
    SELECT u.id,u.name,u.email,u.role,u.profile_pic,
           st.department AS dept,st.role_title,
           s.class_id,s.section,s.roll_no,s.meal_balance
    FROM users u
    LEFT JOIN staff st ON st.user_id=u.id
    LEFT JOIN students s ON s.user_id=u.id
    WHERE u.id=$1
  `, [payload.id])).rows;
  return user || null;
}

function routeContext(req, res, user) {
  // req.path is the complete URL path (for example /api/dashboard).
  // Strip the /api prefix before handing the route name to the route modules.
  // This fixes /api/dashboard being parsed as `api` instead of `dashboard`.
  const pathParts = req.path.split("/").filter(Boolean);
  if (pathParts[0] === "api") pathParts.shift();
  const a = pathParts[0] || "";
  const b = pathParts[1] || "";
  const c = pathParts[2] || "";
  const Q = req.query || {};
  const B = req.body || {};
  const m = req.method;
  const q = async (sql, params = []) => (await db.query(sql, params)).rows;
  const is = (...roles) => roles.includes(user?.role);
  const no = () => send(res, { error: "Forbidden" }, 403);
  const respond = (data, status = 200) => send(res, data, status);
  const log = async (u, action) => {
    if (u?.id) await q("INSERT INTO audit_logs(user_id,action) VALUES($1,$2)", [u.id, action]);
  };
  return { a, b, c, m, B, U: user, q, send: respond, no, is, log, Q, res, path: pathParts };
}

app.post("/api/login", async (req, res, next) => {
  try {
    const email = String(req.body?.email || "").trim().toLowerCase();
    const password = String(req.body?.password || "");
    if (!email || !password) return send(res, { error: "Email and password are required" }, 400);
    const [user] = (await db.query("SELECT id,name,email,role,password_hash FROM users WHERE lower(email)=lower($1)", [email])).rows;
    if (!user || !(await verify(password, user.password_hash))) return send(res, { error: "Invalid email or password" }, 401);
    return send(res, { token: await sign({ id: user.id, role: user.role }), user: { id: user.id, name: user.name, email: user.email, role: user.role } });
  } catch (e) { next(e); }
});

app.post("/api/logout", (_req, res) => send(res, { ok: true }));

app.get("/api/me", async (req, res, next) => {
  try {
    const user = await currentUser(req);
    if (!user) return send(res, { error: "Authentication required" }, 401);
    return send(res, { user });
  } catch (e) { next(e); }
});

app.all("/api/*splat", async (req, res, next) => {
  try {
    const user = await currentUser(req);
    if (!user) return send(res, { error: "Authentication required" }, 401);
    const context = routeContext(req, res, user);
    let handled = await routeA(context);
    if (!handled) handled = await routeB(context);
    if (!handled) return send(res, { error: "API endpoint not found" }, 404);
  } catch (e) { next(e); }
});

app.get("*splat", (_req, res) => {
  res.sendFile(path.resolve("public/index.html"));
});

app.use((err, _req, res, _next) => {
  console.error(err);
  if (res.headersSent) return;
  send(res, { error: "Internal server error" }, 500);
});

await ensure();
const server = http.createServer(app);
server.listen(PORT, () => {
  console.log(`School Management System running at http://localhost:${PORT}`);
});

async function shutdown() {
  await pool.end();
  server.close(() => process.exit(0));
}
process.on("SIGINT", shutdown);
process.on("SIGTERM", shutdown);
