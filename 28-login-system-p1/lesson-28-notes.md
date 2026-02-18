# Lesson 28 — Login & Signup System (Part 1)

## Overview

This lesson builds a **user signup and login system** using PHP, MySQL (PDO), sessions, and password hashing. The project follows a **procedural MVC-like pattern**, separating logic into:

- **Model** — Database queries (`signup_model.inc.php`)
- **View** — Output/display functions (`signup_view.inc.php`)
- **Controller** — Validation/business logic (`signup_contr.inc.php`)

> **Code style used:** Procedural PHP (not Object-Oriented)

---

## Project Structure

```
28-login-system-p1/
├── index.php                  ← Main page (Login & Signup forms)
├── db.sql                     ← SQL to create the users table
├── style.css                  ← Basic styling
├── lesson-28-notes.md         ← This notes file
└── includes/
    ├── dbh.inc.php            ← Database connection (PDO)
    ├── config_session.inc.php ← Session configuration & security
    ├── signup.inc.php         ← Signup form handler (main entry point)
    ├── signup_contr.inc.php   ← Signup controller (validation functions)
    ├── signup_model.inc.php   ← Signup model (database queries)
    ├── signup_view.inc.php    ← Signup view (display functions)
    └── login.inc.php          ← Login handler (empty — Part 2)
```

### File naming convention

- `.inc.php` — Means "include" file; these files are meant to be included/required by other files, not accessed directly.

---

## File-by-File Breakdown

---

### `db.sql` — Database Table Definition

```sql
CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(30) NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIME,
    PRIMARY KEY (id)
);
```

| Column       | Type                | Purpose                                        |
| ------------ | ------------------- | ---------------------------------------------- |
| `id`         | INT, AUTO_INCREMENT | Unique user ID, auto-generated                 |
| `username`   | VARCHAR(30)         | The user's chosen username                     |
| `pwd`        | VARCHAR(255)        | Stores the **hashed** password (not plaintext) |
| `email`      | VARCHAR(100)        | User's email address                           |
| `created_at` | DATETIME            | Timestamp of account creation                  |

> `pwd` is VARCHAR(255) because `password_hash()` outputs a 60-character string for bcrypt, but 255 is used as best practice for future algorithm changes.

---

### `index.php` — Main Page

This is the front-end page that displays the **Login form** and **Signup form**.

```php
require_once 'includes/config_session.inc.php';
require_once 'includes/signup_view.inc.php';
```

- **`require_once`** — Includes a file exactly once. If the file is missing, it throws a fatal error (unlike `include` which only gives a warning).
- `config_session.inc.php` is loaded first to start the session (needed to read session data).
- `signup_view.inc.php` is loaded to make `signup_inputs()` and `check_signup_errors()` available.

#### Login Form

```html
<form action="includes/login.inc.php" method="post">
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="pwd" placeholder="Password">
    <button>Login</button>
</form>
```

- Submits via **POST** to `login.inc.php` (not yet implemented).

#### Signup Form

```php
<form action="includes/signup.inc.php" method="post">
    <?php signup_inputs() ?>
    <button>Signup</button>
</form>
```

- Calls `signup_inputs()` to dynamically render the input fields.
- This allows **pre-filling** previously entered data when there's a validation error (so the user doesn't have to retype everything).

#### Error Display

```php
<?php check_signup_errors(); ?>
```

- Calls `check_signup_errors()` to display any signup errors stored in the session.
- Also shows a success message if `?signup=success` is in the URL.

---

### `includes/dbh.inc.php` — Database Connection

```php
$dsn = "mysql:host=localhost;port=55000;dbname=myfirstdatabase";
$dbusername = "root";
$dbpassword = "";

$pdo = new PDO($dsn, $dbusername, $dbpassword);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
```

#### Key concepts

| Term                     | Meaning                                                                                                                  |
| ------------------------ | ------------------------------------------------------------------------------------------------------------------------ |
| **PDO**                  | **PHP Data Objects** — A database abstraction layer that works with multiple databases (MySQL, PostgreSQL, SQLite, etc.) |
| **DSN**                  | **Data Source Name** — Connection string that tells PDO which database to connect to                                     |
| `PDO::ATTR_ERRMODE`      | Sets how PDO reports errors                                                                                              |
| `PDO::ERRMODE_EXCEPTION` | Makes PDO throw `PDOException` on errors (best for debugging)                                                            |

#### Built-in functions/classes used

- **`new PDO($dsn, $user, $pass)`** — Creates a new database connection.
- **`$pdo->setAttribute()`** — Configures PDO behavior.
- **`die()`** — Terminates the script and outputs a message. Alias of `exit()`.

---

### `includes/config_session.inc.php` — Session Configuration & Security

```php
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);
```

| Setting                        | Purpose                                                                                                                    |
| ------------------------------ | -------------------------------------------------------------------------------------------------------------------------- |
| `session.use_only_cookies = 1` | Only accept session IDs from cookies (not from URL parameters). Prevents **session fixation** attacks via URLs.            |
| `session.use_strict_mode = 1`  | Rejects uninitialized session IDs. If someone sends a made-up session ID, PHP will generate a new one instead of using it. |

```php
session_set_cookie_params([
    'lifetime' => 1800,
    'domain' => 'localhost',
    'path' => '/',
    'secure' => true,
    'httponly' => true
]);
```

| Parameter  | Value         | Purpose                                                             |
| ---------- | ------------- | ------------------------------------------------------------------- |
| `lifetime` | 1800 (30 min) | Session cookie expires after 30 minutes of inactivity               |
| `domain`   | `localhost`   | Cookie is only valid for localhost                                  |
| `path`     | `/`           | Cookie is available across the entire site                          |
| `secure`   | `true`        | Cookie is only sent over HTTPS connections                          |
| `httponly` | `true`        | Cookie cannot be accessed by JavaScript (prevents XSS cookie theft) |

```php
session_start();
```

- **`session_start()`** — Starts a new session or resumes an existing one. Must be called before any `$_SESSION` usage.

#### Session ID Regeneration

```php
if (!isset($_SESSION['last_regeneration'])) {
    regenerate_session_id();
} else {
    $interval = 60 * 30;
    if (time() - $_SESSION["last_regeneration"] >= $interval) {
        regenerate_session_id();
    }
}

function regenerate_session_id() {
    session_regenerate_id();
    $_SESSION["last_regeneration"] = time();
}
```

- **`session_regenerate_id()`** — Generates a new session ID while keeping session data. Prevents **session fixation** attacks.
- The session ID is regenerated every 30 minutes.
- **`time()`** — Returns the current Unix timestamp (seconds since Jan 1, 1970).
- **`isset()`** — Checks if a variable is set and not `null`.

---

### `includes/signup.inc.php` — Signup Form Handler (Main Entry Point)

This file processes the signup form submission. It acts as the **router/coordinator** that ties together the Model, View, and Controller.

#### Flow

1. Check if request method is POST
2. Grab form data from `$_POST`
3. Include required files (database, model, view, controller)
4. Run validation checks (controller functions)
5. If errors exist → store in session → redirect back to `index.php`
6. If no errors → create user (model function) → redirect with success

#### Key code explained

```php
$_SERVER["REQUEST_METHOD"] === "POST"
```

- **`$_SERVER`** — A superglobal containing server/request information.
- `REQUEST_METHOD` tells you if the form was submitted via GET or POST.
- This guard ensures the file only processes form submissions, not direct URL visits.

```php
$username = $_POST["username"];
$pwd = $_POST["pwd"];
$email = $_POST["email"];
```

- **`$_POST`** — A superglobal array containing form data sent via POST method.
- The array keys (`"username"`, `"pwd"`, `"email"`) match the `name` attributes on the HTML `<input>` elements.

```php
$errors = [];

if (is_input_empty($username, $pwd, $email)) {
    $errors["empty_input"] = "Fill in all fields!";
} else if (is_email_invalid($email)) {
    $errors["invalid_email"] = "Invalid email used!";
} else if (is_username_taken($pdo, $username)) {
    $errors["username_taken"] = "Username already taken!";
} else if (is_email_registered($pdo, $email)) {
    $errors["empty_used"] = "Email already registered!";
}
```

- Uses `else if` chain so only the **first** matching error is captured (one error at a time).
- Errors are stored in an associative array with descriptive keys.

```php
if ($errors) {
    $_SESSION["errors_signup"] = $errors;
    $_SESSION["signup_data"] = ["username" => $username, "email" => $email];
    header("Location: ../index.php");
    die();
}
```

- **`$_SESSION`** — A superglobal array used to store data across page loads. Data persists until the session expires or is destroyed.
- Stores both the error messages AND the user's input data (so the form can be pre-filled).
- **`header("Location: ...")`** — Sends an HTTP redirect header to the browser.
- **`die()`** — Stops script execution after the redirect (important! Without it, code below continues to run).

```php
create_user($pdo, $pwd, $username, $email);
header("Location: ../index.php?signup=success");
```

- If no errors, creates the user and redirects with `?signup=success` in the URL.
- **`$pdo = null; $stmt = null;`** — Closes the database connection and statement (cleanup).

#### `try/catch` block

```php
try {
    // ... code that might fail
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
```

- **`try/catch`** — Exception handling. If any PDO operation throws an error, the `catch` block runs.
- **`PDOException`** — A specific exception class for database errors.
- **`$e->getMessage()`** — Gets the error message string from the exception.

---

### `includes/signup_contr.inc.php` — Signup Controller (Validation)

Contains all validation/business logic functions. Uses `declare(strict_types=1)` to enforce type checking.

#### `declare(strict_types=1)`

Forces PHP to strictly check function parameter types. Without it, PHP would silently convert `"123"` (string) to `123` (int). With strict types, passing the wrong type causes a `TypeError`.

---

#### `is_input_empty(string $username, string $pwd, string $email): bool`

```php
function is_input_empty(string $username, string $pwd, string $email) {
    if (empty($username) || empty($pwd) || empty($email)) {
        return true;
    } else {
        return false;
    }
}
```

- **`empty()`** — Returns `true` if a variable is empty (`""`, `0`, `null`, `false`, `[]`).
- Checks if **any** of the three fields are empty.
- **`||`** — Logical OR operator.

---

#### `is_email_invalid(string $email): bool`

```php
function is_email_invalid(string $email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}
```

- **`filter_var($value, FILTER_VALIDATE_EMAIL)`** — A built-in PHP function that validates whether a string is a properly formatted email address. Returns the email string if valid, or `false` if invalid.
- **`FILTER_VALIDATE_EMAIL`** — A PHP filter constant that checks for valid email format (e.g., `user@example.com`).

---

#### `is_username_taken(object $pdo, string $username): bool`

```php
function is_username_taken(object $pdo, string $username) {
    if (get_username($pdo, $username)) {
        return true;
    } else {
        return false;
    }
}
```

- Calls the **model function** `get_username()` to check the database.
- If a result is returned (truthy), the username is already taken.

---

#### `is_email_registered(object $pdo, string $email): bool`

```php
function is_email_registered(object $pdo, string $email) {
    if (get_email($pdo, $email)) {
        return true;
    } else {
        return false;
    }
}
```

- Calls the model function `get_email()` to check if the email already exists in the database.

---

#### `create_user(object $pdo, string $pwd, string $username, string $email): void`

```php
function create_user(object $pdo, string $pwd, string $username, string $email) {
    set_user($pdo, $pwd, $username, $email);
}
```

- A wrapper function that calls the model's `set_user()` to insert the new user.
- Acts as a bridge between the handler (`signup.inc.php`) and the model.

---

### `includes/signup_model.inc.php` — Signup Model (Database Queries)

Contains all database interaction functions. This is the only layer that directly talks to the database.

---

#### `get_username(object $pdo, string $username)`

```php
function get_username(object $pdo, string $username) {
    $query = "SELECT username FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}
```

| Step | Code                                       | Purpose                                                                    |
| ---- | ------------------------------------------ | -------------------------------------------------------------------------- |
| 1    | `$pdo->prepare($query)`                    | **Prepared statement** — Pre-compiles the SQL. Prevents **SQL injection**. |
| 2    | `$stmt->bindParam(":username", $username)` | Binds the PHP variable to the `:username` placeholder                      |
| 3    | `$stmt->execute()`                         | Runs the query                                                             |
| 4    | `$stmt->fetch(PDO::FETCH_ASSOC)`           | Fetches one row as an associative array                                    |

- **`:username`** — A **named placeholder** in the prepared statement. The actual value is safely inserted by `bindParam()`.
- **`PDO::FETCH_ASSOC`** — Returns the result as an associative array (keys are column names).
- Returns `false` if no matching user is found.

---

#### `get_email(object $pdo, string $email)`

Same pattern as `get_username()`, but checks the `email` column instead.

---

#### `set_user(object $pdo, string $pwd, string $username, string $email)`

```php
function set_user(object $pdo, string $pwd, string $username, string $email) {
    $query = "INSERT INTO users (username, pwd, email) VALUES (:username, :pwd, :email);";
    $stmt = $pdo->prepare($query);

    $options = ['cost' => 12];
    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":pwd", $hashedPwd);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
}
```

#### Built-in functions used

- **`password_hash($password, $algorithm, $options)`** — Hashes a password securely.
  - **`PASSWORD_BCRYPT`** — Uses the bcrypt algorithm to hash the password.
  - **`'cost' => 12`** — The cost factor (number of times the hashing is applied: 2^12 = 4096 iterations). Higher cost = more secure but slower.
  - Returns a 60-character hashed string (e.g., `$2y$12$...`).
- **NEVER store plaintext passwords** — Always hash them with `password_hash()`.

> **Note:** All 3 placeholders (`:username`, `:pwd`, `:email`) must be bound before calling `execute()`, otherwise you get: `SQLSTATE[HY093]: Invalid parameter number`.

---

### `includes/signup_view.inc.php` — Signup View (Display Functions)

Handles all HTML output related to the signup process.

---

#### `signup_inputs()`

```php
function signup_inputs() {
    if (isset($_SESSION["signup_data"]["username"]) && !isset($_SESSION["errors_signup"]["username_taken"])) {
        echo '<input type="text" name="username" placeholder="Username" value="' . $_SESSION["signup_data"]["username"] . '">';
    } else {
        echo '<input type="text" name="username" placeholder="Username">';
    }

    echo '<input type="password" name="pwd" placeholder="Password">';

    if (isset($_SESSION["signup_data"]["email"]) && !isset($_SESSION["errors_signup"]["email_used"]) && !isset($_SESSION["errors_signup"]["invalid_email"])) {
        echo '<input type="text" name="email" placeholder="E-Mail" value="' . $_SESSION["signup_data"]["email"] . '">';
    } else {
        echo '<input type="text" name="email" placeholder="E-Mail">';
    }
}
```

- **Pre-fills form data** after a failed signup attempt so the user doesn't have to retype.
- Does NOT pre-fill if:
  - The **username** was the problem (username_taken error)
  - The **email** was the problem (email_used or invalid_email error)
- Password is **never** pre-filled (security best practice).

---

#### `check_signup_errors()`

```php
function check_signup_errors() {
    if (isset($_SESSION["errors_signup"])) {
        $errors = $_SESSION["errors_signup"];
        echo "<br>";
        foreach ($errors as $error) {
            echo '<p>' . $error . '</p>';
        }
        unset($_SESSION["errors_signup"]);
    } else if (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        echo "<br>";
        echo "<p>SIGNUP SUCCESS!!!</p>";
    }
}
```

- **`foreach`** — Loops through each error in the array.
- **`unset()`** — Removes the session variable so errors don't persist after being displayed.
- **`$_GET`** — A superglobal array containing URL query parameters (e.g., `?signup=success`).
- Shows a success message when the URL contains `?signup=success`.

---

### `style.css` — Styling

Basic CSS for the forms:

- Centers forms using `margin: auto` and `flexbox`
- Styles inputs with rounded corners (`border-radius: 10px`)
- Dark-themed signup/login button
- Error messages in **red** (`p { color: red; }`)

---

### `includes/login.inc.php` — Login Handler

Currently **empty**. Will be implemented in Part 2.

---

## Key PHP Superglobals Used

| Superglobal | Purpose                                          |
| ----------- | ------------------------------------------------ |
| `$_SERVER`  | Server and request info (`REQUEST_METHOD`, etc.) |
| `$_POST`    | Form data from POST requests                     |
| `$_GET`     | URL query parameters                             |
| `$_SESSION` | Data that persists across page loads (per-user)  |

---

## Key Built-in Functions Summary

| Function                      | Purpose                                            |
| ----------------------------- | -------------------------------------------------- |
| `require_once`                | Include a file (fatal error if missing), only once |
| `session_start()`             | Start or resume a session                          |
| `session_regenerate_id()`     | Generate a new session ID (security)               |
| `session_set_cookie_params()` | Configure session cookie settings                  |
| `ini_set()`                   | Change PHP configuration at runtime                |
| `password_hash()`             | Securely hash a password                           |
| `filter_var()`                | Validate/sanitize data using filters               |
| `empty()`                     | Check if a variable is empty                       |
| `isset()`                     | Check if a variable exists and is not null         |
| `unset()`                     | Destroy/remove a variable                          |
| `header()`                    | Send raw HTTP headers (used for redirects)         |
| `die()` / `exit()`            | Terminate script execution                         |
| `time()`                      | Get current Unix timestamp                         |
| `echo`                        | Output a string                                    |

---

## Security Concepts Covered

| Concept                         | How it's implemented                                        |
| ------------------------------- | ----------------------------------------------------------- |
| **SQL Injection Prevention**    | Prepared statements with `bindParam()`                      |
| **Password Hashing**            | `password_hash()` with bcrypt (cost 12)                     |
| **Session Fixation Prevention** | `session_regenerate_id()` every 30 minutes                  |
| **Session Cookie Security**     | `httponly`, `secure`, `use_only_cookies`, `use_strict_mode` |
| **XSS Prevention (partial)**    | `httponly` cookies prevent JS access to session             |

---

## Application Flow Diagram

```
User visits index.php
        │
        ├── Fills signup form → POST to signup.inc.php
        │       │
        │       ├── Validation fails?
        │       │       ├── Store errors in $_SESSION["errors_signup"]
        │       │       ├── Store form data in $_SESSION["signup_data"]
        │       │       └── Redirect → index.php (shows errors)
        │       │
        │       └── Validation passes?
        │               ├── Hash password
        │               ├── Insert into database
        │               └── Redirect → index.php?signup=success
        │
        └── index.php loads
                ├── signup_inputs() → renders form (pre-fills if session data exists)
                └── check_signup_errors() → shows errors OR success message
```

---

## Common Mistakes to Watch For

1. **Session key mismatch** — Using `$_SESSION["error_signup"]` in one file and `$_SESSION["errors_signup"]` in another. Always use the exact same key.
2. **Missing `die()` after `header()`** — Without `die()`, PHP continues executing code after a redirect.
3. **Unbound parameters** — Every `:placeholder` in a prepared statement must have a matching `bindParam()` call.
4. **Malformed HTML in `echo`** — Missing closing `>` on tags or broken `<p>` tags won't render correctly.
5. **Function name mismatch** — Calling `create_user()` when the model function is named `set_user()` (the controller wraps it).

---

## Core Concepts Explained

---

### Procedural Code vs Object-Oriented Code

PHP supports two major coding styles:

#### Procedural Code (used in this project)

Code is written as a sequence of **functions** and **statements** executed top-to-bottom. Data is passed between functions as parameters.

```php
// Procedural style — standalone functions
function get_username($pdo, $username) {
    $query = "SELECT username FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Called directly
$result = get_username($pdo, "john");
```

- Functions are **independent** — they don't belong to a class.
- Data is passed around via **parameters** and **return values**.
- Simpler to learn and understand for beginners.

#### Object-Oriented Code (OOP) — not used here, but good to know

Code is organized into **classes** and **objects**. Functions (called **methods**) and data (called **properties**) are bundled together inside a class.

```php
// OOP style — methods inside a class
class UserModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getUsername(string $username) {
        $query = "SELECT username FROM users WHERE username = :username";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Used by creating an object
$userModel = new UserModel($pdo);
$result = $userModel->getUsername("john");
```

| Aspect       | Procedural                 | Object-Oriented                         |
| ------------ | -------------------------- | --------------------------------------- |
| Structure    | Functions + variables      | Classes + objects                       |
| Data access  | Passed as parameters       | Stored in object properties (`$this->`) |
| Reusability  | Copy-paste functions       | Inheritance, interfaces                 |
| Complexity   | Simpler for small projects | Better for large, scalable projects     |
| This project | ✅ Used                     | ❌ Not used                              |

> This project uses **procedural code** because it's easier to learn. Most PHP frameworks (Laravel, Symfony) use OOP.

---

### MVC Pattern (Model-View-Controller)

MVC is a **design pattern** that separates an application into three layers. This project follows a procedural MVC-like structure:

```
┌─────────────────────────────────────────────────┐
│                   MVC Pattern                    │
├─────────────┬─────────────┬─────────────────────┤
│   MODEL     │    VIEW     │     CONTROLLER      │
│             │             │                     │
│ Database    │ HTML output │ Validation &        │
│ queries     │ & display   │ business logic      │
│             │             │                     │
│ signup_     │ signup_     │ signup_             │
│ model.inc   │ view.inc    │ contr.inc           │
│ .php        │ .php        │ .php                │
└─────────────┴─────────────┴─────────────────────┘
```

| Layer          | File                   | Responsibility                                              | Example                                    |
| -------------- | ---------------------- | ----------------------------------------------------------- | ------------------------------------------ |
| **Model**      | `signup_model.inc.php` | Talks to the database (SELECT, INSERT, etc.)                | `get_username()`, `set_user()`             |
| **View**       | `signup_view.inc.php`  | Generates HTML output shown to the user                     | `signup_inputs()`, `check_signup_errors()` |
| **Controller** | `signup_contr.inc.php` | Validates input, applies business rules, decides what to do | `is_input_empty()`, `is_email_invalid()`   |

#### Why use MVC?

- **Separation of concerns** — Each file has one job. Database code doesn't mix with HTML.
- **Easier to debug** — If there's a database bug, you look in the Model. Display bug? Look in the View.
- **Easier to maintain** — You can change the HTML without touching the database code.
- **Team friendly** — Different developers can work on different layers.

#### The coordinator: `signup.inc.php`

In this project, `signup.inc.php` acts as the **entry point/router** that connects all three layers:

```
Form POST → signup.inc.php (coordinator)
                │
                ├── Calls Controller functions (validate)
                ├── Calls Model functions (database)
                └── Redirects to View (display)
```

---

### Type Declarations (`declare(strict_types=1)`)

PHP is a **loosely typed** language by default — it automatically converts between types:

```php
// Without strict types (default PHP behavior)
function add(int $a, int $b) {
    return $a + $b;
}

add("5", "3");  // PHP silently converts strings to ints → returns 8
```

#### `declare(strict_types=1)` — Enables strict mode

```php
<?php
declare(strict_types=1);  // Must be the VERY FIRST statement in the file

function add(int $a, int $b) {
    return $a + $b;
}

add("5", "3");  // ❌ TypeError! Strings are NOT allowed where int is expected
add(5, 3);      // ✅ Works — correct types
```

#### Type hints used in this project

```php
// Parameter type hints — specify what type each parameter must be
function is_input_empty(string $username, string $pwd, string $email) { ... }
//                      ^^^^^^           ^^^^^^        ^^^^^^
//                      type hints ensure only strings are accepted

function is_username_taken(object $pdo, string $username) { ... }
//                         ^^^^^^
//                         $pdo must be an object (PDO instance)
```

| Type Hint | Accepts                  | Example               |
| --------- | ------------------------ | --------------------- |
| `string`  | Text values              | `"hello"`, `""`       |
| `int`     | Whole numbers            | `42`, `0`, `-1`       |
| `float`   | Decimal numbers          | `3.14`                |
| `bool`    | `true` or `false`        | `true`                |
| `array`   | Arrays                   | `[1, 2, 3]`           |
| `object`  | Any object               | `$pdo` (PDO instance) |
| `void`    | Function returns nothing | Used as return type   |

#### Why use strict types?

- **Catches bugs early** — Wrong types cause errors instead of silent conversions.
- **Self-documenting** — You can see what each function expects just by reading the signature.
- **More predictable** — No unexpected type juggling.

> In this project, `signup_contr.inc.php`, `signup_model.inc.php`, and `signup_view.inc.php` all use `declare(strict_types=1)`.