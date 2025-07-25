<?php
// Force theme file re-scan - Minimal functions.php for debugging blank page
/**
 * AKCO Staff Portal functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package AKCO_Staff_Portal
 */

if ( ! function_exists( 'akco_staff_portal_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function akco_staff_portal_setup() {
		error_log( 'AKCO Staff Portal Theme Setup Function Fired! (Minimal Version)' ); // Debugging line

		load_theme_textdomain( 'akco-staff-portal', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'akco-staff-portal' ),
		) );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		add_theme_support( 'custom-background', apply_filters( 'akco_staff_portal_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
endif;
add_action( 'after_setup_theme', 'akco_staff_portal_setup' );

/**
 * Enqueue scripts and styles.
 */
function akco_staff_portal_scripts() {
	wp_enqueue_style( 'akco-staff-portal-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'akco_staff_portal_scripts' );

/**
 * Create Dashboard page on theme activation.
 */
function akco_staff_portal_create_dashboard_page() {
    error_log( 'akco_staff_portal_create_dashboard_page function called.' ); // Debugging
    $dashboard_page_title = 'Dashboard';
    $dashboard_page_content = 'Welcome to your dashboard!';
    $dashboard_page_slug = 'dashboard';
    $dashboard_template = 'template-dashboard.php'; // The custom template file

    $dashboard_page = array(
        'post_title'    => $dashboard_page_title,
        'post_content'  => $dashboard_page_content,
        'post_status'   => 'publish',
        'post_type'     => 'page',
        'post_name'     => $dashboard_page_slug,
    );

    // Check if the page already exists
    $page_id = get_page_by_path( $dashboard_page_slug );
    error_log( 'Page ID before check: ' . ( $page_id ? $page_id->ID : 'Not found' ) ); // Debugging

    if ( ! $page_id ) {
        error_log( 'Dashboard page not found, attempting to create.' ); // Debugging
        // Create the page
        $page_id = wp_insert_post( $dashboard_page );
        if ( is_wp_error( $page_id ) ) {
            error_log( 'Error creating dashboard page: ' . $page_id->get_error_message() ); // Debugging error
        } else {
            error_log( 'Dashboard page created with ID: ' . $page_id ); // Debugging success
        }
    } else {
        $page_id = $page_id->ID;
        error_log( 'Dashboard page already exists with ID: ' . $page_id ); // Debugging
    }

    // Assign the custom template
    if ( $page_id && get_post_meta( $page_id, '_wp_page_template', true ) !== $dashboard_template ) {
        error_log( 'Assigning template to dashboard page ID: ' . $page_id ); // Debugging
        update_post_meta( $page_id, '_wp_page_template', $dashboard_template );
        error_log( 'Template assigned.' ); // Debugging
    } else {
        error_log( 'Template already assigned or page_id is false.' ); // Debugging
    }
}
add_action( 'after_setup_theme', 'akco_staff_portal_create_dashboard_page' );

/**
 * Delete Dashboard page on theme deactivation.
 */
function akco_staff_portal_delete_dashboard_page() {
    error_log( 'akco_staff_portal_delete_dashboard_page function called.' ); // Debugging
    $dashboard_page = get_page_by_path( 'dashboard' );
    if ( $dashboard_page ) {
        error_log( 'Deleting dashboard page with ID: ' . $dashboard_page->ID ); // Debugging
        wp_delete_post( $dashboard_page->ID, true );
        error_log( 'Dashboard page deleted.' ); // Debugging
    } else {
        error_log( 'Dashboard page not found for deletion.' ); // Debugging
    }
}
register_deactivation_hook( __FILE__, 'akco_staff_portal_delete_dashboard_page' );
