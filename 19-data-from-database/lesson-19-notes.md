# SQL Data Selection — SELECT & JOINs

> **Purpose:** Learn how to retrieve data from one or more tables in a MySQL database.  
> **Database used:** `database`  
> **Tables used:** `users`, `comments`

---

## 📑 Table of Contents

1. [SELECT — Retrieving Data](#1-select--retrieving-data)
2. [SELECT with WHERE — Filtering Rows](#2-select-with-where--filtering-rows)
3. [JOINs — Combining Tables](#3-joins--combining-tables)
4. [INNER JOIN](#4-inner-join)
5. [LEFT JOIN](#5-left-join)
6. [RIGHT JOIN](#6-right-join)
7. [FULL JOIN (Workaround)](#7-full-join-workaround)
8. [Quick Reference](#8-quick-reference)

---

## Sample Data Used in This Lesson

**`users` table:**

| id   | username | pwd       | email            | created_at          |
| :--- | :------- | :-------- | :--------------- | :------------------ |
| 1    | Shimu    | spass1234 | shimu@gmail.com  | 2026-02-08 12:00:00 |
| 2    | VioletVV | vpass5678 | violet@gmail.com | 2026-02-08 12:01:00 |
| 3    | Tara     | tpass1234 | tara@gmail.com   | 2026-02-08 12:02:00 |

**`comments` table:**

| id   | username | comment_text       | created_at          | users_id |
| :--- | :------- | :----------------- | :------------------ | :------- |
| 1    | Shimu    | This is a comment! | 2026-02-08 12:05:00 | 1        |
| 2    | Shimu    | Another comment!   | 2026-02-08 12:06:00 | 1        |
| 3    | VioletVV | Violet's comment   | 2026-02-08 12:07:00 | 2        |

> **📝 Note:** Tara (`id = 3`) has **no comments**. This matters when we compare JOIN types.

---

## 1. SELECT — Retrieving Data

| **Why**   | To read/retrieve data from the database. This is the most frequently used SQL command — every time your website displays user info, posts, or products, a `SELECT` is running behind the scenes. |
| :-------- | :----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | Use `SELECT columns FROM table;` — specify which columns you want, or use `*` for all columns.                                                                                                   |
| **Where** | User profiles, dashboards, search results, comment sections — anywhere data is **displayed**.                                                                                                    |

### Syntax

```sql
-- Select specific columns
SELECT column1, column2 FROM table_name;

-- Select all columns
SELECT * FROM table_name;
```

### Example — Select specific columns

```sql
SELECT username, email FROM users WHERE id = 1;
```

**Result:**

| username | email           |
| :------- | :-------------- |
| Shimu    | shimu@gmail.com |

> **💡 Best Practice:** Always select **only the columns you need** instead of `SELECT *`. It's faster and prevents accidentally exposing sensitive data (like passwords).

---

## 2. SELECT with WHERE — Filtering Rows

| **Why**   | Without `WHERE`, you get **every row** in the table. `WHERE` filters the results to only the rows you actually need. |
| :-------- | :------------------------------------------------------------------------------------------------------------------- |
| **How**   | Add `WHERE condition` after the table name.                                                                          |
| **Where** | Loading a specific user's profile, fetching one comment, filtering by category.                                      |

### Example — Get a specific comment

```sql
SELECT username, comment_text FROM comments WHERE id = 1;
```

**Result:**

| username | comment_text       |
| :------- | :----------------- |
| Shimu    | This is a comment! |

### Example — Get all comments by a specific user

```sql
SELECT * FROM comments WHERE users_id = 3;
```

**Result:** Empty — Tara (user `id = 3`) hasn't posted any comments yet.

| id          | username | comment_text | created_at | users_id |
| :---------- | :------- | :----------- | :--------- | :------- |
| *(no rows)* |          |              |            |          |

---

## 3. JOINs — Combining Tables

| **Why**   | Real data is spread across **multiple tables** (users in one, comments in another). JOINs let you pull related data together in a single query — like combining a user's name with their comments. |
| :-------- | :------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | Use `JOIN ... ON` to specify how the tables are connected (which columns match).                                                                                                                   |
| **Where** | Displaying comments with usernames, orders with product names, students with course grades — anytime you need data from **two or more tables**.                                                    |

### The Four JOIN Types at a Glance

```
    INNER JOIN          LEFT JOIN           RIGHT JOIN          FULL JOIN
    ┌───┐ ┌───┐        ┌───┐ ┌───┐        ┌───┐ ┌───┐        ┌───┐ ┌───┐
    │ A ├─┤ B │        │ A ├─┤ B │        │ A ├─┤ B │        │ A ├─┤ B │
    └───┘ └───┘        └───┘ └───┘        └───┘ └───┘        └───┘ └───┘
      ███                ██████             ██████              ███████████
   Only matching       All from A +       All from B +        All from both
      rows              matching B         matching A            tables
```

| JOIN Type    | Returns                                                         | Missing data shows as                        |
| :----------- | :-------------------------------------------------------------- | :------------------------------------------- |
| `INNER JOIN` | Only rows that have a match in **both** tables                  | *(row is excluded entirely)*                 |
| `LEFT JOIN`  | **All** rows from the left table + matching rows from the right | `NULL` for unmatched right columns           |
| `RIGHT JOIN` | **All** rows from the right table + matching rows from the left | `NULL` for unmatched left columns            |
| `FULL JOIN`  | **All** rows from **both** tables                               | `NULL` where there's no match on either side |

---

## 4. INNER JOIN

| **Why**   | To get **only the rows that have matching data in both tables**. If a user has no comments, they won't appear. If a comment has no valid user, it won't appear. |
| :-------- | :-------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | `SELECT ... FROM table1 INNER JOIN table2 ON table1.column = table2.column;`                                                                                    |
| **Where** | When you only want results where a **relationship exists** — users who **have** commented, orders that **have** products.                                       |

### Example — All columns

```sql
SELECT * FROM users
INNER JOIN comments ON users.id = comments.users_id;
```

**Result:** Only Shimu and VioletVV appear — Tara is **excluded** because she has no comments.

| users.id | username | pwd       | email            | comments.id | comment_text       | users_id |
| :------- | :------- | :-------- | :--------------- | :---------- | :----------------- | :------- |
| 1        | Shimu    | spass1234 | shimu@gmail.com  | 1           | This is a comment! | 1        |
| 1        | Shimu    | spass1234 | shimu@gmail.com  | 2           | Another comment!   | 1        |
| 2        | VioletVV | vpass5678 | violet@gmail.com | 3           | Violet's comment   | 2        |

> **📝 Note:** Shimu appears **twice** because she has 2 comments. JOINs create one row per match.

### Example — Specific columns only

```sql
SELECT users.username, comments.comment_text, comments.created_at
FROM users
INNER JOIN comments ON users.id = comments.users_id;
```

**Result:**

| username | comment_text       | created_at          |
| :------- | :----------------- | :------------------ |
| Shimu    | This is a comment! | 2026-02-08 12:05:00 |
| Shimu    | Another comment!   | 2026-02-08 12:06:00 |
| VioletVV | Violet's comment   | 2026-02-08 12:07:00 |

> **💡 Pro Tip:** When selecting from multiple tables, prefix column names with the table name (`users.username`, `comments.comment_text`) to avoid ambiguity — especially when both tables have a column with the same name (like `username`).

---

## 5. LEFT JOIN

| **Why**   | To get **all rows from the left table** regardless of whether they have a match in the right table. Unmatched rows get `NULL` for the right table's columns. |
| :-------- | :----------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | `SELECT ... FROM left_table LEFT JOIN right_table ON condition;`                                                                                             |
| **Where** | When you want **all users**, even those who haven't commented yet. Show everyone, and for those without comments, show blanks.                               |

### Example

```sql
SELECT * FROM users
LEFT JOIN comments ON users.id = comments.users_id;
```

**Result:** All 3 users appear — Tara shows up with `NULL` comment data.

| users.id | username | email              | comments.id | comment_text       | users_id |
| :------- | :------- | :----------------- | :---------- | :----------------- | :------- |
| 1        | Shimu    | shimu@gmail.com    | 1           | This is a comment! | 1        |
| 1        | Shimu    | shimu@gmail.com    | 2           | Another comment!   | 1        |
| 2        | VioletVV | violet@gmail.com   | 3           | Violet's comment   | 2        |
| 3        | **Tara** | **tara@gmail.com** | **NULL**    | **NULL**           | **NULL** |

> **Key difference from INNER JOIN:** Tara now appears with `NULL` values instead of being excluded.

---

## 6. RIGHT JOIN

| **Why**   | To get **all rows from the right table** regardless of whether they have a match in the left table. The opposite of LEFT JOIN.                               |
| :-------- | :----------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | `SELECT ... FROM left_table RIGHT JOIN right_table ON condition;`                                                                                            |
| **Where** | When the right table is your priority — e.g., show all comments even if the user account was deleted (and `users_id` is `NULL` due to `ON DELETE SET NULL`). |

### Example

```sql
SELECT * FROM users
RIGHT JOIN comments ON users.id = comments.users_id;
```

**Result:** All 3 comments appear. If a comment had `users_id = NULL` (deleted user), the user columns would show `NULL`.

| users.id | username | email            | comments.id | comment_text       | users_id |
| :------- | :------- | :--------------- | :---------- | :----------------- | :------- |
| 1        | Shimu    | shimu@gmail.com  | 1           | This is a comment! | 1        |
| 1        | Shimu    | shimu@gmail.com  | 2           | Another comment!   | 1        |
| 2        | VioletVV | violet@gmail.com | 3           | Violet's comment   | 2        |

> **📝 Note:** In this example, every comment has a valid `users_id`, so the result looks similar to INNER JOIN. The difference becomes visible when a comment exists with no matching user (e.g., after `ON DELETE SET NULL`).

---

## 7. FULL JOIN (Workaround)

| **Why**   | To get **all rows from both tables** — every user AND every comment, matched where possible, with `NULL` where there's no match on either side. |
| :-------- | :---------------------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | MySQL **does not support** `FULL JOIN` directly. The workaround is to combine a `LEFT JOIN` and a `RIGHT JOIN` using `UNION`.                   |
| **Where** | When you need a complete picture of both tables — rare in practice, but useful for reports and data audits.                                     |

### Why MySQL doesn't have FULL JOIN

Most other databases (PostgreSQL, SQL Server) support `FULL OUTER JOIN`. MySQL simply never implemented it. The `UNION` workaround gives the same result.

### Workaround — LEFT JOIN + UNION + RIGHT JOIN

```sql
SELECT * FROM users
LEFT JOIN comments ON users.id = comments.users_id

UNION

SELECT * FROM users
RIGHT JOIN comments ON users.id = comments.users_id;
```

**How it works:**

| Step         | What it gets                                                                |
| :----------- | :-------------------------------------------------------------------------- |
| `LEFT JOIN`  | All users + their comments (users without comments get `NULL` comment data) |
| `UNION`      | Combines both results and **removes duplicates**                            |
| `RIGHT JOIN` | All comments + their users (comments without users get `NULL` user data)    |

**Result:** Every user and every comment appears — no data is excluded.

| users.id | username | email            | comments.id | comment_text       | users_id |
| :------- | :------- | :--------------- | :---------- | :----------------- | :------- |
| 1        | Shimu    | shimu@gmail.com  | 1           | This is a comment! | 1        |
| 1        | Shimu    | shimu@gmail.com  | 2           | Another comment!   | 1        |
| 2        | VioletVV | violet@gmail.com | 3           | Violet's comment   | 2        |
| 3        | Tara     | tara@gmail.com   | NULL        | NULL               | NULL     |

> **💡 UNION vs UNION ALL:**
> - `UNION` — removes duplicate rows (use this for FULL JOIN workaround)
> - `UNION ALL` — keeps all rows including duplicates (faster, but not suitable here)

---

## 8. Quick Reference

### SELECT Basics

```sql
-- All columns from a table
SELECT * FROM users;

-- Specific columns
SELECT username, email FROM users;

-- With filter
SELECT * FROM comments WHERE users_id = 3;
```

### JOIN Comparison

| JOIN           | Left table rows | Right table rows | When to use                                   |
| :------------- | :-------------- | :--------------- | :-------------------------------------------- |
| `INNER JOIN`   | Only matched    | Only matched     | Only want rows with data in **both** tables   |
| `LEFT JOIN`    | **All**         | Only matched     | Want all from the left, even without matches  |
| `RIGHT JOIN`   | Only matched    | **All**          | Want all from the right, even without matches |
| `FULL (UNION)` | **All**         | **All**          | Want everything from both tables              |

### JOIN Syntax

```sql
-- INNER JOIN
SELECT * FROM users
INNER JOIN comments ON users.id = comments.users_id;

-- LEFT JOIN
SELECT * FROM users
LEFT JOIN comments ON users.id = comments.users_id;

-- RIGHT JOIN
SELECT * FROM users
RIGHT JOIN comments ON users.id = comments.users_id;

-- FULL JOIN (MySQL workaround)
SELECT * FROM users LEFT JOIN comments ON users.id = comments.users_id
UNION
SELECT * FROM users RIGHT JOIN comments ON users.id = comments.users_id;
```
