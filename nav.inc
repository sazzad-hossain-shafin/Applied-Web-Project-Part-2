<?php
$current = basename($_SERVER["PHP_SELF"]);
?>
<nav aria-label="Main navigation">
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="jobs.php">Jobs</a></li>
        <li><a href="apply.php">Apply</a></li>
        <li><a href="about.php">About</a></li>
        <li>
            <?php if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true): ?>
                <a href="manage.php" <?php echo $current=="manage.php" ? 'aria-current="page"' : ""; ?>>Manage</a>
            <?php else: ?>
                <a href="login.php" <?php echo $current=="login.php" ? 'aria-current="page"' : ""; ?>>Admin Login</a>
            <?php endif; ?>
        </li>
    </ul>
</nav>