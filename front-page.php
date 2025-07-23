<?php
/**
 * The template for the site's front page.
 *
 * @package AKCO_Staff_Portal
 */

// Process login form submission
if ( isset( $_POST['wp-submit'] ) ) {
    $creds = array();
    $creds['user_login'] = sanitize_user( $_POST['log'] );
    $creds['user_password'] = $_POST['pwd'];
    $creds['remember'] = isset( $_POST['rememberme'] );

    $user = wp_signon( $creds, false );

    if ( is_wp_error( $user ) ) {
        // Handle login error
        $login_error = $user->get_error_message();
    } else {
        // Successful login, redirect to dashboard
        wp_redirect( home_url( '/dashboard/' ) );
        exit();
    }
}

get_header(); // Include header.php ?>

<div id="primary" class="content-area">

    <?php if ( is_user_logged_in() ) : ?>
        <?php
            // User is logged in, show the dashboard link or content.
            // For now, let's just show a welcome message and a link.
        ?>
        <div class="akco-content-popup">
            <h1 class="entry-title">Welcome Back, AKCO Volunteer!</h1>
            <p>You are already logged in.</p>
            <p><a href="<?php echo esc_url( home_url( '/dashboard/' ) ); ?>">Go to your Dashboard</a></p>
        </div>
    <?php else : ?>
        <div class="akco-content-popup">
            <h1 class="entry-title">Welcome AKCO Volunteers</h1>
            <p>Ready to change the world!</p>

            <?php if ( isset( $login_error ) ) : ?>
                <p class="login-error"><?php echo esc_html( $login_error ); ?></p>
            <?php endif; ?>

            <form name="loginform" id="loginform" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="post">
                <p>
                    <label for="department">Select Your Department</label>
                    <select name="department" id="department" class="input">
                        <option value="">---</option>
                        <option value="administration_membership">Administration & Membership</option>
                        <option value="finance">Finance</option>
                        <option value="agriculture">Agriculture</option>
                        <option value="media">Media</option>
                        <option value="sports_talent">Sports & Talent</option>
                        <option value="hr">HR</option>
                        <option value="immigration">Immigration</option>
                    </select>
                </p>
                <p>
                    <label for="user_login">Username or Email Address</label>
                    <input type="text" name="log" id="user_login" class="input" value="<?php echo ( isset( $_POST['log'] ) ? esc_attr( $_POST['log'] ) : '' ); ?>" size="20" />
                </p>
                <p>
                    <label for="user_pass">Password</label>
                    <div style="position: relative;">
                        <input type="password" name="pwd" id="user_pass" class="input" value="" size="20" />
                        <span class="dashicons dashicons-visibility" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;" onclick="togglePasswordVisibility()"></span>
                    </div>
                </p>
                <script>
                    function togglePasswordVisibility() {
                        var passwordField = document.getElementById('user_pass');
                        var toggleIcon = document.querySelector('.dashicons-visibility');
                        if (passwordField.type === 'password') {
                            passwordField.type = 'text';
                            toggleIcon.classList.remove('dashicons-visibility');
                            toggleIcon.classList.add('dashicons-hidden');
                        } else {
                            passwordField.type = 'password';
                            toggleIcon.classList.remove('dashicons-hidden');
                            toggleIcon.classList.add('dashicons-visibility');
                        }
                    }
                </script>
                <p class="login-remember"><label><input name="rememberme" type="checkbox" id="rememberme" value="forever" <?php echo ( isset( $_POST['rememberme'] ) ? 'checked="checked"' : '' ); ?>> Remember Me</label></p>
                <p class="login-submit">
                    <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary" value="Log In" />
                </p>
            </form>

            <p id="nav">
                <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>">Lost your password?</a>
            </p>

        </div>
    <?php endif; ?>

    <div class="akco-express-card">
        <!-- Replace YOUR_AKCO_LOGO_URL_HERE with the actual URL of your AKCO logo -->
        <img src="YOUR_AKCO_LOGO_URL_HERE" alt="AKCO Logo">
        <p>Location: Kairi shopping center Kiambu</p>
        <p>Since 2024</p>
    </div>

</div><!-- .content-area -->

<?php get_footer(); // Include footer.php ?>
