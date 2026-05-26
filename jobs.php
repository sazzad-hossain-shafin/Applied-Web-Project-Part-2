<?php
$page_title = "Green Leaf Energy | Jobs";
$body_class = "jobs-page";
include("header.inc");
include("nav.inc");
require_once("settings.php");

$conn = @mysqli_connect($host, $user, $pwd, $sql_db);

if (!$conn) {
    die("<p>Database connection failed.</p>");
}

$search = "";

if (isset($_GET["search"])) {
    $search = trim($_GET["search"]);
}

if ($search != "") {
    $safe_search = mysqli_real_escape_string($conn, $search);

    $query = "SELECT * FROM jobs
              WHERE job_title LIKE '%$safe_search%'
              OR job_reference LIKE '%$safe_search%'
              OR location LIKE '%$safe_search%'";
} else {
    $query = "SELECT * FROM jobs";
}

$result = mysqli_query($conn, $query);
?>

<main>
    <section class="intro">
        <h2>Careers in Clean Energy Technology</h2>
        <p>
            Join Green Leaf Energy and be part of a team building digital platforms
            that support renewable energy projects, public engagement, and sustainability initiatives.
        </p>

        <form method="get" action="jobs.php">
            <label for="search">Search jobs:</label>
            <input type="search" id="search" name="search" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
    </section>

    <section class="job-grid">
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($job = mysqli_fetch_assoc($result)) {
        ?>
                <article class="job-card">
                    <h2><?php echo htmlspecialchars($job["job_title"]); ?></h2>

                    <table>
                        <tr>
                            <th scope="row">Reference</th>
                            <td><?php echo htmlspecialchars($job["job_reference"]); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Location</th>
                            <td><?php echo htmlspecialchars($job["location"]); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Salary</th>
                            <td><?php echo htmlspecialchars($job["salary"]); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Type</th>
                            <td><?php echo htmlspecialchars($job["position_type"]); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Reports To</th>
                            <td><?php echo htmlspecialchars($job["reports_to"]); ?></td>
                        </tr>
                    </table>

                    <h3>About the Role</h3>
                    <p><?php echo htmlspecialchars($job["job_description"]); ?></p>

                    <h3>Responsibilities</h3>
                    <p><?php echo htmlspecialchars($job["responsibilities"]); ?></p>

                    <h3>Qualifications</h3>
                    <p><?php echo htmlspecialchars($job["qualifications"]); ?></p>

                    <a href="apply.php?ref=<?php echo urlencode($job["job_reference"]); ?>" class="apply-btn">Apply Now</a>
                </article>
        <?php
            }
        } else {
            echo "<p>No jobs found.</p>";
        }

        mysqli_close($conn);
        ?>
    </section>

    <aside>
        <h2>Application Tip</h2>
        <p>
            Please check the job reference number before applying. You will need to enter
            the correct reference number in the application form.
        </p>
    </aside>
</main>

<?php include("footer.inc"); ?>