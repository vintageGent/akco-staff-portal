<?php
/**
 * Template Name: Dashboard
 *
 * @package AKCO_Staff_Portal
 */

error_log( 'template-dashboard.php: Start of file.' ); // Debugging

// If user is not logged in, redirect to the login page.
if ( ! is_user_logged_in() ) {
    error_log( 'template-dashboard.php: User not logged in, redirecting.' ); // Debugging
    wp_redirect( home_url( '/' ) );
    exit;
}
error_log( 'template-dashboard.php: User is logged in.' ); // Debugging

get_header(); // Include header.php ?>

<?php error_log( 'template-dashboard.php: After get_header().' ); // Debugging ?>

<div id="primary" class="content-area dashboard">

    <div class="dashboard-header">
        <?php
        $current_user = wp_get_current_user();
        $volunteer_name = $current_user->display_name;
        error_log( 'template-dashboard.php: Displaying welcome message for ' . $volunteer_name ); // Debugging
        ?>
        <h1>Welcome, <?php echo esc_html( $volunteer_name ); ?>!</h1>
        <p>Your personal space to manage your work and stay updated.</p>
    </div>

    <div class="dashboard-widgets">
        <div class="widget profile-widget">
            <h2>My Profile</h2>
            <ul>
                <li><strong>Email:</strong> <?php echo esc_html( $current_user->user_email ); ?></li>
                <li><strong>Department:</strong> <?php echo esc_html( str_replace( '_', ' ', ucfirst( $current_user->roles[0] ) ) ); ?></li>
            </ul>
        </div>

        <div class="widget projects-widget">
            <h2>My Projects</h2>
            <!-- Add project information here -->
        </div>

        <div class="widget announcements-widget">
            <h2>Announcements</h2>
            <?php
            error_log( 'template-dashboard.php: Querying announcements.' ); // Debugging
            $announcements_query = new WP_Query( array(
                'post_type' => 'announcement',
                'posts_per_page' => 3,
            ) );
            if ( $announcements_query->have_posts() ) : ?>
                <?php error_log( 'template-dashboard.php: Announcements found.' ); // Debugging ?>
                <ul>
                    <?php while ( $announcements_query->have_posts() ) : $announcements_query->the_post(); ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                    <?php endwhile; ?>
                </ul>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <?php error_log( 'template-dashboard.php: No announcements found.' ); // Debugging ?>
                <p>No announcements at this time.</p>
            <?php endif; ?>
        </div>
    </div>

</div><!-- .content-area -->

<?php get_footer(); // Include footer.php ?>

<?php error_log( 'template-dashboard.php: End of file.' ); // Debugging ?>
