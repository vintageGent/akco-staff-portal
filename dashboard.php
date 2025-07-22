<?php
/**
 * The template for the logged-in user dashboard.
 *
 * @package AKCO_Staff_Portal
 */

get_header(); // Include header.php ?>

<div id="primary" class="content-area dashboard">

    <div class="dashboard-header">
        <h1>Welcome, [Volunteer Name]!</h1>
        <p>Your personal space to manage your work and stay updated.</p>
    </div>

    <div class="dashboard-widgets">
        <div class="widget profile-widget">
            <h2>My Profile</h2>
            <!-- Add profile information here -->
        </div>

        <div class="widget projects-widget">
            <h2>My Projects</h2>
            <!-- Add project information here -->
        </div>

        <div class="widget announcements-widget">
            <h2>Announcements</h2>
            <!-- Add announcements here -->
        </div>
    </div>

</div><!-- .content-area -->

<?php get_footer(); // Include footer.php ?>
