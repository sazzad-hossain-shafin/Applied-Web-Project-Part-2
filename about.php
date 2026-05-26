<?php
$page_title = "Green Leaf Energy | About";
$body_class = "about-page";
include("header.inc");
include("nav.inc");
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
            <dt>Owen Sinclair</dt>
            <dd>Role: About page developer</dd>
            <dd>Quote: “Wer kämpft, kann verlieren. Wer nicht kämpft, hat schon verloren.”</dd>
            <dd>Translation: “Those who fight may lose. Those who do not fight have already lost.”</dd>

            <dt>Will Daly</dt>
            <dd>Role: Job application page developer</dd>
            <dd>Quote: Deus faustus</dd>
            <dd>Translation: Lucky day</dd>

            <dt>Raffay Ahmad</dt>
            <dd>Role: Jobs page developer</dd>
            <dd>Quote: L’essentiel est invisible pour les yeux</dd>
            <dd>Translation: What is essential is invisible to the eye</dd>

            <dt>Sazzad Hossain Shafin</dt>
            <dd>Role: Home page developer</dd>
            <dd>Quote: Caminante, no hay camino, se hace camino al andar</dd>
            <dd>Translation: Traveler, there is no path; the path is made by walking.</dd>
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
            <caption>Group member fun facts</caption>
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
                <tr>
                    <td>Owen Sinclair</td>
                    <td>Pro Golfer</td>
                    <td>Pizza</td>
                    <td>Melbourne</td>
                    <td>Golf</td>
                </tr>

                <tr>
                    <td>Will Daly</td>
                    <td>Garbage Truck Driver</td>
                    <td>Rice</td>
                    <td>Kyoto</td>
                    <td>Cricket</td>
                </tr>

                <tr>
                    <td>Raffay Ahmad</td>
                    <td>Software Engineer</td>
                    <td>Burger</td>
                    <td>Cape Town</td>
                    <td>Football</td>
                </tr>

                <tr>
                    <td>Sazzad Hossain Shafin</td>
                    <td>Web Developer</td>
                    <td>Pasta</td>
                    <td>Dhaka</td>
                    <td>Football</td>
                </tr>
            </tbody>
        </table>
    </section>
</main>

<?php include("footer.inc"); ?>