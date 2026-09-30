import { db } from "./db.js";
const enc = new TextEncoder();
const hex = b => [...new Uint8Array(b)].map(x => x.toString(16).padStart(2, "0")).join("");
const unhex = s => Uint8Array.from(s.match(/../g) || [], h => parseInt(h, 16));
export async function hash(pw, salt = crypto.getRandomValues(new Uint8Array(16))) {
  const k = await crypto.subtle.importKey("raw", enc.encode(pw), "PBKDF2", false, ["deriveBits"]);
  const bits = await crypto.subtle.deriveBits({ name: "PBKDF2", salt, iterations: 60000, hash: "SHA-256" }, k, 256);
  return hex(salt) + "." + hex(bits);
}
export async function verify(pw, stored) { return (await hash(pw, unhex(stored.split(".")[0]))) === stored; }
let key;
async function hk() {
  if (!key) {
    const g = async () => (await db.query("SELECT v FROM settings WHERE k='jwt'")).rows[0];
    let r = await g();
    if (!r) { await db.query("INSERT INTO settings(k,v) VALUES('jwt',$1) ON CONFLICT DO NOTHING", [hex(crypto.getRandomValues(new Uint8Array(32)))]); r = await g(); }
    key = await crypto.subtle.importKey("raw", enc.encode(r.v), { name: "HMAC", hash: "SHA-256" }, false, ["sign"]);
  }
  return key;
}
const mac = async s => hex(await crypto.subtle.sign("HMAC", await hk(), enc.encode(s)));
export async function sign(p) { const b = hex(enc.encode(JSON.stringify({ ...p, exp: Date.now() + 6048e5 }))); return b + "." + await mac(b); }
export async function check(t) {
  if (!t || !t.includes(".")) return null;
  const [b, s] = t.split(".");
  if ((await mac(b)) !== s) return null;
  const p = JSON.parse(new TextDecoder().decode(unhex(b)));
  return p.exp > Date.now() ? p : null;
}

const SCHEMA = [
"CREATE TABLE IF NOT EXISTS settings(k text PRIMARY KEY, v text)",
"CREATE TABLE IF NOT EXISTS users(id serial PRIMARY KEY, email text UNIQUE NOT NULL, password_hash text NOT NULL, role text NOT NULL CHECK (role IN ('headmaster','teacher','student','staff')), name text NOT NULL, profile_pic text, created_at timestamptz DEFAULT now())",
"CREATE TABLE IF NOT EXISTS classes(id serial PRIMARY KEY, name text NOT NULL)",
"CREATE TABLE IF NOT EXISTS sections(id serial PRIMARY KEY, class_id int REFERENCES classes(id) ON DELETE CASCADE, name text)",
"CREATE TABLE IF NOT EXISTS subjects(id serial PRIMARY KEY, name text NOT NULL)",
"CREATE TABLE IF NOT EXISTS students(user_id int PRIMARY KEY REFERENCES users(id) ON DELETE CASCADE, class_id int REFERENCES classes(id) ON DELETE SET NULL, section text DEFAULT 'A', roll_no int, meal_balance numeric(10,2) DEFAULT 0)",
"CREATE TABLE IF NOT EXISTS teachers(user_id int PRIMARY KEY REFERENCES users(id) ON DELETE CASCADE, subject_ids int[] DEFAULT '{}', salary numeric(10,2) DEFAULT 0)",
"CREATE TABLE IF NOT EXISTS staff(user_id int PRIMARY KEY REFERENCES users(id) ON DELETE CASCADE, department text, role_title text, salary numeric(10,2) DEFAULT 0)",
"CREATE TABLE IF NOT EXISTS timetable(id serial PRIMARY KEY, class_id int REFERENCES classes(id) ON DELETE CASCADE, day text, period int, subject_id int REFERENCES subjects(id) ON DELETE CASCADE, teacher_id int REFERENCES users(id) ON DELETE SET NULL, UNIQUE(class_id,day,period))",
"CREATE TABLE IF NOT EXISTS attendance(id serial PRIMARY KEY, student_id int REFERENCES users(id) ON DELETE CASCADE, date date, status text, marked_by int REFERENCES users(id) ON DELETE SET NULL, UNIQUE(student_id,date))",
"CREATE TABLE IF NOT EXISTS grades(id serial PRIMARY KEY, student_id int REFERENCES users(id) ON DELETE CASCADE, subject_id int REFERENCES subjects(id) ON DELETE CASCADE, exam_type text, marks numeric, graded_by int, UNIQUE(student_id,subject_id,exam_type))",
"CREATE TABLE IF NOT EXISTS assignments(id serial PRIMARY KEY, title text, description text, due_date date, class_id int REFERENCES classes(id) ON DELETE CASCADE, created_by int REFERENCES users(id) ON DELETE SET NULL)",
"CREATE TABLE IF NOT EXISTS submissions(id serial PRIMARY KEY, assignment_id int REFERENCES assignments(id) ON DELETE CASCADE, student_id int REFERENCES users(id) ON DELETE CASCADE, file_url text, submitted_at timestamptz DEFAULT now(), grade numeric, UNIQUE(assignment_id,student_id))",
"CREATE TABLE IF NOT EXISTS leave_requests(id serial PRIMARY KEY, user_id int REFERENCES users(id) ON DELETE CASCADE, from_date date, to_date date, reason text, status text DEFAULT 'pending', approved_by int)",
"CREATE TABLE IF NOT EXISTS announcements(id serial PRIMARY KEY, title text, body text, audience text DEFAULT 'all', created_by int, created_at timestamptz DEFAULT now())",
"CREATE TABLE IF NOT EXISTS payslips(id serial PRIMARY KEY, user_id int REFERENCES users(id) ON DELETE CASCADE, month text, amount numeric, status text DEFAULT 'paid')",
"CREATE TABLE IF NOT EXISTS menu_items(id serial PRIMARY KEY, name text, price numeric, day text, category text)",
"CREATE TABLE IF NOT EXISTS meal_orders(id serial PRIMARY KEY, student_id int REFERENCES users(id) ON DELETE CASCADE, menu_item_id int REFERENCES menu_items(id) ON DELETE CASCADE, date date, status text DEFAULT 'pending')",
"CREATE TABLE IF NOT EXISTS transactions(id serial PRIMARY KEY, student_id int REFERENCES users(id) ON DELETE CASCADE, amount numeric, type text, timestamp timestamptz DEFAULT now())",
"CREATE TABLE IF NOT EXISTS fees(id serial PRIMARY KEY, student_id int REFERENCES users(id) ON DELETE CASCADE, amount numeric, status text DEFAULT 'pending', month text)",
"CREATE TABLE IF NOT EXISTS expenses(id serial PRIMARY KEY, description text, amount numeric, date date DEFAULT current_date)",
"CREATE TABLE IF NOT EXISTS duties(id serial PRIMARY KEY, user_id int REFERENCES users(id) ON DELETE CASCADE, title text, day text, status text DEFAULT 'todo')",
"CREATE TABLE IF NOT EXISTS audit_logs(id serial PRIMARY KEY, user_id int, action text, at timestamptz DEFAULT now())"
];

let ready = false;
let ensuring;
export async function ensure() {
  if (ready) return;
  if (ensuring) return ensuring;
  ensuring = (async () => {
    // Always run CREATE TABLE IF NOT EXISTS so a partially initialized
    // database can recover instead of assuming audit_logs is the only marker.
    await db.transaction(SCHEMA.map(sql => ({ sql, params: [] })));
    const n = (await db.query("SELECT count(*)::int n FROM users")).rows[0].n;
    if (!n) await seed();
    ready = true;
  })();
  try {
    await ensuring;
  } finally {
    ensuring = null;
  }
}

async function seed() {
  const H = await hash("password123"), T = [], add = (sql, params = []) => T.push({ sql, params });
  const ins = (id, e, r, n) => add("INSERT INTO users(email,password_hash,role,name) VALUES($1,$2,$3,$4)", [e, H, r, n]);
  ins(1, "head@school.test", "headmaster", "Dr. Amina Belkacem");
  ["Karim Mansouri", "Sara Haddad", "Yacine Benali"].forEach((n, i) => ins(2 + i, `t${i + 1}@school.test`, "teacher", n));
  const SN = ["Lina Maamar", "Adam Kaci", "Yasmine Boudia", "Anis Rahmani", "Meriem Saidi", "Walid Tabet", "Ines Ferhat", "Sofiane Bouaza", "Amel Khelifi", "Riad Slimani"];
  SN.forEach((n, i) => ins(5 + i, `s${i + 1}@school.test`, "student", n));
  const SF = [["cafe", "Nadia Cherif", "Cafeteria", "Cafeteria Worker", 1800], ["library", "Omar Zidane", "Library", "Librarian", 2000], ["security", "Rachid Amrani", "Security", "Security Guard", 1700]];
  SF.forEach((f, i) => ins(15 + i, f[0] + "@school.test", "staff", f[1]));
  ["Grade 6", "Grade 7", "Grade 8"].forEach((n, i) => { add("INSERT INTO classes(name) VALUES($1)", [n]); add("INSERT INTO sections(class_id,name) VALUES($1,'A')", [i + 1]); });
  ["Mathematics", "English", "Science", "History", "Art"].forEach((n, i) => add("INSERT INTO subjects(name) VALUES($1)", [n]));
  add("INSERT INTO teachers(user_id,subject_ids,salary) VALUES(2,'{1,4}',3000)");
  add("INSERT INTO teachers(user_id,subject_ids,salary) VALUES(3,'{2,5}',3200)");
  add("INSERT INTO teachers(user_id,subject_ids,salary) VALUES(4,'{3}',3100)");
  SF.forEach((f, i) => add("INSERT INTO staff(user_id,department,role_title,salary) VALUES($1,$2,$3,$4)", [15 + i, f[2], f[3], f[4]]));
  SN.forEach((n, i) => {
    const id = 5 + i;
    add("INSERT INTO students(user_id,class_id,roll_no,meal_balance) VALUES($1,$2,$3,20)", [id, 1 + i % 3, i + 1]);
    add("INSERT INTO transactions(student_id,amount,type) VALUES($1,20,'topup')", [id]);
    add("INSERT INTO fees(student_id,amount,status,month) VALUES($1,500,$2,'September 2026')", [id, id % 3 ? "paid" : "pending"]);
    for (let s = 1; s <= 3; s++) add("INSERT INTO grades(student_id,subject_id,exam_type,marks,graded_by) VALUES($1,$2,'Midterm',$3,2)", [id, s, 60 + (id * 7 + s * 13) % 40]);
    for (let d = 1; d <= 5; d++) add("INSERT INTO attendance(student_id,date,status,marked_by) VALUES($1,current_date-$2::int,$3,2)", [id, d, (id + d) % 7 ? "present" : "absent"]);
  });
  const TM = [0, 2, 3, 4, 2, 3], DAYS = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];
  for (let c = 0; c < 3; c++) DAYS.forEach((d, di) => { for (let p = 1; p <= 4; p++) { const s = (c + di + p) % 5 + 1; add("INSERT INTO timetable(class_id,day,period,subject_id,teacher_id) VALUES($1,$2,$3,$4,$5)", [c + 1, d, p, s, TM[s]]); } });
  const MAIN = [["Chicken couscous", 4.5], ["Beef lasagna", 5], ["Vegetable tajine", 4], ["Grilled fish & rice", 5.5], ["Pizza margherita", 4]];
  DAYS.forEach((d, i) => { add("INSERT INTO menu_items(name,price,day,category) VALUES($1,$2,$3,'Main')", [MAIN[i][0], MAIN[i][1], d]); add("INSERT INTO menu_items(name,price,day,category) VALUES('Fruit cup',1.5,$1,'Snack')", [d]); add("INSERT INTO menu_items(name,price,day,category) VALUES('Fresh juice',1,$1,'Drink')", [d]); });
  [[2, 3000], [3, 3200], [4, 3100], [15, 1800], [16, 2000], [17, 1700]].forEach(([u, a]) => { add("INSERT INTO payslips(user_id,month,amount,status) VALUES($1,'August 2026',$2,'paid')", [u, a]); add("INSERT INTO payslips(user_id,month,amount,status) VALUES($1,'September 2026',$2,'pending')", [u, a]); });
  [["Electricity", 420], ["Cafeteria supplies", 650], ["Building maintenance", 300]].forEach(([d, a]) => add("INSERT INTO expenses(description,amount) VALUES($1,$2)", [d, a]));
  [[15, "Prepare lunch service", "Daily"], [15, "Weekly inventory check", "Friday"], [16, "Catalogue new books", "Monday"], [16, "Send overdue reminders", "Thursday"], [17, "Main gate duty 7-9am", "Daily"], [17, "Evening patrol", "Daily"]].forEach(([u, t, d]) => add("INSERT INTO duties(user_id,title,day) VALUES($1,$2,$3)", [u, t, d]));
  add("INSERT INTO leave_requests(user_id,from_date,to_date,reason) VALUES(2,current_date+7,current_date+9,'Family event')");
  add("INSERT INTO announcements(title,body,audience,created_by) VALUES('Welcome to the new term','Classes are in full swing. Please review the updated timetable and cafeteria menu.','all',1)");
  add("INSERT INTO announcements(title,body,audience,created_by) VALUES('Parent-teacher meeting','Meetings take place this Friday from 2pm in the main hall.','all',1)");
  add("INSERT INTO announcements(title,body,audience,created_by) VALUES('Teacher training day','Mandatory training next Monday. Submit grades beforehand.','teacher',1)");
  add("INSERT INTO assignments(title,description,due_date,class_id,created_by) VALUES('Fractions worksheet','Complete exercises 1-20 on fractions.',current_date+5,1,2)");
  add("INSERT INTO assignments(title,description,due_date,class_id,created_by) VALUES('Essay: My Hero','Write 300 words about a person you admire.',current_date+7,2,3)");
  add("INSERT INTO assignments(title,description,due_date,class_id,created_by) VALUES('Plant cell diagram','Draw and label a plant cell.',current_date+4,3,4)");
  // ids are assigned by serial in insertion order (users 1-17, classes 1-3, subjects 1-5)
  await db.transaction(T);
}