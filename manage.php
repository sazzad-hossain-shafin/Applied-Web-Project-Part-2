<?php
session_start();

// Session timeout after 15 minutes of inactivity
if (isset($_SESSION["last_activity"]) && (time() - $_SESSION["last_activity"] > 900)) {
    session_unset();
    session_destroy();
    header("Location: login.php?timeout=1");
    exit();
}
$_SESSION["last_activity"] = time();

// Block non-logged-in users
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: login.php");
    exit();
}

require_once("settings.php");
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    die("<p>Database connection failed.</p>");
}

// --- STATS FOR DASHBOARD ---
$total_eois = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM eoi"))["count"];
$total_jobs = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM jobs"))["count"];
$total_new = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM eoi WHERE status='New'"))["count"];
$total_current = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM eoi WHERE status='Current'"))["count"];
$total_final = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM eoi WHERE status='Final'"))["count"];

// --- HANDLE ACTIONS ---
$message = "";

// Delete EOIs by job reference
if (isset($_POST["action"]) && $_POST["action"] == "delete_by_ref") {
    $del_ref = mysqli_real_escape_string($conn, trim($_POST["del_ref"]));
    if ($del_ref != "") {
        $del_result = mysqli_query($conn, "DELETE FROM eoi WHERE job_reference = '$del_ref'");
        $affected = mysqli_affected_rows($conn);
        if ($affected > 0) {
            $message = "success:Deleted $affected EOI(s) with job reference '$del_ref'.";
        } else {
            $message = "error:No EOIs found with job reference '$del_ref'.";
        }
    }
}

// Change EOI status
if (isset($_POST["action"]) && $_POST["action"] == "change_status") {
    $eoi_num = (int)$_POST["eoi_number"];
    $new_status = mysqli_real_escape_string($conn, $_POST["new_status"]);
    $allowed = ["New", "Current", "Final"];
    if (in_array($new_status, $allowed) && $eoi_num > 0) {
        mysqli_query($conn, "UPDATE eoi SET status = '$new_status' WHERE EOInumber = $eoi_num");
        $message = "success:EOI #$eoi_num status updated to '$new_status'.";
    }
}

// --- BUILD QUERY FOR EOI LIST ---
$where = "";
$filter_ref = isset($_GET["filter_ref"]) ? trim($_GET["filter_ref"]) : "";
$filter_fname = isset($_GET["filter_fname"]) ? trim($_GET["filter_fname"]) : "";
$filter_lname = isset($_GET["filter_lname"]) ? trim($_GET["filter_lname"]) : "";
$sort_field = isset($_GET["sort"]) ? $_GET["sort"] : "EOInumber";
$sort_dir = isset($_GET["dir"]) && $_GET["dir"] == "DESC" ? "DESC" : "ASC";

// Whitelist sort fields to prevent SQL injection
$allowed_sorts = ["EOInumber", "job_reference", "first_name", "last_name", "status", "email"];
if (!in_array($sort_field, $allowed_sorts)) {
    $sort_field = "EOInumber";
}

$conditions = [];
if ($filter_ref != "") {
    $safe_ref = mysqli_real_escape_string($conn, $filter_ref);
    $conditions[] = "job_reference = '$safe_ref'";
}
if ($filter_fname != "") {
    $safe_fname = mysqli_real_escape_string($conn, $filter_fname);
    $conditions[] = "first_name LIKE '%$safe_fname%'";
}
if ($filter_lname != "") {
    $safe_lname = mysqli_real_escape_string($conn, $filter_lname);
    $conditions[] = "last_name LIKE '%$safe_lname%'";
}

if (count($conditions) > 0) {
    $where = "WHERE " . implode(" AND ", $conditions);
}

$query = "SELECT * FROM eoi $where ORDER BY $sort_field $sort_dir";
$eoi_result = mysqli_query($conn, $query);
$eoi_count = mysqli_num_rows($eoi_result);

// Helper: sort link builder
function sort_link($field, $label, $current_sort, $current_dir, $params) {
    $new_dir = ($current_sort == $field && $current_dir == "ASC") ? "DESC" : "ASC";
    $arrow = "";
    if ($current_sort == $field) {
        $arrow = $current_dir == "ASC" ? " ▲" : " ▼";
    }
    $params["sort"] = $field;
    $params["dir"] = $new_dir;
    $qs = http_build_query($params);
    return "<a href='manage.php?$qs'>$label$arrow</a>";
}

$filter_params = [];
if ($filter_ref != "") $filter_params["filter_ref"] = $filter_ref;
if ($filter_fname != "") $filter_params["filter_fname"] = $filter_fname;
if ($filter_lname != "") $filter_params["filter_lname"] = $filter_lname;

// Status badge helper
function status_badge($status) {
    $class = "status-" . strtolower($status);
    return "<span class='$class'>$status</span>";
}

$page_title = "Green Leaf Energy | Manage";
$body_class = "manage-page";
include("header.inc");
include("nav.inc");
?>

<main>
    <!-- WELCOME BAR -->
    <section class="intro">
        <h2>HR Manager Dashboard</h2>
        <p>Welcome back, <strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong>. 
        <a href="logout.php">Logout</a></p>
    </section>

    <!-- STATS -->
    <section>
        <h2>Overview</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_eois; ?></div>
                <div class="stat-label">Total EOIs</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_jobs; ?></div>
                <div class="stat-label">Active Jobs</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_new; ?></div>
                <div class="stat-label"><span class="status-new">New</span></div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_current; ?></div>
                <div class="stat-label"><span class="status-current">Current</span></div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_final; ?></div>
                <div class="stat-label"><span class="status-final">Final</span></div>
            </div>
        </div>
    </section>

    <!-- MESSAGE -->
    <?php if ($message != ""):
        list($msg_type, $msg_text) = explode(":", $message, 2);
        $msg_class = $msg_type == "success" ? "success-msg" : "error-msg";
    ?>
        <p class="<?php echo $msg_class; ?>"><?php echo htmlspecialchars($msg_text); ?></p>
    <?php endif; ?>

    <!-- FILTER BAR -->
    <section>
        <h2>Search & Filter EOIs</h2>
        <form method="get" action="manage.php">
            <div class="filter-bar">
                <div>
                    <label for="filter_ref">Job Reference:</label>
                    <input type="text" id="filter_ref" name="filter_ref" 
                           value="<?php echo htmlspecialchars($filter_ref); ?>" placeholder="e.g. WD001">
                </div>
                <div>
                    <label for="filter_fname">First Name:</label>
                    <input type="text" id="filter_fname" name="filter_fname" 
                           value="<?php echo htmlspecialchars($filter_fname); ?>" placeholder="First name">
                </div>
                <div>
                    <label for="filter_lname">Last Name:</label>
                    <input type="text" id="filter_lname" name="filter_lname" 
                           value="<?php echo htmlspecialchars($filter_lname); ?>" placeholder="Last name">
                </div>
                <div>
                    <button type="submit">Search</button>
                    <a href="manage.php" class="apply-btn">Clear</a>
                </div>
            </div>
        </form>
    </section>

    <!-- EOI TABLE -->
    <section>
        <h2>Expressions of Interest 
            <small style="font-size:0.6em; color:#555;">(<?php echo $eoi_count; ?> result<?php echo $eoi_count != 1 ? "s" : ""; ?>)</small>
        </h2>

        <?php if ($eoi_count == 0): ?>
            <p>No EOIs found matching your search.</p>
        <?php else: ?>
        <div style="overflow-x:auto;">
        <table>
            <caption>EOI Applications</caption>
            <tr>
                <th><?php echo sort_link("EOInumber", "EOI #", $sort_field, $sort_dir, $filter_params); ?></th>
                <th><?php echo sort_link("job_reference", "Job Ref", $sort_field, $sort_dir, $filter_params); ?></th>
                <th><?php echo sort_link("first_name", "First Name", $sort_field, $sort_dir, $filter_params); ?></th>
                <th><?php echo sort_link("last_name", "Last Name", $sort_field, $sort_dir, $filter_params); ?></th>
                <th><?php echo sort_link("email", "Email", $sort_field, $sort_dir, $filter_params); ?></th>
                <th>Phone</th>
                <th>State</th>
                <th><?php echo sort_link("status", "Status", $sort_field, $sort_dir, $filter_params); ?></th>
                <th>Change Status</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($eoi_result)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row["EOInumber"]); ?></td>
                <td><?php echo htmlspecialchars($row["job_reference"]); ?></td>
                <td><?php echo htmlspecialchars($row["first_name"]); ?></td>
                <td><?php echo htmlspecialchars($row["last_name"]); ?></td>
                <td><?php echo htmlspecialchars($row["email"]); ?></td>
                <td><?php echo htmlspecialchars($row["phone"]); ?></td>
                <td><?php echo htmlspecialchars($row["state"]); ?></td>
                <td><?php echo status_badge($row["status"]); ?></td>
                <td>
                    <form method="post" action="manage.php?<?php echo http_build_query($filter_params); ?>">
                        <input type="hidden" name="action" value="change_status">
                        <input type="hidden" name="eoi_number" value="<?php echo $row["EOInumber"]; ?>">
                        <select name="new_status">
                            <option value="New" <?php echo $row["status"]=="New" ? "selected" : ""; ?>>New</option>
                            <option value="Current" <?php echo $row["status"]=="Current" ? "selected" : ""; ?>>Current</option>
                            <option value="Final" <?php echo $row["status"]=="Final" ? "selected" : ""; ?>>Final</option>
                        </select>
                        <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        </div>
        <?php endif; ?>
    </section>

    <!-- DELETE BY JOB REFERENCE -->
    <section>
        <h2>Delete EOIs by Job Reference</h2>
        <p>This will permanently delete <strong>all</strong> EOIs for a given job reference.</p>
        <form method="post" action="manage.php" 
              onsubmit="return confirm('Are you sure you want to delete ALL EOIs for this job reference? This cannot be undone.');">
            <input type="hidden" name="action" value="delete_by_ref">
            <div class="filter-bar">
                <div>
                    <label for="del_ref">Job Reference:</label>
                    <input type="text" id="del_ref" name="del_ref" placeholder="e.g. WD001">
                </div>
                <div style="padding-top:24px;">
                    <button type="submit" class="danger-btn">Delete All EOIs</button>
                </div>
            </div>
        </form>
    </section>

</main>

<?php
include("footer.inc");
mysqli_close($conn);
?>