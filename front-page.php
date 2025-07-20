<?php
/**
 * The template for the site's front page.
 *
 * @package AKCO_Staff_Portal
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php if ( is_user_logged_in() ) : ?>

            <article class="page type-page status-publish hentry">
                <header class="entry-header">
                    <?php
                    $current_user = wp_get_current_user();
                    $display_name = $current_user->display_name;
                    ?>
                    <h1 class="entry-title">Welcome, <?php echo esc_html( $display_name ); ?></h1>
                    <div class="akco-card-details">
                        <p class="akco-label">AKCO Premium Card</p>
                        <p class="akco-location">Location: Kairi shopping center Kiambu</p>
                    </div>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <p>This is the main dashboard for the staff portal. Future content and links will go here.</p>
                    <p>For example:</p>
                    <ul>
                        <li><a href="#">View Leave Balance</a></li>
                        <li><a href="#">Download Payslip</a></li>
                        <li><a href="#">Company Announcements</a></li>
                    </ul>
                </div><!-- .entry-content -->
            </article>

        <?php else : ?>

            <article class="page type-page status-publish hentry">
                <header class="entry-header">
                    <h1 class="entry-title">Staff Login</h1>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <p>Please log in to access the AKCO Staff Portal.</p>
                    <p>Login to your departments:</p>
                    <?php echo do_shortcode( '[ultimatemember_login]' ); ?>
                </div><!-- .entry-content -->
            </article>

        <?php endif; ?>

    </main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
