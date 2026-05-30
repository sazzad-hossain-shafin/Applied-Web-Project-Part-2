<?php
session_start();

/* If User Is already logged in, redirect to manage.php */
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    header("Location: manage.php");
    exit();
}

/* Limits too many login attempts */
if (!isset($_SESSION["login_attempts"])) {
    $_SESSION["login_attempts"] = 0;
    $_SESSION["lockout_time"] = null;
}
$error = "";
$locked_out = false;
$lockout_seconds = 30;

/* Checks to make sure user isnt already locked out */
if ($_SESSION["login_attempts"] >= 3) {
    $time_since_lockout = time() - $_SESSION["lockout_time"];
    if ($time_since_lockout < $lockout_seconds) {
        $remaining = $lockout_seconds - $time_since_lockout;
        $error = "Too many failed attempts. Please wait $remaining seconds.";
        $locked_out = true;
    } else {
        /* Reset lockout after a certain amount of time has passed */
        $_SESSION["login_attempts"] = 0;
        $_SESSION["lockout_time"] = null;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !$locked_out) {
   require_once("settings.php");
   $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

   if (!$conn) {
       die("<p>Database connection failed.</p>");
   }
   $username = trim($_POST["username"]);
   $password = trim($_POST["password"]);

   $safe_user = mysqli_real_escape_string($conn, $username);
   $query = "SELECT * FROM users WHERE username = '$safe_user'";
   $result = mysqli_query($conn, $query);

   if ($result && mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
  if ($password === $row["password"]) {
        /* Successful login */
        $_SESSION["logged_in"] = true;
        $_SESSION["username"] = $username;
        $_SESSION["login_attempts"] = 0; 
        $_SESSION["last_activity"] = time();
       mysqli_close($conn);
        header("Location: manage.php");
        exit();
   }
}
/* Failed login */
 $_SESSION["login_attempts"]++;
 $_SESSION["lockout_time"] = time();
 $ATTEMPTS_LEFT = 3 - $_SESSION["login_attempts"];
 if ($ATTEMPTS_LEFT > 0) {
     $error = "Invalid username or password. You have $ATTEMPTS_LEFT attempt(s) left.";
 } else {
     $error = "Too many failed attempts. Please wait $lockout_seconds seconds.";
     $locked_out = true;
 }
    mysqli_close($conn);
}

$page_title = "Green Leaf Energy - Admin Login";
$body_class = "login-page";
include("header.inc");
include("nav.inc");
?>
<main>
<section class= "intro">
    <h2> Admin Login</h2>
    <p>This page is for Admins only. <p>
</section>  
    <section>
        <?php if ($error != ""): ?>
            <p class="error-msg"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="post" action="login.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" autocomplete="username">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" autocomplete="current-password">

            <button type="submit" <?php echo $locked_out ? "disabled" : ""; ?>>Login</button>
        </form>
    </section>
</main>

<?php include("footer.inc"); ?>

