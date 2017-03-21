<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://logicfighters.com
 * @since             1.0.0
 * @package           Approve_reviews_manually_by_amit
 *
 * @wordpress-plugin
 * Plugin Name:       Approve Reviews Manually By Amit
 * Plugin URI:        http://logicfighters.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Logic Fighters
 * Author URI:        http://logicfighters.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       approve_reviews_manually_by_amit
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
} 

$aprm_settings_text = get_option('aprm_settings' );
if($aprm_settings_text['aprm_checkbox_field_0']){ 
add_action( 'add_meta_boxes_comment', 'extend_comment_add_meta_box' );
function extend_comment_add_meta_box() {
add_meta_box( 'title', __( 'Reviewed By' ), 'extend_comment_meta_box', 'comment', 'normal', 'high' );
}
}
function extend_comment_meta_box ( $comment ) {
$owner_status = get_comment_meta( $comment->comment_ID, 'owner_status', true );
wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false );
?>
    <p>
        <label for="owner_status">
            <?php _e( 'Owner Is' ); ?>
        </label>
        <select name="owner_status">
            <option value="verified" <?php selected( 'verified', $owner_status);?> >Verified</option>
            <option value="unverified" <?php selected( 'unverified', $owner_status);?> >Unverified</option>
        </select>
    </p>
    <?php
   
}

add_action( 'edit_comment', 'extend_comment_edit_metafields' );

function extend_comment_edit_metafields( $comment_id ) {
if( ! isset( $_POST['extend_comment_update'] ) || ! wp_verify_nonce( $_POST['extend_comment_update'], 'extend_comment_update' ) ) return;

if ( ( isset( $_POST['owner_status'] ) ) && ( $_POST['owner_status'] != '') ) :
$owner_status = wp_filter_nohtml_kses($_POST['owner_status']);
update_comment_meta( $comment_id, 'owner_status', $owner_status );
else :
delete_comment_meta( $comment_id, 'owner_status');
endif;
}  
$aprm_settings_text = get_option('aprm_settings' );

if($aprm_settings_text['aprm_checkbox_field_0']){ 
function aprm_review_display_meta($comment) {

?>
        <div class="custom_verified_text">
            <?php 
         global $comment;
         global $wpdb;
         $aprm_settings_text = get_option('aprm_settings' ); 
         $sql = "SELECT * FROM ".$wpdb->prefix."commentmeta WHERE comment_id='$comment->comment_ID' AND meta_value='verified'"; 
         $result = $wpdb->get_results($sql); 
         if($result['0']->meta_value == 'verified'){
             if($aprm_settings_text['aprm_text_field_1']){
                echo $aprm_settings_text['aprm_text_field_1'];  
             }else{
                 echo "Veriified Owner";
             } 
         }else{
             if($aprm_settings_text['aprm_text_field_2']){
                 echo $aprm_settings_text['aprm_text_field_2'];  
             } else{
                 echo "Unverified Owner";
             }
         }
         
        ?>
        </div>
        <?php
}
add_action( 'woocommerce_review_meta', 'aprm_review_display_meta', 6 );
}
require plugin_dir_path( __FILE__ ) . 'aprm_settings_fields.php'; 
require plugin_dir_path( __FILE__ ) . 'aprm_custom_settings.php';