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
              
               $_parent->add_action('wp_head',$this,'my_custom_js');   
          }
          function my_custom_js() {
    echo '<script type="text/javascript" src="'.plugin_dir_url( __FILE__ ) . 'js/vue.min.js"></script>';
}

// Add hook for front-end <head></head>

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
                wp_enqueue_style('vexcss', plugin_dir_url( __FILE__ ) . 'css/vex.css', array(), $this->version, 'all' );
                wp_enqueue_style('vexcsstheme', plugin_dir_url( __FILE__ ) . 'css/vex-theme-os.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/smash-media-custom-user-profile-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts(){

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
                wp_enqueue_script('vex', plugin_dir_url( __FILE__ ) . 'js/vue.combined.min.js',array(), $this->version, false);
            
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/smash-media-custom-user-profile-public.js', array( 'jquery','vex'), $this->version, false );

	}
        
        
        public function register_shortcodes(){
            
         add_shortcode('shortcode-debugger',array($this,'getShortcode'));
        //[get-top-authors]
        add_shortcode('get-top-authors',array($this,'getTopAuthors'));
        //[get-top-categories]
          add_shortcode('get-top-categories',array($this,'getTopcategories'));
          //[user-author-subscriptions]
          add_shortcode('user-author-subscriptions',array($this,'getUserAuthorSubscriptions'));
          
       // [get-cateogries]
         add_shortcode('get-cateogries', array($this,'get_categories'));
         add_shortcode('display-authors', array($this,'getAuthors'));
         add_shortcode('user_subscriptions',array($this,'user_subscriptions'));
         
      
//        add_shortcode('search-and-compare', array($this,'create_angular_search_and_compare_component'));
          
        }
        
        public function get_categories(){
            $all_categories = \custom_profile\Subscription::getCategories(false);
           // var_dump($all_categories);
        }
        public function getShortcode(){
            $html = do_shortcode('[vc_row][vc_column][vc_raw_html]JTNDZGl2JTIwY2xhc3MlM0QlMjJ0aXRsZS1zZWN0aW9uJTIyJTNFJTBBJTA5JTNDaDElM0UlM0NzcGFuJTIwY2xhc3MlM0QlMjJ3b3JsZCUyMiUzRU15JTIwU3Vic2NyaXB0aW9ucyUzQyUyRnNwYW4lM0UlM0MlMkZoMSUzRSUwQSUzQyUyRmRpdiUzRQ==[/vc_raw_html][qk_featured_carousel thumbsize="thumbnail"][/vc_column][/vc_row][vc_row][vc_column][vc_raw_html]JTNDZGl2JTIwY2xhc3MlM0QlMjJ0aXRsZS1zZWN0aW9uJTIyJTNFJTBBJTA5JTNDaDElM0UlM0NzcGFuJTIwY2xhc3MlM0QlMjJ3b3JsZCUyMiUzRVRvcCUyMEF1dGhvcnMlM0MlMkZzcGFuJTNFJTNDJTJGaDElM0UlMEElM0MlMkZkaXYlM0U=[/vc_raw_html][qk_posts_carousel order2="5" thumbsize="thumbnail" filter="horizontal"][/vc_column][/vc_row][vc_row][vc_column width="1/4" css=".vc_custom_1481733046254{margin-right: 40px !important;}"][vc_raw_html]JTNDZGl2JTIwY2xhc3MlM0QlMjJ0aXRsZS1zZWN0aW9uJTIyJTNFJTBBJTA5JTNDaDElM0UlM0NzcGFuJTIwY2xhc3MlM0QlMjJ3b3JsZCUyMiUzRUZlYXR1cmVkJTIwQ2F0ZWdvcmllcyUzQyUyRnNwYW4lM0UlM0MlMkZoMSUzRSUwQSUzQyUyRmRpdiUzRQ==[/vc_raw_html][qk_post cat="business" thumbsize="thumbnail"][/vc_column][vc_column width="3/4" css=".vc_custom_1481733084388{margin-left: 10px !important;}"][qk_posts_grid title="Recent Articles" cat="economy" order="4" pagination="on"][/vc_column][/vc_row]');
            
            file_put_contents('shortcode.txt', base64_encode(json_encode($html)));
            echo $html;
            
        }
        public function getAuthors(){
            var_dump(\custom_profile\Subscription::getAuthorsAndCategories(0));
        }
        
        public function getUserAuthorSubscriptions(){
            $html = "<div id='subscription-container'>";
            $curentUser = wp_get_current_user();
            if(!$curentUser){
                return false;
            }
           $all_subscriptions =  \custom_profile\Subscription::_get(null,"wp_user_Id = ".$curentUser->ID ." AND author_Id != 0");
          if(empty($all_subscriptions)){
             return "<div id='subscription-container'><h6>You do not have subscription yet</h6></div>";
          }
           if(!Utilities::isValidDatabaseReturn($all_subscriptions)){
               return false;
           }
         
           $all_authors = array();
           
                           
                                               
           foreach ($all_subscriptions as $currSubscription){
               if(in_array($currSubscription->author_Id,$all_authors)){
                   continue;
               }
               
               

        $curr_author_id = 0;
              
               
              
               $author_image = null;
           
               $author_name = "";
             
//               if($currSubscription->category_Id !== 0){
//                   
//               $curr_category_id = $currSubscription->category_Id;
//               $category_name = get_cat_name($currSubscription->category_Id);
//               $category_image = z_taxonomy_image_url($currSubscription->category_Id);
//               
//               }
               if($currSubscription->author_Id){
               $curr_author_id = $currSubscription->author_Id;
               $currAuthor = get_user_by('ID',$curr_author_id);
               $author_name = $currAuthor->first_name . " ".$currAuthor->last_name;
               $author_image = self::get_metronet_image_url($curr_author_id);
               }
               $image = $author_image;
               
              // get_category_//
            
          
        
          
             
                  $tag_name = "AUTHOR";
              
             
             
           
                     


           $html .= '<div class="owl-item" style="width: 285px; margin-right: 0px;"><div class="item news-post standard-post">';
	   $html .=  '<div class="post-gallery"><div class="thumb-wrap">';
           $html .= '<img width="150"  height="150" src="'.$image .'" class="attachment-thumbnail size-thumbnail wp-post-image" alt="">';
           $html .= '<a href="#" class="unsubscribe" data-current-user="'.$curentUser->ID.'" data-subscription-id="'.$currSubscription->subscription_Id .'">Unsubscribe</a>';
           $html .= '</div><a class="category-post sport" href="#">'.$tag_name .'</a></div><div class="post-content">'; 
            $html .= '<h2><a href="#" >$tag_title</a></h2></div></div></div>';
          
                       array_push($all_authors,$currSubscription->author_Id);
      
           }
           return $html."</div>";
        }
        
        public function getTopAuthors(){
            $html = "";
            $current_user = wp_get_current_user();
            $authors_subscribed_to = array();
            $user_author_subscriptions= \custom_profile\Subscription::_get(array('author_Id'),"wp_user_Id = ".$current_user->ID,ARRAY_N);
            if($user_author_subscriptions && is_array($user_author_subscriptions)){
                $authors_subscribed_to = array_unique($user_author_subscriptions);
            }
            $allAuthors = get_users(array("who"=>'author'));
           
         
                                                 foreach ($allAuthors as $thisAuthor){
                if(in_array($thisAuthor->ID, $authors_subscribed_to)){
                    continue;
                }
                $thisAuthorAvatar = self::get_metronet_image_url($thisAuthor->ID);
         $args = array(
	'posts_per_page'   => 5,
	'offset'           => 0,
	'category'         => '',
	'category_name'    => '',
	'orderby'          => 'date',
	'order'            => 'DESC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => 'post',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'author'	   => $thisAuthor->ID,
	'author_name'	   => '',
	'post_status'      => 'publish',
	'suppress_filters' => true 
        );
       
       $all_author_post = get_posts($args);
          $thumbnails  = array();
                foreach ($all_author_post as $post) {
                   if (has_post_thumbnail( $post->ID )){
                  $thumbnails [] = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID) )[0];  
                }else{
                    $thumbnails [] = 0; 
                } 
                }         
                 
                 $html .= '<div class="owl-item" style="width: 285px; margin-right: 0px;"><div data-current-author="'. $thisAuthor->ID .
                         '" data-current-user="'.$current_user->ID .'" data-thumbnails ="'.base64_encode(json_encode( $thumbnails)).'" data-author-posts="'.base64_encode(json_encode($all_author_post)).'" class="activate-author-posts item news-post standard-post"><div class="post-gallery"><div class="thumb-wrap" data-current-author="'. $thisAuthor->ID .'" data-current-user="'.$current_user->ID .'" class="activate-author-posts" data-author-posts="'.base64_encode(json_encode($all_author_post)).'"><img width="150"  height="150" src="'.$thisAuthorAvatar .'" class="attachment-thumbnail size-thumbnail wp-post-image" alt=""></div></div><div class="post-content">'.
                        '<h2><a href="#" class="activate-author-posts" data-current-author="'. $thisAuthor->ID .
                         '"  data-current-user="'.$current_user->ID .'" data-thumbnails ="'.base64_encode(json_encode( $thumbnails)).'"  data-author-posts="'.base64_encode(json_encode($all_author_post)).'">'.
                         $thisAuthor->first_name . " " . $thisAuthor->last_name .'</a></h2></div></div></div>';
             
            };
          
           return $html;
        }
        
        public function getTopcategories(){
            $html = "";
            $current_user = wp_get_current_user();
           $all_categories =  get_categories();
           foreach ($all_categories as $thisCategory){
               $category_image = z_taxonomy_image_url($thisCategory->term_id);
               if(!$category_image){
                   $category_image = "http://manandpaper.com/wp-content/uploads/2015/11/13707054_1317570784938557_1553403587_n.jpg";
               }
                $args = array(
               
                'category'         => $thisCategory->term_id,
                'post_status'      => 'publish'
                );
                $posts_array = get_posts( $args ); 
                $thumbnails  = array();
                foreach ($posts_array as $post) {
                   if (has_post_thumbnail( $post->ID )){
                  $thumbnails [] = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID) )[0];  
                }else{
                    $thumbnails [] = 0; 
                } 
                }
                
               
               
               $html .= '<div data-active-category="'.$thisCategory->term_id.'" class="news-post activate-category image-post default-size" data-current-user="' . $current_user->ID . '"';
            $html .= ' data-thumbnails ="'.base64_encode(json_encode( $thumbnails)).'"   data-category-posts="' . base64_encode(json_encode($posts_array)) . '">';
            $html .= '<div  data-active-category="'.$thisCategory->term_id.'" class="thumb-wrap activate-category" data-current-user="' . $current_user->ID . '"';
            $html .= ' data-thumbnails ="'.base64_encode(json_encode( $thumbnails)).'"  data-category-posts="' . base64_encode(json_encode($posts_array)) . '">';
            $html .= '<img src="' . $category_image . '" alt="' . $thisCategory->name . '"></div><div class="hover-box"><div class="inner-hover">';
            $html .= '<a class="category-post business" href="#" >' . strtoupper($thisCategory->name) . '</a>';

            $html .= '<h2><a href="#" class="thumb-wrap activate-category" data-current-user="' . $current_user->ID . '"';
            $html .= ' data-category-posts="' . base64_encode(json_encode($posts_array)) . '">' . strtoupper($thisCategory->name) . '</a></h2></div></div></div>';
        }
           return $html;
        }
      
        public static function  get_metronet_image_url($_user_Id){
            $found_url =  wp_get_attachment_url(get_user_meta($_user_Id,'wp_metronet_image_id',true));
            return $found_url ? $found_url : get_avatar_url($_user_Id);
        }
        
        

}

