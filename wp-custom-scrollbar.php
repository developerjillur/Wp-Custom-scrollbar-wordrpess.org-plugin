<?php 
/*
 * Plugin Name: Wp Custom scrollbar
 * Plugin URI: http://www.a1lrsrealtyservices.com/plugindemo/
 * Description: Wp Custom scrollbar is nicescroll wordpress plugin. You change your scroll bar just one click. And you get powerful option panel.
 * Author: Jillur Rahman, Asiancoders
 * Author URI: http://asiancoders.com
 * Version: 1.0.0
 * Text Domain: asiancoderswcs_text
*/

// Prevent direct file access
if( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Register text domain
 */
function asiancoderswcs_textdomain_register() {
	load_plugin_textdomain( 'asiancoderswcs_text', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'asiancoderswcs_textdomain_register' );


/**
 * Print direct link to Custom Styles admin page
 * and inserts a link to the Custom Styles admin page
 */
function asiancoderswcs_plugin_settings_link( $links ) {
	$settings_page = '<a href="' . admin_url( 'themes.php?page=asiancoderswcs-settings' ) .'">' . __( 'Settings', 'asiancoderswcs_text' ) . '</a>';
	array_unshift( $links, $settings_page );
	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'asiancoderswcs_plugin_settings_link' );


/**
 * Delete options on uninstall
 */
function asiancoderswcs_unistall_function() {
    delete_option( 'asiancoderswcs_options' );
}
register_uninstall_hook( __FILE__, 'asiancoderswcs_unistall_function' );



// enqueue_scripts
	function asiancoderswcs_enqueu_seripts() {
		wp_enqueue_script( 'jquery' );

		wp_enqueue_style('wpcs-style-css', plugin_dir_url(__FILE__) . 'inc/css/wpcs-style.css');
		wp_enqueue_script('nicescroll-min-js', plugin_dir_url(__FILE__) . 'inc/js/jquery.nicescroll.min.js', array('jquery'), '3.5.4');
	}

add_action('wp_enqueue_scripts', 'asiancoderswcs_enqueu_seripts');


// admin_enqueue_scripts
function asiancoderswcs_admin_enqueu_seripts() {
	wp_enqueue_style('wpcs-admin-style', plugin_dir_url(__FILE__) . 'inc/css/wpcs-admin-style.css');
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'my-script-handle', plugin_dir_url(__FILE__) . 'inc/js/color-pickr.js', array( 'wp-color-picker' ), false, true );
}
add_action( 'admin_enqueue_scripts', 'asiancoderswcs_admin_enqueu_seripts' );


// add option in wp menu
function add_asiancoderswcs_options(){
	add_theme_page( __( 'Wp Custom scrollbar', 'asiancoderswcs_text' ), __( 'Wp Custom scrollbar', 'asiancoderswcs_text' ), 'manage_options', 'asiancoderswcs-settings', 'asiancoderswcs_asiancoderswcs_options');
}
add_action('admin_menu', 'add_asiancoderswcs_options');


// Default values
$asiancoderswcs_options = array(
	'cursor_color' => '#e67e22',
	'cursor_width' => '10px',
	'cursor_border_width' => '0px',
	'cursor_border_color' => '#1e1f23',
	'border_radius' => '4px',
	'scroll_speed' => '60',
	'scroll_auto_hide_mode' => 'false'
);


if ( is_admin() ) : // Load only if we are viewing an admin page
function asiancoderswcs_asiancoderswcs_settings() {
	// Register settings and call sanitation function
	register_setting( 'asiancoderswcs_p_options', 'asiancoderswcs_options', 'asiancoderswcs_validate_options' );
}

add_action( 'admin_init', 'asiancoderswcs_asiancoderswcs_settings' );

// Store layouts views in array
$scroll_auto_hide_mode = array(
	'auto_hide_yes' => array(
		'value' => 'true',
		'label' => __( 'Enable auto hide Scrollbar', 'asiancoderswcs_text' )
	),
	'auto_hide_no' => array(
		'value' => 'false',
		'label' => __( 'Disable auto hide Scrollbar', 'asiancoderswcs_text' )
	)
);


// Function to generate options page
function asiancoderswcs_asiancoderswcs_options() {
	global $asiancoderswcs_options, $scroll_auto_hide_mode;
	
	if ( !isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false; // This checks whether the form has just been submitted. ?>


	<div class="wrap custom_container">
	
		<h2> <?php _e( 'Wp Custom scrollbar Options', 'asiancoderswcs_text' ); ?></h2>

		<?php if ( false !== $_REQUEST['updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved', 'asiancoderswcs_text'); ?></strong></p></div>
		<?php endif; // If the form has just been submitted, this shows the notification ?>
		
		<form method="post" action="options.php">
		
		<?php $settings = get_option( 'asiancoderswcs_options', $asiancoderswcs_options ); ?>
		
		<?php settings_fields( 'asiancoderswcs_p_options' ); ?>

		
		<table class="form-table">
			
			<!-- setting update masssage -->
			<?php if ( isset( $_GET['settings-updated'] ) ) : ?>
				<div id="message" class="updated notice is-dismissible my_cusstom_update_style">
					<p>
						<?php _e( 'Your Settins was sucessfully updated.', 'asiancoderswcs_text' ); ?>
					</p>
				</div>
			<?php endif; ?> 
			<!-- end update masssage -->

			<tr valign="top">
				<th scope="row"><label for="cursor_color"> <?php _e( 'Scrollbar color', 'asiancoderswcs_text' ); ?></label></th>
				<td>
					<input  id='cursor_color' type="text" name="asiancoderswcs_options[cursor_color]" value="<?php echo stripslashes($settings['cursor_color']); ?>" class="my-color-field" />
					<p class="description"> <?php _e( 'Select Scrollbar color here. You get nice flat color for your website: <a href="https://flatuicolors.com/" target="_blink">click here</a>', 'asiancoderswcs_text' ); ?></p>
				</td>
			</tr>
		
			<tr valign="top">
				<th scope="row"><label for="cursor_width"> <?php _e( 'Scrollbar width', 'asiancoderswcs_text' ); ?></label></th>
				<td>
					<input id="cursor_width" type="text" name="asiancoderswcs_options[cursor_width]" value="<?php echo stripslashes($settings['cursor_width']); ?>" />
					<p class="description"> <?php _e( 'Type your Scrollbar width in pixel, This will be count pixel for Example: 12px', 'asiancoderswcs_text' ); ?> </p>
				</td>
			</tr>
		
			<tr valign="top">
				<th scope="row"><label for="cursor_border_width"> <?php _e( 'Scrollbar border width', 'asiancoderswcs_text' ); ?></label></th>
				<td>
					<input id="cursor_border_width" type="text" name="asiancoderswcs_options[cursor_border_width]" value="<?php echo stripslashes($settings['cursor_border_width']); ?>" />
					<p class="description"> <?php _e( 'Type your Scrollbar border width in pixel, This will be count pixel for Example: 2px', 'asiancoderswcs_text' ); ?></p>
				</td>
			</tr>
		
			<tr valign="top">
				<th scope="row"><label for="cursor_border_color"> <?php _e( 'Scrollbar border color', 'asiancoderswcs_text' ); ?></label></th>
				<td>
					<input  id='cursor_border_color' type="text" name="asiancoderswcs_options[cursor_border_color]" value="<?php echo stripslashes($settings['cursor_border_color']); ?>" class="my-color-field" />
					<p class="description"> <?php _e( 'Select Scrollbar border color here. You get nice flat color for your website: <a href="https://flatuicolors.com/" target="_blink">click here</a>', 'asiancoderswcs_text' ); ?> </p>
				</td>
			</tr>
		
			<tr valign="top">
				<th scope="row"><label for="border_radius"> <?php _e( 'Scrollbar border radius', 'asiancoderswcs_text' ); ?></label></th>
				<td>
					<input id="border_radius" type="text" name="asiancoderswcs_options[border_radius]" value="<?php echo stripslashes($settings['border_radius']); ?>" />
					<p class="description"> <?php _e( 'Type your Scrollbar border radius in pixel, This will be count pixel for Example: 6px', 'asiancoderswcs_text' ); ?></p>
				</td>
			</tr>
		
			<tr valign="top">
				<th scope="row"><label for="scroll_speed"> <?php _e( 'Scrollbar speed', 'asiancoderswcs_text' ); ?></label></th>
				<td>
					<input id="scroll_speed" type="text" name="asiancoderswcs_options[scroll_speed]" value="<?php echo stripslashes($settings['scroll_speed']); ?>" />
					<p class="description"> <?php _e( 'Type your scrolling speed, default value is 60. Increase value make Scrollbar speed slower &amp; decrease value make Scrollbar speed faster.', 'asiancoderswcs_text' ); ?></p>
				</td>
			</tr>
		
			<tr valign="top">
				<th scope="row"><label for="scroll_auto_hide_mode"> <?php _e( 'Scrollbar Autohide settings', 'asiancoderswcs_text' ); ?></label></th>
				<td>
					<?php foreach( $scroll_auto_hide_mode as $activate ) : ?>
					<input type="radio" id="hide_<?php echo $activate['value']; ?>" name="asiancoderswcs_options[scroll_auto_hide_mode]" value="<?php esc_attr_e( $activate['value'] ); ?>" <?php checked( $settings['scroll_auto_hide_mode'], $activate['value'] ); ?> />
					<label for="hide_<?php echo $activate['value']; ?>"><?php echo $activate['label']; ?></label><br />
					<?php endforeach; ?>
				</td>
			</tr>

			<tr>
				<td colspan="2"><p class="submit"><input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'asiancoderswcs_text' ); ?>" /></p></td>
				<td align="center"><input type="submit" class="button-secondary custom_register_default" name="asiancoderswcs_options[back_as_default]" value="<?php _e( 'Register default', 'asiancoderswcs_text' ); ?>" /></td>
			</tr>
		</table>
		
		</form>
	
	</div>  <!-- end wrap -->
	
	<?php
}

// Inputs validation, if fails validations replace by default values.
function asiancoderswcs_validate_options( $input ) {
	global $asiancoderswcs_options, $scroll_auto_hide_mode;
	
	$settings = get_option( 'asiancoderswcs_options', $asiancoderswcs_options );
	
	// We strip all tags from the text field, to avoid Vulnerabilities like XSS
	
	$input['cursor_color'] = isset( $input['back_as_default'] ) ? '#e67e22' : wp_filter_post_kses( $input['cursor_color'] );
	$input['cursor_width'] = isset( $input['back_as_default'] ) ? '10px' : wp_filter_post_kses( $input['cursor_width'] );
	$input['cursor_border_width'] = isset( $input['back_as_default'] ) ? '0px' : wp_filter_post_kses( $input['cursor_border_width'] );
	$input['cursor_border_color'] = isset( $input['back_as_default'] ) ? '#1e1f23' : wp_filter_post_kses( $input['cursor_border_color'] );
	$input['border_radius'] = isset( $input['back_as_default'] ) ? '4px' : wp_filter_post_kses( $input['border_radius'] );
	$input['scroll_speed'] = isset( $input['back_as_default'] ) ? '60' : wp_filter_post_kses( $input['scroll_speed'] );
	$input['scroll_auto_hide_mode'] = isset( $input['back_as_default'] ) ? 'false' : wp_filter_post_kses( $input['scroll_auto_hide_mode'] );
	
	return $input;
}

endif;		// Endif is_admin()

function scroller_customizable_asiancoderswcs_active() { ?>

<?php global $asiancoderswcs_options; $scroller_settings = get_option( 'asiancoderswcs_options', $asiancoderswcs_options ); ?>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("html").niceScroll({
			cursorcolor: "<?php echo $scroller_settings['cursor_color']; ?>",
			cursorwidth: "<?php echo $scroller_settings['cursor_width']; ?>",
			cursorborder: "<?php echo $scroller_settings['cursor_border_width'].' solid '.$scroller_settings['cursor_border_color']; ?>",
			cursorborderradius: "<?php echo $scroller_settings['border_radius']; ?>",
			scrollspeed: <?php echo $scroller_settings['scroll_speed']; ?>,
			autohidemode: <?php echo $scroller_settings['scroll_auto_hide_mode']; ?>,
			bouncescroll: true
		});
	});
</script>

<?php
}
add_action('wp_head', 'scroller_customizable_asiancoderswcs_active');