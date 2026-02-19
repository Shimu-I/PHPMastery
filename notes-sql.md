# 📝 SQL Fundamentals — Complete Reference

> **Author:** Jasmin Sultana Shimu  
> **Purpose:** Personal reference guide for SQL learned through the PHP tutorial  
> **Database Tool:** phpMyAdmin (via XAMPP)  
> **Last Updated:** February 2026

---

## 📑 Table of Contents

1. [What Is SQL?](#1-what-is-sql)
2. [Data Types](#2-data-types)
3. [Creating Databases & Tables](#3-creating-databases--tables)
4. [Table Constraints & Keys](#4-table-constraints--keys)
5. [INSERT — Adding Data](#5-insert--adding-data)
6. [SELECT — Retrieving Data](#6-select--retrieving-data)
7. [WHERE — Filtering Rows](#7-where--filtering-rows)
8. [AND / OR — Combining Conditions](#8-and--or--combining-conditions)
9. [UPDATE — Modifying Data](#9-update--modifying-data)
10. [DELETE — Removing Data](#10-delete--removing-data)
11. [AUTO_INCREMENT Behavior](#11-auto_increment-behavior)
12. [JOINs — Combining Tables](#12-joins--combining-tables)
13. [Foreign Key Delete Behaviors](#13-foreign-key-delete-behaviors)
14. [Quick Reference](#14-quick-reference)

---

## 1. What Is SQL?

| **Why**   | SQL (Structured Query Language) is the standard language for communicating with relational databases. Every web application that stores data (users, posts, products) uses SQL behind the scenes. |
| :-------- | :----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | You write SQL queries to **create** tables, **insert** data, **select** (read) data, **update** data, and **delete** data — known as **CRUD** operations.                                        |
| **Where** | phpMyAdmin, MySQL command line, or executed from PHP code via PDO.                                                                                                                               |

### The 4 CRUD Operations

| Operation  | SQL Keyword    | Purpose                          |
| :--------- | :------------- | :------------------------------- |
| **C**reate | `INSERT INTO`  | Add new rows to a table          |
| **R**ead   | `SELECT`       | Retrieve data from a table       |
| **U**pdate | `UPDATE ... SET` | Modify existing rows           |
| **D**elete | `DELETE FROM`  | Remove rows from a table         |

---

## 2. Data Types

### 2.1 Numeric Data Types

| Data Type  | Range (Signed)                   | Purpose                                                           |
| :--------- | :------------------------------- | :---------------------------------------------------------------- |
| **INT**    | -2,147,483,648 to 2,147,483,647 | Standard whole numbers (User IDs, counts).                        |
| **BIGINT** | ± 9.22 Quintillion               | Massive datasets (Global transaction IDs, social media views).    |
| **FLOAT**  | ~7 decimal digits precision      | Approximate values where speed is prioritized over precision.     |
| **DOUBLE** | ~15 decimal digits precision     | High-precision decimal values (Scientific data, GPS coordinates). |

#### Signed vs. Unsigned

| Type | Range | Example |
|:---|:---|:---|
| **Signed** (default) | Allows negative and positive | `TINYINT` → -128 to 127 |
| **Unsigned** | Positive only — doubles the upper range | `TINYINT UNSIGNED` → 0 to 255 |

> **Best Practice:** Use `UNSIGNED` for values that can never be negative (age, stock quantity, primary keys).

---

### 2.2 String (Text) Data Types

| Data Type      | Limit              | Storage Behavior                                                       |
| :------------- | :----------------- | :--------------------------------------------------------------------- |
| **CHAR(N)**    | Up to 255          | **Fixed length.** Always uses N space (pads with spaces).              |
| **VARCHAR(N)** | Up to 65,535       | **Variable length.** Only uses space for the actual characters stored. |
| **TEXT**       | Up to 65,535 bytes | Best for very long notes, blog posts, or large descriptions.           |

#### What do the parentheses `( )` do?

| Context | Meaning |
|:---|:---|
| **VARCHAR(30)** | **Hard limit** — stops you from entering 31 characters |
| **INT(11)** | Historically the **display width** (padding). In modern MySQL 8.0+, mostly ignored — does NOT change storage size |

---

### 2.3 Date and Time Data Types

| Data Type    | Format               | Example             |
| :----------- | :------------------- | :------------------ |
| **DATE**     | YYYY-MM-DD           | 2023-05-14          |
| **DATETIME** | YYYY-MM-DD HH:MM:SS | 2023-05-14 16:00:00 |

#### Cautions

| Issue | Detail |
|:---|:---|
| **Format** | Must use `YYYY-MM-DD`. Using `DD-MM-YYYY` causes "Invalid Date" errors |
| **Time Zones** | `DATETIME` stores the literal value — no timezone conversion. For global apps, consider `TIMESTAMP` (converts to UTC) |
| **Zero Dates** | Modern SQL blocks `0000-00-00`. Use `NULL` for empty date fields |

---

## 3. Creating Databases & Tables

### 3.1 Creating a Database

```sql
CREATE DATABASE myfirstdatabase;
```

### 3.2 Creating a Table

```sql
CREATE TABLE users (
    id         INT(11) NOT NULL AUTO_INCREMENT,
    username   VARCHAR(30) NOT NULL,
    pwd        VARCHAR(255) NOT NULL,
    email      VARCHAR(100) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIME,
    PRIMARY KEY(id)
);
```

**Column-by-column breakdown:**

| Column       | Type           | Constraints                                 | Why                                                               |
| :----------- | :------------- | :------------------------------------------ | :---------------------------------------------------------------- |
| `id`         | `INT(11)`      | `NOT NULL`, `AUTO_INCREMENT`, `PRIMARY KEY` | Unique identifier — auto-generates 1, 2, 3…                       |
| `username`   | `VARCHAR(30)`  | `NOT NULL`                                  | Max 30 characters, cannot be empty                                |
| `pwd`        | `VARCHAR(255)` | `NOT NULL`                                  | 255 chars to store **hashed** passwords (never store plain text!) |
| `email`      | `VARCHAR(100)` | `NOT NULL`                                  | Max 100 characters for email                                      |
| `created_at` | `DATETIME`     | `NOT NULL`, `DEFAULT CURRENT_TIME`          | Automatically records when the user was created                   |

### 3.3 Creating a Related Table (with Foreign Key)

```sql
CREATE TABLE comments (
    id           INT(11) NOT NULL AUTO_INCREMENT,
    username     VARCHAR(30) NOT NULL,
    comment_text TEXT NOT NULL,
    created_at   DATETIME NOT NULL DEFAULT CURRENT_TIME,
    users_id     INT(11),
    PRIMARY KEY(id),
    FOREIGN KEY(users_id) REFERENCES users(id) ON DELETE SET NULL
);
```

**The foreign key line explained:**

```sql
FOREIGN KEY(users_id) REFERENCES users(id) ON DELETE SET NULL
--          ↑                      ↑              ↑
--    Column in THIS table    Column in PARENT   What happens when the
--    (comments.users_id)     table (users.id)   parent row is deleted
```

> **Note:** `users_id` is intentionally nullable (no `NOT NULL`). This allows `ON DELETE SET NULL` to work — if the user is deleted, the comment stays but loses its link.

### 3.4 Practical Example with All Data Types

```sql
CREATE TABLE employee_records (
    emp_id        INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name     VARCHAR(100) NOT NULL,
    biography     TEXT,
    salary        DOUBLE(10, 2),
    date_of_birth DATE,
    created_at    DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

---

## 4. Table Constraints & Keys

### 4.1 Constraints

Constraints are **rules** on columns that enforce data integrity.

| Constraint       | What It Does                                                  | Example                                             |
| :--------------- | :------------------------------------------------------------ | :-------------------------------------------------- |
| `NOT NULL`       | Column **must** have a value — empty/null is rejected         | `username VARCHAR(30) NOT NULL`                     |
| `AUTO_INCREMENT` | Automatically generates the next number (1, 2, 3…)            | `id INT(11) NOT NULL AUTO_INCREMENT`                |
| `DEFAULT`        | Sets a fallback value if none is provided                     | `created_at DATETIME NOT NULL DEFAULT CURRENT_TIME` |
| `UNIQUE`         | No two rows can have the same value in this column            | `email VARCHAR(100) UNIQUE`                         |
| `PRIMARY KEY`    | Uniquely identifies each row (combines `NOT NULL` + `UNIQUE`) | `PRIMARY KEY(id)`                                   |
| `FOREIGN KEY`    | Links a column to the primary key of **another** table        | `FOREIGN KEY(users_id) REFERENCES users(id)`        |

---

### 4.2 Primary Key

| **Why**   | Every table needs a way to **uniquely identify** each row. Without it, you can't reliably find, update, or delete a specific record. |
| :-------- | :----------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | Mark one column (usually `id`) as `PRIMARY KEY`. It must be `NOT NULL` and each value must be **unique**.                            |
| **Where** | Every table should have exactly **one** primary key.                                                                                 |

- Automatically enforces `NOT NULL` + `UNIQUE`
- Typically paired with `AUTO_INCREMENT` so IDs are generated automatically
- A table can have **only one** primary key

---

### 4.3 Secondary Key (Index)

| **Why**   | To **speed up** searches on columns you query frequently (e.g., username, email). |
| :-------- | :-------------------------------------------------------------------------------- |
| **How**   | Create an index — like a book index, MySQL can jump to the right row instead of scanning everything. |
| **Where** | Columns used in `WHERE`, `JOIN`, or `ORDER BY` clauses.                           |

```sql
CREATE INDEX idx_username ON users(username);
```

> **Note:** A secondary key (index) does **not** enforce uniqueness — it's purely for performance. Use `UNIQUE INDEX` if you also need uniqueness.

---

### 4.4 Foreign Key

| **Why**   | To create a **relationship** between two tables. Ensures a value in one table actually exists in another. |
| :-------- | :------------------------------------------------------------------------------------------------------- |
| **How**   | Point a column in the child table to the primary key of the parent table.                                |
| **Where** | Users & comments, orders & products, students & courses — any time tables are related.                   |

```sql
-- comments.users_id → users.id
FOREIGN KEY(users_id) REFERENCES users(id)
```

---

## 5. INSERT — Adding Data

| **Why**   | To add new rows (records) into a table — this is how users, comments, products, etc. get stored. |
| :-------- | :----------------------------------------------------------------------------------------------- |
| **How**   | `INSERT INTO table (columns) VALUES (values);` — columns and values must match in order and count. |
| **Where** | Registration forms, posting comments, placing orders.                                             |

### Syntax

```sql
INSERT INTO table_name (column1, column2, column3)
VALUES ('value1', 'value2', 'value3');
```

### Examples

```sql
-- Insert a user
INSERT INTO users (username, pwd, email)
VALUES ('Shimu', 'spass1234', 'shimu@gmail.com');

-- Insert another user
INSERT INTO users (username, pwd, email)
VALUES ('Violet', 'vpass1234', 'violet@gmail.com');
```

**Result:**

| id | username | pwd       | email            | created_at          |
|:---|:---------|:----------|:-----------------|:--------------------|
| 1  | Shimu    | spass1234 | shimu@gmail.com  | 2026-02-08 12:00:00 |
| 2  | Violet   | vpass1234 | violet@gmail.com | 2026-02-08 12:01:00 |

> **Note:** We didn't include `id` or `created_at` because `id` has `AUTO_INCREMENT` and `created_at` has `DEFAULT CURRENT_TIME` — the database fills them in automatically.

### Inserting Into a Table with Foreign Keys

```sql
-- Add a comment linked to user id = 1 (Shimu)
INSERT INTO comments (username, comment_text, users_id)
VALUES ('Shimu', 'This is a comment on a website!', 1);
```

> **Important:** If `users_id = 1` doesn't exist in the `users` table, MySQL **rejects** the insert with a foreign key constraint error. This ensures **referential integrity** — no orphan comments pointing to non-existent users.

---

## 6. SELECT — Retrieving Data

| **Why**   | To read/retrieve data. The most frequently used SQL command — every time your website displays user info, posts, or products, a `SELECT` is running. |
| :-------- | :--------------------------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | `SELECT columns FROM table;` — specify which columns, or use `*` for all.                                                                           |
| **Where** | User profiles, dashboards, search results, comment sections — anywhere data is **displayed**.                                                        |

### Syntax

```sql
-- All columns
SELECT * FROM table_name;

-- Specific columns
SELECT column1, column2 FROM table_name;
```

### Examples

```sql
-- Get all users
SELECT * FROM users;

-- Get only username and email
SELECT username, email FROM users;

-- Get a specific user
SELECT username, email FROM users WHERE id = 1;
```

**Result of last query:**

| username | email           |
|:---------|:----------------|
| Shimu    | shimu@gmail.com |

### `fetchAll()` vs `fetch()` (in PHP)

| Method | Returns | Use When |
|:---|:---|:---|
| `fetchAll()` | **All rows** at once as an array of arrays | Multiple results (search, lists) |
| `fetch()` | **One row** at a time | Single record (user profile) |

> **Best Practice:** Always select **only the columns you need** instead of `SELECT *`. It's faster and prevents accidentally exposing sensitive data.

---

## 7. WHERE — Filtering Rows

| **Why**   | `WHERE` acts as a **filter** — it tells MySQL which specific row(s) to affect. Without it, your query applies to the **entire table**. |
| :-------- | :------------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | Add `WHERE column = value` after `SELECT`, `UPDATE`, or `DELETE`.                                                                     |
| **Where** | Every `UPDATE` and `DELETE` (required for safety), and most `SELECT` statements.                                                      |

### Examples

```sql
-- Target by primary key (most precise — exactly one row)
SELECT * FROM users WHERE id = 2;

-- Target by column value
SELECT * FROM comments WHERE username = 'Shimu';

-- Target with conditions
DELETE FROM users WHERE username = 'Violet' AND pwd = 'vpass1234';
```

> **Best Practice:** Use the **primary key** (`id`) in your `WHERE` clause whenever possible. It's guaranteed unique, so you'll never accidentally affect the wrong row.

---

## 8. AND / OR — Combining Conditions

| **Why**   | Sometimes one condition isn't enough to pinpoint the right row(s). |
| :-------- | :---------------------------------------------------------------- |
| **How**   | `AND` = **both** must be true. `OR` = **at least one** must be true. |
| **Where** | Login checks, multi-criteria searches, flexible filters.          |

### Examples

```sql
-- AND: Both conditions must be true
UPDATE users SET username = 'VioletVV', pwd = 'vpass5678'
WHERE username = 'Violet' AND pwd = 'vpass1234';

-- OR: Either condition can be true
DELETE FROM users WHERE id = 1 OR id = 3;
```

| Operator | Logic                  | Matches                        |
| :------- | :--------------------- | :----------------------------- |
| `AND`    | **Both** must be true  | Only if all conditions match   |
| `OR`     | **Either** can be true | If any one condition matches   |

```sql
-- Precise targeting with AND
DELETE FROM users WHERE username = 'Shimu' AND email = 'shimu@gmail.com';

-- Broader targeting with OR
SELECT * FROM users WHERE id = 1 OR id = 2;
```

---

## 9. UPDATE — Modifying Data

| **Why**   | To change existing data without deleting and re-inserting. Users change passwords, update profiles, fix typos. |
| :-------- | :------------------------------------------------------------------------------------------------------------- |
| **How**   | `UPDATE table SET column = 'new_value' WHERE condition;`                                                       |
| **Where** | Profile edits, password resets, status changes, data corrections.                                              |

### Syntax

```sql
UPDATE table_name
SET column1 = 'new_value1', column2 = 'new_value2'
WHERE condition;
```

### Example

```sql
UPDATE users SET username = 'VioletVV', pwd = 'vpass5678'
WHERE id = 2;
```

**Result:**

| id | username     | pwd           | email            |
|:---|:-------------|:--------------|:-----------------|
| 1  | Shimu        | spass1234     | shimu@gmail.com  |
| 2  | **VioletVV** | **vpass5678** | violet@gmail.com |

> **⚠️ CRITICAL: Always use `WHERE` with `UPDATE`!**
> ```sql
> -- 🚨 DANGER — this changes ALL users' passwords!
> UPDATE users SET pwd = 'oops';
> ```
> Without `WHERE`, **every row** in the table gets updated.

---

## 10. DELETE — Removing Data

| **Why**   | To permanently remove rows — account deletion, removing spam, cleaning old data. |
| :-------- | :------------------------------------------------------------------------------- |
| **How**   | `DELETE FROM table WHERE condition;`                                              |
| **Where** | Account deletion, removing comments, clearing expired sessions.                  |

### Syntax

```sql
DELETE FROM table_name WHERE condition;
```

### Example

```sql
DELETE FROM users WHERE id = 1;
```

> **⚠️ CRITICAL: Always use `WHERE` with `DELETE`!**
> ```sql
> -- 🚨 DANGER — this empties the ENTIRE table!
> DELETE FROM users;
> ```
> There is **no undo** — the data is gone.

---

## 11. AUTO_INCREMENT Behavior

### What happens after deleting a row?

After deleting user with `id = 1` and inserting a new user:

```sql
DELETE FROM users WHERE id = 1;

INSERT INTO users (username, pwd, email)
VALUES ('Tara', 'tpass1234', 'tara@gmail.com');
```

**Result:**

| id    | username | pwd       | email            |
|:------|:---------|:----------|:-----------------|
| 2     | VioletVV | vpass5678 | violet@gmail.com |
| **3** | Tara     | tpass1234 | tara@gmail.com   |

Tara gets `id = 3`, **not** `id = 1`. `AUTO_INCREMENT` always continues from the **highest value ever used** — it never recycles deleted IDs.

### Why You Should NEVER Manually Change IDs

| Reason                  | Explanation                                                                                      |
| :---------------------- | :----------------------------------------------------------------------------------------------- |
| **Breaks foreign keys** | Other tables may reference `id = 1`. Reusing it links Tara to Shimu's old comments              |
| **Causes collisions**   | If you set an ID to 5 manually and `AUTO_INCREMENT` also generates 5 → duplicate key error       |
| **Gaps are normal**     | Every production database has gaps in IDs. They're expected and harmless                         |
| **Security risk**       | Sequential, gap-free IDs reveal how many users you have. Gaps make it harder to guess valid IDs  |

> **Bottom line:** Let the database handle IDs. Gaps in `AUTO_INCREMENT` are perfectly fine — don't touch them.

---

## 12. JOINs — Combining Tables

| **Why**   | Real data is spread across **multiple tables**. JOINs let you pull related data together in a single query. |
| :-------- | :---------------------------------------------------------------------------------------------------------- |
| **How**   | `JOIN ... ON` specifies how the tables are connected (which columns match).                                  |
| **Where** | Comments with usernames, orders with product names, students with course grades.                             |

### Sample Data

**`users` table:**

| id | username | pwd       | email            |
|:---|:---------|:----------|:-----------------|
| 1  | Shimu    | spass1234 | shimu@gmail.com  |
| 2  | VioletVV | vpass5678 | violet@gmail.com |
| 3  | Tara     | tpass1234 | tara@gmail.com   |

**`comments` table:**

| id | username | comment_text       | users_id |
|:---|:---------|:-------------------|:---------|
| 1  | Shimu    | This is a comment! | 1        |
| 2  | Shimu    | Another comment!   | 1        |
| 3  | VioletVV | Violet's comment   | 2        |

> **Note:** Tara (`id = 3`) has **no comments**. This difference matters when comparing JOIN types.

---

### 12.1 The Four JOIN Types at a Glance

```
    INNER JOIN          LEFT JOIN           RIGHT JOIN          FULL JOIN
    ┌───┐ ┌───┐        ┌───┐ ┌───┐        ┌───┐ ┌───┐        ┌───┐ ┌───┐
    │ A ├─┤ B │        │ A ├─┤ B │        │ A ├─┤ B │        │ A ├─┤ B │
    └───┘ └───┘        └───┘ └───┘        └───┘ └───┘        └───┘ └───┘
      ███                ██████             ██████              ███████████
   Only matching       All from A +       All from B +        All from both
      rows              matching B         matching A            tables
```

| JOIN Type    | Returns                                                 | Missing data shows as        |
| :----------- | :------------------------------------------------------ | :--------------------------- |
| `INNER JOIN` | Only rows with a match in **both** tables               | *(row excluded entirely)*    |
| `LEFT JOIN`  | **All** left + matching right                           | `NULL` for unmatched right   |
| `RIGHT JOIN` | **All** right + matching left                           | `NULL` for unmatched left    |
| `FULL JOIN`  | **All** from **both** tables                            | `NULL` where no match exists |

---

### 12.2 INNER JOIN

| **Why**   | Get **only the rows that match in both tables**. Users without comments are excluded. |
| :-------- | :------------------------------------------------------------------------------------ |
| **How**   | `SELECT ... FROM table1 INNER JOIN table2 ON table1.col = table2.col;`                |

```sql
SELECT users.username, comments.comment_text, comments.created_at
FROM users
INNER JOIN comments ON users.id = comments.users_id;
```

**Result:** Only Shimu and VioletVV — Tara excluded (no comments).

| username | comment_text       | created_at          |
|:---------|:-------------------|:--------------------|
| Shimu    | This is a comment! | 2026-02-08 12:05:00 |
| Shimu    | Another comment!   | 2026-02-08 12:06:00 |
| VioletVV | Violet's comment   | 2026-02-08 12:07:00 |

> **Note:** Shimu appears **twice** because she has 2 comments. JOINs create one row per match.

---

### 12.3 LEFT JOIN

| **Why**   | Get **all rows from the left table** even if they have no match on the right. Unmatched rows show `NULL`. |
| :-------- | :-------------------------------------------------------------------------------------------------------- |
| **How**   | `SELECT ... FROM left_table LEFT JOIN right_table ON condition;`                                           |

```sql
SELECT * FROM users
LEFT JOIN comments ON users.id = comments.users_id;
```

**Result:** All 3 users — Tara appears with `NULL` comment data.

| users.id | username | email            | comments.id | comment_text       | users_id |
|:---------|:---------|:-----------------|:------------|:-------------------|:---------|
| 1        | Shimu    | shimu@gmail.com  | 1           | This is a comment! | 1        |
| 1        | Shimu    | shimu@gmail.com  | 2           | Another comment!   | 1        |
| 2        | VioletVV | violet@gmail.com | 3           | Violet's comment   | 2        |
| 3        | Tara     | tara@gmail.com   | NULL        | NULL               | NULL     |

---

### 12.4 RIGHT JOIN

| **Why**   | Get **all rows from the right table** even if they have no match on the left. Opposite of LEFT JOIN. |
| :-------- | :--------------------------------------------------------------------------------------------------- |
| **How**   | `SELECT ... FROM left_table RIGHT JOIN right_table ON condition;`                                     |

```sql
SELECT * FROM users
RIGHT JOIN comments ON users.id = comments.users_id;
```

**Result:** All 3 comments appear. If a comment had `users_id = NULL` (deleted user), the user columns would show `NULL`.

---

### 12.5 FULL JOIN (MySQL Workaround)

| **Why**   | Get **all rows from both tables** — matched where possible, `NULL` where not.           |
| :-------- | :-------------------------------------------------------------------------------------- |
| **How**   | MySQL doesn't support `FULL JOIN`. Combine `LEFT JOIN` + `UNION` + `RIGHT JOIN`.        |

```sql
SELECT * FROM users
LEFT JOIN comments ON users.id = comments.users_id

UNION

SELECT * FROM users
RIGHT JOIN comments ON users.id = comments.users_id;
```

| Step         | What it gets                                                    |
|:-------------|:----------------------------------------------------------------|
| `LEFT JOIN`  | All users + their comments (missing comments → `NULL`)          |
| `UNION`      | Combines both results and **removes duplicates**                |
| `RIGHT JOIN` | All comments + their users (missing users → `NULL`)             |

> **`UNION` vs `UNION ALL`:** `UNION` removes duplicate rows. `UNION ALL` keeps all rows including duplicates — faster but not suitable for the FULL JOIN workaround.

---

### 12.6 Prefix Column Names in JOINs

When both tables have a column with the same name (like `username`), prefix with the table name to avoid ambiguity:

```sql
-- ✅ Clear — specify which table's username
SELECT users.username, comments.comment_text
FROM users
INNER JOIN comments ON users.id = comments.users_id;

-- ❌ Ambiguous — MySQL doesn't know which "username" you mean
SELECT username, comment_text
FROM users
INNER JOIN comments ON users.id = comments.users_id;
```

---

## 13. Foreign Key Delete Behaviors

### The Problem

When a user deletes their account (parent row is removed from `users`), what happens to their comments (child rows in `comments`) that still reference that user?

**By default, MySQL blocks the delete** — it refuses to delete the parent if children exist.

### The Four `ON DELETE` Options

| Behavior              | What Happens                                                                          | Use When                                                                    |
| :-------------------- | :------------------------------------------------------------------------------------ | :-------------------------------------------------------------------------- |
| `ON DELETE NO ACTION` | ❌ **Blocks delete.** Error thrown — can't delete parent while children exist           | Protect related data; force deleting children first                         |
| `ON DELETE RESTRICT`  | ❌ **Same as NO ACTION** in MySQL. Prevents parent deletion                             | Same as above — identical in MySQL                                          |
| `ON DELETE CASCADE`   | 🔥 **Deletes children too.** Delete user → all their comments are automatically deleted | Child data has no meaning without parent (sessions, temp records)           |
| `ON DELETE SET NULL`  | 🔄 **Sets foreign key to NULL.** Comments stay, but `users_id` becomes `NULL`           | Child data should survive but lose the link (keep comments, show "deleted") |

### Example

```sql
-- CASCADE: Deleting a user ALSO deletes all their comments
FOREIGN KEY(users_id) REFERENCES users(id) ON DELETE CASCADE

-- SET NULL: Deleting a user keeps comments but clears users_id
FOREIGN KEY(users_id) REFERENCES users(id) ON DELETE SET NULL
```

> **Note:** For `SET NULL` to work, the foreign key column (`users_id`) must be **nullable** — do NOT set it as `NOT NULL`.

---

## 14. Quick Reference

### Database & Table Creation

```sql
-- Create a database
CREATE DATABASE myfirstdatabase;

-- Create a table
CREATE TABLE users (
    id         INT(11) NOT NULL AUTO_INCREMENT,
    username   VARCHAR(30) NOT NULL,
    pwd        VARCHAR(255) NOT NULL,
    email      VARCHAR(100) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIME,
    PRIMARY KEY(id)
);

-- Create a table with foreign key
CREATE TABLE comments (
    id           INT(11) NOT NULL AUTO_INCREMENT,
    comment_text TEXT NOT NULL,
    users_id     INT(11),
    PRIMARY KEY(id),
    FOREIGN KEY(users_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Create an index for faster lookups
CREATE INDEX idx_username ON users(username);
```

### CRUD Operations

```sql
-- INSERT: Add new data
INSERT INTO users (username, pwd, email)
VALUES ('Shimu', 'hashedpwd', 'shimu@gmail.com');

-- SELECT: Read data
SELECT * FROM users;
SELECT username, email FROM users WHERE id = 1;

-- UPDATE: Modify data (always use WHERE!)
UPDATE users SET username = 'NewName', pwd = 'newpwd'
WHERE id = 2;

-- DELETE: Remove data (always use WHERE!)
DELETE FROM users WHERE id = 1;
```

### Filtering

```sql
-- WHERE: Target specific rows
WHERE id = 2
WHERE username = 'Shimu'

-- AND: Both must be true
WHERE username = 'Shimu' AND email = 'shimu@gmail.com'

-- OR: Either can be true
WHERE id = 1 OR id = 3
```

### JOINs

```sql
-- INNER JOIN (only matching rows)
SELECT * FROM users
INNER JOIN comments ON users.id = comments.users_id;

-- LEFT JOIN (all from left + matching right)
SELECT * FROM users
LEFT JOIN comments ON users.id = comments.users_id;

-- RIGHT JOIN (all from right + matching left)
SELECT * FROM users
RIGHT JOIN comments ON users.id = comments.users_id;

-- FULL JOIN (MySQL workaround — all from both)
SELECT * FROM users LEFT JOIN comments ON users.id = comments.users_id
UNION
SELECT * FROM users RIGHT JOIN comments ON users.id = comments.users_id;
```

### Constraints Cheat Sheet

```
NOT NULL           → Must have a value
AUTO_INCREMENT     → Auto-generates next number
DEFAULT value      → Fallback if no value provided
UNIQUE             → No duplicates allowed
PRIMARY KEY        → Unique row identifier (NOT NULL + UNIQUE)
FOREIGN KEY        → Links to another table's primary key
ON DELETE CASCADE  → Delete children when parent is deleted
ON DELETE SET NULL → Set foreign key to NULL when parent deleted
```

### Data Types Cheat Sheet

```
INT / BIGINT       → Whole numbers
FLOAT / DOUBLE     → Decimal numbers
CHAR(N)            → Fixed-length string
VARCHAR(N)         → Variable-length string (most common)
TEXT               → Long text
DATE               → YYYY-MM-DD
DATETIME           → YYYY-MM-DD HH:MM:SS
```

---

> **🚀 Keep Learning!** This covers all SQL fundamentals taught in the PHP tutorial — from data types and table creation to CRUD operations and JOINs. Next up: subqueries, GROUP BY, HAVING, and aggregate functions!
