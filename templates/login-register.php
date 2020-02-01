<?php
/**
 * Template Name: Login/Register
 *
 * @package   Chic WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

get_header();

if ( isset( $_POST['adduser'] )
	&& isset( $_POST['add-nonce'] )
	&& wp_verify_nonce( $_POST['add-nonce'], 'add-user' )
) {

	// Die if the nonce fails
	if ( ! wp_verify_nonce( $_POST['add-nonce'],'add-user' ) ) {
		wp_die( 'Sorry! That was secure, guess you\'re cheatin huh!', 'chic' );
	}

	// Setup new user
	else {
		$wpex_userdata = array(
			'user_login'       => esc_attr( $_POST['user_name'] ),
			'user_email'       => esc_attr( $_POST['email'] ),
			'user_pass'        => esc_attr( $_POST['register_user_pass'] ),
			'user_pass_repeat' => esc_attr( $_POST['register_user_pass_repeat'] ),
			'role'             => get_option( 'default_role' ),
		);
		
		// Username check
		if ( ! $wpex_userdata['user_login'] ) {
			$wpex_error = __( 'A <strong>username</strong> is required for registration.', 'chic' );
		} elseif ( username_exists( $wpex_userdata['user_login'] ) ) {
			$wpex_error = __( 'Sorry, that username already exists!', 'chic' );
		}

		// Email check
		elseif ( ! $wpex_userdata['user_email'] ) {
			$wpex_error = __( 'An <strong>email</strong> is required for registration.', 'chic' );
		} elseif ( ! is_email( $wpex_userdata['user_email'] ) ) {
			$wpex_error = __( 'You must enter a valid email address.', 'chic' );
		} elseif ( email_exists($wpex_userdata['user_email'] ) ) {
			$wpex_error = __( 'Sorry, that email address is already used!', 'chic' );
		}

		// Pass 1 or Password 2
		elseif ( ! $wpex_userdata['user_pass'] ){
			$wpex_error = __( 'A <strong>password</strong> is required for registration.', 'chic' );
		}

		// Password match
		elseif ( $wpex_userdata['user_pass'] != $wpex_userdata['user_pass_repeat'] ){
			$wpex_error = __( 'Password do not match.', 'chic' );
		}

		// setup new users and send notification
		else{
			$new_user = wp_insert_user( $wpex_userdata );
			wp_new_user_notification( $new_user, $wpex_userdata['user_pass'] );
		}
	}
} ?>

	<div class="wpex-content-area wpex-clr">

		<main class="wpex-site-main wpex-clr">

			<?php while ( have_posts() ) : the_post(); ?>

				<article class="wpex-clr">

					<?php
					// If user is already logged in
					if ( is_user_logged_in() ) { ?>

						<div class="wpex-already-loggedin-msg wpex-boxed-container wpex-clr">
							<p><?php
							// Get current user and display already logged in message
							$current_user = wp_get_current_user();
							echo __( 'You are already logged in as:', 'chic' ) .' <strong>'. $current_user->display_name; ?></strong></p>
							<a href="<?php echo wp_logout_url( get_permalink() ); ?>" class="theme-button light"><?php _e( 'Logout', 'chic' ); ?></a>
						</div><!-- .already-loggedin-msg -->

					<?php
					// Display login form & register form
					} else { ?>

					<div class="wpex-row wpex-clr">

						<div class="login-form wpex-login-template-form wpex-clr">

							<div class="wpex-boxed-container wpex-clr">

								<h2><?php _e( 'Login to an account', 'chic' ); ?></h2>

								<?php wp_login_form( array(
									'label_username' => '',
									'label_password' => '',
									'remember'       => false,
								) ); ?>

								<a href="<?php echo wp_lostpassword_url(); ?>" title="<?php _e( 'Lost Password? Recover it here.', 'chic' ); ?>"><?php _e( 'Lost Password?', 'chic' ); ?></a>

							</div><!-- .wpex-boxed-container -->

						</div><!-- .login-form -->

						<div class="register-form wpex-login-template-form wpex-clr">

							<div class="wpex-boxed-container wpex-clr">

								<?php
								// User was created display message
								if ( isset( $new_user ) ) { ?>
									<div class="notice green registration-notice">
										<?php _e( 'Registration successful. You can now log in above.', 'chic' ); ?>
									</div><!-- .notice -->
								<?php }
								// User not created, display error
								elseif ( !isset( $new_user ) && isset( $wpex_error ) && !empty( $wpex_error ) ) { ?>
									<div class="notice yellow registration-notice">
										<?php echo $wpex_error; ?>
									</div><!-- .notice -->
								<?php } ?>
								<h2><?php _e( 'Register for an account', 'chic' ); ?></h2>

								<form method="POST" id="adduser" class="user-forms" action="" autocomplete="off">

									<p><input class="text-input" name="user_name" type="text" id="user_name" value="<?php echo isset( $_POST['user_name'] ) ? $_POST['user_name'] : ''; ?>" placeholder="<?php echo 'Username *'; ?>" /></p>

									<p><input class="text-input" name="email" type="text" id="email" value="<?php echo isset( $_POST['email'] ) ? $_POST['email'] : ''; ?>" placeholder="<?php echo 'E-mail *'; ?>" /></p>

									<p><input class="text-input" name="register_user_pass" type="password" id="register_user_pass" value="" placeholder="<?php echo 'Password *'; ?>" /></p>

									<p><input class="text-input" name="register_user_pass_repeat" type="password" id="register_user_pass_repeat" value="" placeholder="<?php echo 'Confirm Password *'; ?>" /></p>
									
									<p class="strength"><span><?php _e( 'Strength indicator', 'chic' ); ?></span></p>

									<p class="form-submit">
										<input name="adduser" type="submit" id="addusersub" class="submit button" value="Register" />
										<?php wp_nonce_field( 'add-user', 'add-nonce' ) ?>
										<input name="action" type="hidden" id="action" value="adduser" />
									</p>

								</form>

								<?php
								// Enqueue password strength js
								wp_enqueue_script( 'password-strength-meter' ); ?>

								<script>
								// <![CDATA[
									jQuery( function() {
										// Password check
										function password_strength() {
											var pass  = jQuery('#register_user_pass').val();
											var pass2 = jQuery('#register_user_pass_repeat').val();
											var user  = jQuery('#user_name').val();
											jQuery('.strength').removeClass('short bad good strong empty mismatch');
											if ( ! pass ) {
												jQuery('#pass-strength-result').html( pwsL10n.empty );
												return;
											}
											var strength = passwordStrength(pass, user, pass2);
											if ( 2 == strength ) {
												jQuery('.strength').addClass('bad').html( pwsL10n.bad );
											}
											else if ( 3 == strength ) {
												jQuery('.strength').addClass('good').html( pwsL10n.good );
											}
											else if ( 4 == strength ) {
												jQuery('.strength').addClass('strong').html( pwsL10n.strong );
											}
											else if ( 5 == strength ) {
												jQuery('.strength').addClass('mismatch').html( pwsL10n.mismatch );
											}
											else {
												jQuery('.strength').addClass('short').html( pwsL10n.short );
											}
										}
										jQuery( '#register_user_pass, #register_user_pass_repeat' ).val('').keyup( password_strength );
									} );
									pwsL10n = {
										empty    : "<?php _e( 'Strength indicator', 'chic' ) ?>",
										short    : "<?php _e( 'Very weak', 'chic' ) ?>",
										bad      : "<?php _e( 'Weak', 'chic' ) ?>",
										good     : "<?php _e( 'Medium', 'chic' ) ?>",
										strong   : "<?php _e( 'Strong', 'chic' ) ?>",
										mismatch : "<?php _e( 'Mismatch', 'chic' ) ?>"
									}
									try{
										convertEntities(pwsL10n);
									} catch( e ) { };
									// ]]>
									</script>

								</div><!-- .wpex-boxed-container -->

							</div><!-- .register-form -->

						</div><!-- .wpex-row -->

					<?php } ?>

				</article><!-- .wpex-clr -->

			<?php endwhile; ?>

		</main><!-- .wpex-main -->

	</div><!-- .wpex-content-area -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>