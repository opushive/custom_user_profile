<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.opushive.com
 * @since             1.0.0
 * @package           Smash_Media_Custom_User_Profile
 *
 * @wordpress-plugin
 * Plugin Name:       Custom User Profile
 * Plugin URI:        http://www.opushive.com
 * Description:       This Plugin helps manage subscriber subscriptions AND other profile details
 * Version:           1.0.0
 * Author:            Tosin Omotayo
 * Author URI:        http://www.opushive.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       smash-media-custom-user-profile
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-smash-media-custom-user-profile-activator.php
 */
function activate_smash_media_custom_user_profile() {
   if(!is_plugin_active( 'smash-media-sms-mgr/smash-media-sms-mgr.php' ) and current_user_can( 'activate_plugins' ) ) {
     wp_die('Sorry, but this plugin requires the Smash Media Sms Manager plugin to be installed and active. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');  
   }
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-smash-media-custom-user-profile-activator.php';
	Smash_Media_Custom_User_Profile_Activator::activate();
        Smash_Media_Custom_User_Profile_Activator::upgrade();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-smash-media-custom-user-profile-deactivator.php
 */
function deactivate_smash_media_custom_user_profile() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-smash-media-custom-user-profile-deactivator.php';
	Smash_Media_Custom_User_Profile_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_smash_media_custom_user_profile' );
register_deactivation_hook( __FILE__, 'deactivate_smash_media_custom_user_profile' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-smash-media-custom-user-profile.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_smash_media_custom_user_profile() {

	$plugin = new Smash_Media_Custom_User_Profile();
	$plugin->run();

}
run_smash_media_custom_user_profile();

function smash_media_custom_user_profile_callback($buffer){
	return $buffer;
}
function smash_media_custom_user_profile_add_ob_start(){
	ob_start("smash_media_custom_user_profile_callback");
}
function smash_media_custom_user_profile_flush_ob_end(){
	ob_end_flush();
}
function smash_media_custom_user_profile_upgrade_check(){
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-smash-media-custom-user-profile-activator.php';
    Smash_Media_Custom_User_Profile_Activator::upgrade();

}

add_action('init', 'smash_media_custom_user_profile_add_ob_start');
add_action('wp_footer', 'smash_media_custom_user_profile_flush_ob_end');
add_action('init', 'smash_media_custom_user_profile_upgrade_check');
