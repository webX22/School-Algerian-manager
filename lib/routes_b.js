import fs from "node:fs/promises";
import path from "node:path";

const UPLOAD_DIR = path.resolve(process.env.UPLOAD_DIR || "./uploads");

async function putFile(key, buffer, contentType) {
  const filePath = path.join(UPLOAD_DIR, ...key.split("/"));
  await fs.mkdir(path.dirname(filePath), { recursive: true });
  await fs.writeFile(filePath, buffer);
  await fs.writeFile(filePath + ".meta.json", JSON.stringify({ contentType }, null, 2));
}

async function getFile(key) {
  const safe = path.normalize(key).replace(/^([.][.][\\/])+/, "");
  const filePath = path.resolve(UPLOAD_DIR, safe);
  if (!filePath.startsWith(UPLOAD_DIR + path.sep) && filePath !== UPLOAD_DIR) return null;
  try {
    const buffer = await fs.readFile(filePath);
    let contentType = "application/octet-stream";
    try { contentType = JSON.parse(await fs.readFile(filePath + ".meta.json", "utf8")).contentType || contentType; } catch {}
    return { buffer, contentType };
  } catch {
    return null;
  }
}
const today = () => new Date().toISOString().slice(0, 10);
const decode = b64 => Uint8Array.from(atob(b64), c => c.charCodeAt(0));
export default async function (x) {
  const { a, b, c, m, B, U, q, send, no, is, log, Q, res, path } = x;
  const cafe = async () => is("headmaster") || (is("staff") && U.dept === "Cafeteria");
  const cls = async () => (await q("SELECT class_id FROM students WHERE user_id=$1", [U.id]))[0]?.class_id ?? null;
  const save = async (folder, d) => {
    const buf = decode(d.data);
    if (buf.length > 4e6) throw new Error("File too large (4MB max)");
    const key = folder + "/" + Date.now() + "-" + (d.filename || "file").replace(/[^\w.-]/g, "_");
    await putFile(key, buf, d.contentType || "application/octet-stream");
    return "/api/files/" + key;
  };

  if (a === "files" && m === "GET") {
    const f = await getFile(path.slice(1).join("/"));
    if (!f) return send({ error: "Not found" }, 404);
    res.setHeader("Content-Type", f.contentType || "application/octet-stream");
    res.send(f.buffer); return 1;
  }
  if (a === "profile-pic" && m === "POST") {
    if (!B.data) return send({ error: "Image required" }, 400);
    const url = await save("avatars", B.filename ? B : { ...B, filename: "u" + U.id });
    await q("UPDATE users SET profile_pic=$2 WHERE id=$1", [U.id, url]);
    return send({ url });
  }

  if (a === "assignments") {
    if (is("staff")) return no();
    if (m === "GET") return send(await q("SELECT a.id,a.title,a.description,to_char(a.due_date,'YYYY-MM-DD') due_date,c.name class,a.class_id,u.name teacher,(SELECT sb.file_url FROM submissions sb WHERE sb.assignment_id=a.id AND sb.student_id=$1::int) submitted FROM assignments a JOIN classes c ON c.id=a.class_id LEFT JOIN users u ON u.id=a.created_by WHERE ($2::int IS NULL OR a.class_id=$2::int) AND ($3::int IS NULL OR a.created_by=$3::int) ORDER BY a.due_date", [U.id, is("student") ? await cls() : null, is("teacher") ? U.id : null]));
    if (m === "POST") {
      if (!is("teacher", "headmaster")) return no();
      if (!B.title || !B.class_id || !B.due_date) return send({ error: "Title, class and due date are required" }, 400);
      await q("INSERT INTO assignments(title,description,due_date,class_id,created_by) VALUES($1,$2,$3,$4,$5)", [B.title, B.description || "", B.due_date, B.class_id, U.id]);
      await log(U, "Created assignment " + B.title); return send({ ok: 1 }, 201);
    }
  }
  if (a === "submissions") {
    if (is("staff")) return no();
    if (m === "POST") {
      if (!is("student")) return no();
      if (!B.assignment_id || !B.data) return send({ error: "Assignment and file are required" }, 400);
      const url = await save("submissions", B);
      await q("INSERT INTO submissions(assignment_id,student_id,file_url) VALUES($1,$2,$3) ON CONFLICT(assignment_id,student_id) DO UPDATE SET file_url=$3,submitted_at=now()", [B.assignment_id, U.id, url]);
      return send({ ok: 1, url }, 201);
    }
    if (m === "GET") return send(await q("SELECT sb.id,a.title assignment,u.name student,sb.file_url,to_char(sb.submitted_at,'YYYY-MM-DD HH24:MI') submitted_at,sb.grade FROM submissions sb JOIN assignments a ON a.id=sb.assignment_id JOIN users u ON u.id=sb.student_id WHERE ($1::int IS NULL OR sb.student_id=$1::int) AND ($2::int IS NULL OR a.created_by=$2::int) ORDER BY sb.submitted_at DESC", [is("student") ? U.id : null, is("teacher") ? U.id : null]));
    if (m === "PUT" && b) {
      if (!is("teacher", "headmaster")) return no();
      if (!(B.grade >= 0 && B.grade <= 100)) return send({ error: "Grade must be 0-100" }, 400);
      await q("UPDATE submissions SET grade=$2 WHERE id=$1", [b, B.grade]); await log(U, "Graded submission #" + b);
      return send({ ok: 1 });
    }
  }

  if (a === "leave-requests") {
    if (m === "GET") return send(await q("SELECT l.id,u.name applicant,u.role,to_char(l.from_date,'YYYY-MM-DD') from_date,to_char(l.to_date,'YYYY-MM-DD') to_date,l.reason,l.status FROM leave_requests l JOIN users u ON u.id=l.user_id WHERE ($1::int IS NULL OR l.user_id=$1::int) ORDER BY l.id DESC", [is("headmaster") ? null : U.id]));
    if (m === "POST") {
      if (is("student", "headmaster")) return no();
      if (!B.from_date || !B.to_date || !B.reason || B.to_date < B.from_date) return send({ error: "Valid dates (end after start) and a reason are required" }, 400);
      await q("INSERT INTO leave_requests(user_id,from_date,to_date,reason) VALUES($1,$2,$3,$4)", [U.id, B.from_date, B.to_date, B.reason]);
      return send({ ok: 1 }, 201);
    }
    if (m === "PUT" && c === "approve") {
      if (!is("headmaster")) return no();
      if (!["approved", "rejected"].includes(B.status)) return send({ error: "Status must be approved or rejected" }, 400);
      await q("UPDATE leave_requests SET status=$2,approved_by=$3 WHERE id=$1", [b, B.status, U.id]); await log(U, `Leave #${b} ${B.status}`);
      return send({ ok: 1 });
    }
  }

  if (a === "announcements") {
    if (m === "GET") return send(await q("SELECT a.id,a.title,a.body,a.audience,to_char(a.created_at,'YYYY-MM-DD') date,u.name author FROM announcements a LEFT JOIN users u ON u.id=a.created_by WHERE $1::boolean OR a.audience IN ('all',$2::text) ORDER BY a.id DESC", [is("headmaster"), U.role]));
    if (m === "POST") {
      if (!is("headmaster")) return no();
      if (!B.title || !B.body || !["all", "teacher", "student", "staff"].includes(B.audience || "all")) return send({ error: "Title, body and a valid audience are required" }, 400);
      await q("INSERT INTO announcements(title,body,audience,created_by) VALUES($1,$2,$3,$4)", [B.title, B.body, B.audience || "all", U.id]);
      await log(U, "Posted announcement " + B.title); return send({ ok: 1 }, 201);
    }
  }

  if (a === "menu") {
    if (m === "GET") return send(await q("SELECT * FROM menu_items ORDER BY array_position(ARRAY['Monday','Tuesday','Wednesday','Thursday','Friday'],day),id"));
    if (!(await cafe())) return no();
    if (m === "POST") {
      if (!B.name || !(B.price >= 0) || !B.day) return send({ error: "Name, day and a valid price are required" }, 400);
      await q("INSERT INTO menu_items(name,price,day,category) VALUES($1,$2,$3,$4)", [B.name, B.price, B.day, B.category || "Main"]); await log(U, "Added menu item " + B.name);
      return send({ ok: 1 }, 201);
    }
    if (m === "PUT" && b) { await q("UPDATE menu_items SET price=$2 WHERE id=$1", [b, B.price]); await log(U, "Changed price #" + b); return send({ ok: 1 }); }
    if (m === "DELETE" && b) { await q("DELETE FROM menu_items WHERE id=$1", [b]); await log(U, "Removed menu item #" + b); return send({ ok: 1 }); }
  }
  if (a === "meal-orders") {
    if (m === "GET") {
      if (!is("student") && !(await cafe())) return no();
      return send(await q("SELECT o.id,u.name student,mi.name item,mi.price,to_char(o.date,'YYYY-MM-DD') date,o.status FROM meal_orders o JOIN users u ON u.id=o.student_id JOIN menu_items mi ON mi.id=o.menu_item_id WHERE ($1::int IS NULL OR o.student_id=$1::int) ORDER BY o.date DESC,o.id DESC LIMIT 200", [is("student") ? U.id : null]));
    }
    if (m === "POST") {
      if (!is("student")) return no();
      const [it] = await q("SELECT * FROM menu_items WHERE id=$1", [B.menu_item_id]);
      if (!it) return send({ error: "Menu item not found" }, 404);
      const [ok] = await q("UPDATE students SET meal_balance=meal_balance-$2 WHERE user_id=$1 AND meal_balance>=$2 RETURNING meal_balance", [U.id, it.price]);
      if (!ok) return send({ error: "Insufficient meal balance - please top up" }, 402);
      await q("INSERT INTO meal_orders(student_id,menu_item_id,date) VALUES($1,$2,$3)", [U.id, it.id, B.date || today()]);
      await q("INSERT INTO transactions(student_id,amount,type) VALUES($1,$2,'meal')", [U.id, -it.price]);
      return send({ balance: ok.meal_balance }, 201);
    }
    if (m === "PUT" && b) { if (!(await cafe())) return no(); await q("UPDATE meal_orders SET status=$2 WHERE id=$1", [b, B.status || "served"]); return send({ ok: 1 }); }
  }
  if (a === "meal-topup" && m === "POST") {
    // Students may top up their own balance; cafeteria staff/headmaster may
    // top up a selected student.
    const sid = is("student") ? U.id : B.student_id;
    if (!is("student") && !(await cafe())) return no();
    if (!sid || !(B.amount > 0 && B.amount <= 500)) return send({ error: "Amount must be between 1 and 500" }, 400);
    const [r] = await q("UPDATE students SET meal_balance=meal_balance+$2 WHERE user_id=$1 RETURNING meal_balance", [sid, B.amount]);
    if (!r) return send({ error: "Student not found" }, 404);
    await q("INSERT INTO transactions(student_id,amount,type) VALUES($1,$2,'topup')", [sid, B.amount]); await log(U, `Top-up $${B.amount} for #${sid}`);
    return send({ balance: r.meal_balance }, 201);
  }
  if (a === "balance") return send((await q("SELECT meal_balance FROM students WHERE user_id=$1", [U.id]))[0] || { meal_balance: 0 });

  if (a === "payslips" && m === "GET") {
    if (is("student")) return no();
    return send(await q("SELECT p.id,u.name employee,p.month,p.amount,p.status FROM payslips p JOIN users u ON u.id=p.user_id WHERE ($1::int IS NULL OR p.user_id=$1::int) ORDER BY p.id DESC", [is("headmaster") ? null : U.id]));
  }
  if (a === "reports" && m === "GET") {
    if (!is("headmaster")) return no();
    const [s] = await q("SELECT (SELECT coalesce(sum(amount),0) FROM fees WHERE status='paid') fees_collected,(SELECT coalesce(sum(amount),0) FROM fees WHERE status='pending') fees_pending,(SELECT coalesce(sum(amount),0) FROM payslips WHERE status='paid') salaries_paid,(SELECT coalesce(sum(amount),0) FROM expenses) expenses,(SELECT coalesce(sum(amount),0) FROM transactions WHERE type='topup') meal_topups");
    return send({ summary: s, expenses: await q("SELECT id,description,amount,to_char(date,'YYYY-MM-DD') date FROM expenses ORDER BY id DESC") });
  }
  if (a === "expenses" && m === "POST") {
    if (!is("headmaster")) return no();
    if (!B.description || !(B.amount > 0)) return send({ error: "Description and amount are required" }, 400);
    await q("INSERT INTO expenses(description,amount) VALUES($1,$2)", [B.description, B.amount]); await log(U, "Recorded expense " + B.description);
    return send({ ok: 1 }, 201);
  }
  if (a === "audit-logs" && m === "GET") {
    if (!is("headmaster")) return no();
    return send(await q("SELECT l.id,u.name \"user\",l.action,to_char(l.at,'YYYY-MM-DD HH24:MI') at FROM audit_logs l LEFT JOIN users u ON u.id=l.user_id ORDER BY l.id DESC LIMIT 200"));
  }
  if (a === "duties") {
    if (m === "GET") { if (is("student", "teacher")) return no(); return send(await q("SELECT d.id,u.name assignee,d.title,d.day,d.status FROM duties d JOIN users u ON u.id=d.user_id WHERE ($1::int IS NULL OR d.user_id=$1::int) ORDER BY d.id", [is("headmaster") ? null : U.id])); }
    if (m === "POST") { if (!is("headmaster") || !B.user_id || !B.title) return no(); await q("INSERT INTO duties(user_id,title,day) VALUES($1,$2,$3)", [B.user_id, B.title, B.day || "Daily"]); return send({ ok: 1 }, 201); }
    if (m === "PUT" && b) { await q("UPDATE duties SET status=$2 WHERE id=$1 AND ($3::boolean OR user_id=$4)", [b, B.status === "done" ? "done" : "todo", is("headmaster"), U.id]); return send({ ok: 1 }); }
  }
  return 0;
}