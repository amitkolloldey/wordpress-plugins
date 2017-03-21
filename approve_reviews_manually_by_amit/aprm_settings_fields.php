<?php
if ( ! defined( 'WPINC' ) ) {
	die;
} 

 
add_action( 'admin_menu', 'aprm_add_admin_menu' );
add_action( 'admin_init', 'aprm_settings_init' );


function aprm_add_admin_menu(  ) { 

	add_menu_page( 'Approve Reviews Manually By Amit', 'Approve Reviews Manually By Amit', 'manage_options', 'approve_reviews_manually_by_amit', 'aprm_options_page','dashicons-index-card',26 );

}


function aprm_settings_init(  ) { 

	register_setting( 'pluginPage', 'aprm_settings' );

	add_settings_section(
		'aprm_pluginPage_section', 
		__( '', 'approve_reviews_manually_by_amit' ), 
		'aprm_settings_section_callback', 
		'pluginPage'
	);
 
	add_settings_field( 
		'aprm_checkbox_field_0', 
		__( 'Enable Approve Reviews Manually', 'approve_reviews_manually_by_amit' ), 
		'aprm_checkbox_field_0_render', 
		'pluginPage', 
		'aprm_pluginPage_section' 
	);

	add_settings_field( 
		'aprm_text_field_1', 
		__( 'Text Label For "Verified Owner"', 'approve_reviews_manually_by_amit' ), 
		'aprm_text_field_1_render', 
		'pluginPage', 
		'aprm_pluginPage_section' 
	);
	add_settings_field( 
		'aprm_text_field_2', 
		__( 'Text Label For "Unverified Owner"', 'approve_reviews_manually_by_amit' ), 
		'aprm_text_field_2_render', 
		'pluginPage', 
		'aprm_pluginPage_section' 
	);

	add_settings_field( 
		'aprm_textarea_field_2', 
		__( 'Custom CSS', 'approve_reviews_manually_by_amit' ), 
		'aprm_textarea_field_2_render', 
		'pluginPage', 
		'aprm_pluginPage_section' 
	);


}


function aprm_checkbox_field_0_render(  ) { 

	$options = get_option( 'aprm_settings' );
	?>
    <input type='checkbox' name='aprm_settings[aprm_checkbox_field_0]' <?php checked( $options[ 'aprm_checkbox_field_0'], 1 ); ?> value='1'>
    <?php

}


function aprm_text_field_1_render( ) { 

	$options = get_option( 'aprm_settings' );
	?>
        <input type='text' name='aprm_settings[aprm_text_field_1]' value='<?php echo $options[' aprm_text_field_1 ']; ?>'>
        <?php

}


function aprm_text_field_2_render( ) { 

	$options = get_option( 'aprm_settings' );
	?>
            <input type='text' name='aprm_settings[aprm_text_field_2]' value='<?php echo $options[' aprm_text_field_2 ']; ?>'>
            <?php

}


function aprm_textarea_field_2_render(  ) { 

	$options = get_option( 'aprm_settings' );
	?>
                <textarea cols='40' rows='5' name='aprm_settings[aprm_textarea_field_2]' class="large-text code">
                    <?php echo $options['aprm_textarea_field_2']; ?>
                </textarea>
                <?php

}


function aprm_settings_section_callback(  ) { 


}


function aprm_options_page(  ) { 

	?>
                    <form action='options.php' method='post'>
                        <h2>Approve Reviews Manually By Amit</h2>
                        <?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>
                    </form>
                    <?php

}

?>