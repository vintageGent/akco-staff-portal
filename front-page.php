<?php
/**
 * The template for the site's front page.
 *
 * @package AKCO_Staff_Portal
 */

get_header(); // Include header.php ?>

<div id="primary" class="content-area">

    <div class="akco-content-popup">
        <?php if ( is_user_logged_in() ) : ?>
            <?php
                // Redirect to the dashboard.
                wp_redirect( home_url( '/dashboard.php' ) );
                exit;
            ?>
        <?php else : ?>
            <h1 class="entry-title">Welcome AKCO Volunteers</h1>
            <p>Ready to change the world!</p>
            <div class="entry-content">
                <p>Login to your departments:</p>
                <?php echo do_shortcode( '[ultimatemember_login]' ); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="akco-express-card">
        <!-- Replace YOUR_AKCO_LOGO_URL_HERE with the actual URL of your AKCO logo -->
        <img src="YOUR_AKCO_LOGO_URL_HERE" alt="AKCO Logo">
        <p>Location: Kairi shopping center Kiambu</p>
        <p>Since 2024</p>
    </div>

</div><!-- .content-area -->

<?php get_footer(); // Include footer.php ?>
