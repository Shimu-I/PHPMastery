# Connecting PHP to a MySQL Database

> **Purpose:** Understand how PHP connects to a MySQL database, the 3 connection methods, file naming conventions, and a line-by-line breakdown of the connection file.  
> **File:** `includes/dbh.inc.php`  
> **Database:** `database` (running on XAMPP/MySQL)

---

## 📑 Table of Contents

1. [Why Do We Need a Database Connection?](#1-why-do-we-need-a-database-connection)
2. [File Naming Convention — `dbh.inc.php`](#2-file-naming-convention--dbhincphp)
3. [The 3 Ways to Connect PHP to MySQL](#3-the-3-ways-to-connect-php-to-mysql)
4. [Line-by-Line Breakdown of `dbh.inc.php`](#4-line-by-line-breakdown-of-dbhincphp)
5. [Quick Reference](#5-quick-reference)

---

## 1. Why Do We Need a Database Connection?

| **Why**   | PHP and MySQL are two separate systems. PHP runs the website logic; MySQL stores the data. For PHP to read, insert, update, or delete data, it must first **establish a connection** to the MySQL server — like opening a phone line before making a call. |
| :-------- | :--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | Create a dedicated PHP file that holds the connection code. Include this file in any page that needs database access.                                                                                                                                      |
| **Where** | Every page that interacts with the database — login, registration, displaying comments, dashboards, admin panels.                                                                                                                                          |

### The flow:

```
Browser → PHP file → includes dbh.inc.php → connects to MySQL → runs queries → returns data → PHP generates HTML → Browser displays it
```

> **💡 Best Practice:** Keep the connection in a **separate file** and `require` it where needed. This way, if your database password or host changes, you update **one file** instead of every page.

---

## 2. File Naming Convention — `dbh.inc.php`

The filename `dbh.inc.php` isn't random — each part has a meaning:

| Part   | Stands For                   | Purpose                                                                                                                                   |
| :----- | :--------------------------- | :---------------------------------------------------------------------------------------------------------------------------------------- |
| `dbh`  | **D**ata**b**ase **H**andler | Describes what this file does — it handles the database connection                                                                        |
| `.inc` | **Inc**lude                  | Signals to other developers that this file is meant to be **included** in other files (via `require` or `include`), not accessed directly |
| `.php` | PHP file                     | It's still a PHP file — the server processes it as PHP. The `.inc` is just a naming convention, not a different file type                 |

### The `includes/` folder

```
20-connect-db/
├── conn-db.php              ← The page that uses the database
├── connection.md            ← This notes file
└── includes/
    └── dbh.inc.php          ← Database connection (kept separate)
```

> **💡 Why a separate folder?** Organizing include files into an `includes/` folder is a PHP convention. It keeps your project structure clean and makes it clear which files are utilities vs. pages.

### Why does `dbh.inc.php` need to be inside the `includes/` folder?

It doesn't **need** to be — PHP will work regardless of where you put it. But developers do it for 4 important reasons:

**1. Separation of concerns**
- Files in the root are **pages** users visit (`conn-db.php`, `index.php`)
- Files in `includes/` are **utilities** pulled into pages — they're never accessed directly by the browser

**2. Security**
- If someone guesses your file path and visits `yoursite.com/dbh.inc.php` directly, they could potentially see an error or blank page that leaks info. Keeping include files in a subfolder makes it easier to block direct access via `.htaccess`:

```apache
# Inside includes/.htaccess
Deny from all
```

**3. Scalability**
- As your project grows, you'll have many include files (`dbh.inc.php`, `auth.inc.php`, `helpers.inc.php`, `config.inc.php`). Without a dedicated folder, your root becomes a mess of pages mixed with utility files.

**4. Team readability**
- Any developer joining your project instantly understands: *"files in `includes/` are not standalone pages — they're meant to be `require`d."*

**Typical professional project structure:**

```
project/
├── index.php              ← Page (user visits this)
├── login.php              ← Page
├── dashboard.php          ← Page
└── includes/              ← Utilities (never visited directly)
    ├── dbh.inc.php        ← Database connection
    ├── auth.inc.php       ← Authentication helpers
    └── config.inc.php     ← Site-wide settings
```

> **💡 Bottom line:** You *could* put `dbh.inc.php` in the root and it would work — but every PHP framework and professional project uses a folder structure like this for organization, security, and clarity.

### How to include it in other files:

```php
<?php
require_once "includes/dbh.inc.php";
// Now $pdo is available — you can run queries
?>
```

| Function       | Behavior if file not found                       | Use when                               |
| :------------- | :----------------------------------------------- | :------------------------------------- |
| `include`      | ⚠️ Warning, script **continues**                  | Optional files (nice-to-have)          |
| `require`      | ❌ Fatal error, script **stops**                  | Essential files like the DB connection |
| `include_once` | Same as `include`, but skips if already included | Preventing duplicate includes          |
| `require_once` | Same as `require`, but skips if already included | ✅ **Best for DB connection**           |

---

## 3. The 3 Ways to Connect PHP to MySQL

PHP offers 3 different methods (called **extensions**) to talk to MySQL. They all connect to the same database but differ in features, safety, and flexibility.

---

### 3.1 `mysql_*` (Old MySQL Extension) — ❌ NEVER USE

| **What**         | The original PHP MySQL extension (`mysql_connect`, `mysql_query`, etc.)                                            |
| :--------------- | :----------------------------------------------------------------------------------------------------------------- |
| **Status**       | **Removed** from PHP 7.0+. Does not exist in modern PHP.                                                           |
| **Why it's bad** | No prepared statements (vulnerable to SQL injection), no OOP support, no error handling, deprecated since PHP 5.5. |

```php
<?php
// ❌ DO NOT USE — removed from PHP 7.0+
$conn = mysql_connect("localhost", "root", "");
mysql_select_db("database", $conn);
$result = mysql_query("SELECT * FROM users");
?>
```

| Problem                    | Explanation                                                              |
| :------------------------- | :----------------------------------------------------------------------- |
| **SQL Injection**          | User input goes directly into queries — hackers can inject malicious SQL |
| **No prepared statements** | Can't separate SQL logic from user data                                  |
| **Removed**                | Won't work on any modern PHP installation                                |

> **⚠️ If you see `mysql_connect` in a tutorial, that tutorial is outdated. Close it and find a newer one.**

---

### 3.2 `mysqli` (MySQL Improved) — ✅ Usable

| **What**       | The improved MySQL extension. Supports both procedural and object-oriented syntax.                               |
| :------------- | :--------------------------------------------------------------------------------------------------------------- |
| **Status**     | ✅ Active and maintained. Works only with **MySQL** databases.                                                    |
| **Why use it** | Simple to learn, supports prepared statements, good for MySQL-only projects.                                     |
| **Limitation** | Only works with MySQL — if you ever switch to PostgreSQL, SQLite, etc., you must rewrite all your database code. |

#### Procedural style:

```php
<?php
$conn = mysqli_connect("localhost", "root", "", "database");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully!";
?>
```

#### Object-oriented style:

```php
<?php
$conn = new mysqli("localhost", "root", "", "database");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully!";
?>
```

---

### 3.3 `PDO` (PHP Data Objects) — ✅ Recommended

| **What**                             | A database abstraction layer that works with **12+ database systems**, not just MySQL.                                                            |
| :----------------------------------- | :------------------------------------------------------------------------------------------------------------------------------------------------ |
| **Status**                           | ✅ Active, modern, and the **recommended** approach.                                                                                               |
| **Why use it**                       | Database-agnostic (switch databases without rewriting code), consistent API, excellent error handling, named placeholders in prepared statements. |
| **This is what `dbh.inc.php` uses.** |                                                                                                                                                   |

```php
<?php
$dsn = "mysql:host=localhost;dbname=database";
$dbusername = "root";
$dbpassword = "";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
```

---

### 3.4 Comparison Table

| Feature                        | `mysql_*`    | `mysqli`            | `PDO`                        |
| :----------------------------- | :----------- | :------------------ | :--------------------------- |
| **Status**                     | ❌ Removed    | ✅ Active            | ✅ Active                     |
| **Prepared statements**        | ❌ No         | ✅ Yes               | ✅ Yes                        |
| **Object-oriented**            | ❌ No         | ✅ Yes               | ✅ Yes                        |
| **Procedural**                 | ✅ Yes        | ✅ Yes               | ❌ No                         |
| **Works with other databases** | ❌ MySQL only | ❌ MySQL only        | ✅ **12+ databases**          |
| **Named placeholders**         | ❌ No         | ❌ No (`?` only)     | ✅ Yes (`:name`)              |
| **Error handling**             | Poor         | OK                  | ✅ **Excellent** (exceptions) |
| **Recommendation**             | 🚫 Never      | 👍 OK for MySQL-only | ⭐ **Best choice**            |

> **💡 Bottom line:** Use **PDO**. It's the industry standard for modern PHP. If you learn PDO, you can connect to MySQL, PostgreSQL, SQLite, SQL Server, and more — all with the same syntax.

---

## 4. Line-by-Line Breakdown of `dbh.inc.php`

Here is the full file, followed by a detailed explanation of **every single line**:

```php
<?php

$dsn = "mysql:host=localhost:55000;dbname=database";
$dbusername = "root";
$dbpassword = "";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
```

---

### Line 1: `<?php`

Opens a PHP block. Since this file is **pure PHP** (no HTML), we don't need a closing `?>` tag — omitting it is actually best practice to avoid accidental whitespace issues.

---

### Line 3: `$dsn = "mysql:host=localhost:55000;dbname=database";`

**DSN** stands for **Data Source Name** — it tells PDO **where** and **what** to connect to.

| Part                   | Meaning                                                                                                                                                                 |
| :--------------------- | :---------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `mysql:`               | The **database driver** — tells PDO to use the MySQL driver                                                                                                             |
| `host=localhost:55000` | The **server address** — `localhost` means the database is on the same machine. `:55000` is the **port number** (default MySQL port is `3306`; your XAMPP uses `55000`) |
| `dbname=database`      | The **name of the database** to connect to                                                                                                                              |

> **📝 Note:** If your MySQL runs on the default port (`3306`), the DSN would be:
> ```php
> $dsn = "mysql:host=localhost;dbname=database";
> ```

---

### Line 4: `$dbusername = "root";`

The **MySQL username**. In XAMPP's default setup, the username is `root` — the admin account with full privileges.

> **⚠️ In production:** Never use `root`. Create a dedicated database user with only the permissions it needs.

---

### Line 5: `$dbpassword = "";`

The **MySQL password**. XAMPP's default `root` account has **no password** (empty string).

> **⚠️ In production:** Always set a strong password. Consider using environment variables (`$_ENV`) to keep passwords out of your code.

---

### Line 7: `try {`

Opens a **try-catch block** — PHP's error handling mechanism. The code inside `try` will **attempt** to connect. If it fails, execution jumps to the `catch` block instead of crashing the entire page.

---

### Line 8: `$pdo = new PDO($dsn, $dbusername, $dbpassword);`

This is the line that **actually creates the connection**.

| Part           | Meaning                                                                          |
| :------------- | :------------------------------------------------------------------------------- |
| `new PDO(...)` | Creates a new PDO **object** (an instance of the PDO class)                      |
| `$dsn`         | Where to connect (host + database name)                                          |
| `$dbusername`  | Login username                                                                   |
| `$dbpassword`  | Login password                                                                   |
| `$pdo`         | The variable that **holds** the connection — you'll use this in all your queries |

If the connection succeeds, `$pdo` is now a live connection to your database. If it fails (wrong password, database doesn't exist, MySQL not running), it throws a `PDOException`.

---

### Line 9: `$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);`

Configures **how PDO reports errors**.

| Part                      | Meaning                                          |
| :------------------------ | :----------------------------------------------- |
| `$pdo->setAttribute(...)` | Set a configuration option on the PDO connection |
| `PDO::ATTR_ERRMODE`       | The setting we're changing — the **error mode**  |
| `PDO::ERRMODE_EXCEPTION`  | The value — throw **exceptions** on errors       |

**The 3 error modes:**

| Mode                     | Behavior                                             | Recommended?          |
| :----------------------- | :--------------------------------------------------- | :-------------------- |
| `PDO::ERRMODE_SILENT`    | Errors are ignored — you must manually check         | ❌ Dangerous           |
| `PDO::ERRMODE_WARNING`   | PHP warning is issued, but script continues          | ❌ Easy to miss        |
| `PDO::ERRMODE_EXCEPTION` | Exception is thrown — stops execution, can be caught | ✅ **Always use this** |

> **Why this matters:** Without `ERRMODE_EXCEPTION`, a failed query would silently return `false` and you'd spend hours wondering why your page shows no data. With exceptions, you get an immediate, descriptive error message.

---

### Line 10: `} catch (PDOException $e) {`

If **anything** inside the `try` block fails (connection error, wrong credentials, database doesn't exist), execution jumps here.

| Part           | Meaning                                                           |
| :------------- | :---------------------------------------------------------------- |
| `catch`        | Catches the error instead of letting it crash the page            |
| `PDOException` | The specific type of error we're catching (PDO-related errors)    |
| `$e`           | The **exception object** — contains details about what went wrong |

---

### Line 11: `echo "Connection failed: " . $e->getMessage();`

Displays the error message to help you debug.

| Part               | Meaning                                                             |
| :----------------- | :------------------------------------------------------------------ |
| `$e->getMessage()` | Gets the human-readable error description from the exception object |

**Common error messages you might see:**

| Error                           | Cause                        | Fix                             |
| :------------------------------ | :--------------------------- | :------------------------------ |
| `could not find driver`         | PDO MySQL driver not enabled | Enable `pdo_mysql` in `php.ini` |
| `Access denied for user 'root'` | Wrong username or password   | Check credentials               |
| `Unknown database 'database'`   | Database doesn't exist       | Create it in phpMyAdmin         |
| `Connection refused`            | MySQL server isn't running   | Start MySQL in XAMPP            |
| `No connection could be made`   | Wrong host or port           | Verify host and port number     |

> **⚠️ In production:** Don't echo database errors to users — it reveals sensitive info (database name, host, etc.). Log them to a file instead:
> ```php
> catch (PDOException $e) {
>     error_log("DB Connection Error: " . $e->getMessage());
>     die("Something went wrong. Please try again later.");
> }
> ```

---

## 5. Quick Reference

### Connection Template (copy & adapt)

```php
<?php
// includes/dbh.inc.php

$dsn        = "mysql:host=localhost;dbname=YOUR_DATABASE_NAME";
$dbusername = "root";
$dbpassword = "";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
```

### Using the connection in other files

```php
<?php
// In any PHP page that needs the database:
require_once "includes/dbh.inc.php";

// Now $pdo is available — run your queries:
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute([':id' => 1]);
$user = $stmt->fetch();
```

### Cheat Sheet

```
$dsn                    → Data Source Name (where + what database)
new PDO(...)            → Creates the connection object
setAttribute(...)       → Configures PDO behavior
ERRMODE_EXCEPTION       → Throw errors as catchable exceptions
try { } catch { }       → Handle connection errors gracefully
require_once            → Include the connection file (fail if missing)
$e->getMessage()        → Get the error description from an exception
```
