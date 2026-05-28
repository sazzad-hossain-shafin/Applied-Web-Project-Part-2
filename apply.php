<?php
$page_title = "Green Leaf Energy | Apply";
$body_class = "apply-page";

include("header.inc");
include("nav.inc");
require_once("settings.php");

$conn = @mysqli_connect($host, $user, $pwd, $sql_db);

if (!$conn) {
    die("<p>Database connection failed.</p>");
}

$job_ref = "";

if (isset($_GET['ref'])) {
    $job_ref = $_GET['ref'];
}

$query = "SELECT job_reference, job_title FROM jobs";
$result = mysqli_query($conn, $query);
?>

<main>

    <section>
        <h2>Job Application Form</h2>

        <form method="post" action="process_eoi.php" novalidate>

            <!-- JOB REFERENCE -->
            <label for="jobref">Job Reference Number:</label>
            <small>Select one available job from the dropdown list.</small>

            <select id="jobref" name="jobref">

                <option value="">Select a job</option>

                <?php
                while ($job = mysqli_fetch_assoc($result)) {

                    $ref = htmlspecialchars($job["job_reference"]);
                    $title = htmlspecialchars($job["job_title"]);

                    if ($job_ref == $job["job_reference"]) {
                        echo "<option value='$ref' selected>$title ($ref)</option>";
                    } else {
                        echo "<option value='$ref'>$title ($ref)</option>";
                    }
                }

                mysqli_close($conn);
                ?>

            </select>

            <!-- PERSONAL INFORMATION -->
            <fieldset>

                <legend>Personal Information</legend>

                <label for="fname">First Name:</label>
                <small>Letters only, maximum 20 characters.</small>

                <input
                    type="text"
                    id="fname"
                    name="fname"
                    maxlength="20"
                >

                <label for="lname">Last Name:</label>
                <small>Letters only, maximum 20 characters.</small>

                <input
                    type="text"
                    id="lname"
                    name="lname"
                    maxlength="20"
                >

                <label for="dob">Date of Birth:</label>
                <small>Please use dd/mm/yyyy format.</small>

                <input
                    type="text"
                    id="dob"
                    name="dob"
                    placeholder="dd/mm/yyyy"
                >

            </fieldset>

            <!-- GENDER -->
            <fieldset>

                <legend>Gender</legend>

                <input type="radio" id="male" name="gender" value="Male">
                <label for="male">Male</label>

                <input type="radio" id="female" name="gender" value="Female">
                <label for="female">Female</label>

                <input type="radio" id="other" name="gender" value="Other">
                <label for="other">Other</label>

            </fieldset>

            <!-- CONTACT INFORMATION -->
            <fieldset>

                <legend>Contact Information</legend>

                <label for="address">Street Address:</label>
                <small>Maximum 40 characters.</small>

                <input
                    type="text"
                    id="address"
                    name="address"
                    maxlength="40"
                >

                <label for="suburb">Suburb/Town:</label>
                <small>Maximum 40 characters.</small>

                <input
                    type="text"
                    id="suburb"
                    name="suburb"
                    maxlength="40"
                >

                <label for="state">State:</label>

                <select id="state" name="state">

                    <option value="">Select State</option>
                    <option value="VIC">VIC</option>
                    <option value="NSW">NSW</option>
                    <option value="QLD">QLD</option>
                    <option value="NT">NT</option>
                    <option value="WA">WA</option>
                    <option value="SA">SA</option>
                    <option value="TAS">TAS</option>
                    <option value="ACT">ACT</option>

                </select>

                <label for="postcode">Postcode:</label>
                <small>Must be exactly 4 digits.</small>

                <input
                    type="text"
                    id="postcode"
                    name="postcode"
                >

                <label for="phonenumber">Phone Number:</label>
                <small>Enter 8 to 12 digits only.</small>

                <input
                    type="text"
                    id="phonenumber"
                    name="phonenumber"
                >

                <label for="email">Email Address:</label>
                <small>Please enter a valid email address.</small>

                <input
                    type="text"
                    id="email"
                    name="email"
                >

            </fieldset>

            <!-- SKILLS -->
            <fieldset>

                <legend>Applicant Skills</legend>

                <input type="checkbox" id="teamwork" name="skills[]" value="Teamwork">
                <label for="teamwork">Teamwork</label>

                <input type="checkbox" id="coding" name="skills[]" value="Coding">
                <label for="coding">Coding</label>

                <input type="checkbox" id="frontend" name="skills[]" value="Frontend Development">
                <label for="frontend">Frontend Development</label>

                <input type="checkbox" id="backend" name="skills[]" value="Software Development">
                <label for="backend">Software Development</label>

                <br><br>

                <label for="other_skills">Other Skills:</label>
                <small>Optional: Describe additional skills or experience.</small>

                <textarea
                    id="other_skills"
                    name="other_skills"
                    rows="5"
                ></textarea>

            </fieldset>

            <!-- BUTTONS -->
            <button type="submit">Submit Application</button>
            <button type="reset">Reset Form</button>

        </form>

    </section>

</main>

<?php include("footer.inc"); ?>