<?php
$page_title = "Green Leaf Energy | About";
$body_class = "about-page";
include("header.inc");
include("nav.inc");
require_once("settings.php");

$conn = @mysqli_connect($host, $user, $pwd, $sql_db);

if (!$conn) {
    die("<p>Database connection failed.</p>");
}

$query = "SELECT * FROM about_members";
$result = mysqli_query($conn, $query);
?>

<main>
    <section>
        <h2>Our Group Information</h2>

        <ul>
            <li>Group Name: Green Leaf Energy
                <ol>
                    <li>Class Day: Thursday</li>
                    <li>Class Time: 2:30 - 4:30 PM</li>
                </ol>
            </li>
        </ul>
    </section>

    <section>
        <h2>Members and Contributions</h2>

        <dl>
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($member = mysqli_fetch_assoc($result)) {
                    echo "<dt>" . htmlspecialchars($member["member_name"]) . "</dt>";
                    echo "<dd>Role: " . htmlspecialchars($member["role"]) . "</dd>";
                    echo "<dd>Quote: " . htmlspecialchars($member["quote"]) . "</dd>";
                    echo "<dd>Translation: " . htmlspecialchars($member["translation"]) . "</dd>";
                }
            } else {
                echo "<p>No member information found.</p>";
            }
            ?>
        </dl>
    </section>

    <section>
        <h2>Group Picture</h2>

        <figure>
            <img src="images/group_project_picture.png" alt="Group project team picture">
            <figcaption>Our group picture</figcaption>
        </figure>
    </section>

    <section>
        <h2>Fun Facts</h2>

        <table>
            <caption>Group member fun facts loaded from database</caption>

            <thead>
                <tr>
                    <th scope="col">Member</th>
                    <th scope="col">Dream Job</th>
                    <th scope="col">Favourite Food</th>
                    <th scope="col">Hometown</th>
                    <th scope="col">Favourite Sport</th>
                </tr>
            </thead>

            <tbody>
                <?php
                mysqli_data_seek($result, 0);

                while ($member = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($member["member_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($member["dream_job"]) . "</td>";
                    echo "<td>" . htmlspecialchars($member["favourite_food"]) . "</td>";
                    echo "<td>" . htmlspecialchars($member["hometown"]) . "</td>";
                    echo "<td>" . htmlspecialchars($member["favourite_sport"]) . "</td>";
                    echo "</tr>";
                }

                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </section>
</main>

<?php include("footer.inc"); ?>