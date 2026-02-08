# SQL Data Types Reference Guide

## 1. Numeric Data Types
Used for storing mathematical values. These are categorized by their storage size and whether they allow decimals.

| Data Type  | Range (Signed)                  | Purpose                                                           |
| :--------- | :------------------------------ | :---------------------------------------------------------------- |
| **INT**    | -2,147,483,648 to 2,147,483,647 | Standard whole numbers (User IDs, counts).                        |
| **BIGINT** | ± 9.22 Quintillion              | Massive datasets (Global transaction IDs, social media views).    |
| **FLOAT**  | ~7 decimal digits precision     | Approximate values where speed is prioritized over precision.     |
| **DOUBLE** | ~15 decimal digits precision    | High-precision decimal values (Scientific data, GPS coordinates). |

### ⚖️ Signed vs. Unsigned
This determines if the column can store negative numbers.
* **Signed (Default):** Permits both positive and negative values.
* **Unsigned:** Does **not** permit negative values. The range starts at **0**, which effectively **doubles** the positive capacity.
    * *Example:* A `SIGNED TINYINT` is -128 to 127. An `UNSIGNED TINYINT` is 0 to 255.
    * *Best Practice:* Use `UNSIGNED` for values that can never be negative (age, stock quantity, primary keys).

---

## 2. String (Text) Data Types
Used for alphanumeric data like names, emails, and descriptions.

| Data Type      | Limit              | Storage Behavior                                                       |
| :------------- | :----------------- | :--------------------------------------------------------------------- |
| **CHAR(N)**    | Up to 255          | **Fixed length.** Always uses N space (pads with spaces).              |
| **VARCHAR(N)** | Up to 65,535       | **Variable length.** Only uses space for the actual characters stored. |
| **TEXT**       | Up to 65,535 bytes | Best for very long notes, blog posts, or large descriptions.           |

### 💡 What do the parentheses `( )` do?
* **For Strings (VARCHAR):** It sets a **hard limit**. `VARCHAR(30)` acts as a gatekeeper; it will stop you from entering 31 characters, helping maintain data integrity.
* **For Numbers (INT):** Historically, `INT(11)` referred to the **display width** (padding) in older terminal interfaces. In modern SQL (like MySQL 8.0+), these parentheses for integers are mostly ignored and do not change the storage size.

---

## 3. Date and Time Data Types
Essential for tracking when records are created or when events occur.

| Data Type    | Format              | Example             |
| :----------- | :------------------ | :------------------ |
| **DATE**     | YYYY-MM-DD          | 2023-05-14          |
| **DATETIME** | YYYY-MM-DD HH:MM:SS | 2023-05-14 16:00:00 |

### ⚠️ Critical Cautions:
* **The Format Rule:** SQL is rigid. You **must** use `YYYY-MM-DD`. Swapping to `DD-MM-YYYY` is the #1 cause of "Invalid Date" errors.
* **Time Zone Blindness:** `DATETIME` is literal. It stays exactly as you saved it regardless of the user's location. For global applications, many developers prefer `TIMESTAMP` (which converts to UTC).
* **Zero Dates:** Modern SQL versions often block `0000-00-00`. Use `NULL` for empty date fields to avoid errors.

---

## 4. Practical Table Example
```sql
CREATE TABLE employee_records (
    emp_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, -- No negative IDs, doubles capacity
    full_name VARCHAR(100) NOT NULL,                -- Variable length for efficiency
    biography TEXT,                                 -- Long-form text
    salary DOUBLE(10, 2),                           -- High precision for money
    date_of_birth DATE,                             -- Strict YYYY-MM-DD
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP   -- Full timestamp
);
```

---

## 5. Table Constraints & Keys

### 5.1 What Are Constraints?

Constraints are **rules** you put on columns to enforce data integrity. They make sure bad or incomplete data can't sneak into your database.

| Constraint       | What It Does                                                  | Example                                             |
| :--------------- | :------------------------------------------------------------ | :-------------------------------------------------- |
| `NOT NULL`       | Column **must** have a value — empty/null is rejected         | `username VARCHAR(30) NOT NULL`                     |
| `AUTO_INCREMENT` | Automatically generates the next number (1, 2, 3…)            | `id INT(11) NOT NULL AUTO_INCREMENT`                |
| `DEFAULT`        | Sets a fallback value if none is provided                     | `created_at DATETIME NOT NULL DEFAULT CURRENT_TIME` |
| `UNIQUE`         | No two rows can have the same value in this column            | `email VARCHAR(100) UNIQUE`                         |
| `PRIMARY KEY`    | Uniquely identifies each row (combines `NOT NULL` + `UNIQUE`) | `PRIMARY KEY(id)`                                   |
| `FOREIGN KEY`    | Links a column to the primary key of **another** table        | `FOREIGN KEY(users_id) REFERENCES users(id)`        |

---

### 5.2 Understanding Keys

#### Primary Key

| **Why**   | Every table needs a way to **uniquely identify** each row. Without it, you can't reliably find, update, or delete a specific record. |
| :-------- | :----------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | Mark one column (usually `id`) as `PRIMARY KEY`. It must be `NOT NULL` and each value must be **unique**.                            |
| **Where** | Every table should have exactly **one** primary key.                                                                                 |

- Automatically enforces `NOT NULL` + `UNIQUE`
- Typically paired with `AUTO_INCREMENT` so IDs are generated automatically
- A table can have **only one** primary key

#### Secondary Key (Index)

| **Why**   | To **speed up** searches on columns you query frequently (e.g., searching by `username` or `email`).                    |
| :-------- | :---------------------------------------------------------------------------------------------------------------------- |
| **How**   | Create an index on the column. It's like a book index — MySQL can jump to the right row instead of scanning everything. |
| **Where** | Columns used in `WHERE` clauses, `JOIN` conditions, or `ORDER BY`.                                                      |

```sql
-- Create an index on the username column for faster lookups
CREATE INDEX idx_username ON users(username);
```

> **📝 Note:** A secondary key (index) does **not** enforce uniqueness — it's purely for performance. If you also need uniqueness, use `UNIQUE INDEX`.

#### Foreign Key

| **Why**   | To create a **relationship** between two tables. It ensures that a value in one table actually exists in another table. |
| :-------- | :---------------------------------------------------------------------------------------------------------------------- |
| **How**   | Point a column in the child table to the primary key of the parent table using `FOREIGN KEY ... REFERENCES`.            |
| **Where** | Any time tables are related — users & comments, orders & products, students & courses.                                  |

---

## 6. Creating Tables — Full Example

### 6.1 The `users` Table (Parent)

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

**Line-by-line breakdown:**

| Column       | Type           | Constraints                                 | Why                                                               |
| :----------- | :------------- | :------------------------------------------ | :---------------------------------------------------------------- |
| `id`         | `INT(11)`      | `NOT NULL`, `AUTO_INCREMENT`, `PRIMARY KEY` | Unique identifier — auto-generates 1, 2, 3…                       |
| `username`   | `VARCHAR(30)`  | `NOT NULL`                                  | Max 30 characters, cannot be empty                                |
| `pwd`        | `VARCHAR(255)` | `NOT NULL`                                  | 255 chars to store **hashed** passwords (never store plain text!) |
| `email`      | `VARCHAR(100)` | `NOT NULL`                                  | Max 100 characters for email                                      |
| `created_at` | `DATETIME`     | `NOT NULL`, `DEFAULT CURRENT_TIME`          | Automatically records when the user was created                   |

---

### 6.2 The `comments` Table (Child — linked to `users`)

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

**Line-by-line breakdown:**

| Column         | Type          | Constraints                                 | Why                                                 |
| :------------- | :------------ | :------------------------------------------ | :-------------------------------------------------- |
| `id`           | `INT(11)`     | `NOT NULL`, `AUTO_INCREMENT`, `PRIMARY KEY` | Unique comment ID                                   |
| `username`     | `VARCHAR(30)` | `NOT NULL`                                  | Who wrote the comment                               |
| `comment_text` | `TEXT`        | `NOT NULL`                                  | The actual comment (unlimited length)               |
| `created_at`   | `DATETIME`    | `NOT NULL`, `DEFAULT CURRENT_TIME`          | When the comment was posted                         |
| `users_id`     | `INT(11)`     | *(nullable)*                                | Links to `users.id` — which user wrote this comment |

**The Foreign Key line explained:**

```sql
FOREIGN KEY(users_id) REFERENCES users(id) ON DELETE SET NULL
--          ↑                      ↑              ↑
--    Column in THIS table    Column in PARENT   What happens when the
--    (comments.users_id)     table (users.id)   parent row is deleted
```

> **📝 Note:** `users_id` is **not** set to `NOT NULL` — it's intentionally nullable. This allows `ON DELETE SET NULL` to work. If it were `NOT NULL`, setting it to `NULL` would violate the constraint.

---

## 7. Foreign Key Delete Behaviors (`ON DELETE`)

### 7.1 The Problem

When a user deletes their account (parent row is removed from `users`), what should happen to their comments (child rows in `comments`) that still reference that user?

**By default, you get an error** — MySQL will **refuse** to delete the user because other rows depend on them. The `ON DELETE` clause tells MySQL how to handle this.

---

### 7.2 The Four Options

| Behavior              | What Happens                                                                                                    | Use When                                                                                                     |
| :-------------------- | :-------------------------------------------------------------------------------------------------------------- | :----------------------------------------------------------------------------------------------------------- |
| `ON DELETE NO ACTION` | ❌ **Blocks the delete.** Error thrown — you cannot delete the parent if children exist.                         | You want to **protect** related data. Force the app to delete children first.                                |
| `ON DELETE RESTRICT`  | ❌ **Same as NO ACTION** in MySQL. Prevents deletion of the parent row.                                          | Same as above — they behave identically in MySQL.                                                            |
| `ON DELETE CASCADE`   | 🔥 **Deletes children too.** When the user is deleted, all their comments are **automatically deleted** as well. | When child data has no meaning without the parent (e.g., delete user → delete their sessions).               |
| `ON DELETE SET NULL`  | 🔄 **Sets the foreign key to NULL.** The comments stay, but `users_id` becomes `NULL` (the link is broken).      | When child data should **survive** but lose the parent reference (e.g., keep comments, show "deleted user"). |

### 7.3 Visual Example

**Starting data:**

| `users` table |              | `comments` table |              |
| :------------ | :----------- | :--------------- | :----------- |
| **id**        | **username** | **id**           | **users_id** |
| 1             | Shimu        | 1                | 1            |
| 2             | Frida        | 2                | 1            |
|               |              | 3                | 2            |

**Now we run:** `DELETE FROM users WHERE id = 1;` (Shimu deletes her account)

| `ON DELETE` Option       | Result in `comments`                                                               |
| :----------------------- | :--------------------------------------------------------------------------------- |
| `NO ACTION` / `RESTRICT` | ❌ **Error!** Delete is blocked because comments with `users_id = 1` still exist.   |
| `CASCADE`                | Comments 1 and 2 are **permanently deleted** along with Shimu's account.           |
| `SET NULL`               | Comments 1 and 2 **remain**, but `users_id` is set to `NULL` (anonymous comments). |

### 7.4 Syntax

```sql
-- Block delete if children exist (default behavior)
FOREIGN KEY(users_id) REFERENCES users(id) ON DELETE NO ACTION

-- Delete all related children automatically
FOREIGN KEY(users_id) REFERENCES users(id) ON DELETE CASCADE

-- Keep children but set the link to NULL
FOREIGN KEY(users_id) REFERENCES users(id) ON DELETE SET NULL
```

> **⚠️ Be careful with `CASCADE`** — it can silently delete a lot of data. If a user has 500 comments and you cascade-delete the user, all 500 comments vanish instantly with no undo.

> **💡 Best Practice:** For most web apps:
> - Use `SET NULL` for content that should survive (comments, posts, reviews)
> - Use `CASCADE` for data that's meaningless without the parent (login sessions, shopping cart items)
> - Use `RESTRICT` / `NO ACTION` when you want the app to handle cleanup explicitly