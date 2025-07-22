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
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function akco_staff_portal_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on AKCO Staff Portal, use a find and replace
		 * to change 'akco-staff-portal' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'akco-staff-portal', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'akco-staff-portal' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'akco_staff_portal_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
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
