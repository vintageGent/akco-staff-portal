<?php
/**
 * Template Name: Custom Login Page
 *
 * @package AKCO_Staff_Portal
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <div class="login-container">
            <h1 class="login-title">AKCO Portal Login</h1>

            <form name="loginform" id="loginform" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">
                
                <p>
                    <label for="user_login">Username or Email Address</label>
                    <input type="text" name="log" id="user_login" class="input" value="" size="20" />
                </p>
                <p>
                    <label for="user_pass">Password</label>
                    <input type="password" name="pwd" id="user_pass" class="input" value="" size="20" />
                </p>
                <p class="login-remember"><label><input name="rememberme" type="checkbox" id="rememberme" value="forever"> Remember Me</label></p>
                <p class="login-submit">
                    <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary" value="Log In" />
                    <input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url( '/dashboard/' ) ); ?>" />
                </p>
            </form>

            <p id="nav">
                <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>">Lost your password?</a>
            </p>

        </div>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
