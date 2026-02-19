# Lesson 29 — Login & Signup System (Part 2)

## Overview

Part 2 continues from **Lesson 28** and adds the **Login**, **Logout**, and **Session Management** features. The project still uses **procedural PHP** with a **MVC-like pattern**.

> **Code style:** Procedural PHP (not OOP)
> **Pattern:** MVC-like (Model → DB queries, View → display, Controller → validation)

---

## What's New in Part 2 (Added on top of Part 1)

| Feature | Files Added/Changed | Why |
|---|---|---|
| **Login system** | `login.inc.php`, `login_contr.inc.php`, `login_model.inc.php`, `login_view.inc.php` | Users can now log in with username & password |
| **Logout system** | `logout.inc.php` | Users can destroy their session and log out |
| **Login form visibility** | `index.php` | Login form hides when user is already logged in |
| **Session ID regeneration** | `config_session.inc.php` | Prevents session fixation attacks by regenerating session IDs |
| **Login error display** | `login_view.inc.php` | Shows login errors and success messages |
| **Username display** | `login_view.inc.php` | Shows "logged in as ..." when session is active |

---

## Project Structure

```
29-login-system-p2/
├── index.php                    ← Main page (Login, Signup, Logout forms)
├── db.sql                       ← SQL to create the users table
├── style.css                    ← Basic styling
├── lesson-29-notes.md           ← This notes file
└── includes/
    ├── dbh.inc.php              ← Database connection (PDO)
    ├── config_session.inc.php   ← Session config, security & ID regeneration
    ├── signup.inc.php           ← Signup form handler
    ├── signup_contr.inc.php     ← Signup controller (validation)
    ├── signup_model.inc.php     ← Signup model (DB queries)
    ├── signup_view.inc.php      ← Signup view (form inputs & error display)
    ├── login.inc.php            ← Login form handler (NEW)
    ├── login_contr.inc.php      ← Login controller (validation) (NEW)
    ├── login_model.inc.php      ← Login model (DB query) (NEW)
    ├── login_view.inc.php       ← Login view (username & error display) (NEW)
    └── logout.inc.php           ← Logout handler (NEW)
```

---

## File-by-File Breakdown (New Files Only)

---

### `login.inc.php` — Login Form Handler

- Entry point when the login form is submitted
- Checks `$_SERVER["REQUEST_METHOD"] === "POST"` to only accept POST requests
- Collects `$_POST["username"]` and `$_POST["pwd"]`
- Requires `dbh.inc.php`, `login_model.inc.php`, `login_view.inc.php`, `login_contr.inc.php`
- Runs error checks: empty input → wrong username → wrong password
- If errors exist → stores them in `$_SESSION["errors_login"]` and redirects back
- If no errors → sets session variables (`user_id`, `user_username`, `last_regeneration`) and redirects with `?login=success`

**Key session variables set on login:**
```php
$_SESSION["user_id"] = $result["id"];
$_SESSION["user_username"] = htmlspecialchars($result["username"]);
$_SESSION["last_regeneration"] = time();
```

---

### `login_model.inc.php` — Login Model (DB Query)

- Contains `get_user($pdo, $username)` function
- Uses `SELECT *` to fetch the full user row by username
- Returns the result as an associative array (or `false` if not found)
- Uses **prepared statements** with `bindParam()` to prevent SQL injection

```php
function get_user(object $pdo, string $username) {
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}
```

---

### `login_contr.inc.php` — Login Controller (Validation)

- `declare(strict_types=1)` — enforces type checking
- **3 validation functions:**

| Function | What it checks |
|---|---|
| `is_input_empty($username, $pwd)` | Are username or password empty? |
| `is_username_wrong($result)` | Did the DB query return `false` (user not found)? |
| `is_password_wrong($pwd, $hashPwd)` | Does `password_verify()` fail? |

- `is_username_wrong()` uses a **union type**: `bool|array $result` — because `PDO::fetch()` returns `false` (bool) on failure or an array on success

---

### `login_view.inc.php` — Login View (Display)

- **2 functions:**

| Function | Purpose |
|---|---|
| `output_username()` | Displays "logged in as [username]" or "not logged in" based on `$_SESSION["user_id"]` |
| `check_login_errors()` | Displays login error messages from `$_SESSION["errors_login"]` and clears them, or shows success message |

---

### `logout.inc.php` — Logout Handler

- Must use the **same `session_set_cookie_params()`** as `config_session.inc.php` before calling `session_start()`
- Calls `session_unset()` → clears all session variables
- Calls `session_destroy()` → destroys the session on server
- Calls `setcookie()` → tells the browser to delete the session cookie
- Redirects to `index.php`

```php
session_start();
session_unset();
session_destroy();
setcookie(session_name(), '', time() - 3600, '/', 'localhost', true, true);
header("Location: ../index.php");
die();
```

---

### `config_session.inc.php` — Session Security (Updated)

**What it does:**
1. Forces cookies-only sessions (`use_only_cookies`)
2. Enables strict mode (`use_strict_mode`)
3. Sets secure cookie parameters (lifetime, httponly, secure, domain, path)
4. Starts the session
5. Regenerates session ID every 30 minutes for both logged-in and guest users

**Two regeneration functions:**

| Function | For | What it does |
|---|---|---|
| `regenerate_session_id()` | Guest (not logged in) | Simple `session_regenerate_id(true)` + update timestamp |
| `regenerate_session_id_loggedin()` | Logged-in user | Simple `session_regenerate_id(true)` + update timestamp |

**Why regenerate session IDs?**
- Prevents **session fixation attacks** — where an attacker sets a known session ID and waits for the victim to log in with it
- `session_regenerate_id(true)` creates a new ID and **deletes the old session file** (`true` parameter)

---

### `index.php` — Main Page (Updated)

**New features added:**
- Displays logged-in username via `output_username()`
- **Conditionally hides the login form** when `$_SESSION["user_id"]` is set
- Shows login errors via `check_login_errors()`
- Includes a **Logout form** that posts to `logout.inc.php`

**Conditional form display pattern:**
```php
<?php if (!isset($_SESSION["user_id"])) { ?>
    <!-- Login form HTML here -->
<?php } ?>
```

---

## Key Concepts Used

### 1. `declare(strict_types=1)`
- Enforces strict type checking for function parameters
- If a function expects `string`, passing `int` will throw a `TypeError`
- Must be the **very first statement** in the file

### 2. Union Types (`bool|array`)
- PHP 8+ feature
- Allows a parameter or return type to accept multiple types
- Used in `is_username_wrong(bool|array $result)` because `PDO::fetch()` returns `false` or an array

### 3. `password_verify($pwd, $hashPwd)`
- Compares a plain-text password against a bcrypt hash
- Returns `true` if they match, `false` if not
- Used in `is_password_wrong()` in the login controller

### 4. `htmlspecialchars()`
- Converts special characters to HTML entities
- Prevents **XSS (Cross-Site Scripting)** attacks
- Used when storing username in session: `htmlspecialchars($result["username"])`

### 5. `session_regenerate_id(true)`
- Generates a new session ID and deletes the old session data
- The `true` parameter ensures the old session file is deleted
- Prevents session fixation attacks

### 6. `setcookie()` for logout
- Used to delete the session cookie from the browser
- Setting expiry to `time() - 3600` (past time) tells the browser to remove it

### 7. `$_SERVER["REQUEST_METHOD"]`
- Checks if the request is POST/GET
- Prevents direct URL access to form handler files

---

## Bugs Faced & Fixed

### Bug 1: Login form not disappearing after login
- **Problem:** `$_SESSION["user_Id"]` (capital `I`) was set in `login.inc.php`, but `index.php` and `login_view.inc.php` checked for `$_SESSION["user_id"]` (lowercase `i`)
- **Cause:** Case mismatch in array key — PHP array keys are case-sensitive
- **Fix:** Changed `$_SESSION["user_Id"]` → `$_SESSION["user_id"]` in `login.inc.php`
- **Lesson:** Always be consistent with naming. PHP array keys are **case-sensitive**

### Bug 2: Logout button not working
- **Problem:** `logout.inc.php` used a bare `session_start()` without matching cookie parameters
- **Cause:** The session was created with specific `session_set_cookie_params()` settings (domain, path, secure, httponly). Without those same settings, `session_start()` starts a **new empty session** instead of resuming the existing one. The old session was never destroyed.
- **Fix:** Added the same `session_set_cookie_params()` before `session_start()`, and added `setcookie()` to delete the cookie from the browser
- **Lesson:** When destroying a session, you must use the **same cookie parameters** that were used to create it

### Bug 3: `Undefined array key "user_id"` warning in `config_session.inc.php`
- **Problem:** `regenerate_session_id()` function tried to access `$_SESSION["user_id"]` for non-logged-in users
- **Cause:** The function was meant for **guest users** who don't have a `user_id` in their session, but it contained code that built a custom session ID using the user ID
- **Fix:** Removed the `$_SESSION["user_id"]`, `session_create_id()`, and `session_id()` lines — guest regeneration only needs `session_regenerate_id(true)`
- **Lesson:** `regenerate_session_id()` (guest) and `regenerate_session_id_loggedin()` serve **different purposes**. Don't mix their logic.

### Bug 4: `Session ID cannot be changed when a session is active` warning
- **Problem:** `session_id()` was called after `session_regenerate_id(true)` inside `regenerate_session_id()`
- **Cause:** `session_regenerate_id()` already regenerates the ID while the session is active. Calling `session_id()` after that tries to change it again, which PHP doesn't allow
- **Fix:** Removed the `session_id()` call from the guest regeneration function
- **Lesson:** You **cannot** call `session_id()` while a session is active. Use it **before** `session_start()` or use `session_regenerate_id()` instead

### Bug 5: Stray `?>` rendering on the page
- **Problem:** A literal `?>` text appeared on the page between the login form and error display
- **Cause:** An extra `?>` was left in `index.php` outside of PHP tags, so it rendered as visible text
- **Fix:** Removed the stray `?>`
- **Lesson:** Be careful with opening/closing PHP tags in mixed HTML/PHP files

---

## Complete Logic Summary

### Signup Flow (numbered steps)

1. User fills in username, password, email in the signup form
2. Form submits via POST to `signup.inc.php`
3. Check `$_SERVER["REQUEST_METHOD"] === "POST"`
4. Require `dbh.inc.php`, `signup_model.inc.php`, `signup_view.inc.php`, `signup_contr.inc.php`
5. Validate: is input empty? → if yes, add `$errors["empty_input"] = "Fill in all fields!"`
6. Validate: is email format invalid? → `filter_var($email, FILTER_VALIDATE_EMAIL)` → if fails, add `$errors["invalid_email"] = "Invalid email used!"`
7. Validate: is username already taken? → query DB with `get_username()` → if found, add `$errors["username_taken"] = "Username already taken!"`
8. Validate: is email already registered? → query DB with `get_email()` → if found, add `$errors["empty_used"] = "Email already registered!"`
9. If errors → store in `$_SESSION["errors_signup"]` + store form data in `$_SESSION["signup_data"]` → redirect back to `index.php`
10. On `index.php` → `check_signup_errors()` runs and detects `$_SESSION["errors_signup"]`
11. It loops through errors with `foreach` and displays each as `<p>error message</p>` in **red**
12. After displaying, it clears them with `unset($_SESSION["errors_signup"])`
13. `signup_inputs()` checks `$_SESSION["signup_data"]` and **pre-fills** the form fields so user doesn't re-type:
    - Pre-fills **username** only if the error was NOT `username_taken`
    - Pre-fills **email** only if the error was NOT `email_used` or `invalid_email`
    - **Password is never pre-filled** (security best practice)
14. If no errors → hash password with `password_hash($pwd, PASSWORD_BCRYPT, ['cost' => 12])`
15. Insert new user into DB with prepared statement (`set_user()`)
16. Redirect to `index.php?signup=success`
17. On `index.php` → `check_signup_errors()` detects `$_GET["signup"] === "success"` and shows `"SIGNUP SUCCESS!!!"`

### Signup Error Display Logic (how errors appear under signup form)

**How it works step by step:**

1. `signup.inc.php` creates an `$errors = []` array
2. Validations use `if/else if` chain (stops at first failure category)
3. Error is added: `$errors["error_name"] = "Error message"`
4. Form data (username, email) is saved: `$_SESSION["signup_data"] = ["username" => $username, "email" => $email]`
5. Both `$errors` and form data are stored in session → redirect back to `index.php`
6. `check_signup_errors()` checks `isset($_SESSION["errors_signup"])`
7. If errors exist → loops through and echoes each as a `<p>` tag → then `unset()`
8. If no errors but `$_GET["signup"] === "success"` → shows success message

**Pre-filling form fields after error (`signup_inputs()`):**
```php
function signup_inputs() {
    // Pre-fill username if saved AND error was not "username_taken"
    if (isset($_SESSION["signup_data"]["username"]) && !isset($_SESSION["errors_signup"]["username_taken"])) {
        echo '<input type="text" name="username" placeholder="Username" value="' . $_SESSION["signup_data"]["username"] . '">';
    } else {
        echo '<input type="text" name="username" placeholder="Username">';
    }

    // Password is NEVER pre-filled
    echo '<input type="password" name="pwd" placeholder="Password">';

    // Pre-fill email if saved AND error was not "email_used" or "invalid_email"
    if (isset($_SESSION["signup_data"]["email"]) && !isset($_SESSION["errors_signup"]["email_used"]) && !isset($_SESSION["errors_signup"]["invalid_email"])) {
        echo '<input type="text" name="email" placeholder="E-Mail" value="' . $_SESSION["signup_data"]["email"] . '">';
    } else {
        echo '<input type="text" name="email" placeholder="E-Mail">';
    }
}
```

**Why pre-fill form fields?**
- Better UX — user doesn't have to re-type everything after one mistake
- Only the **problematic field** is cleared so user knows which one to fix
- Password is never pre-filled for security reasons

**Error display code from `signup_view.inc.php`:**
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

### Login Flow (numbered steps)

1. User fills in username and password in the login form
2. Form submits via POST to `login.inc.php`
3. Check `$_SERVER["REQUEST_METHOD"] === "POST"`
4. Require `dbh.inc.php`, `login_model.inc.php`, `login_view.inc.php`, `login_contr.inc.php`
5. Validate: is input empty? → if yes, add `$errors["empty_input"] = "Fill in all fields!"`
6. Query DB for user by username (`get_user()`) → returns full user row or `false`
7. Validate: does user exist? → if `false`, add `$errors["login_incorrect"] = "Incorrect login info!"`
8. Validate: does password match hash? → `password_verify($pwd, $result["pwd"])` → if fails, add `$errors["login_incorrect"] = "Incorrect login info!"`
9. If errors → store in `$_SESSION["errors_login"]` → redirect back to `index.php`
10. On `index.php` → `check_login_errors()` runs and detects `$_SESSION["errors_login"]`
11. It loops through errors with `foreach` and displays each as `<p>error message</p>` in **red** (styled by CSS)
12. After displaying, it clears them with `unset($_SESSION["errors_login"])` so they don't show again on refresh
13. If no errors → set `$_SESSION["user_id"]`, `$_SESSION["user_username"]`, `$_SESSION["last_regeneration"]`
14. Redirect to `index.php?login=success`
15. On `index.php` → `check_login_errors()` detects `$_GET["login"] === "success"` and shows `"LOGIN SUCCESS!!!"`
16. `output_username()` shows "logged in as [name]"
17. Login form is **hidden** because `$_SESSION["user_id"]` is now set

### Login Error Display Logic (how errors appear under login form)

**How it works step by step:**

1. `login.inc.php` creates an `$errors = []` array
2. Each validation adds a key-value pair: `$errors["error_name"] = "Error message"`
3. The entire `$errors` array is stored in the session: `$_SESSION["errors_login"] = $errors`
4. Page redirects back to `index.php` (this is a **POST-Redirect-GET** pattern)
5. `index.php` calls `check_login_errors()` from `login_view.inc.php`
6. The function checks `isset($_SESSION["errors_login"])`
7. If errors exist → loops through and echoes each as a `<p>` tag
8. Then `unset($_SESSION["errors_login"])` clears them so they disappear on next refresh
9. If no errors but `$_GET["login"] === "success"` → shows success message

**Why use sessions for errors instead of URL parameters?**
- Sessions can store **arrays** (multiple errors at once)
- URL parameters are visible and can be manipulated by users
- Sessions are cleared after displaying, preventing stale error messages

**Why `unset()` after displaying?**
- Without `unset()`, refreshing the page would show the same errors again
- `unset()` ensures errors are **one-time flash messages**

**Code from `login_view.inc.php`:**
```php
function check_login_errors() {
    if (isset($_SESSION["errors_login"])) {
        $errors = $_SESSION["errors_login"];
        echo "<br>";
        foreach ($errors as $error) {
            echo "<p>" . $error . "</p>";
        }
        unset($_SESSION["errors_login"]);
    } else if (isset($_GET["login"]) && $_GET["login"] === "success") {
        echo "<br>";
        echo "<p>LOGIN SUCCESS!!!</p>";
    }
}
```

**Same pattern used for signup errors** in `signup_view.inc.php` with `$_SESSION["errors_signup"]`

### Signup Error Display Logic (same pattern)

1. `signup.inc.php` builds `$errors[]` array with validation messages
2. Stores in `$_SESSION["errors_signup"]` + stores form data in `$_SESSION["signup_data"]`
3. Redirects back to `index.php`
4. `check_signup_errors()` loops through and displays errors, then `unset()`
5. `signup_inputs()` pre-fills username/email from `$_SESSION["signup_data"]` so user doesn't re-type
6. Skips pre-filling if that specific field caused the error (e.g., won't pre-fill username if it's taken)

### Logout Flow (numbered steps)

1. User clicks the Logout button
2. Form submits via POST to `logout.inc.php`
3. Set the same `session_set_cookie_params()` as `config_session.inc.php`
4. Call `session_start()` to resume the existing session
5. Call `session_unset()` → clears all `$_SESSION` variables
6. Call `session_destroy()` → destroys the session on the server
7. Call `setcookie()` with past expiry → deletes cookie from browser
8. Redirect to `index.php`
9. On `index.php` → `output_username()` shows "not logged in"
10. Login form **reappears** because `$_SESSION["user_id"]` no longer exists

### Session Security Flow (numbered steps)

1. `config_session.inc.php` is included on every page load
2. Force cookies-only sessions and strict mode
3. Set secure cookie parameters (30 min lifetime, httponly, secure)
4. Start the session
5. Check if user is logged in (`$_SESSION["user_id"]`)
6. If logged in → regenerate session ID every 30 minutes (`regenerate_session_id_loggedin()`)
7. If guest → regenerate session ID every 30 minutes (`regenerate_session_id()`)
8. Both use `session_regenerate_id(true)` which creates new ID and deletes old session file
9. Update `$_SESSION["last_regeneration"]` timestamp after each regeneration