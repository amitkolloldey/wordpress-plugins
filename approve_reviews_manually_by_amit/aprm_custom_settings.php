<?php
if ( ! defined( 'WPINC' ) ) {
	die;
} 


add_action('wp_head','aprm_custom_styles');
function aprm_custom_styles(){
    ?>
    <style>
        em.verified {
            display: none;
        }
        
        <?php $aprm_settings=get_option('aprm_settings');
        echo $aprm_settings['aprm_textarea_field_2'];
        ?>
    </style>
    <?php
}