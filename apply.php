<?php
$page_title = "Green Leaf Energy | Apply";
$body_class = "apply-page";
include("header.inc");
include("nav.inc");

$job_ref = "";

if (isset($_GET['ref'])) {
    $job_ref = $_GET['ref'];
}
?>

<main>

    <section>
        <h2>Job Application Form</h2>

        <form method="post" action="process_eoi.php">

            <label for="jobref">Job Reference Number:</label>
            <input
                type="text"
                id="jobref"
                name="jobref"
                required
                pattern="[A-Za-z0-9]{5}"
                title="Exactly 5 letters or numbers"
                value="<?php echo $job_ref; ?>"
            >

            <fieldset>
                <legend>Personal Information</legend>

                <label for="fname">First Name:</label>
                <input
                    type="text"
                    id="fname"
                    name="fname"
                    maxlength="20"
                    pattern="[A-Za-z]+"
                    required
                >

                <label for="lname">Last Name:</label>
                <input
                    type="text"
                    id="lname"
                    name="lname"
                    maxlength="20"
                    pattern="[A-Za-z]+"
                    required
                >

                <label for="dob">Date of Birth:</label>
                <input
                    type="text"
                    id="dob"
                    name="dob"
                    placeholder="dd/mm/yyyy"
                    pattern="\d{2}/\d{2}/\d{4}"
                    required
                >
            </fieldset>

            <fieldset>
                <legend>Gender</legend>

                <input type="radio" id="male" name="gender" value="Male" required>
                <label for="male">Male</label>

                <input type="radio" id="female" name="gender" value="Female">
                <label for="female">Female</label>

                <input type="radio" id="other" name="gender" value="Other">
                <label for="other">Other</label>
            </fieldset>

            <fieldset>
                <legend>Contact Information</legend>

                <label for="address">Street Address:</label>
                <input
                    type="text"
                    id="address"
                    name="address"
                    maxlength="40"
                    required
                >

                <label for="suburb">Suburb/Town:</label>
                <input
                    type="text"
                    id="suburb"
                    name="suburb"
                    maxlength="40"
                    required
                >

                <label for="state">State:</label>
                <select id="state" name="state" required>
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
                <input
                    type="text"
                    id="postcode"
                    name="postcode"
                    pattern="\d{4}"
                    required
                >

                <label for="phonenumber">Phone Number:</label>
                <input
                    type="text"
                    id="phonenumber"
                    name="phonenumber"
                    pattern="\d{8,12}"
                    title="8 to 12 digits"
                    required
                >

                <label for="email">Email Address:</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                >
            </fieldset>

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

                <textarea
                    id="other_skills"
                    name="other_skills"
                    rows="5"
                ></textarea>
            </fieldset>

            <button type="submit">Submit Application</button>
            <button type="reset">Reset Form</button>

        </form>
    </section>

</main>

<?php include("footer.inc"); ?>