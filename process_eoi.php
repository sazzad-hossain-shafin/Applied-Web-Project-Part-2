<?php
require_once("settings.php");

function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/* Block direct access */
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: apply.php");
    exit();
}

$conn = @mysqli_connect($host, $user, $pwd, $sql_db);

if (!$conn) {
    die("<p>Database connection failed.</p>");
}

/* Safely collect form data */
$job_reference = isset($_POST["jobref"]) ? clean_input($_POST["jobref"]) : "";
$first_name = isset($_POST["fname"]) ? clean_input($_POST["fname"]) : "";
$last_name = isset($_POST["lname"]) ? clean_input($_POST["lname"]) : "";
$date_of_birth = isset($_POST["dob"]) ? clean_input($_POST["dob"]) : "";
$gender = isset($_POST["gender"]) ? clean_input($_POST["gender"]) : "";
$street_address = isset($_POST["address"]) ? clean_input($_POST["address"]) : "";
$suburb_town = isset($_POST["suburb"]) ? clean_input($_POST["suburb"]) : "";
$state = isset($_POST["state"]) ? clean_input($_POST["state"]) : "";
$postcode = isset($_POST["postcode"]) ? clean_input($_POST["postcode"]) : "";
$email = isset($_POST["email"]) ? clean_input($_POST["email"]) : "";
$phone = isset($_POST["phonenumber"]) ? clean_input($_POST["phonenumber"]) : "";
$other_skills = isset($_POST["other_skills"]) ? clean_input($_POST["other_skills"]) : "";

/* Skills */
$skill_1 = "";
$skill_2 = "";
$skill_3 = "";

if (isset($_POST["skills"]) && is_array($_POST["skills"])) {
    $selected_skills = $_POST["skills"];

    if (in_array("Teamwork", $selected_skills)) {
        $skill_1 = "Teamwork";
    }

    if (in_array("Coding", $selected_skills)) {
        $skill_2 = "Coding";
    }

    $extra_skills = array();

    if (in_array("Frontend Development", $selected_skills)) {
        $extra_skills[] = "Frontend Development";
    }

    if (in_array("Software Development", $selected_skills)) {
        $extra_skills[] = "Software Development";
    }

    $skill_3 = implode(", ", $extra_skills);
}

/* Server-side validation */
$errors = "";

if ($job_reference == "") {
    $errors .= "<p>Job reference is required.</p>";
} elseif (!preg_match("/^[A-Za-z0-9]{5}$/", $job_reference)) {
    $errors .= "<p>Job reference must be exactly 5 letters or numbers.</p>";
}

if ($first_name == "") {
    $errors .= "<p>First name is required.</p>";
} elseif (!preg_match("/^[A-Za-z]{1,20}$/", $first_name)) {
    $errors .= "<p>First name must only contain letters and be 20 characters or less.</p>";
}

if ($last_name == "") {
    $errors .= "<p>Last name is required.</p>";
} elseif (!preg_match("/^[A-Za-z]{1,20}$/", $last_name)) {
    $errors .= "<p>Last name must only contain letters and be 20 characters or less.</p>";
}

if ($date_of_birth == "") {
    $errors .= "<p>Date of birth is required.</p>";
} elseif (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $date_of_birth)) {
    $errors .= "<p>Date of birth must be in dd/mm/yyyy format.</p>";
}

if ($gender == "") {
    $errors .= "<p>Gender is required.</p>";
}

if ($street_address == "") {
    $errors .= "<p>Street address is required.</p>";
} elseif (strlen($street_address) > 40) {
    $errors .= "<p>Street address must be 40 characters or less.</p>";
}

if ($suburb_town == "") {
    $errors .= "<p>Suburb or town is required.</p>";
} elseif (strlen($suburb_town) > 40) {
    $errors .= "<p>Suburb or town must be 40 characters or less.</p>";
}

if ($state == "") {
    $errors .= "<p>State is required.</p>";
}

if ($postcode == "") {
    $errors .= "<p>Postcode is required.</p>";
} elseif (!preg_match("/^\d{4}$/", $postcode)) {
    $errors .= "<p>Postcode must be exactly 4 digits.</p>";
}

if ($email == "") {
    $errors .= "<p>Email address is required.</p>";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors .= "<p>Email address is not valid.</p>";
}

if ($phone == "") {
    $errors .= "<p>Phone number is required.</p>";
} elseif (!preg_match("/^\d{8,12}$/", $phone)) {
    $errors .= "<p>Phone number must be 8 to 12 digits.</p>";
}

/* Check that job reference exists in jobs table */
if ($job_reference != "") {
    $check_job = mysqli_real_escape_string($conn, $job_reference);
    $job_query = "SELECT job_reference FROM jobs WHERE job_reference = '$check_job'";
    $job_result = mysqli_query($conn, $job_query);

    if (!$job_result || mysqli_num_rows($job_result) == 0) {
        $errors .= "<p>The selected job reference does not exist.</p>";
    }
}

/* Show errors */
if ($errors != "") {
    $page_title = "Application Error";
    $body_class = "apply-page";
    include("header.inc");
    include("nav.inc");

    echo "<main><section>";
    echo "<h2>Application Error</h2>";
    echo $errors;
    echo "<p><a href='apply.php'>Go back to application form</a></p>";
    echo "</section></main>";

    include("footer.inc");
    mysqli_close($conn);
    exit();
}

/* Escape before insert */
$job_reference = mysqli_real_escape_string($conn, $job_reference);
$first_name = mysqli_real_escape_string($conn, $first_name);
$last_name = mysqli_real_escape_string($conn, $last_name);
$date_of_birth = mysqli_real_escape_string($conn, $date_of_birth);
$gender = mysqli_real_escape_string($conn, $gender);
$street_address = mysqli_real_escape_string($conn, $street_address);
$suburb_town = mysqli_real_escape_string($conn, $suburb_town);
$state = mysqli_real_escape_string($conn, $state);
$postcode = mysqli_real_escape_string($conn, $postcode);
$email = mysqli_real_escape_string($conn, $email);
$phone = mysqli_real_escape_string($conn, $phone);
$skill_1 = mysqli_real_escape_string($conn, $skill_1);
$skill_2 = mysqli_real_escape_string($conn, $skill_2);
$skill_3 = mysqli_real_escape_string($conn, $skill_3);
$other_skills = mysqli_real_escape_string($conn, $other_skills);

$query = "INSERT INTO eoi
(job_reference, first_name, last_name, date_of_birth, gender, street_address, suburb_town, state, postcode, email, phone, skill_1, skill_2, skill_3, other_skills, status)
VALUES
('$job_reference', '$first_name', '$last_name', '$date_of_birth', '$gender', '$street_address', '$suburb_town', '$state', '$postcode', '$email', '$phone', '$skill_1', '$skill_2', '$skill_3', '$other_skills', 'New')";

$result = mysqli_query($conn, $query);

$page_title = "Application Submitted";
$body_class = "apply-page";
include("header.inc");
include("nav.inc");

echo "<main><section>";

if ($result) {
    $eoi_number = mysqli_insert_id($conn);

    echo "<h2>Application Submitted Successfully</h2>";
    echo "<p>Thank you, " . htmlspecialchars($first_name) . ". Your application has been received.</p>";
    echo "<p>Your EOI number is: <strong>" . htmlspecialchars($eoi_number) . "</strong></p>";
    echo "<p>Status: New</p>";
} else {
    echo "<h2>Application Error</h2>";
    echo "<p>Sorry, your application could not be submitted.</p>";
}

echo "</section></main>";

include("footer.inc");

mysqli_close($conn);
?>