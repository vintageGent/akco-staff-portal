<?php
/**
 * The template for the site's front page.
 *
 * @package AKCO_Staff_Portal
 */

get_header(); // Include header.php ?>

<div id="primary" class="content-area">

        <div class="akco-top-logo">
            <!-- Replace YOUR_AKCO_LOGO_URL_HERE with the actual URL of your AKCO logo -->
            <img src="YOUR_AKCO_LOGO_URL_HERE" alt="AKCO Logo">
        </div>

        <div class="akco-express-card">
            <!-- Replace YOUR_AKCO_LOGO_URL_HERE with the actual URL of your AKCO logo -->
            <img src="YOUR_AKCO_LOGO_URL_HERE" alt="AKCO Logo">
            <p>Location: Kairi shopping center Kiambu</p>
            <p>Since 2024</p>
        </div>

        <div class="akco-content-popup">
            <?php if ( is_user_logged_in() ) : ?>
                <?php
                $current_user = wp_get_current_user();
                $display_name = $current_user->display_name;
                ?>
                <h1 class="entry-title">Welcome AKCO Staff</h1>
                <p>Ready to change the world!</p>
                <div class="entry-content">
                    <ul>
                        <li><a href="#">Login</a></li>
                        <li><a href="#">Logout</a></li>
                        <li><a href="#">View Leave Balance</a></li>
                        <li><a href="#">Download Payslip</a></li>
                        <li><a href="#">Organization Announcements</a></li>
                    </ul>
                </div>
            <?php else : ?>
                <h1 class="entry-title">Welcome AKCO Staff</h1>
                <p>Ready to change the world!</p>
                <div class="entry-content">
                    <p>Login to your departments:</p>
                    <?php echo do_shortcode( '[ultimatemember_login]' ); ?>
                </div>
            <?php endif; ?>
        </div>

</div><!-- .content-area -->

<?php get_footer(); // Include footer.php ?>