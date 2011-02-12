<?php
// ref: http://themeshaper.com/sample-theme-options/

/**
 * Init plugin options to white list our options
 */
add_action( 'admin_init', 'theme_options_init' );
function theme_options_init(){
	register_setting( 'dojo_options', 'dojo_theme_options', 'theme_options_validate' );
}

/**
 * Load up the menu page
 */
add_action( 'admin_menu', 'theme_options_add_page' );
function theme_options_add_page() {
	add_theme_page( __( 'Advanced Dojo Options' ), __( 'Advanced Dojo Options' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}

/**
 * Create the options page
 */
function theme_options_do_page() {

	// Check update status
	if ( ! isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false;

	?>

	<div class="wrap">

		<?php
			// Headline
			screen_icon();
			print "<h2>" . get_current_theme() . __( ' Theme Options' ) . "</h2>";
		?>

		<?php
			// Display update messages
			if ( false !== $_REQUEST['updated'] ) :
		?>
			<div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
		<?php endif; ?>

		<?php // Start the form ?>
		<form method="post" action="options.php">
			<?php settings_fields( 'dojo_options' ); ?>
			<?php $options = get_option( 'dojo_theme_options' ); ?>
			<table class="form-table">

				<?php
				/**
				 * A sample checkbox option
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'A checkbox' ); ?></th>
					<td>
						<input id="dojo_theme_options[option1]" name="dojo_theme_options[option1]" type="checkbox" value="1" <?php checked( '1', $options['option1'] ); ?> />
						<label class="description" for="dojo_theme_options[option1]"><?php _e( 'dojo checkbox' ); ?></label>
					</td>
				</tr>

				<?php
				/**
				 * A sample text input option
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Some text' ); ?></th>
					<td>
						<input id="dojo_theme_options[sometext]" class="regular-text" type="text" name="dojo_theme_options[sometext]" value="<?php esc_attr_e( $options['sometext'] ); ?>" />
						<label class="description" for="dojo_theme_options[sometext]"><?php _e( 'dojo text input' ); ?></label>
					</td>
				</tr>

				<?php
				/**
				 * A sample textarea option
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'A textbox' ); ?></th>
					<td>
						<textarea id="dojo_theme_options[sometextarea]" class="large-text" cols="50" rows="10" name="dojo_theme_options[sometextarea]"><?php echo stripslashes( $options['sometextarea'] ); ?></textarea>
						<label class="description" for="dojo_theme_options[sometextarea]"><?php _e( 'dojo text box' ); ?></label>
					</td>
				</tr>
			</table>

			<?php // Submit Button ?>
			<p class="submit">
				<input type="submit" name="plugin_options[submit]" class="button-primary" value="<?php _e( 'Save Options' ); ?>" />
				<input type="submit" name="plugin_options[reset]" value="Reset all Options" />
			</p>
			<p>To uninstall Dojo, use the "Reset all Options" button. That will remove all Dojo options from your database. Then you can switch to a different theme.</p>

		</form>
	</div><!-- /.wrap -->
<?php } // end theme_options_do_page

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {
	global $select_options, $radio_options;

	// Our checkbox value is either 0 or 1
	if ( ! isset( $input['option1'] ) )
		$input['option1'] = null;
	$input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );

	// Say our text option must be safe text with no HTML tags
	$input['sometext'] = wp_filter_nohtml_kses( $input['sometext'] );

	// Say our textarea option must be safe text with the allowed tags for posts
	$input['sometextarea'] = wp_filter_post_kses( $input['sometextarea'] );

	return $input;
}

// adapted from http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/