<?php 
/*
Plugin Name: WP Visual Sitemap
Description: Plugin to add a visual sitemap to the frontend of your site
Version:     1.0
Author:      Martin Stewart
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

defined( 'ABSPATH' );

#************************************
#		CSS and javascript
#************************************

function wpvs_enqueue_admin_scripts() {

	# admin javascript
    wp_enqueue_script( 'wpvs-admin-js', plugins_url('admin/wpvs-admin-scripts.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ), false, true );

    # admin css
    wp_enqueue_style( 'wpvs_admin_css', plugins_url('admin/wpvs-admin-styles.css', __FILE__ ));

    // # front end css
    // wp_enqueue_style( 'wpvs_front_end_css', plugins_url('css/wpvs-front-end.css', __FILE__ ));

    // # front end javascript
    // wp_enqueue_script( 'wpvs-admin-js', plugins_url('js/wpvs-front-end.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ), false, true );

}
add_action( 'admin_enqueue_scripts', 'wpvs_enqueue_admin_scripts' );



#************************************
#			Admin menu
#************************************

# Add an admin menu
function wpvs_admin_menu() {
	add_options_page( 'WP Visual Sitemap Settings', 'WP Visual Sitemap', 'manage_options', 'wpvs_settings', 'wpvs_plugin_options' );
}

# Output the options
function wpvs_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	?>
	<div class="wrap">
		<h1>WP Visual Sitemap Settings</h1>
		<form method="post" action="options.php">
			<?php

				settings_fields( 'wpvs_option_group' );
				do_settings_sections( 'wpvs_option_group' ); ?>

				<table class="form-table">
			        <tr valign="top">
			        	<th scope="row">Background colour</th>
			        	<td>
			        		<input type="text" name="icon_background_colour" class="my-color-field" data-default-color="#009691" value="<?php echo esc_attr( get_option('icon_background_colour') ); ?>" />
			        	</td>
			        </tr>
			         
			        <tr valign="top">
			        	<th scope="row">Use icons?</th>
			        	<td>
			        		<input type="checkbox" name="use_icons" value="yes" <?php checked( 'yes', get_option( 'use_icons' ) ); ?> />
			        	</td>
			        </tr>

			        <tr valign="top">
			        	<th scope="row">Number of columns</th>
			        	<td>
			        		
			        		<label for="column_1">1</label>
			        		<input type="radio" name="number_of_columns" value="1" id="column_1" <?php checked( '1', get_option( 'number_of_columns' ) ); ?> >

			        		<label for="column_2">2</label>
			        		<input type="radio" name="number_of_columns" value="2" id="column_2" <?php checked( '2', get_option( 'number_of_columns' ) ); ?> >

			        		<label for="column_3">3</label>
			        		<input type="radio" name="number_of_columns" value="3" id="column_3" <?php checked( '3', get_option( 'number_of_columns' ) ); ?> >

			        		<label for="column_4">4</label>
			        		<input type="radio" name="number_of_columns" value="4" id="column_4" <?php checked( '4', get_option( 'number_of_columns' ) ); ?> >

			        	</td>
			        </tr>
			        
			    </table>		    

				<?php

				submit_button();

			?>
		</form>
	</div>
<?php
}

# Register options
function wpvs_register_settings() {
  register_setting( 'wpvs_option_group', 'icon_background_colour' );
  register_setting( 'wpvs_option_group', 'use_icons' );
  register_setting( 'wpvs_option_group', 'number_of_columns' );
}

if ( is_admin() ) {
	add_action( 'admin_menu', 'wpvs_admin_menu' );
	add_action( 'admin_init', 'wpvs_register_settings' );
}


#************************************
#		Settings meta box
#************************************

# Enqueue color picker
function wpvs_color_picker( $hook_suffix ) {
    wp_enqueue_style( 'wp-color-picker' );
}
add_action( 'admin_enqueue_scripts', 'wpvs_color_picker' );


# Enqueue Font Awesome picker
function wpvs_fa_picker() {
	wp_enqueue_script( 'fa_picker_js', plugins_url('fontawesome/iconpicker/js/fontawesome-iconpicker.min.js', __FILE__ ), array( 'jquery' ), false, true );
	wp_enqueue_style( 'fa_picker_css', plugins_url('fontawesome/iconpicker/css/fontawesome-iconpicker.min.css', __FILE__ ));
	wp_enqueue_style( 'fa_css', plugins_url('fontawesome/css/font-awesome.min.css', __FILE__ ));
}

# Only enqueue if icons are enabled
if ( get_option( 'use_icons' ) === 'yes' ) {
	add_action( 'admin_enqueue_scripts', 'wpvs_fa_picker' );
}

# Register the meta box
add_action( 'add_meta_boxes', 'wpvs_metabox' );
function wpvs_metabox() {
	add_meta_box('wpvs_page_settings', 'WP Visual Sitemap', 'wpvs_page_settings', 'page', 'side', 'default');
}

# Add the fields
function wpvs_page_settings($post) {
	
	wp_nonce_field( basename( __FILE__ ), 'wpvs_nonce' );
    $wpvs_stored_meta = get_post_meta( $post->ID ); ?>

	<p>
	    <label for="include_in_sitemap">
	        <span class="wpvs_label"><?php _e( 'Include in sitemap?', 'wpvs-textdomain' )?></span>
	    </label>
	</p>
	<input type="checkbox" name="include_in_sitemap" id="include_in_sitemap" value="yes" <?php if ( isset ( $wpvs_stored_meta['include_in_sitemap'] ) ) checked( $wpvs_stored_meta['include_in_sitemap'][0], 'yes' ); ?>>

<?php

	if ( get_option( 'use_icons' ) === 'yes' ) { ?>
	
	<p>
		<span class="wpvs_label"><label for="wpvs_fa_icon"><?php _e( 'Page icon', 'wpvs-textdomain' )?></label></span>
	</p>

	<?php 
	
	echo isset ( $wpvs_stored_meta['wpvs_fa_icon'] ) ? '<i id="wpvs_fa_chosen_icon" class="fa ' . $wpvs_stored_meta['wpvs_fa_icon'][0] . '"></i>' : '<i id="wpvs_fa_chosen_icon"></i>';

	?>
    <input type="text" name="wpvs_fa_icon" id="wpvs_fa_icon" data-input-search="true" placeholder="Search for icon..." value="<?php if ( isset ( $wpvs_stored_meta['wpvs_fa_icon'] ) ) echo $wpvs_stored_meta['wpvs_fa_icon'][0]; ?>">

    <script type="text/javascript">
    	jQuery(document).ready(function($){
	    	$('#wpvs_fa_icon').iconpicker();
    	});
    </script>
	
	<?php 
	}

}

# Save the data
function wpvs_save_meta($post_id) {
	
	# Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'wpvs_nonce' ] ) && wp_verify_nonce( $_POST[ 'wpvs_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    # Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

	# Checks for input and saves
	if( isset( $_POST[ 'include_in_sitemap' ] ) ) {
	    update_post_meta( $post_id, 'include_in_sitemap', 'yes' );
	} else {
	    update_post_meta( $post_id, 'include_in_sitemap', '' );
	}

	// Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'wpvs_fa_icon' ] ) ) {
        update_post_meta( $post_id, 'wpvs_fa_icon', $_POST[ 'wpvs_fa_icon' ] );
    }

}

add_action('save_post', 'wpvs_save_meta'); // save the custom fields








