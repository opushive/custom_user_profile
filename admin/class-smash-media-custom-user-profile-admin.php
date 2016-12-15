<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.opushive.com
 * @since      1.0.0
 *
 * @package    Smash_Media_Custom_User_Profile
 * @subpackage Smash_Media_Custom_User_Profile/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Smash_Media_Custom_User_Profile
 * @subpackage Smash_Media_Custom_User_Profile/admin
 * @author     Tosin Omotayo <tosin@okasho.org>
 */
class Smash_Media_Custom_User_Profile_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Smash_Media_Custom_User_Profile_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Smash_Media_Custom_User_Profile_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/smash-media-custom-user-profile-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name,"https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css", array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Smash_Media_Custom_User_Profile_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Smash_Media_Custom_User_Profile_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/smash-media-custom-user-profile-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js", array( 'jquery' ), $this->version, false );

	}
       public function create_top_level_menu() {
//        add_menu_page("Subscriber Management", "Subscriber Management", "activate_plugins", "subscriber-management", array('Subscriber', "render_subscriber"), "dashicons-id-alt", 9);
         add_menu_page("Custom User Profile", "Custom User Profile", "activate_plugins", "custom-user-profile", array('\custom_profile\Subscription', "render_subscriptions"), "dashicons-admin-comments", 12);
    } 
     public function get_plugin_name() {
        return $this->plugin_name;
    }
    


}
