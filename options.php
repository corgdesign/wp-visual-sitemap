<?php 
/*
	WP Visual Sitemap options page
*/

defined( 'ABSPATH' );

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
			        		<input type="radio" name="number_of_columns" value="1" id="column_1" <?php checked( '1', get_option( 'number_of_columns' ) ); ?> ><br>

			        		<label for="column_2">2</label>
			        		<input type="radio" name="number_of_columns" value="2" id="column_2" <?php checked( '2', get_option( 'number_of_columns' ) ); ?> ><br>

			        		<label for="column_3">3</label>
			        		<input type="radio" name="number_of_columns" value="3" id="column_3" <?php checked( '3', get_option( 'number_of_columns' ) ); ?> ><br>

			        		<label for="column_4">4</label>
			        		<input type="radio" name="number_of_columns" value="4" id="column_4" <?php checked( '4', get_option( 'number_of_columns' ) ); ?> ><br>

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