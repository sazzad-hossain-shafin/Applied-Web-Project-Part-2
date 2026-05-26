<?php
require_once("settings.php");

function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: apply.php");
    exit();
}

$conn = @mysqli_connect($host, $user, $pwd, $sql_db);

if (!$conn) {
    die("<p>Database connection failed.</p>");
}

$job_reference = clean_input($_POST["jobref"]);
$first_name = clean_input($_POST["fname"]);
$last_name = clean_input($_POST["lname"]);
$date_of_birth = clean_input($_POST["dob"]);
$gender = clean_input($_POST["gender"]);
$street_address = clean_input($_POST["address"]);
$suburb_town = clean_input($_POST["suburb"]);
$state = clean_input($_POST["state"]);
$postcode = clean_input($_POST["postcode"]);
$email = clean_input($_POST["email"]);
$phone = clean_input($_POST["phonenumber"]);
$other_skills = clean_input($_POST["other_skills"]);

$skills = "";

if (isset($_POST["skills"])) {
    $skills = implode(", ", $_POST["skills"]);
}

$skill_1 = "";
$skill_2 = "";
$skill_3 = "";

if (strpos($skills, "Teamwork") !== false) {
    $skill_1 = "Teamwork";
}

if (strpos($skills, "Coding") !== false) {
    $skill_2 = "Coding";
}

if (strpos($skills, "Frontend Development") !== false || strpos($skills, "Software Development") !== false) {
    $skill_3 = $skills;
}

$errors = "";

if (!preg_match("/^[A-Za-z0-9]{5}$/", $job_reference)) {
    $errors .= "<p>Job reference must be exactly 5 letters or numbers.</p>";
}

if (!preg_match("/^[A-Za-z]{1,20}$/", $first_name)) {
    $errors .= "<p>First name must only contain letters and be 20 characters or less.</p>";
}

if (!preg_match("/^[A-Za-z]{1,20}$/", $last_name)) {
    $errors .= "<p>Last name must only contain letters and be 20 characters or less.</p>";
}

if (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $date_of_birth)) {
    $errors .= "<p>Date of birth must be in dd/mm/yyyy format.</p>";
}

if (!preg_match("/^\d{4}$/", $postcode)) {
    $errors .= "<p>Postcode must be exactly 4 digits.</p>";
}

if (!preg_match("/^\d{8,12}$/", $phone)) {
    $errors .= "<p>Phone number must be 8 to 12 digits.</p>";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors .= "<p>Email address is not valid.</p>";
}

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
    echo "<p>Thank you, " . $first_name . ". Your application has been received.</p>";
    echo "<p>Your EOI number is: <strong>" . $eoi_number . "</strong></p>";
    echo "<p>Status: New</p>";
} else {
    echo "<h2>Application Error</h2>";
    echo "<p>Sorry, your application could not be submitted.</p>";
}

echo "</section></main>";

include("footer.inc");

mysqli_close($conn);
?>