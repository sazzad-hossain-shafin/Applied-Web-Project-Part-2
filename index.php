<?php
$page_title = "Green Leaf Energy | Home";
$body_class = "home-page";
include("header.inc");
include("nav.inc");
?>

<main>
    <section>
        <h2>Build a cleaner future with Green Leaf Energy</h2>

        <figure>
            <img src="images/solar_panel_image.jpg" alt="Solar panels and wind turbines representing renewable energy">
            <figcaption>Renewable energy solutions used by Green Leaf Energy</figcaption>
        </figure>

        <p>
            Green Leaf Energy is a renewable energy company strengthening its technology team to support websites
            promoting clean energy solutions, project information, and public engagement initiatives.
        </p>

        <p>
            Our organisation combines sustainability, innovation, and digital communication to help communities
            and stakeholders better understand the benefits of renewable energy.
        </p>
    </section>

    <section>
        <h2>Who we are</h2>

        <p>
            Green Leaf Energy develops sustainable energy solutions across solar, wind, and smart energy systems.
        </p>

        <p>
            As we grow, we are looking for talented people who want to contribute to a cleaner future.
        </p>

        <div class="embedded-note">
            <p>We value accessibility, inclusion, innovation, and environmental responsibility.</p>
        </div>
    </section>

    <section>
        <h2>Why join Green Leaf Energy?</h2>

        <article>
            <h3>Meaningful impact</h3>
            <p>Support renewable energy and sustainability.</p>
        </article>

        <article>
            <h3>Inclusive workplace</h3>
            <p>Work in a diverse and respectful environment.</p>
        </article>

        <article>
            <h3>Career growth</h3>
            <p>Develop your skills in a growing industry.</p>
        </article>
    </section>

    <section>
        <h2>Recruitment Overview</h2>

        <p>The table below shows job areas and roles.</p>

        <table>
            <caption>Green Leaf Energy recruitment overview</caption>

            <thead>
                <tr>
                    <th scope="col">Division</th>
                    <th scope="col">Area</th>
                    <th scope="col">Work Type</th>
                    <th scope="col">Location</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <th scope="rowgroup" rowspan="2">Digital Services</th>
                    <td>Website Content Support</td>
                    <td>Full-time</td>
                    <td>Melbourne</td>
                </tr>

                <tr>
                    <td>Online Community Engagement</td>
                    <td>Hybrid</td>
                    <td>Melbourne</td>
                </tr>

                <tr>
                    <th scope="rowgroup" rowspan="2">Project Communication</th>
                    <td>Clean Energy Project Updates</td>
                    <td>Full-time</td>
                    <td>Sydney</td>
                </tr>

                <tr>
                    <td>Stakeholder Information Services</td>
                    <td>Part-time</td>
                    <td>Remote</td>
                </tr>

                <tr>
                    <th scope="row" colspan="2">Current Hiring Focus</th>
                    <td colspan="2">Digital communication and accessibility</td>
                </tr>
            </tbody>
        </table>
    </section>

    <section>
        <h2>Search our careers site</h2>

        <form action="jobs.php" method="get">
            <label for="site-search">Search jobs or information:</label>
            <input type="search" id="site-search" name="search" placeholder="Search by keyword">
            <button type="submit">Search</button>
        </form>
    </section>

    <section>
        <h2>Acknowledgement of Country</h2>

        <p>
            Green Leaf Energy acknowledges the Traditional Owners of Country throughout Australia and acknowledges their continuing connection to land, waters and community.
        </p>

        <p>
            We pay our respects to the people, the cultures and the Elders past and present.
        </p>
    </section>
</main>

<?php include("footer.inc"); ?>