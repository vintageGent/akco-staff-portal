<?php
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
		error_log( 'AKCO Staff Portal Theme Setup Function Fired!' ); // Debugging line

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

    if ( is_user_logged_in() ) {
        $user = wp_get_current_user();
        $role = ( array ) $user->roles;
        $role = $role[0];

        if ( $role === 'agriculture' ) {
            wp_enqueue_style( 'akco-staff-portal-agriculture-style', get_template_directory_uri() . '/css/agriculture-style.css' );
        }
        // Add more else if statements for other departments here
    }

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'akco_staff_portal_scripts' );

/**
 * Create custom user roles for departments.
 */
function akco_staff_portal_add_roles() {
    add_role( 'administration_membership', 'Administration & Membership', get_role( 'subscriber' )->capabilities );
    add_role( 'finance', 'Finance', get_role( 'subscriber' )->capabilities );
    add_role( 'agriculture', 'Agriculture', get_role( 'subscriber' )->capabilities );
    add_role( 'media', 'Media', get_role( 'subscriber' )->capabilities );
    add_role( 'sports_talent', 'Sports & Talent', get_role( 'subscriber' )->capabilities );
    add_role( 'hr', 'HR', get_role( 'subscriber' )->capabilities );
    add_role( 'immigration', 'Immigration', get_role( 'subscriber' )->capabilities );
}
add_action( 'init', 'akco_staff_portal_add_roles' );

/**
 * Redirect users with custom roles to the dashboard after login.
 */
function akco_staff_portal_login_redirect( $redirect_to, $request, $user ) {
    // Is there a user to check?
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        // Check if the user has one of our custom roles
        $custom_roles = array( 'administration_membership', 'finance', 'agriculture', 'media', 'sports_talent', 'hr', 'immigration' );
        foreach ( $custom_roles as $role ) {
            if ( in_array( $role, $user->roles ) ) {
                return home_url( '/dashboard/' );
            }
        }
    }
    return $redirect_to;
}
add_filter( 'login_redirect', 'akco_staff_portal_login_redirect', 10, 3 );

/**
 * Redirect to custom login page after logout.
 */
function akco_staff_portal_logout_redirect() {
    wp_redirect( home_url( '/portal-login/' ) );
    exit();
}
add_action( 'wp_logout', 'akco_staff_portal_logout_redirect' );

/**
 * Redirect non-admin users away from the WordPress admin area.
 */
function akco_staff_portal_redirect_non_admin() {
    // Get the URL of the dashboard page.
    $dashboard_url = home_url( '/dashboard/' );

    // Get the current URL the user is trying to access.
    $current_url = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    // If the user is already on the dashboard, do nothing to prevent a loop.
    if ( trailingslashit( $current_url ) === trailingslashit( $dashboard_url ) ) {
        return;
    }

    // If the user is in the admin area, is not an administrator, and it's not an AJAX request, redirect them.
    if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
        wp_redirect( $dashboard_url );
        exit;
    }
}
add_action( 'admin_init', 'akco_staff_portal_redirect_non_admin' );

/**
 * Create custom post types for Projects and Announcements.
 */
function akco_staff_portal_create_post_types() {
    // Projects
    register_post_type( 'project', array(
        'labels' => array(
            'name' => __( 'Projects' ),
            'singular_name' => __( 'Project' )
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array( 'title', 'editor', 'thumbnail' ),
        'rewrite' => array( 'slug' => 'projects' ),
    ));

    // Announcements
    register_post_type( 'announcement', array(
        'labels' => array(
            'name' => __( 'Announcements' ),
            'singular_name' => __( 'Announcement' )
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array( 'title', 'editor' ),
        'rewrite' => array( 'slug' => 'announcements' ),
    ));
}
add_action( 'init', 'akco_staff_portal_create_post_types' );

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