# Lesson 24 — Selecting Data from a Database with PHP

> **Purpose:** Learn how to search for and display data from a MySQL database using PHP, PDO prepared statements, and `fetchAll()`.  
> **Files:** `index.php`, `search.php`, `includes/dbh.inc.php`  
> **Database:** `database` → `comments` table

---

## 📑 Table of Contents

1. [Why Associative Arrays Are Best for Database Data](#1-why-associative-arrays-are-best-for-database-data)
2. [Line-by-Line Breakdown of search.php](#2-line-by-line-breakdown-of-searchphp)
3. [Why No die() After the PHP Block?](#3-why-no-die-after-the-php-block)
4. [Two Ways to Write HTML with PHP](#4-two-ways-to-write-html-with-php)
5. [Full Code Reference](#5-full-code-reference)

---

## 1. Why Associative Arrays Are Best for Database Data

When you fetch data from a database, PHP can return it in different formats:

| Fetch Mode         | What It Returns                         | Access Style       | Example                            |
| :----------------- | :-------------------------------------- | :----------------- | :--------------------------------- |
| `PDO::FETCH_ASSOC` | Associative array (column name → value) | `$row["username"]` | ⭐ **Best choice**                  |
| `PDO::FETCH_NUM`   | Numeric array (index → value)           | `$row[0]`          | Fragile — breaks if columns change |
| `PDO::FETCH_BOTH`  | Both associative + numeric (default)    | Either style       | Uses double the memory             |
| `PDO::FETCH_OBJ`   | Object                                  | `$row->username`   | Good but less common in tutorials  |

### Why `FETCH_ASSOC` wins:

```php
<?php
// ✅ FETCH_ASSOC — Clear and readable
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo $results[0]["username"];     // Clear: we're getting the username
echo $results[0]["comment_text"]; // Clear: we're getting the comment text

// ❌ FETCH_NUM — Confusing
$results = $stmt->fetchAll(PDO::FETCH_NUM);
echo $results[0][0]; // What column is 0? username? email? Who knows!
echo $results[0][1]; // If you add a column later, all indexes shift

// ❌ Default (FETCH_BOTH) — Wastes memory
$results = $stmt->fetchAll(); // Returns both styles = double the data
?>
```

> **💡 Rule:** Always use `PDO::FETCH_ASSOC` when grabbing data from the database. Your code will be readable, efficient, and won't break if the table structure changes.

### `fetchAll()` vs `fetch()`

| Method       | Returns                                    | Use When                                            |
| :----------- | :----------------------------------------- | :-------------------------------------------------- |
| `fetchAll()` | **All rows** at once as an array of arrays | You need multiple rows (search results, lists)      |
| `fetch()`    | **One row** at a time                      | You need just one row (user profile, single record) |

```php
<?php
// Multiple rows — use fetchAll()
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
// $results = [ ["username" => "john", ...], ["username" => "jane", ...] ]

// Single row — use fetch()
$user = $stmt->fetch(PDO::FETCH_ASSOC);
// $user = ["username" => "john", "pwd" => "...", "email" => "..."]
?>
```

---

## 2. Line-by-Line Breakdown of `search.php`

### Part 1 — The PHP Block (Data Logic)

```php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usersearch = $_POST["usersearch"];
```

- Checks if the form was submitted via POST.
- Grabs the search term from the form input (the `name="usersearch"` field in `index.php`).

---

```php
    try {
        require_once "includes/dbh.inc.php";

        if ($pdo === null) {
            throw new PDOException("Database connection failed");
        }
```

- Opens error handling, loads the database connection.
- Extra safety check: if `$pdo` is somehow `null`, it manually throws an error rather than letting the code continue without a connection.

---

```php
        $query = "SELECT * FROM comments WHERE username = :usersearch;";
```

- SQL query using a **named parameter** (`:usersearch`).
- `SELECT *` grabs all columns from the `comments` table.
- `WHERE username = :usersearch` filters to only rows where the username matches the search term.

---

```php
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":usersearch", $usersearch);
        $stmt->execute();
```

| Line                    | What It Does                                                          |
| :---------------------- | :-------------------------------------------------------------------- |
| `$pdo->prepare($query)` | Sends query structure to MySQL (with `:usersearch` placeholder)       |
| `$stmt->bindParam(...)` | Links the `:usersearch` placeholder to the `$usersearch` PHP variable |
| `$stmt->execute()`      | Runs the query — MySQL fills in the placeholder with the bound value  |

> **Why `bindParam()` instead of `execute([$usersearch])`?**  
> Both work! `bindParam()` with named parameters is just more explicit and readable. You could also do:
> ```php
> $stmt->execute([":usersearch" => $usersearch]);
> ```

---

```php
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
```

- Fetches **all matching rows** as an array of associative arrays.
- If the username "john" has 3 comments, `$results` will be an array with 3 elements.
- Each element is an associative array like `["username" => "john", "comment_text" => "...", "created_at" => "..."]`.

---

```php
        $stmt = null;
        $pdo = null;
```

- Closes the statement and connection. Same cleanup pattern as lesson 22.

---

```php
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: index.php");
}
```

- Error handling: if anything fails, stop and show the error.
- If someone accesses `search.php` directly (GET request), redirect them to the search form.

---

### Part 2 — The HTML Block (Display Logic)

```php
<?php
if (empty($results)) {
    echo "<div>";
    echo "<p>There were no results!</p>";
    echo "</div>";
} else {
    foreach ($results as $row) {
        echo "<div>";
        echo "<h4>" . htmlspecialchars($row["username"]) . "</h4>";
        echo  "<p>" . htmlspecialchars($row["comment_text"]) . "</p>";
        echo "<p>" . htmlspecialchars($row["created_at"]) . "</p>";
        echo "</div>";
    }
}
?>
```

| Part                         | What It Does                                                                 |
| :--------------------------- | :--------------------------------------------------------------------------- |
| `empty($results)`            | Checks if the query returned **zero rows** (no comments found for that user) |
| `foreach ($results as $row)` | Loops through each row — `$row` is one associative array per iteration       |
| `$row["username"]`           | Accesses the `username` column of the current row                            |
| `htmlspecialchars(...)`      | Escapes HTML characters before displaying — prevents XSS attacks             |

### How `foreach` works with `$results`:

```
$results = [
    ["username" => "john", "comment_text" => "Hello!", "created_at" => "2024-01-01"],
    ["username" => "john", "comment_text" => "PHP rocks", "created_at" => "2024-01-02"]
];

// First loop:  $row = ["username" => "john", "comment_text" => "Hello!", ...]
// Second loop: $row = ["username" => "john", "comment_text" => "PHP rocks", ...]
```

---

## 3. Why No `die()` After the PHP Block?

In **lesson 22** (`formhandler.php`), we used `die()` after `header()`:

```php
header("Location: ../form.php");
die();  // ← Script STOPS here
```

In **lesson 24** (`search.php`), there's **no** `die()` after the PHP logic. Why?

| Lesson 22 (formhandler.php)                                | Lesson 24 (search.php)                                                 |
| :--------------------------------------------------------- | :--------------------------------------------------------------------- |
| **Only processes data** — no HTML to display               | **Processes data AND displays HTML** below the PHP block               |
| After inserting data, there's nothing left to do → `die()` | After querying data, we still need the HTML section to display results |
| File has no `<html>` — it's a pure handler                 | File has `<html>` below the PHP block                                  |

```php
// Lesson 22 — Handler only (no HTML needed)
<?php
    // ... insert data ...
    header("Location: ../form.php");
    die();  // ✅ Correct — nothing below matters
?>

// Lesson 24 — PHP + HTML in same file  
<?php
    // ... fetch data into $results ...
    // ❌ No die() here — we need the HTML below to display results!
?>
<!DOCTYPE html>
<html>
    <!-- This HTML uses $results to display data -->
</html>
```

> **💡 Rule:** Use `die()` when the script's job is done and there's nothing else to render. Don't use `die()` when there's HTML below that needs to display.

---

## 4. Two Ways to Write HTML with PHP

The `search.php` file uses **Method 1** (echo everything). There's an alternative **Method 2** that some developers prefer:

---

### Method 1: Echo HTML Inside PHP (Used in search.php)

```php
<?php
foreach ($results as $row) {
    echo "<div>";
    echo "<h4>" . htmlspecialchars($row["username"]) . "</h4>";
    echo "<p>" . htmlspecialchars($row["comment_text"]) . "</p>";
    echo "</div>";
}
?>
```

| Pros                           | Cons                                      |
| :----------------------------- | :---------------------------------------- |
| ✅ Everything in one PHP block  | ❌ Lots of quotes and string concatenation |
| ✅ Good for small HTML snippets | ❌ Hard to read when HTML gets complex     |
|                                | ❌ No syntax highlighting for the HTML     |

---

### Method 2: Close/Open PHP Tags Around HTML (Alternative)

```php
<?php foreach ($results as $row) { ?>
    <div>
        <h4><?php echo htmlspecialchars($row["username"]); ?></h4>
        <p><?php echo htmlspecialchars($row["comment_text"]); ?></p>
        <p><?php echo htmlspecialchars($row["created_at"]); ?></p>
    </div>
<?php } ?>
```

| Pros                                                  | Cons                                    |
| :---------------------------------------------------- | :-------------------------------------- |
| ✅ HTML gets proper syntax highlighting in your editor | ❌ More `<?php ?>` tags scattered around |
| ✅ Easier to read and style complex HTML               | ❌ Can look messy if overused            |
| ✅ HTML structure is more visible                      |                                         |

### How it works:

```
<?php foreach ($results as $row) { ?>    ← PHP opens the loop, then CLOSES
    <div>                                ← Regular HTML (rendered for each loop)
        <h4><?php echo ... ?></h4>       ← Quick PHP echo inside HTML
    </div>
<?php } ?>                               ← PHP closes the loop
```

The key insight: **You can open and close `<?php ?>` tags as many times as you want.** PHP remembers the loop state even when you temporarily switch to HTML mode.

> **💡 Both methods produce identical output.** Choose whichever is more readable for your situation. Method 2 is generally preferred for complex HTML layouts.

---

## 5. Full Code Reference

### `index.php` — The Search Form

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form class="searchform" action="search.php" method="post">
        <label for="search">Search for user:</label>
        <input id="search" type="text" name="usersearch" placeholder="Search...">
        <button>Search</button>
    </form>
</body>
</html>
```

### `search.php` — Search Handler + Display

```php
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usersearch = $_POST["usersearch"];

    try {
        require_once "includes/dbh.inc.php";

        if ($pdo === null) {
            throw new PDOException("Database connection failed");
        }

        $query = "SELECT * FROM comments WHERE username = :usersearch;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":usersearch", $usersearch);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = null;
        $pdo = null;
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <section>
        <h3>Search Results:</h3>
        <?php
        if (empty($results)) {
            echo "<div><p>There were no results!</p></div>";
        } else {
            foreach ($results as $row) {
                echo "<div>";
                echo "<h4>" . htmlspecialchars($row["username"]) . "</h4>";
                echo "<p>" . htmlspecialchars($row["comment_text"]) . "</p>";
                echo "<p>" . htmlspecialchars($row["created_at"]) . "</p>";
                echo "</div>";
            }
        }
        ?>
    </section>
</body>
</html>
```

### The Complete Flow:

```
User types a username in index.php → clicks "Search"
       ↓
Browser sends POST request to search.php
       ↓
search.php grabs $_POST["usersearch"]
       ↓
Loads database connection (dbh.inc.php) → $pdo is ready
       ↓
Prepares SELECT query with :usersearch named parameter
       ↓
Binds $usersearch to :usersearch → executes
       ↓
fetchAll(PDO::FETCH_ASSOC) → $results = array of matching rows
       ↓
Closes connection ($stmt = null, $pdo = null)
       ↓
PHP block ends — HTML below renders
       ↓
foreach loops through $results → displays each comment with htmlspecialchars()
```

### Lesson 22 vs Lesson 24 — Side-by-Side Comparison

| Feature              | Lesson 22 (INSERT)        | Lesson 24 (SELECT)                    |
| :------------------- | :------------------------ | :------------------------------------ |
| SQL Operation        | `INSERT INTO`             | `SELECT * FROM`                       |
| Parameter Style      | Positional `?`            | Named `:usersearch`                   |
| Binding Method       | `execute([$var1, $var2])` | `bindParam()` + `execute()`           |
| After Query          | Redirect + `die()`        | Fetch results + display HTML          |
| HTML in File?        | No — separate `form.php`  | Yes — HTML is in the same file        |
| `htmlspecialchars()` | Not needed (no output)    | Required (displaying data in browser) |
| `die()` used?        | Yes — after redirect      | No — HTML below still needs to render |
