# 🏋️ PHP & SQL — Practice Problems & Projects

> **Purpose:** Test your understanding after studying each lesson. Try solving each problem **without** looking at the answers.  
> **Rules:** Answers & approaches are at the [bottom of this file](#-answers--approaches). No peeking!  
> **Last Updated:** February 2026

---

## 📑 Table of Contents

- [Lesson 1 — PHP Syntax](#lesson-1--php-syntax)
- [Lesson 2 — Mixing PHP with HTML](#lesson-2--mixing-php-with-html)
- [Lesson 3 — Variables & Naming](#lesson-3--variables--naming)
- [Lesson 4 — Data Types](#lesson-4--data-types)
- [Lesson 5 — Superglobal Variables](#lesson-5--superglobal-variables)
- [Lesson 6 — Handling Form Data](#lesson-6--handling-form-data)
- [Lesson 7 — Operators](#lesson-7--operators)
- [Lesson 8 — Control Structures](#lesson-8--control-structures)
- [Lesson 9 — Arrays](#lesson-9--arrays)
- [Lesson 10 — Built-in Functions](#lesson-10--built-in-functions)
- [Lesson 11 — User-Defined Functions](#lesson-11--user-defined-functions)
- [Lesson 12 — Variable Scope & Constants](#lesson-12--variable-scope--constants)
- [Lesson 13 — Loops](#lesson-13--loops)
- [Lesson 14 — SQL Basics (Tables, INSERT, UPDATE, DELETE)](#lesson-14--sql-basics)
- [Lesson 15 — SQL SELECT & JOINs](#lesson-15--sql-select--joins)
- [Lesson 16 — Connecting PHP to MySQL (PDO)](#lesson-16--connecting-php-to-mysql-pdo)
- [Lesson 17 — INSERT & SELECT via PHP](#lesson-17--insert--select-via-php)
- [Lesson 18 — Sessions](#lesson-18--sessions)
- [Lesson 19 — Session Security](#lesson-19--session-security)
- [Lesson 20 — Password Hashing](#lesson-20--password-hashing)
- [Lesson 21 — Login System (Signup, Login, Logout)](#lesson-21--login-system)
- [Lesson 22 — PHP Security](#lesson-22--php-security)
- [Answers & Approaches](#-answers--approaches)
- [Projects](#-projects--small-to-big)

---

## Lesson 1 — PHP Syntax

**Q1.1** — What is wrong with the following code? Fix it so it prints "Hello, World!" in the browser.

```php
<php
    echo "Hello, World!"
?>
```

**Q1.2** — Write a PHP script that prints your full name, your age, and your favorite color — each on a separate line in the browser. Use `<br>` for line breaks.

**Q1.3** — What is the difference between `echo` and `print` in PHP? Write a snippet that uses both to display the text "PHP is fun".

---

## Lesson 2 — Mixing PHP with HTML

**Q2.1** — Create a complete HTML page (with `<!DOCTYPE html>`, `<head>`, `<body>`) where the `<title>` is set dynamically using PHP, and the `<h1>` inside the body also displays the same title using a PHP variable.

**Q2.2** — You have an array of 3 colors. Without using a loop, write the HTML for an unordered list (`<ul>`) where each `<li>` is generated using PHP's open/close tag method (not `echo`).

**Q2.3** — Explain in your own words: Why is it considered best practice to close PHP tags `?>` before writing large blocks of HTML, instead of using `echo` for every HTML line?

---

## Lesson 3 — Variables & Naming

**Q3.1** — Which of the following variable names are **invalid** in PHP? Explain why each invalid one fails.

```
$myName       $_age       $1stPlace       $user-name
$__secret     $MY_CONST   $first name     $camelCase
```

**Q3.2** — Create three variables: one for your name (string), one for your birth year (integer), and one to calculate your age using the current year. Print a sentence like: "My name is Shimu and I am 24 years old."

**Q3.3** — What will the following code output? Predict the answer before running it.

```php
<?php
$x = 10;
$y = $x;
$x = 20;
echo $y;
?>
```

---

## Lesson 4 — Data Types

**Q4.1** — For each value below, state its PHP data type and what `var_dump()` would output:

```
42          "42"          42.5          true
null        [1, 2, 3]     "0"           ""
```

**Q4.2** — What is the difference between `==` and `===` when comparing `42` and `"42"`? What does each return and why?

**Q4.3** — Write a PHP script that demonstrates **type juggling** — create a variable as a string `"100"`, add the integer `50` to it, and show that PHP automatically converts it. Print the result and its type using `var_dump()`.

---

## Lesson 5 — Superglobal Variables

**Q5.1** — Name at least 5 PHP superglobal variables and write one sentence describing what each one stores.

**Q5.2** — Write a PHP snippet that prints the following server information: the current script filename, the server name, and the request method. Use `$_SERVER`.

**Q5.3** — A user visits `profile.php?user=shimu&role=admin`. Write the PHP code to extract and display both values from the URL. What superglobal do you use?

---

## Lesson 6 — Handling Form Data

**Q6.1** — Create an HTML form with fields for "Name" and "Message" that submits via POST to a file called `handler.php`. In `handler.php`, display: "Hello [Name], you said: [Message]".

**Q6.2** — What happens if a user goes directly to `handler.php` by typing the URL in the browser without submitting the form? Write PHP code to detect this and redirect them back to the form.

**Q6.3** — What is the difference between `GET` and `POST` methods? Give one real-world example where you'd use each.

---

## Lesson 7 — Operators

**Q7.1** — What will each of the following expressions evaluate to?

```php
10 % 3
2 ** 4
"5" + "3"
10 === "10"
true && false
!false || false
```

**Q7.2** — Write a PHP script that takes a number stored in a variable and checks:
- Is it even or odd? (use modulus `%`)
- Is it positive, negative, or zero?
Print a message for each.

**Q7.3** — What is the difference between `++$a` (pre-increment) and `$a++` (post-increment)? Write code that demonstrates the difference using `echo`.

---

## Lesson 8 — Control Structures

**Q8.1** — Write an `if/else if/else` block that takes a variable `$grade` (a number 0–100) and prints:
- "A" for 90–100
- "B" for 80–89
- "C" for 70–79
- "D" for 60–69
- "F" for below 60

**Q8.2** — Rewrite the grade checker from Q8.1 using a `match` expression (PHP 8+). If the grade doesn't fit any range, return "Invalid grade".

**Q8.3** — Write a `switch` statement that takes a variable `$day` (like "Monday", "Tuesday") and prints:
- "Start of the week" for Monday
- "Midweek" for Wednesday
- "Weekend!" for Saturday or Sunday
- "Regular day" for everything else

---

## Lesson 9 — Arrays

**Q9.1** — Create an **indexed** array of 5 fruits. Then:
- Print the third fruit
- Add "Mango" to the end
- Remove the second fruit and re-index the array
- Print the total count

**Q9.2** — Create an **associative** array representing a student with keys: `name`, `age`, `grade`, `email`. Print a sentence like: "[name] is [age] years old, in grade [grade], and can be reached at [email]."

**Q9.3** — You have the array `$scores = [85, 92, 78, 95, 88]`. Without using any built-in sort function, write PHP code to find and print the highest and lowest scores.

---

## Lesson 10 — Built-in Functions

**Q10.1** — Given the string `$text = "  Hello, PHP World!  "`:
- Trim the whitespace
- Convert it to all uppercase
- Find the position of the word "PHP"
- Replace "PHP" with "JavaScript"
- Print the final result

**Q10.2** — Write PHP code that generates a random number between 1 and 100. If the number is above 50, print "You win!", otherwise print "Try again!". Also print the number.

**Q10.3** — Given the string `"john.doe@example.com"`, use string functions to extract:
- Everything before the `@` sign (username)
- Everything after the `@` sign (domain)

---

## Lesson 11 — User-Defined Functions

**Q11.1** — Write a function called `celsiusToFahrenheit` that takes a temperature in Celsius and returns the Fahrenheit equivalent. Formula: `F = (C × 9/5) + 32`. Test it with 0, 100, and 37.

**Q11.2** — Write a function called `greet` that takes two parameters: `$name` and `$timeOfDay` (with a default value of `"morning"`). It should return "Good [timeOfDay], [name]!". Call it with and without the second argument.

**Q11.3** — Write a function called `isEven` that takes an integer and returns `true` if even, `false` if odd. Use `declare(strict_types=1)` and add proper type hints for the parameter and return type.

---

## Lesson 12 — Variable Scope & Constants

**Q12.1** — What will the following code output? Explain why.

```php
<?php
$message = "Hello from outside!";

function showMessage() {
    echo $message;
}

showMessage();
?>
```

**Q12.2** — Rewrite the code in Q12.1 using **two different approaches** to make it work: (a) using the `global` keyword, and (b) by passing `$message` as a parameter.

**Q12.3** — Create a function called `counter()` that counts how many times it's been called. Each time you call it, it should print "Called X times". Use the `static` keyword. Call it 4 times in a row.

---

## Lesson 13 — Loops

**Q13.1** — Using a `for` loop, print the multiplication table for the number 7 (from 7×1 to 7×10), formatted like: `7 x 1 = 7`.

**Q13.2** — Write a `while` loop that starts with `$n = 1` and keeps doubling it (1, 2, 4, 8, 16…) until it exceeds 1000. Print each value and the final count of iterations.

**Q13.3** — Given the associative array below, use a `foreach` loop to print each item formatted as "[item] costs $[price]":

```php
$menu = [
    "Burger" => 5.99,
    "Pizza" => 8.50,
    "Salad" => 4.25,
    "Drink" => 1.50
];
```

---

## Lesson 14 — SQL Basics

**Q14.1** — Write the SQL to create a `products` table with:
- `id` — auto-incrementing primary key
- `name` — max 50 characters, required
- `price` — decimal number with 2 decimal places
- `stock` — whole number, defaults to 0
- `created_at` — auto-filled date/time

**Q14.2** — Using the `products` table from Q14.1, write SQL queries to:
- Insert 3 products (Laptop $999.99, Mouse $25.50, Keyboard $75.00)
- Update the price of "Mouse" to $29.99
- Delete the product with id = 3

**Q14.3** — You have a `users` table and an `orders` table. Write the SQL to create the `orders` table so that:
- Each order links to a user via a foreign key
- If a user is deleted, their orders are also automatically deleted

---

## Lesson 15 — SQL SELECT & JOINs

**Q15.1** — Given a `students` table and a `courses` table linked by `student_id`, write:
- An **INNER JOIN** to show all students and their enrolled courses
- A **LEFT JOIN** to show all students, even those not enrolled in any course

**Q15.2** — What is the difference between `UNION` and `UNION ALL`? When would you use each?

**Q15.3** — Write a SELECT query that finds all users who have **never** posted a comment. Use a LEFT JOIN and check for NULL.

---

## Lesson 16 — Connecting PHP to MySQL (PDO)

**Q16.1** — Write a complete `dbh.inc.php` file from memory that connects to a MySQL database called `mystore` on localhost with username `root` and no password. Include proper error handling.

**Q16.2** — What are the 3 PDO error modes? Which one should you always use and why?

**Q16.3** — Explain why `require_once` is better than `include` for loading a database connection file. What would happen with `include` if the file was missing?

---

## Lesson 17 — INSERT & SELECT via PHP

**Q17.1** — Write a PHP form handler that receives `title`, `content`, and `author` via POST and inserts them into a `posts` table using **named parameters** (`:param`). Include try/catch, redirect, and `die()`.

**Q17.2** — Write a PHP search page that accepts a username from a form, queries the `users` table, and displays all matching results using `fetchAll(PDO::FETCH_ASSOC)` and a `foreach` loop. Use `htmlspecialchars()` on all output.

**Q17.3** — What is the critical difference between these two code snippets? Which is safe and which is dangerous?

```php
// Snippet A
$query = "SELECT * FROM users WHERE username = '$username'";
$pdo->query($query);

// Snippet B
$query = "SELECT * FROM users WHERE username = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$username]);
```

---

## Lesson 18 — Sessions

**Q18.1** — Write PHP code for two pages:
- `page1.php` — starts a session, stores the user's favorite color, and provides a link to page 2
- `page2.php` — starts the session and displays the color stored on page 1

**Q18.2** — What is the difference between `session_unset()`, `unset($_SESSION["key"])`, and `session_destroy()`? When would you use each?

**Q18.3** — Why must `session_start()` be called **before** any HTML output? What error do you get if you echo something first?

---

## Lesson 19 — Session Security

**Q19.1** — Write a complete session configuration file (`config_session.inc.php`) from memory that includes:
- Cookies-only mode
- Strict mode
- Secure cookie parameters (lifetime, httponly, secure)
- Session ID regeneration every 30 minutes

**Q19.2** — Explain in your own words what a **session fixation attack** is. How does `session_regenerate_id(true)` prevent it?

**Q19.3** — Why is `httponly => true` important in `session_set_cookie_params()`? What attack does it help prevent?

---

## Lesson 20 — Password Hashing

**Q20.1** — A developer stores passwords like this: `$pwd = md5($_POST["password"])`. List at least 3 reasons why this is unsafe and what they should use instead.

**Q20.2** — Write the PHP code for:
- Hashing a password during **signup** (using bcrypt with cost 12)
- Verifying a password during **login** (checking against the stored hash)

**Q20.3** — What is the difference between a **salt** and a **pepper** in password hashing? Where is each stored? Does `password_hash()` handle salts automatically?

---

## Lesson 21 — Login System

**Q21.1** — Draw (describe in text) the complete **signup flow** from form submission to database insertion, listing every validation step that should happen.

**Q21.2** — Write the controller function `is_password_wrong()` that takes a plain password and a hashed password, and returns `true` if they don't match. Use `password_verify()`.

**Q21.3** — Write a complete `logout.inc.php` file from memory that properly destroys the session and deletes the cookie. What happens if you forget to match the `session_set_cookie_params()` in the logout file?

---

## Lesson 22 — PHP Security

**Q22.1** — For each of the following threats, name the PHP function or technique that prevents it:
- SQL injection
- Cross-site scripting (XSS)
- Session hijacking
- Password exposure in a database breach
- Form double-submission

**Q22.2** — A junior developer wrote this code. Find **all** the security issues:

```php
<?php
$username = $_POST["username"];
$password = $_POST["password"];

$query = "SELECT * FROM users WHERE username = '$username' AND pwd = '$password'";
$result = $pdo->query($query);
$user = $result->fetch();

if ($user) {
    echo "Welcome, " . $user["username"];
    $_SESSION["loggedin"] = true;
}
?>
```

**Q22.3** — Explain the **POST-Redirect-GET** pattern. Why is it important? What happens if you skip the redirect after a form POST?

---

---

## 📝 Answers & Approaches

> **How to use:** Try solving each problem yourself first. Then check the approach below to see if you're on the right track. The approaches give guidance without full copy-paste solutions — the goal is to learn, not to memorize.

---

### Lesson 1 Answers

**A1.1** — Two issues: (1) Opening tag should be `<?php` not `<php`. (2) Missing semicolon after `"Hello, World!"`. Fixed: `<?php echo "Hello, World!"; ?>`

**A1.2** — Use `echo` three times with `"<br>"` after each line. Example structure: `echo "Name: Shimu<br>"; echo "Age: 24<br>";`...

**A1.3** — `echo` can print multiple strings separated by commas and has no return value. `print` can only take one argument and returns `1`. In practice, they're almost identical — most developers use `echo`.

---

### Lesson 2 Answers

**A2.1** — Store the title in `$title = "My Page";`. In `<title>`, use `<?php echo $title; ?>`. Same in `<h1>`.

**A2.2** — Use the close/open PHP tags around HTML pattern: `<?php $colors = ["Red","Blue","Green"]; ?>` then `<ul>` with `<li><?php echo $colors[0]; ?></li>` for each item.

**A2.3** — Closing PHP tags lets your editor provide HTML syntax highlighting, autocompletion, and proper indentation. Large `echo` blocks lose all HTML tooling and become hard to read/maintain.

---

### Lesson 3 Answers

**A3.1** — Invalid: `$1stPlace` (can't start with a number), `$user-name` (hyphens not allowed, use underscore), `$first name` (spaces not allowed). All others are valid.

**A3.2** — `$name = "Shimu"; $birthYear = 2002; $age = date("Y") - $birthYear;` then concatenate into a sentence with `.`.

**A3.3** — Output is `10`. `$y = $x` copies the value, not the reference. Changing `$x` afterward doesn't affect `$y`.

---

### Lesson 4 Answers

**A4.1** — `42` → int, `"42"` → string, `42.5` → float, `true` → bool, `null` → NULL, `[1,2,3]` → array, `"0"` → string, `""` → string. `var_dump()` would show type and value for each.

**A4.2** — `42 == "42"` → `true` (loose comparison, PHP converts the string to int). `42 === "42"` → `false` (strict comparison, different types).

**A4.3** — `$val = "100"; $result = $val + 50; var_dump($result);` → outputs `int(150)`. PHP automatically cast "100" to integer for the addition.

---

### Lesson 5 Answers

**A5.1** — `$_GET` (URL data), `$_POST` (form POST data), `$_SERVER` (server info), `$_SESSION` (session data), `$_COOKIE` (browser cookies), `$_REQUEST` (combined GET+POST+COOKIE), `$_FILES` (uploaded files).

**A5.2** — `echo $_SERVER["SCRIPT_NAME"]; echo $_SERVER["SERVER_NAME"]; echo $_SERVER["REQUEST_METHOD"];`

**A5.3** — Use `$_GET["user"]` and `$_GET["role"]` since data is in the URL query string.

---

### Lesson 6 Answers

**A6.1** — Form: `<form action="handler.php" method="post">` with `<input name="name">` and `<textarea name="message">`. Handler: grab `$_POST["name"]` and `$_POST["message"]`, echo the message.

**A6.2** — Check `$_SERVER["REQUEST_METHOD"] == "POST"` at the top. In the `else` block: `header("Location: form.php"); die();`

**A6.3** — `GET` puts data in the URL (visible, bookmarkable) — use for search forms, filters. `POST` sends data in the body (hidden, not in URL) — use for login forms, signups, anything that changes data.

---

### Lesson 7 Answers

**A7.1** — `10 % 3` → `1`, `2 ** 4` → `16`, `"5" + "3"` → `8` (type juggling to int), `10 === "10"` → `false`, `true && false` → `false`, `!false || false` → `true`.

**A7.2** — Use `$num % 2 === 0` for even/odd. Use `if ($num > 0)` / `else if ($num < 0)` / `else` for sign check.

**A7.3** — `$a = 5; echo ++$a;` prints `6` (increments then returns). `$a = 5; echo $a++;` prints `5` (returns then increments). After both, `$a` is `6`.

---

### Lesson 8 Answers

**A8.1** — Chain: `if ($grade >= 90)` → A, `else if ($grade >= 80)` → B, etc. Order matters — check highest first.

**A8.2** — `match(true)` pattern: `$grade >= 90 => "A", $grade >= 80 => "B", ...` with `default => "Invalid grade"`. Note: `match` uses strict comparison and returns a value.

**A8.3** — `switch($day)` with `case "Monday":` → break, etc. For Saturday/Sunday, stack two cases: `case "Saturday": case "Sunday":` → both hit the same block. Use `default:` for "Regular day".

---

### Lesson 9 Answers

**A9.1** — Third fruit: `$fruits[2]`. Add: `array_push($fruits, "Mango")` or `$fruits[] = "Mango"`. Remove second + re-index: `array_splice($fruits, 1, 1)`. Count: `count($fruits)`.

**A9.2** — Create with `$student = ["name" => "Shimu", "age" => 24, ...]`. Access with `$student["name"]`, etc. Concatenate into a sentence.

**A9.3** — Initialize `$max = $scores[0]` and `$min = $scores[0]`. Loop through with `foreach`, compare each value. Update `$max`/`$min` accordingly.

---

### Lesson 10 Answers

**A10.1** — `trim($text)` → remove whitespace. `strtoupper()` → uppercase. `strpos($text, "PHP")` → find position. `str_replace("PHP", "JavaScript", $text)` → replace. Chain them or do step by step.

**A10.2** — `$num = rand(1, 100);` then `if ($num > 50)` → win, else → try again. Echo the number too.

**A10.3** — `$pos = strpos($email, "@"); $username = substr($email, 0, $pos); $domain = substr($email, $pos + 1);`. Or use `explode("@", $email)`.

---

### Lesson 11 Answers

**A11.1** — `function celsiusToFahrenheit(float $c): float { return ($c * 9/5) + 32; }`. Test: `0°C = 32°F`, `100°C = 212°F`, `37°C = 98.6°F`.

**A11.2** — `function greet(string $name, string $timeOfDay = "morning"): string { return "Good $timeOfDay, $name!"; }`. Call: `greet("Shimu")` → "Good morning, Shimu!". `greet("Shimu", "evening")` → "Good evening, Shimu!".

**A11.3** — `declare(strict_types=1); function isEven(int $num): bool { return $num % 2 === 0; }`.

---

### Lesson 12 Answers

**A12.1** — Outputs a warning/error — `$message` is undefined inside the function. PHP functions have their own scope; they can't see variables declared outside.

**A12.2** — (a) Add `global $message;` inside the function. (b) Change to `function showMessage($message)` and call `showMessage($message)`. Method (b) is preferred — `global` creates hidden dependencies.

**A12.3** — `function counter() { static $count = 0; $count++; echo "Called $count times\n"; }`. `static` preserves `$count` between calls instead of resetting to 0.

---

### Lesson 13 Answers

**A13.1** — `for ($i = 1; $i <= 10; $i++) { echo "7 x $i = " . (7 * $i) . "<br>"; }`

**A13.2** — `$n = 1; $count = 0; while ($n <= 1000) { echo $n . "<br>"; $n *= 2; $count++; }`. Values: 1, 2, 4, 8, 16, 32, 64, 128, 256, 512 — 10 iterations.

**A13.3** — `foreach ($menu as $item => $price) { echo "$item costs \$$price<br>"; }`. The `$item` is the key (food name), `$price` is the value.

---

### Lesson 14 Answers

**A14.1** — `CREATE TABLE products (id INT NOT NULL AUTO_INCREMENT, name VARCHAR(50) NOT NULL, price DOUBLE(10,2), stock INT DEFAULT 0, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(id));`

**A14.2** — INSERT: three `INSERT INTO products (name, price) VALUES ('Laptop', 999.99);` statements. UPDATE: `UPDATE products SET price = 29.99 WHERE name = 'Mouse';`. DELETE: `DELETE FROM products WHERE id = 3;`.

**A14.3** — `FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE` — CASCADE automatically deletes child rows when the parent is deleted.

---

### Lesson 15 Answers

**A15.1** — INNER: `SELECT students.name, courses.title FROM students INNER JOIN courses ON students.id = courses.student_id;`. LEFT: same but `LEFT JOIN` — shows all students, `NULL` for course columns where unmatched.

**A15.2** — `UNION` removes duplicates from the combined result. `UNION ALL` keeps all rows including duplicates (faster). Use `UNION` for the FULL JOIN workaround; `UNION ALL` when you know there are no duplicates or want to keep them.

**A15.3** — `SELECT users.* FROM users LEFT JOIN comments ON users.id = comments.users_id WHERE comments.id IS NULL;` — The LEFT JOIN includes all users; the `WHERE IS NULL` filters to only those with no matching comment.

---

### Lesson 16 Answers

**A16.1** — `$dsn = "mysql:host=localhost;dbname=mystore"; $dbusername = "root"; $dbpassword = ""; try { $pdo = new PDO($dsn, $dbusername, $dbpassword); $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); } catch (PDOException $e) { echo "Connection failed: " . $e->getMessage(); }`

**A16.2** — `ERRMODE_SILENT` (errors ignored), `ERRMODE_WARNING` (warnings, script continues), `ERRMODE_EXCEPTION` (throws catchable exceptions). Always use `ERRMODE_EXCEPTION` — silent failures are extremely hard to debug.

**A16.3** — `require_once` throws a **fatal error** and stops the script. `include` issues a **warning** but continues — meaning all database queries would fail with "undefined variable $pdo" errors. For essential files, you want the script to stop immediately.

---

### Lesson 17 Answers

**A17.1** — Check `$_SERVER["REQUEST_METHOD"] == "POST"`, grab `$_POST` values, `require_once "dbh.inc.php"`, prepare with `:title`, `:content`, `:author`, `bindParam` each, `execute()`, `$pdo = null`, `header("Location: ...")`, `die()`. Wrap in try/catch.

**A17.2** — POST handler fetches `$_POST["username"]`, prepares `SELECT * FROM users WHERE username = :username`, `bindParam`, `execute`, `fetchAll(PDO::FETCH_ASSOC)`. Loop with `foreach`, wrap every output in `htmlspecialchars()`. Check `empty($results)` for "no results" message.

**A17.3** — Snippet A is **dangerous** — raw user input in the query allows SQL injection. Snippet B is **safe** — prepared statement treats `$username` as data, never as SQL code.

---

### Lesson 18 Answers

**A18.1** — Both pages start with `session_start();`. Page 1: `$_SESSION["color"] = "blue";` then `<a href="page2.php">`. Page 2: `echo $_SESSION["color"];` — outputs "blue".

**A18.2** — `unset($_SESSION["key"])` removes one variable. `session_unset()` removes all variables but session stays alive. `session_destroy()` destroys the entire session (takes effect next page load). Use `unset` for one key, all three together for full logout.

**A18.3** — `session_start()` sends a cookie header. HTTP headers must come before any output. If you echo first, PHP throws "headers already sent" warning and the session won't work.

---

### Lesson 19 Answers

**A19.1** — `ini_set('session.use_only_cookies', 1); ini_set('session.use_strict_mode', 1);` then `session_set_cookie_params(['lifetime' => 1800, 'secure' => true, 'httponly' => true, ...]);` then `session_start();` then the regeneration block checking `$_SESSION['last_regeneration']` against `time()` with a 30-minute interval.

**A19.2** — Attacker creates a session ID, tricks the victim into using it (e.g., via a crafted link), victim logs in with that ID, attacker now has a valid logged-in session. `session_regenerate_id(true)` generates a new ID and destroys the old file — the attacker's known ID becomes useless.

**A19.3** — `httponly => true` prevents JavaScript from reading `document.cookie`. This blocks **XSS attacks** that try to steal session cookies by injecting `<script>` tags.

---

### Lesson 20 Answers

**A20.1** — (1) `md5` is a fast hash — can be brute-forced in seconds. (2) No automatic salt — identical passwords produce identical hashes. (3) Rainbow table attacks work against md5. Use `password_hash($pwd, PASSWORD_BCRYPT, ['cost' => 12])` instead.

**A20.2** — Signup: `$hash = password_hash($pwd, PASSWORD_BCRYPT, ['cost' => 12]);` then INSERT `$hash` into DB. Login: fetch the stored hash, then `if (password_verify($loginPwd, $storedHash))` → success.

**A20.3** — **Salt**: random string added to each password before hashing (makes each hash unique). Stored in the database alongside the hash. `password_hash()` generates and embeds the salt automatically. **Pepper**: application-wide secret added to all passwords. Stored in code or `.env` file, never in the database.

---

### Lesson 21 Answers

**A21.1** — Flow: Form POST → grab `$_POST` data → check empty fields → validate email with `filter_var` → check if username exists (DB query) → check if email exists (DB query) → if errors, store in `$_SESSION` + redirect → if no errors, `password_hash()` → INSERT → redirect with success.

**A21.2** — `function is_password_wrong(string $pwd, string $hashPwd): bool { return !password_verify($pwd, $hashPwd); }`. Returns `true` if `password_verify` returns `false` (password doesn't match).

**A21.3** — Must include matching `session_set_cookie_params()`, then `session_start()`, `session_unset()`, `session_destroy()`, `setcookie(session_name(), '', time() - 3600, ...)`. If params don't match, `session_start()` creates a **new** session instead of resuming the old one — the old session never gets destroyed.

---

### Lesson 22 Answers

**A22.1** — SQL injection → `$pdo->prepare()` with `bindParam()`. XSS → `htmlspecialchars()`. Session hijacking → `session_set_cookie_params()` (httponly, secure) + `session_regenerate_id()`. Password exposure → `password_hash()`. Form double-submit → POST-Redirect-GET pattern with `header()` + `die()`.

**A22.2** — Issues: (1) No prepared statement — SQL injection vulnerability. (2) Comparing plaintext password in SQL instead of using `password_verify()`. (3) No `htmlspecialchars()` on output — XSS vulnerability. (4) No `session_start()` before using `$_SESSION`. (5) No `empty()` check on input fields.

**A22.3** — User submits form (POST) → server processes → server **redirects** (header + die) → browser makes GET request to the result page. Without the redirect, refreshing the page re-submits the POST — causing duplicate database entries (double charge, double registration, etc.).

---

---

## 🚀 Projects — Small to Big

### Project 1: Personal Contact Book (Beginner)

**What to build:** A web app where you can add, view, edit, and delete contacts (name, phone, email).

**Skills used:** HTML forms, PHP form handling, PDO (full CRUD), prepared statements, `htmlspecialchars()`, POST-Redirect-GET.

**Real-life problem it solves:** Replaces a messy spreadsheet or notebook for storing contact information. Small businesses, freelancers, and families can use it to keep a centralized, searchable contact list accessible from any browser.

**Features:**
- Add a new contact (name, phone, email)
- View all contacts in a table
- Edit a contact's details
- Delete a contact with confirmation
- Search contacts by name

---

### Project 2: Feedback / Survey Form with Results (Beginner–Intermediate)

**What to build:** A public-facing feedback form where anyone can submit a response (name, rating 1–5, comment). An admin page displays all responses with stats (average rating, total submissions).

**Skills used:** Forms, POST handling, INSERT (prepared statements), SELECT + `fetchAll()`, `foreach` loops, `htmlspecialchars()`, basic math (averages).

**Real-life problem it solves:** Businesses need customer feedback. Instead of using expensive third-party tools (SurveyMonkey, Google Forms with sheets), this gives a self-hosted, private solution. Restaurants, small shops, or event organizers can collect and view feedback instantly.

**Features:**
- Public feedback form (no login required)
- Admin results page showing all submissions
- Average rating calculation
- Filter by rating (show only 5-star reviews, etc.)

---

### Project 3: Secure Blog with User Authentication (Intermediate)

**What to build:** A multi-user blog where users can register, log in, create posts, edit their own posts, and log out. Visitors can read posts without logging in.

**Skills used:** Full login system (signup, login, logout), sessions, session security, password hashing, MVC file structure, CRUD on posts, `htmlspecialchars()`, `filter_var()`, prepared statements, POST-Redirect-GET, flash messages.

**Real-life problem it solves:** Personal blogging platform without relying on WordPress or Medium. Useful for writers, hobbyists, or small organizations who want full control over their content. Can be deployed on cheap shared hosting with XAMPP-like environments.

**Features:**
- User registration with email validation
- Secure login with bcrypt password hashing
- Session-based authentication with security config
- Create, edit, delete blog posts (only your own)
- Public homepage listing all posts
- Proper logout with session + cookie destruction

---

### Project 4: Task Manager / To-Do App with Categories (Intermediate)

**What to build:** A personal task manager where users log in and manage their own tasks. Tasks have a title, description, due date, priority (low/medium/high), status (pending/in-progress/done), and category.

**Skills used:** Login system, sessions, PDO CRUD, foreign keys (tasks → users, tasks → categories), JOINs, UPDATE for status changes, DELETE, sorting/filtering with WHERE + AND/OR, `date()` for due dates.

**Real-life problem it solves:** Replaces sticky notes, scattered reminder apps, and expensive project management tools. Students can track assignments with due dates. Freelancers can track client tasks. Anyone can organize personal errands by priority and category.

**Features:**
- User accounts (signup/login/logout)
- Add tasks with title, description, due date, priority, category
- Mark tasks as pending / in-progress / done
- Filter by category, priority, or status
- Sort by due date
- Delete completed tasks
- Categories table linked by foreign key

---

### Project 5: Mini E-Commerce Store (Advanced)

**What to build:** A small online store where visitors can browse products, search by category, and add items to a shopping cart (session-based). An admin panel lets store owners add/edit/remove products and view all orders.

**Skills used:** Everything from the tutorial — full login system, sessions (shopping cart), session security, password hashing, MVC structure, PDO prepared statements (full CRUD), JOINs (orders ↔ products ↔ users), foreign keys with CASCADE/SET NULL, `htmlspecialchars()` on all output, form validation, POST-Redirect-GET, try/catch error handling, multiple related tables.

**Real-life problem it solves:** Small businesses, artisans, and local shops that want a basic online presence without paying for Shopify ($39/month+). A handmade jewelry seller, a local bakery, or a small bookshop can list products, take orders, and manage inventory. This project teaches the exact architecture that real e-commerce platforms are built on.

**Features:**
- Public product catalog with categories
- Product search by name or category
- Session-based shopping cart (add, remove, update quantity)
- User registration and login
- Order placement (cart → order → order_items)
- Admin panel: add/edit/delete products, view orders
- Database with 4+ related tables (users, products, orders, order_items, categories)
- Foreign keys with proper ON DELETE behaviors

---

> **💡 Progression Path:** Project 1 → 2 → 3 → 4 → 5 builds on your skills incrementally. Each project reuses everything from the previous one and adds new complexity. By Project 5, you're using **every concept** from the entire tutorial.

---

> **🚀 After completing all 5 projects, you'll have a portfolio of real-world PHP applications and a deep understanding of the fundamentals that power the web.**
