# Lesson 22 — Inserting Data into a Database with PHP

> **Purpose:** Learn how to securely insert user-submitted form data into a MySQL database using PHP and PDO prepared statements.  
> **Files:** `form.php`, `includes/formhandler.php`  
> **Database:** `database` → `users` table

---

## 📑 Table of Contents

1. [Prepared Statements — What & Why](#1-prepared-statements--what--why)
2. [The Two Types of Prepared Statements](#2-the-two-types-of-prepared-statements)
3. [Line-by-Line Breakdown of formhandler.php](#3-line-by-line-breakdown-of-formhandlerphp)
4. [require vs include vs die vs exit](#4-require-vs-include-vs-die-vs-exit)
5. [When to Use htmlspecialchars()](#5-when-to-use-htmlspecialchars)
6. [Parameter Order Matters](#6-parameter-order-matters)
7. [Full Code Reference](#7-full-code-reference)

---

## 1. Prepared Statements — What & Why

| **Why**   | Without prepared statements, user input goes directly into your SQL query — a hacker can type malicious SQL into your form and **take over your entire database** (SQL injection attack). Prepared statements make this **impossible**. |
| :-------- | :-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | Instead of putting values directly in the query, you put **placeholders** (`?` or `:name`). PHP sends the query structure and the values **separately** to MySQL, so user input is never treated as SQL code.                           |
| **Where** | **Every single query** that uses any form of user input — no exceptions.                                                                                                                                                                |

### Without prepared statement (DANGEROUS ❌):

```php
<?php
// 🚨 NEVER DO THIS — vulnerable to SQL injection
$query = "INSERT INTO users (username) VALUES ('$username')";
$pdo->query($query);

// A hacker could type:   '); DROP TABLE users; --
// This would DELETE your entire users table!
?>
```

### With prepared statement (SAFE ✅):

```php
<?php
$query = "INSERT INTO users (username) VALUES (?);";
$stmt = $pdo->prepare($query);
$stmt->execute([$username]);
// Even if $username contains malicious SQL, it's treated as plain text
?>
```

> **💡 Rule:** If your page is **not using prepared statements**, your page is **not secure**. Period.

---

## 2. The Two Types of Prepared Statements

PDO supports two ways to write placeholders:

---

### Method 1: Positional Parameters (`?`) — Unnamed

Placeholders are `?` marks. Values are passed in an array **in the same order** as the `?` marks appear.

```php
<?php
$query = "INSERT INTO users (username, pwd, email) VALUES (?, ?, ?);";
$stmt = $pdo->prepare($query);
$stmt->execute([$username, $pwd, $email]);
//              1st ?      2nd ?  3rd ?
?>
```

| Pros                      | Cons                                                              |
| :------------------------ | :---------------------------------------------------------------- |
| ✅ Shorter to write        | ❌ Order matters — mix them up and wrong data goes to wrong column |
| ✅ Good for simple queries | ❌ Harder to read with many parameters                             |

---

### Method 2: Named Parameters (`:name`) — Named

Placeholders have names starting with `:`. Values are bound by name, so **order doesn't matter**.

```php
<?php
$query = "INSERT INTO users (username, pwd, email) VALUES (:username, :pwd, :email);";
$stmt = $pdo->prepare($query);

// Option A: bind individually then execute
$stmt->bindParam(":username", $username);
$stmt->bindParam(":pwd", $pwd);
$stmt->bindParam(":email", $email);
$stmt->execute();

// Option B: pass as associative array in execute
$stmt->execute([
    ":username" => $username,
    ":pwd" => $pwd,
    ":email" => $email
]);
?>
```

| Pros                                                 | Cons                    |
| :--------------------------------------------------- | :---------------------- |
| ✅ Order doesn't matter — bound by name               | ❌ Slightly more verbose |
| ✅ Self-documenting — `:username` is clearer than `?` |                         |
| ✅ Easier to debug with many parameters               |                         |

> **💡 Pro Tip:** For simple queries with 2–3 parameters, positional `?` is fine. For complex queries with many parameters, named `:param` is much safer and more readable.

---

## 3. Line-by-Line Breakdown of `formhandler.php`

### Check if form was submitted via POST

```php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
```

- **Why:** Prevents users from accessing `formhandler.php` directly via the browser URL (which would be a GET request).
- **How:** `$_SERVER["REQUEST_METHOD"]` returns `"POST"` or `"GET"` depending on how the page was reached.
- **Where:** Always at the top of any form handler file.

---

### Grab form data

```php
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $email = $_POST["email"];
```

- `$_POST` is a superglobal array that contains all data sent via the POST method.
- The keys (`"username"`, `"pwd"`, `"email"`) must match the `name` attributes in `form.php`'s `<input>` tags.

---

### Open try-catch and load the database connection

```php
    try {
        require_once "../../20-connect-db/includes/dbh.inc.php";
```

- `try { }` catches any database errors so the page doesn't crash with an ugly PHP error.
- `require_once` loads the database connection — after this line, `$pdo` is available.

---

### Prepare and execute the query

```php
        $query = "INSERT INTO users (username, pwd, email) VALUES (?, ?, ?);";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username, $pwd, $email]);
```

| Line                    | What It Does                                                 |
| :---------------------- | :----------------------------------------------------------- |
| `$query = "INSERT ..."` | SQL with `?` placeholders — values are NOT embedded here     |
| `$pdo->prepare($query)` | Sends the query structure to MySQL for compilation           |
| `$stmt->execute([...])` | Sends the actual values separately — MySQL fills in the `?`s |

> `$stmt` stands for **statement** — it's the prepared query object.

---

### Close the connection

```php
        $pdo = null;
        $stmt = null;
```

- Sets both objects to `null` which destroys the PDO connection and statement.
- **Why?** PHP auto-closes connections when the script ends, but explicitly closing is a good habit — especially for high-traffic sites.

---

### Redirect and stop

```php
        header("Location: ../form.php");
        die();
```

- `header("Location: ...")` tells the browser to go to another page.
- `die()` **stops the script immediately** after the redirect — without this, PHP continues executing the remaining code.

> **⚠️ Important:** `die()` must come **after** `header()`. If `die()` came first, the redirect would never happen because the script would already be stopped.

---

### Error handling and fallback

```php
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../form.php");
}
```

- `catch` block runs only if something fails inside `try` (connection error, SQL error, constraint violation).
- `else` block runs if someone accessed the file via GET (typed the URL directly) — redirects them back to the form.

---

## 4. `require` vs `include` vs `die()` vs `exit()`

### File Inclusion — Comparison Table

| Function       | If File NOT Found                | Duplicate Protection        | Use When                                            |
| :------------- | :------------------------------- | :-------------------------- | :-------------------------------------------------- |
| `include`      | ⚠️ Warning → script **continues** | ❌ No                        | Optional files — page can work without them         |
| `include_once` | ⚠️ Warning → script **continues** | ✅ Skips if already included | Optional files included from multiple places        |
| `require`      | ❌ Fatal Error → script **stops** | ❌ No                        | Essential files — page **cannot** work without them |
| `require_once` | ❌ Fatal Error → script **stops** | ✅ Skips if already included | ⭐ **Database connections**, config files            |

```php
<?php
// ✅ Best for DB connection — fatal if missing, won't duplicate
require_once "includes/dbh.inc.php";

// ❌ Bad for DB — if file is missing, script continues with no $pdo
include "includes/dbh.inc.php";
?>
```

> **Why `require_once` for the database?** If the connection file is missing, every query will fail. Better to **stop immediately** with a clear error than to continue and get confusing "undefined variable $pdo" errors.

---

### Script Termination — `die()` vs `exit()`

| Function      | What It Does                                              | Difference           |
| :------------ | :-------------------------------------------------------- | :------------------- |
| `die("msg")`  | Stops the script immediately, optionally prints a message | Alias for `exit()`   |
| `exit("msg")` | Stops the script immediately, optionally prints a message | Identical to `die()` |

```php
<?php
// These are EXACTLY the same:
die("Something went wrong");
exit("Something went wrong");

// Both can also take a status code:
exit(1);  // Non-zero = error
exit(0);  // Zero = success
?>
```

> **💡 Convention:** Most PHP developers use `die()` for error situations and `exit()` for normal termination — but they're functionally **identical**. Pick one and be consistent.

---

## 5. When to Use `htmlspecialchars()`

| Situation                                       | Use `htmlspecialchars()`? | Why                                                                                 |
| :---------------------------------------------- | :------------------------ | :---------------------------------------------------------------------------------- |
| **Outputting data in the browser** (echo, HTML) | ✅ **YES — always**        | Prevents XSS attacks — user input could contain `<script>` tags                     |
| **Inserting data into the database**            | ❌ **No**                  | Prepared statements handle security; `htmlspecialchars()` would corrupt stored data |
| **Passing data between PHP variables**          | ❌ **No**                  | No browser involved — no XSS risk                                                   |

```php
<?php
// ❌ DON'T sanitize before database insert
$username = htmlspecialchars($_POST["username"]); // NO — corrupts data in DB
$stmt->execute([$username]);

// ✅ DO sanitize when displaying in the browser
echo htmlspecialchars($row["username"]); // YES — prevents XSS
?>
```

> **Rule of thumb:** `htmlspecialchars()` is for **output** (browser display). Prepared statements are for **input** (database queries). Don't mix them up.

---

## 6. Parameter Order Matters

With **positional parameters** (`?`), the order in `execute()` **must match** the order of `?` placeholders in the query:

```php
<?php
$query = "INSERT INTO users (username, pwd, email) VALUES (?, ?, ?);";
//                           1st       2nd  3rd

// ✅ CORRECT — same order
$stmt->execute([$username, $pwd, $email]);
//               1st       2nd   3rd

// ❌ WRONG — swapped order
$stmt->execute([$email, $username, $pwd]);
//               1st     2nd       3rd
// Result: email goes into username column, username into pwd, pwd into email!
?>
```

### What happens if the order is wrong?

- **No error is thrown** — PHP doesn't know the order is wrong
- Data silently goes into the **wrong columns**
- A user's email ends up as their username, username as their password, etc.
- Extremely hard to debug because everything "works" but the data is scrambled

> **💡 This is why named parameters are safer for complex queries:**
> ```php
> // Order in execute() doesn't matter — bound by name
> $stmt->execute([
>     ":email" => $email,
>     ":username" => $username,  // Different order — still correct!
>     ":pwd" => $pwd
> ]);
> ```

---

## 7. Full Code Reference

### `form.php` — The Signup Form

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3>Signup</h3>
    <form action="includes/formhandler.php" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="pwd" placeholder="Password">
        <input type="text" name="email" placeholder="E-Mail">
        <button>Signup</button>
    </form>
</body>
</html>
```

### `includes/formhandler.php` — The Handler

```php
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $email = $_POST["email"];

    try {
        require_once "../../20-connect-db/includes/dbh.inc.php";

        $query = "INSERT INTO users (username, pwd, email) VALUES (?, ?, ?);";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username, $pwd, $email]);

        $pdo = null;
        $stmt = null;

        header("Location: ../form.php");
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../form.php");
}
```

### The Complete Flow:

```
User fills out form.php → clicks "Signup"
       ↓
Browser sends POST request to includes/formhandler.php
       ↓
formhandler.php grabs $_POST data
       ↓
Loads database connection (dbh.inc.php) → $pdo is ready
       ↓
Prepares INSERT query with ? placeholders
       ↓
Executes with actual values → data safely inserted into users table
       ↓
Closes connection ($pdo = null, $stmt = null)
       ↓
Redirects user back to form.php
```
