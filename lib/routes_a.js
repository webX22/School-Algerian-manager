import { hash } from "./core.js";
const DAYS = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];
export default async function (x) {
  const { a, b, m, B, U, q, send, no, is, log, Q } = x;
  const cls = async () => (await q("SELECT class_id FROM students WHERE user_id=$1", [U.id]))[0]?.class_id ?? null;

  if (a === "meta") return send({ classes: await q("SELECT * FROM classes ORDER BY id"), subjects: await q("SELECT * FROM subjects ORDER BY id"), teachers: await q("SELECT id,name FROM users WHERE role='teacher' ORDER BY id") });

  if (a === "dashboard") {
    const day = new Date().toLocaleDateString("en-US", { weekday: "long" });
    let cards = [], table = null;
    if (is("headmaster")) {
      const [c] = await q("SELECT (SELECT count(*) FROM students)::int s,(SELECT count(*) FROM teachers)::int t,(SELECT count(*) FROM staff)::int f,(SELECT coalesce(sum(amount),0) FROM fees WHERE status='paid')+(SELECT coalesce(sum(amount),0) FROM transactions WHERE type='topup') rev,(SELECT coalesce(round(100.0*count(*) FILTER (WHERE status='present')/greatest(count(*),1)),0) FROM attendance) att,(SELECT count(*) FROM leave_requests WHERE status='pending')::int p");
      cards = [["Students", c.s], ["Teachers", c.t], ["Staff", c.f], ["Revenue", "$" + c.rev], ["Attendance", c.att + "%"], ["Pending approvals", c.p]];
      table = ["Recent announcements", await q("SELECT title,audience,to_char(created_at,'YYYY-MM-DD') date FROM announcements ORDER BY id DESC LIMIT 5")];
    } else if (is("teacher")) {
      const sch = await q("SELECT t.period,s.name subject,c.name class FROM timetable t JOIN subjects s ON s.id=t.subject_id JOIN classes c ON c.id=t.class_id WHERE t.teacher_id=$1 AND t.day=$2 ORDER BY t.period", [U.id, day]);
      const [g] = await q("SELECT count(*)::int n FROM submissions s JOIN assignments a ON a.id=s.assignment_id WHERE a.created_by=$1 AND s.grade IS NULL", [U.id]);
      const [cl] = await q("SELECT count(DISTINCT class_id)::int n, (SELECT count(*) FROM students WHERE class_id IN (SELECT class_id FROM timetable WHERE teacher_id=$1))::int stu FROM timetable WHERE teacher_id=$1", [U.id]);
      cards = [["Periods today", sch.length], ["Pending grading", g.n], ["Classes", cl.n], ["Students taught", cl.stu]];
      table = ["Today's schedule (" + day + ")", sch];
    } else if (is("student")) {
      const [s] = await q("SELECT class_id,meal_balance FROM students WHERE user_id=$1", [U.id]);
      const tt = await q("SELECT t.period,sub.name subject,u.name teacher FROM timetable t JOIN subjects sub ON sub.id=t.subject_id LEFT JOIN users u ON u.id=t.teacher_id WHERE t.class_id=$1 AND t.day=$2 ORDER BY t.period", [s?.class_id ?? null, day]);
      const [as] = await q("SELECT count(*)::int n FROM assignments a WHERE class_id=$1 AND due_date>=current_date AND NOT EXISTS(SELECT 1 FROM submissions x WHERE x.assignment_id=a.id AND x.student_id=$2)", [s?.class_id ?? null, U.id]);
      cards = [["Meal balance", "$" + (s?.meal_balance ?? 0)], ["Open assignments", as.n], ["Classes today", tt.length]];
      table = ["Today's timetable (" + day + ")", tt];
    } else {
      const d = await q("SELECT title,day,status FROM duties WHERE user_id=$1 ORDER BY id", [U.id]);
      const [st] = await q("SELECT department,role_title FROM staff WHERE user_id=$1", [U.id]);
      cards = [["Position", st?.role_title], ["Department", st?.department], ["Open duties", d.filter(v => v.status !== "done").length]];
      table = ["My duties", d];
    }
    return send({ cards, table });
  }

  if (a === "users") {
    if (m === "GET") {
      if (!is("headmaster") && !(is("teacher") && Q.role === "student")) return no();
      return send(await q("SELECT u.id,u.name,u.email,u.role,u.profile_pic,s.class_id,c.name class,s.roll_no,s.meal_balance,st.role_title,st.department,coalesce(t.salary,st.salary) salary FROM users u LEFT JOIN students s ON s.user_id=u.id LEFT JOIN classes c ON c.id=s.class_id LEFT JOIN staff st ON st.user_id=u.id LEFT JOIN teachers t ON t.user_id=u.id WHERE ($1::text IS NULL OR u.role=$1::text) AND ($2::int IS NULL OR s.class_id=$2::int) ORDER BY u.id", [Q.role || null, Q.class_id || null]));
    }
    if (m === "POST") {
      if (!is("headmaster")) return no();
      if (!B.email || !B.name || !B.password || B.password.length < 6 || !["teacher", "student", "staff"].includes(B.role)) return send({ error: "Name, email, role and a 6+ character password are required" }, 400);
      const [r] = await q("INSERT INTO users(email,password_hash,role,name) VALUES(lower($1),$2,$3,$4) RETURNING id", [B.email, await hash(B.password), B.role, B.name]).catch(() => []);
      if (!r) return send({ error: "That email is already registered" }, 409);
      if (B.role === "student") await q("INSERT INTO students(user_id,class_id,roll_no,meal_balance) VALUES($1,$2,$3,0)", [r.id, B.class_id || null, B.roll_no || null]);
      if (B.role === "teacher") await q("INSERT INTO teachers(user_id,salary) VALUES($1,$2)", [r.id, B.salary || 0]);
      if (B.role === "staff") await q("INSERT INTO staff(user_id,department,role_title,salary) VALUES($1,$2,$3,$4)", [r.id, B.department || "General", B.role_title || "Staff", B.salary || 0]);
      await log(U, `Created ${B.role} ${B.email}`);
      return send({ id: r.id }, 201);
    }
    if (m === "PUT" && b) {
      if (!is("headmaster") && +b !== U.id) return no();
      await q("UPDATE users SET name=coalesce($2,name),email=coalesce(lower($3),email),profile_pic=coalesce($4,profile_pic) WHERE id=$1", [b, B.name || null, B.email || null, B.profile_pic || null]).catch(() => 0);
      if (B.password) { if (B.password.length < 6) return send({ error: "Password too short" }, 400); await q("UPDATE users SET password_hash=$2 WHERE id=$1", [b, await hash(B.password)]); }
      if (is("headmaster")) {
        if (B.class_id) await q("UPDATE students SET class_id=$2 WHERE user_id=$1", [b, B.class_id]);
        if (B.salary) { await q("UPDATE teachers SET salary=$2 WHERE user_id=$1", [b, B.salary]); await q("UPDATE staff SET salary=$2 WHERE user_id=$1", [b, B.salary]); }
      }
      await log(U, "Updated user #" + b);
      return send({ ok: 1 });
    }
    if (m === "DELETE" && b) {
      if (!is("headmaster")) return no();
      if (+b === U.id) return send({ error: "You cannot delete your own account" }, 400);
      await q("DELETE FROM users WHERE id=$1", [b]);
      await log(U, "Deleted user #" + b);
      return send({ ok: 1 });
    }
  }

  if (a === "classes" && m === "POST") {
    if (!is("headmaster") || !B.name) return no();
    const [r] = await q("INSERT INTO classes(name) VALUES($1) RETURNING id", [B.name]);
    await q("INSERT INTO sections(class_id,name) VALUES($1,'A')", [r.id]); await log(U, "Created class " + B.name);
    return send({ id: r.id }, 201);
  }
  if (a === "subjects" && m === "POST") {
    if (!is("headmaster") || !B.name) return no();
    await q("INSERT INTO subjects(name) VALUES($1)", [B.name]); await log(U, "Created subject " + B.name);
    return send({ ok: 1 }, 201);
  }
  if (a === "timetable") {
    if (m === "GET") {
      const cid = is("student") ? await cls() : (x.Q.class_id || null);
      return send(await q("SELECT t.id,c.name class,t.day,t.period,s.name subject,u.name teacher FROM timetable t JOIN classes c ON c.id=t.class_id JOIN subjects s ON s.id=t.subject_id LEFT JOIN users u ON u.id=t.teacher_id WHERE ($1::int IS NULL OR t.class_id=$1::int) AND ($2::int IS NULL OR t.teacher_id=$2::int) ORDER BY t.class_id,array_position(ARRAY['Monday','Tuesday','Wednesday','Thursday','Friday'],t.day),t.period", [cid, is("teacher") ? U.id : null]));
    }
    if (m === "POST") {
      if (!is("headmaster")) return no();
      if (!DAYS.includes(B.day) || !B.class_id || !B.subject_id || !(B.period > 0)) return send({ error: "Class, day, period and subject are required" }, 400);
      await q("INSERT INTO timetable(class_id,day,period,subject_id,teacher_id) VALUES($1,$2,$3,$4,$5) ON CONFLICT(class_id,day,period) DO UPDATE SET subject_id=$4,teacher_id=$5", [B.class_id, B.day, B.period, B.subject_id, B.teacher_id || null]);
      await log(U, "Updated timetable"); return send({ ok: 1 }, 201);
    }
  }

  if (a === "attendance") {
    if (is("staff")) return no();
    if (m === "GET") return send(await q("SELECT a.id,to_char(a.date,'YYYY-MM-DD') date,a.status,u.name student,a.student_id FROM attendance a JOIN users u ON u.id=a.student_id LEFT JOIN students s ON s.user_id=a.student_id WHERE ($1::int IS NULL OR a.student_id=$1::int) AND ($2::date IS NULL OR a.date=$2::date) AND ($3::int IS NULL OR s.class_id=$3::int) ORDER BY a.date DESC,u.name LIMIT 300", [is("student") ? U.id : (Q.student_id || null), Q.date || null, Q.class_id || null]));
    if (m === "POST") {
      if (!is("teacher", "headmaster")) return no();
      const d = B.date || new Date().toISOString().slice(0, 10), rec = B.records || [];
      for (const r of rec) if (["present", "absent", "late"].includes(r.status)) await q("INSERT INTO attendance(student_id,date,status,marked_by) VALUES($1,$2,$3,$4) ON CONFLICT(student_id,date) DO UPDATE SET status=$3,marked_by=$4", [r.student_id, d, r.status, U.id]);
      await log(U, "Marked attendance for " + d);
      return send({ saved: rec.length }, 201);
    }
  }

  if (a === "grades") {
    if (is("staff")) return no();
    if (m === "GET") return send(await q("SELECT g.id,u.name student,g.student_id,s.name subject,g.exam_type,g.marks FROM grades g JOIN users u ON u.id=g.student_id JOIN subjects s ON s.id=g.subject_id WHERE ($1::int IS NULL OR g.student_id=$1::int) ORDER BY u.name,g.exam_type,s.name", [is("student") ? U.id : (Q.student_id || null)]));
    if (m === "POST") {
      if (!is("teacher", "headmaster")) return no();
      if (!B.student_id || !B.subject_id || !B.exam_type || !(B.marks >= 0 && B.marks <= 100)) return send({ error: "Student, subject, exam type and marks (0-100) are required" }, 400);
      await q("INSERT INTO grades(student_id,subject_id,exam_type,marks,graded_by) VALUES($1,$2,$3,$4,$5) ON CONFLICT(student_id,subject_id,exam_type) DO UPDATE SET marks=$4,graded_by=$5", [B.student_id, B.subject_id, B.exam_type, B.marks, U.id]);
      await log(U, "Entered grade for student #" + B.student_id);
      return send({ ok: 1 }, 201);
    }
  }
  return 0;
}