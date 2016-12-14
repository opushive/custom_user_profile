<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.opushive.com
 * @since      1.0.0
 *
 * @package    Smash_Media_Custom_User_Profile
 * @subpackage Smash_Media_Custom_User_Profile/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Smash_Media_Custom_User_Profile
 * @subpackage Smash_Media_Custom_User_Profile/public
 * @author     Tosin Omotayo <tosin@okasho.org>
 */
class Smash_Media_Custom_User_Profile_Public {
       public $_parent;
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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
                  $this->register_shortcodes();
	}
        public function add_hooks($_parent) {
              $this->_parent = $_parent;
             
          }
	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/smash-media-custom-user-profile-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/smash-media-custom-user-profile-public.js', array( 'jquery' ), $this->version, false );

	}
        
        
        public function register_shortcodes(){
       // [get-cateogries]
         add_shortcode('get-cateogries', array($this,'get_categories'));
         add_shortcode('display-authors', array($this,'getAuthors'));
//        add_shortcode('search-and-compare', array($this,'create_angular_search_and_compare_component'));
    
        }
        
        public function get_categories(){
            $all_categories = \custom_profile\Subscription::getCategories(false);
           // var_dump($all_categories);
        }
        
        public function getAuthors(){
            var_dump(\custom_profile\Subscription::getAuthorsAndCategories(0));
        }

}
