# SQL Data Manipulation — INSERT, UPDATE & DELETE

> **Purpose:** Learn how to add, modify, and remove data in a MySQL database.  
> **Database used:** `database`  
> **Tables used:** `users`, `comments`

---

## 📑 Table of Contents

1. [INSERT — Adding Data](#1-insert--adding-data)
2. [UPDATE — Modifying Data](#2-update--modifying-data)
3. [WHERE — Targeting Specific Rows](#3-where--targeting-specific-rows)
4. [AND / OR — Combining Conditions](#4-and--or--combining-conditions)
5. [DELETE — Removing Data](#5-delete--removing-data)
6. [AUTO_INCREMENT After Deletion](#6-auto_increment-after-deletion)
7. [Inserting Into Related Tables (Foreign Keys)](#7-inserting-into-related-tables-foreign-keys)

---

## 1. INSERT — Adding Data

| **Why**   | To add new rows (records) into a table — this is how users, comments, products, etc. get stored in the database for the first time. |
| :-------- | :---------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | Use `INSERT INTO table (columns) VALUES (values);` — columns and values must match in order and count.                              |
| **Where** | Registration forms, posting comments, placing orders — anytime new data enters the system.                                          |

### Syntax

```sql
INSERT INTO table_name (column1, column2, column3)
VALUES ('value1', 'value2', 'value3');
```

### Example — Adding users

```sql
-- Insert first user
INSERT INTO users (username, pwd, email)
VALUES ('Shimu', 'spass1234', 'shimu@gmail.com');

-- Insert second user
INSERT INTO users (username, pwd, email)
VALUES ('Violet', 'vpass1234', 'violet@gmail.com');
```

**Result in `users` table:**

| id   | username | pwd       | email            | created_at          |
| :--- | :------- | :-------- | :--------------- | :------------------ |
| 1    | Shimu    | spass1234 | shimu@gmail.com  | 2026-02-08 12:00:00 |
| 2    | Violet   | vpass1234 | violet@gmail.com | 2026-02-08 12:01:00 |

> **📝 Note:** We didn't include `id` or `created_at` because:
> - `id` has `AUTO_INCREMENT` — the database generates it automatically (1, 2, 3…)
> - `created_at` has `DEFAULT CURRENT_TIME` — it fills in the current date/time on its own

---

## 2. UPDATE — Modifying Data

| **Why**   | To change existing data without deleting and re-inserting the row. Users change passwords, update profiles, fix typos — `UPDATE` handles all of that. |
| :-------- | :---------------------------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | Use `UPDATE table SET column = 'new_value' WHERE condition;` — the `WHERE` clause targets which row(s) to change.                                     |
| **Where** | Profile edits, password resets, status changes, any data correction.                                                                                  |

### Syntax

```sql
UPDATE table_name
SET column1 = 'new_value1', column2 = 'new_value2'
WHERE condition;
```

### Example — Update by `id`

```sql
UPDATE users SET username = 'VioletVV', pwd = 'vpass5678'
WHERE id = 2;
```

**Result:**

| id   | username     | pwd           | email            |
| :--- | :----------- | :------------ | :--------------- |
| 1    | Shimu        | spass1234     | shimu@gmail.com  |
| 2    | **VioletVV** | **vpass5678** | violet@gmail.com |

> **⚠️ CRITICAL: Always use `WHERE` with `UPDATE`!**  
> Without `WHERE`, **every row** in the table gets updated:
> ```sql
> -- 🚨 DANGER — this changes ALL users' passwords!
> UPDATE users SET pwd = 'oops';
> ```

---

## 3. WHERE — Targeting Specific Rows

| **Why**   | `WHERE` acts as a **filter** — it tells MySQL which specific row(s) to affect. Without it, your `UPDATE` or `DELETE` applies to the **entire table**. |
| :-------- | :---------------------------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | Add `WHERE column = value` after your `UPDATE` or `DELETE` statement.                                                                                 |
| **Where** | Every `UPDATE` and `DELETE` statement — practically required for safe data manipulation.                                                              |

### Example

```sql
-- Target by primary key (most precise — always targets exactly one row)
WHERE id = 2

-- Target by any column value
WHERE username = 'Violet'

-- Target by multiple conditions (see AND/OR below)
WHERE username = 'Violet' AND pwd = 'vpass1234'
```

> **💡 Best Practice:** Whenever possible, use the **primary key** (`id`) in your `WHERE` clause. It's guaranteed to be unique, so you'll never accidentally affect the wrong row.

---

## 4. AND / OR — Combining Conditions

| **Why**   | Sometimes one condition isn't enough to pinpoint the right row(s). `AND` and `OR` let you combine multiple conditions for precise targeting. |
| :-------- | :------------------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | `AND` = **both** conditions must be true. `OR` = **at least one** must be true.                                                              |
| **Where** | Login checks (username AND password), searching by multiple criteria, flexible filters.                                                      |

### Example — UPDATE with AND

```sql
UPDATE users SET username = 'VioletVV', pwd = 'vpass5678'
WHERE username = 'Violet' AND pwd = 'vpass1234';
```

This only updates the row where **both** conditions are true:
- ✅ `username` is `'Violet'` **AND**
- ✅ `pwd` is `'vpass1234'`

If either condition is false, **nothing happens** — no row is changed.

### AND vs OR

| Operator | Logic                  | Example                               | Matches            |
| :------- | :--------------------- | :------------------------------------ | :----------------- |
| `AND`    | **Both** must be true  | `WHERE id = 1 AND username = 'Shimu'` | Only if both match |
| `OR`     | **Either** can be true | `WHERE id = 1 OR id = 2`              | Matches both rows  |

```sql
-- AND: Precise — both conditions required
DELETE FROM users WHERE username = 'Shimu' AND email = 'shimu@gmail.com';

-- OR: Broader — either condition is enough
DELETE FROM users WHERE id = 1 OR id = 3;
```

---

## 5. DELETE — Removing Data

| **Why**   | To permanently remove rows from a table — account deletion, removing spam, cleaning old data.   |
| :-------- | :---------------------------------------------------------------------------------------------- |
| **How**   | Use `DELETE FROM table WHERE condition;` — the `WHERE` clause specifies which row(s) to remove. |
| **Where** | Account deletion, removing comments, clearing expired sessions.                                 |

### Syntax

```sql
DELETE FROM table_name WHERE condition;
```

### Example

```sql
DELETE FROM users WHERE id = 1;
```

**Result:** Shimu's row is permanently removed.

| id    | username  | pwd           | email               |
| :---- | :-------- | :------------ | :------------------ |
| ~~1~~ | ~~Shimu~~ | ~~spass1234~~ | ~~shimu@gmail.com~~ |
| 2     | VioletVV  | vpass5678     | violet@gmail.com    |

> **⚠️ CRITICAL: Always use `WHERE` with `DELETE`!**  
> Without `WHERE`, you delete **every single row** in the table:
> ```sql
> -- 🚨 DANGER — this empties the entire table!
> DELETE FROM users;
> ```
> There is **no undo** — the data is gone.

---

## 6. AUTO_INCREMENT After Deletion

### What happens when you delete a row and insert a new one?

After deleting user with `id = 1` (Shimu), the next inserted user does **not** get `id = 1` again:

```sql
-- Shimu (id = 1) was deleted. Now we insert a new user:
INSERT INTO users (username, pwd, email)
VALUES ('Tara', 'tpass1234', 'tara@gmail.com');
```

**Result:**

| id    | username | pwd       | email            |
| :---- | :------- | :-------- | :--------------- |
| 2     | VioletVV | vpass5678 | violet@gmail.com |
| **3** | Tara     | tpass1234 | tara@gmail.com   |

Tara gets `id = 3`, not `id = 1`.

### Why?

`AUTO_INCREMENT` always continues from the **highest value ever used** — it never recycles deleted IDs.

### Why you should NEVER manually change IDs:

| Reason                  | Explanation                                                                                                   |
| :---------------------- | :------------------------------------------------------------------------------------------------------------ |
| **Breaks foreign keys** | Other tables (like `comments`) may reference `id = 1`. Reusing it would link Tara to Shimu's old comments.    |
| **Causes collisions**   | If you set an ID to 5 manually, and `AUTO_INCREMENT` also tries to generate 5, you get a duplicate key error. |
| **Gaps are normal**     | Every production database has gaps in IDs. It's expected and harmless — IDs are identifiers, not counters.    |
| **Security risk**       | Sequential, gap-free IDs reveal how many users you have. Gaps make it harder to guess valid IDs.              |

> **💡 Bottom line:** Let the database handle IDs. Gaps in `AUTO_INCREMENT` are perfectly fine — don't touch them.

---

## 7. Inserting Into Related Tables (Foreign Keys)

### Adding a comment linked to a user

Since the `comments` table has a `users_id` foreign key that references `users(id)`, you must provide a **valid user ID** when inserting a comment:

```sql
INSERT INTO comments (username, comment_text, users_id)
VALUES ('Shimu', 'This is a comment on a website!', 1);
```

**Result in `comments` table:**

| id   | username | comment_text                    | created_at          | users_id |
| :--- | :------- | :------------------------------ | :------------------ | :------- |
| 1    | Shimu    | This is a comment on a website! | 2026-02-08 12:05:00 | 1        |

The `users_id = 1` links this comment to the user with `id = 1` in the `users` table.

> **⚠️ Important:** If `users_id = 1` doesn't exist in the `users` table, MySQL will **reject** the insert with a foreign key constraint error. The foreign key ensures **referential integrity** — you can't create orphan comments pointing to non-existent users.

---

## 📌 Quick Reference

```sql
-- INSERT: Add new data
INSERT INTO table (col1, col2) VALUES ('val1', 'val2');

-- UPDATE: Modify existing data (always use WHERE!)
UPDATE table SET col1 = 'new' WHERE id = 1;

-- DELETE: Remove data (always use WHERE!)
DELETE FROM table WHERE id = 1;

-- WHERE: Filter which rows to affect
WHERE column = 'value'

-- AND: Both conditions must be true
WHERE col1 = 'a' AND col2 = 'b'

-- OR: Either condition can be true
WHERE col1 = 'a' OR col1 = 'b'
```
