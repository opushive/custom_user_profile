<?php
namespace custom_profile;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Subscriber_Subscription
 *
 * @author tosin
 */
class Subscription  extends \smash\ADb implements \smash\IWp{
    protected $subscription_Id;
    protected $subscriber_Id;
    protected $wp_user_Id;
    protected $author_Id;
    protected $category_Id;
    private static $message = "";
    private static $notice = "";
    
    public function __construct($_id, $_fieldlist = NULL, $_createOnDb = false) {

    $fieldToTypes = array(
        'subscription_Id' => '%d',
        'subscriber_Id' => '%d',
        'wp_user_Id' => '%d',
        'author_Id' => '%d',
        'category_Id' => '%d'
    );
    //put your code here
  }

    function getSubscriber_Id() {
        return $this->subscriber_Id;
    }

    function getWp_user_Id() {
        return $this->wp_user_Id;
    }

    function getAuthor_Id() {
        return $this->author_Id;
    }

    function getCategory_Id() {
        return $this->category_Id;
    }

    function setSubscriber_Id($subscriber_Id) {
        $this->subscriber_Id = $subscriber_Id;
    }

    function setWp_user_Id($wp_user_Id) {
        $this->wp_user_Id = $wp_user_Id;
    }

    function setAuthor_Id($author_Id) {
        $this->author_Id = $author_Id;
    }

    function setCategory_Id($category_Id) {
        $this->category_Id = $category_Id;
    }
    
    public static function render_subscriptions(){
        
       $subscription = new \Subscription_List_Table();

        if ('delete' ===  $subscription->current_action()) {
            $delete = true;
            if (empty($_GET['subscription_Id'])) {
                self::$notice = '<div class="updated below-h2" id="message"><p>No Item was Selected</p></div>';
                $delete = false;
            }
            if ($delete && is_array($_GET['subscription_Id'])) {
                foreach ($_GET['subscription_Id'] as $current_id) {
                    self::delete_subscription(intval($current_id));
                }
            } else {
                if ($delete) {
                    self::delete_subscription(filter_input(INPUT_GET, 'subscription_Id', FILTER_SANITIZE_NUMBER_INT));
                }
            }
            if ($delete) {
                self::$message = '<div class="updated below-h2" id="message"><p>' .
                        sprintf(__('Items deleted: %d'), count($_REQUEST['subscription_Id'])) . '</p></div>';
            }
        }
        ?>
        <div class="wrap">
            <h2><?php _e('Subscription') ?> <a class="add-new-h2"
                                             href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=smash_subscription_form'); ?>"><?php _e('Add Subscriber') ?></a>
            </h2>
            <form id="account-table" method="GET" >
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>

                <?php
                if (!empty(self::$message)) {
                    echo self::$message;
                }
               $subscription->prepare_items();
               $subscription->display();
                ?>

            </form>
        </div>

        <?php  
    }
    protected static function _table() {
        global $wpdb;
        
        return 'wp_smash_custom_profile';
    }
    
    public function render_crud_view(){
        $default  = array(
        'subscription_Id' => 0,
        'subscriber_Id' => 0,
        'wp_user_Id' => 0,
        'author_Id' => 0,
        'category_Id' => 0
        );
        $item = $this->initialize_subscription_if_id($default);
        
        add_meta_box('subscription_meta_box', 'Subscription', array($this, 'add_subscription_meta_box'), 'subscription', 'normal', 'default');  
         if (isset($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__))) {
            
            $item = shortcode_atts($default, $_REQUEST);
             $this->handle_create();
             $this->handle_update();
        }
        ?>
         <div class="wrap">
            <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
            <h2><?php _e('Subscriptions') ?> <a class="add-new-h2"
                                             href="<?php
                                             echo get_admin_url(get_current_blog_id(), 'admin.php?page=smash_subscriber_list_table');
                                             ?>"><?php _e('Back to list') ?></a>
            </h2>
            <?php if (!empty(self::$notice)): ?>
                <div id="notice" class="error"><p><?php echo self::$notice ?></p></div>
            <?php endif; ?>
            <?php if (!empty(self::$message)): ?>
                <div id="message" class="updated"><p><?php echo self::$message ?></p></div>
                <?php endif; ?>
            <form id="form" method="POST" enctype="multipart/form-data">
                <?php
                if (isset($_POST['subscription_Id'])) {
                    _e('<a class="add-new-h2" href="' . $_SERVER['REQUEST_URI'] . '">Reset Form</a>');
                }
                ?>
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(basename(__FILE__)) ?>"/>

                

                <div class="metabox-holder" id="poststuff">
                    <div id="post-body">
                        <div id="post-body-content">
                            <?php /* And here we call our custom meta box */ ?>
        <?php do_meta_boxes('subscription', 'normal', $item); ?>
                            <input type="submit" value="<?php isset($_GET['subscription_Id']) ? _e('Update') : _e('Save') ?>" id="submit" class="button-primary" name="submit">

                        </div>
                    </div>
                </div>
            </form>
        </div>
 <?php
    }
    public function render_subscriber_subscription_crud(){
        $default  = array(
        'subscription_Id' => 0,
        'subscriber_Id' => 0,
        'wp_user_Id' => 0,
        'author_Id' => 0,
        'category_Id' => 0
        );
        $item = $this->initialize_subscription_if_id($default);
        
        add_meta_box('subscriber_meta_box', 'Subscription', array($this, 'add_subscriber_meta_box'), 'subscriber_box', 'normal', 'default');  
         if (isset($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__))) {
            
            $item = shortcode_atts($default, $_REQUEST);
             $this->handle_subscriber_create();
             $this->handle_subscriber_update();
        }
        ?>
         <div class="wrap">
            <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
            <h2><?php _e('Subscriptions') ?> <a class="add-new-h2"
                                             href="<?php
                                             echo get_admin_url(get_current_blog_id(), 'admin.php?page=smash_subscriber_list_table');
                                             ?>"><?php _e('Back to list') ?></a>
            </h2>
            <?php if (!empty(self::$notice)): ?>
                <div id="notice" class="error"><p><?php echo self::$notice ?></p></div>
            <?php endif; ?>
            <?php if (!empty(self::$message)): ?>
                <div id="message" class="updated"><p><?php echo self::$message ?></p></div>
                <?php endif; ?>
            <form id="form" method="POST" enctype="multipart/form-data">
                <?php
                if (isset($_POST['subscription_Id'])) {
                    _e('<a class="add-new-h2" href="' . $_SERVER['REQUEST_URI'] . '">Reset Form</a>');
                }
                ?>
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(basename(__FILE__)) ?>"/>

                

                <div class="metabox-holder" id="poststuff">
                    <div id="post-body">
                        <div id="post-body-content">
                            <?php /* And here we call our custom meta box */ ?>
        <?php do_meta_boxes('subscriber_box', 'normal', $item); ?>
                            <input type="submit" value="<?php isset($_GET['subscription_Id']) ? _e('Update') : _e('Save') ?>" id="submit" class="button-primary" name="submit">

                        </div>
                    </div>
                </div>
            </form>
        </div>
 <?php
    }
    
    public function add_subscription_meta_box($item){
       
       $currentUser = get_current_user();
       $current_categories = array();
      
        ?>
   
        <table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">
            <tbody>
             <?php 
             
           _e(\isess\GenericComponentBuilder::getRow("Subscriber", "dropdown", $item['subscriber_Id'], "subscriber_Id", "subscriber_Id", array('data' => $all_subscribers, 'class' => 'service-tokenizer', 'callback' => array($this, 'generateSubscriberDropdown'))));
            ?>
             
          
             <?php 
           _e(\isess\GenericComponentBuilder::getRow("Author", "dropdown", $item['author_Id'], "author_Id", "author_Id", array('data' => get_users(array('who'=>'authors')), 'class' => 'service-tokenizer', 'callback' => array($this, 'generateAuthorDropdown'))));
            ?>
             <?php 
           _e(\isess\GenericComponentBuilder::getRow("Categories", "dropdown", $item['category_Id'], "category_Id", "category_Id", array('data' => get_categories(), 'class' => 'service-tokenizer', 'callback' => array($this, 'generateCategoryDropdown'))));
            ?>
                
        </tbody>
        </table> 
       <?php
    }
    
    public function add_subscriber_meta_box($item){
       
         $currentUser = get_current_user();
         $current_categories = array();
       $current_authors = array();
        ?>
   
        <table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">
            <tbody>
                 
            
          <?php     _e(\isess\GenericComponentBuilder::getRow("Categories", "tagbox", $current_categories, "categories[]", null, array('data' => self::getCategories(0), 'class' => 'events service-tokenizer', 'callback' => array($this, 'generateCategoriesTagbox')))); ?>
           
            
            </tbody>
            
            <tbody class="hidden">
             <?php 
       //   _e(\isess\GenericComponentBuilder::getRow("Categories", "dropdown", $item['category_Id'], "category_Id", "category_Id", array('data' => get_categories(), 'class' => 'service-tokenizer', 'callback' => array($this, 'generateCategoryDropdown'))));
            ?>
            </tbody>   
        </tbody>
        </table> 
        <table style="width: 100%;" class="form-table">
            <tbody>
                <tr>
                    <td>
                     <?php  //_e(\isess\GenericComponentBuilder::getRow("Authors", 
                //              "tagbox",   $current_authors, "authors[]", null, array('data' => self::getAuthorsAndCategories(0), 'class' => 'events service-tokenizer', 'callback' => array($this, 'generateSubscriberAuthorTagBox')))); ?>
            <?php 
            _e(\isess\GenericComponentBuilder::getRow("Author", "dropdown", $item['author_Id'], "author_Id", "subscriber_author_Id", array('data' => self::getAuthorsAndCategories(0), 'class' => 'service-tokenizer', 'callback' => array($this, 'generateSubscriberAuthorDropdown'))));
            ?>
                  
                    </td>
            <tbody id="author-categories-container" class="hidden"> 
                 <tr class="form-field">
            <th valign="top" scope="row">
                <label for="">Selected Author Categories</label>
            </th>
            <td id="authors_categories">
                <input type="checkbox" class="author-categories" attr="4|2|author[action]">author[action]&nbsp;&nbsp;&nbsp;
                <input type="checkbox" class="author-categories" attr="4|2|author[action]">author[action]&nbsp;&nbsp;&nbsp;
                <input type="checkbox" class="author-categories" attr="4|2|author[action]">author[action]&nbsp;&nbsp;&nbsp;
                <input type="checkbox" class="author-categories" attr="4|2|author[action]">author[action]&nbsp;&nbsp;&nbsp;
            </td>
                 </tr>
<!--                <tr><td>
                    
                    </td><td></td></tr>
                <tr><td><input type="checkbox" class="author-categories" attr="4|2|author[action]"</td></tr>
                 <tr><td><input type="checkbox" class="author-categories" attr="4|2|author[action]"</td></tr>
                  <tr><td><input type="checkbox" class="author-categories" attr="4|2|author[action]"</td></tr>
                 <tr><td><input type="checkbox" class="author-categories" attr="4|2|author[action]"</td></tr>
                 </td>  
                   
                </tr>-->
               
              </tbody>
              <tbody>
                  
            <?php 
            _e(\isess\GenericComponentBuilder::getRow("Selected Categories", 
                      "tagbox",   array() , "authorscategories[]", "selected-categories", array('data' => array(), 'class' => 'selected_categories service-tokenizer', 'callback' => function(){
                
                      }))); 
            ?>
                 
                  
              </tbody>
        </table>
       <?php
    }
    
    public function  handle_update(){
        global $wpdb;
        if(isset($_REQUEST['subscription_Id'])){
         $item = array();
         $item['subscriber_Id'] = $_REQUEST['subscriber_Id'];
         $item['category_Id'] = $_REQUEST['category_Id'] != '' ? $_REQUEST['category_Id'] : 0;
         $item['author_Id'] = $_REQUEST['author_Id'] != '' ? $_REQUEST['author_Id'] : 0;
         
         $subscriber =  \smash\Subscriber::_get(NULL,'subscriber_Id = '.(int)$item['subscriber_Id']);
         $foundSubscriber = $subscriber[0];
         $item['wp_user_Id'] = $subscriber[0]->wp_user_Id;
         
         $susbcription_already_exist = Subscription::_get(NULL,'author_Id = '.$item['author_Id'].
                                       " AND category_Id = ".$item['category_Id'] ." AND subscriber_Id = ".$item['subscriber_Id']);
         $susbcription_already_exist = $wpdb->get_results('SELECT * FROM wp_smash_subscription WHERE author_Id = '.$item['author_Id'].
                                       " AND category_Id = ".$item['category_Id'] ." AND subscriber_Id = ".$item['subscriber_Id']);
         if( $susbcription_already_exist != NULL || (is_array($susbcription_already_exist) && count($susbcription_already_exist) != 0)){
              self::$notice = "Subscription already exist";
              return $item;
         }
           $result  = Subscription::_update($item,array("subscription_Id"=>(int)$_REQUEST['subscription_Id']));
         
        
         if($result === FALSE){
              self::$notice = "Error updating subscription";
              return $item;
         }
         self::$message = "Subscription Successfully created";
          return true;
        }
    }
    public function  handle_subscriber_update(){
        global $wpdb;
        if(isset($_REQUEST['subscription_Id'])){
         $item = array();
         $item['subscriber_Id'] = $_REQUEST['subscriber_Id'];
         $item['category_Id'] = $_REQUEST['category_Id'] != '' ? $_REQUEST['category_Id'] : 0;
         $item['author_Id'] = $_REQUEST['author_Id'] != '' ? $_REQUEST['author_Id'] : 0;
         
         $subscriber =  \smash\Subscriber::_get(NULL,'subscriber_Id = '.(int)$item['subscriber_Id']);
         $foundSubscriber = $subscriber[0];
         $item['wp_user_Id'] = $subscriber[0]->wp_user_Id;
         
         $susbcription_already_exist = Subscription::_get(NULL,'author_Id = '.$item['author_Id'].
                                       " AND category_Id = ".$item['category_Id'] ." AND subscriber_Id = ".$item['subscriber_Id']);
         $susbcription_already_exist = $wpdb->get_results('SELECT * FROM wp_smash_subscription WHERE author_Id = '.$item['author_Id'].
                                       " AND category_Id = ".$item['category_Id'] ." AND subscriber_Id = ".$item['subscriber_Id']);
         if( $susbcription_already_exist != NULL || (is_array($susbcription_already_exist) && count($susbcription_already_exist) != 0)){
              self::$notice = "Subscription already exist";
              return $item;
         }
           $result  = Subscription::_update($item,array("subscription_Id"=>(int)$_REQUEST['subscription_Id']));
         
        
         if($result === FALSE){
              self::$notice = "Error updating subscription";
              return $item;
         }
         self::$message = "Subscription Successfully created";
          return true;
        }
    }
    public function handle_create(){
         global $wpdb;
        if(!isset($_REQUEST['subscription_Id'])){
         $item = array();
         $item['subscriber_Id'] = $_REQUEST['subscriber_Id'];
         $item['category_Id'] = $_REQUEST['category_Id'] != '' ? $_REQUEST['category_Id'] : 0;
         $item['author_Id'] = $_REQUEST['author_Id'] != '' ? $_REQUEST['author_Id'] : 0;
         
         $subscriber =  \smash\Subscriber::_get(NULL,'subscriber_Id = '.(int)$item['subscriber_Id']);
         $foundSubscriber = $subscriber[0];
         $item['wp_user_Id'] = $subscriber[0]->wp_user_Id;
         
         $susbcription_alraedy_exist = self::_get(NULL,'author_Id = '.$item['author_Id'].
                                       " AND category_Id = ".$item['category_Id'] ." AND subscriber_Id = ".$item['subscriber_Id']);
         if(\Utilities::isValidDbObj($susbcription_alraedy_exist)){
              self::$notice = "Subscription already exist";
              return $item;
         }
         $createSubscription = new Subscription(NULL,NULL);
         $result = $createSubscription->create($item);
         if(!$result){
              self::$notice = "Subscription already exist";
              return $item;
         }
         self::$message = "Subscription Successfully created";
          return true;
        }
    }
    public function handle_subscriber_create(){
         global $wpdb;
        if(!isset($_REQUEST['subscription_Id'])){
         $item = array();
         $currentSubscriber = get_current_user_id();
         
          $subscriber =  \smash\Subscriber::_get(NULL,'wp_user_id = '. $currentSubscriber);
          if(!\Utilities::isValidDatabaseReturn($subscriber)){
              self::$notice = "Subscriber does does not yet exist";
              return $item; 
          };
          //create category subcription
          foreach ($_REQUEST['categories'] as $currentCategory){
              $susbcription_alraedy_exist = self::_get(NULL,'author_Id = 0'.
                                       " AND category_Id = ".$currentCategory ." AND subscriber_Id = ". $subscriber[0]->subscriber_Id);  
            if(!\Utilities::isValidDatabaseReturn($susbcription_alraedy_exist)){
               $createSubscription = new Subscription(NULL,NULL);
            $result = $createSubscription->create(array('category_Id'=>$currentCategory,'author_Id'=>0,'wp_user_Id'=>$currentSubscriber,'subscriber_Id'=>$subscriber[0]->subscriber_Id)); 
            }
          }
          
          foreach($_REQUEST['authorscategories'] as $currentAuthorCategory){
               $thisCurrentAuthorCategory = explode("|", $currentAuthorCategory);
                $susbcription_alraedy_exist = self::_get(NULL,'author_Id = '.$thisCurrentAuthorCategory[0].
                                       " AND category_Id = ".$thisCurrentAuthorCategory[1] ." AND subscriber_Id = ". $subscriber[0]->subscriber_Id); 
                
              if(!\Utilities::isValidDatabaseReturn( $susbcription_alraedy_exist)){
               $createSubscription = new Subscription(NULL,NULL);
            $result = $createSubscription->create(array('category_Id'=>$thisCurrentAuthorCategory[1],'author_Id'=>$thisCurrentAuthorCategory[0],'wp_user_Id'=>$currentSubscriber,'subscriber_Id'=>$subscriber[0]->subscriber_Id)); 
            }
          }

        
         self::$message = "Subscription Successfully created";
          return true;
        }
    }
    
    public function handle_delete(){
        
    }
    public function addHooks($_parent) {
        $_parent->add_action('admin_menu', $this, 'add_menu_item');
        $_parent->add_action('wp_ajax_get_author_categories',$this,'getAuthorsCategories');
        //this hook manages user subscription via ajax
         $_parent->add_action('wp_ajax_subscribe_user',$this,'subscribe_user_ajax');
          //this hook manages user unsubscription via ajax
          $_parent->add_action('wp_ajax_unsubscribe_user',$this,'unsubscribe_user_ajax');
        $_parent->add_filter('smash_table_filter',$this,'filter_table_name');
        
    }
    public function add_menu_item(){
        //add_menu_page('Subscriber', 'Subscriber', 'activate_plugins', 'subscriber_list', array($this, 'render_subscriber'));
        add_submenu_page('custom-user-profile', __('Subscription List'), __('Subscription List'), 'activate_plugins', 'smash_subscription_list_table', array($this, 'render_subscriptions'));
        add_submenu_page('custom-user-profile', __('New Subscription'), __('New Subscription'), 'activate_plugins', 'smash_subscription_form', array($this, 'render_crud_view'));
       //  add_submenu_page('profile.php','User Subscription', __('User Subscription'), 'read','user_subscription_page', array($this, 'render_crud_view'));
         add_users_page( "User Subscription Page","User Subscription",'read','user_subscription', array($this, 'render_subscriber_subscription_crud'));
         add_users_page( "User Subscription List","User Subscription List",'read','user_subscription_list', array($this, 'render_subscriptions'));
         
    }
      public function initialize_subscription_if_id(array $default_subscriber) {
        if (isset($_GET['subscription_Id'])) {
             $found_subscription = Subscription::_get(NULL,'subscription_Id = '.(int)$_REQUEST['subscription_Id']);
          
           if(!\Utilities::isValidDatabaseReturn($found_subscription)){
              return $default_subscriber;
           }

            if (is_array( $found_subscription) && !empty( $found_subscription)) {

               

              return (array)$found_subscription[0];
            } else {
                return $default_subscriber;
            }
        } else {
            return $default_subscriber;
        }
    }
     public static function createTable($_aArgList = NULL) {
        global $wpdb;
        $table_name = $wpdb->prefix . parent::$prefix . 'subscription';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE " . $table_name . " (
          subscription_Id int(11) NOT NULL AUTO_INCREMENT,
          wp_user_Id int(11) NOT NULL,
          subscriber_Id INT(11) NOT NULL,
          author_Id INT(11) NOT NULL,
          category_Id INT(11) NOT NULL,
          PRIMARY KEY  (subscription_Id)
        );";
           
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($sql);
        
        
    }
    
   public function generateCategoryDropdown($_data,$_value){
        ?>
        <option value="">Select Status</option>
        <?php
        foreach ($_data as $activeData):
            $selected = $activeData->term_id == trim($_value) ? "selected" : null;
            ?>
            <option value="<?php _e($activeData->term_id) ?>"  <?php _e($selected) ?>><?php _e($activeData->name) ?></option>
            <?php
        endforeach; 
   }
   
   public function generateSubscriberDropdown($_data,$_value){
     ?>
        <option value="">Select Status</option>
        <?php
       
        foreach ($_data as $activeData):
            $selected = $activeData->subscriber_Id === trim($_value) ? "selected" : null;
            ?>
            <option value="<?php _e($activeData->subscriber_Id) ?>"  <?php _e($selected) ?>><?php _e($activeData->firstname ." ".$activeData->surname. " [".$activeData->subscriber_Id."]") ?></option>
            <?php
        endforeach;  
   }
   public function generateAuthorDropdown($_data,$_value){
   
     ?>
        <option value="">Select Status</option>
        <?php
        
        foreach ($_data as $activeData):
            $selected = $activeData->ID == trim($_value) ? "selected" : null;
            ?>
            <option value="<?php _e($activeData->ID) ?>"  <?php _e($selected) ?>><?php _e($activeData->user_email. " [".$activeData->ID."]") ?></option>
            <?php
        endforeach;  
   }  
   public function generateSubscriberAuthorDropdown($_data,$_value){
      
       
     ?>
        <option value="">Select Author</option>
        <?php
        
        foreach ($_data as $activeData):
            $selected = $activeData['author']->ID == trim($_value) ? "selected" : null;
            ?>
            <option attr="<?php _e(base64_encode(json_encode($activeData))) ?>" value="<?php _e($activeData['author']->ID) ?>"  <?php _e($selected) ?>><?php _e( $activeData['author']->display_name) ?></option>
            <?php
        endforeach;  
   }  
   
   public static function uninstallTable($_aArgList = NULL) {
        
    }
   public function subscribe_user_ajax(){
       if(isset($_REQUEST['user'])){
           $wp_user_id = $_REQUEST['user'];
           $wp_user_id = 5;
           $author = $_REQUEST['author'];
           $category = $_REQUEST['category'];
            $subscriber  = \smash\Subscriber::_get(NULL,'wp_user_Id = '.$wp_user_id);
            if(!\Utilities::isValidDatabaseReturn($subscriber)){
                
              return json_encode(array('status'=>false,'message'=>'You are not a subscriber'));
            }
            $susbcription_exist =  $all_susbscriptions =  Subscription::_get(NULL,'wp_user_Id = '.$wp_user_id .
                    ' AND author_Id = '.$author .' AND category_Id = '.$category);
            if(!\Utilities::isValidDatabaseReturn($susbcription_exist)){
                
              return json_encode(array('status'=>false,'message'=>'You are already subscribed'));
            }
            //create subscription
            $item = array();
         $item['subscriber_Id'] = $subscriber[0]->subscriber_Id;
         $item['category_Id'] = $category;
         $item['author_Id'] = $author;
         $item['wp_user_Id'] = $wp_user_id;
         
          
         $createSubscription = new Subscription(NULL,NULL);
         $result = $createSubscription->create($item);
         return json_encode(array('status'=>true, $this->getUserSubscriptions($wp_user_id)));
         
       }
   }
   
   public function unsubscribe_user_ajax(){
     if(isset($_REQUEST['unsubscribe_user'])){
       
       }  
   }
   
   public static function getCategories($_isAjax= 1){
       if(!$_isAjax){
           return get_categories();
        
       }
       die(json_encode(get_categories()));
   }

   public static function getAuthorsCategories($author_id = 0,$_isAjax = true){
       global $wpdb;
       
       if(isset($_REQUEST['author_Id'])){
          $author_id =  $_REQUEST['author_Id'];
       }
       if($author_id == 0){
           die(json_encode(get_categories()));
       }
        $author_categories = $wpdb->get_results("
        SELECT DISTINCT(terms.term_id) as cat_ID, terms.name, terms.slug
        FROM $wpdb->posts as posts
        LEFT JOIN $wpdb->term_relationships as relationships ON posts.ID = relationships.object_ID
        LEFT JOIN $wpdb->term_taxonomy as tax ON relationships.term_taxonomy_id = tax.term_taxonomy_id
        LEFT JOIN $wpdb->terms as terms ON tax.term_id = terms.term_id
        WHERE 1=1 AND (
            posts.post_status = 'publish' AND
            posts.post_author = ".$author_id ." AND
            tax.taxonomy = 'category' )
        ORDER BY terms.name ASC
       ");
        if($_isAjax){
        die(json_encode($author_categories));
        }
        return $author_categories;
   }
   public static function getAuthorsAndCategories($_isAjax= 1){
       global $wpdb;
       $authors =  get_users(array('who'=>'authors'));
  
       $allAuthorsAndCategories = array();
       foreach ($authors as $currentAuthor){
         $allAuthorsAndCategories[] = array('author'=>$currentAuthor,
             'categories'=>self::getAuthorsCategories($currentAuthor->ID,false));  
       }
       
      if($_isAjax){
         die($allAuthorsAndCategories); 
      }
      return $allAuthorsAndCategories;
      
   }
   
   public function filter_table_name($_table){
      return  smash_custom_profile_strip_interface($_table,'custom_profile');
   }
   
   public static function delete_subscription($_id){
      $ID = (int) $_id;
       $result = Subscription::_delete("subscription_Id = " .$ID);
                return $result;
   }
 
   public function generateCategoriesTagbox($_data, $_value=array()) {
     
        
        $categories_Id = array();
        foreach ($_value as $thisData) {
           $categories_Id[] = $thisData->term_id;
        }
        ?>
        <option value="" disabled="true">Select Categories</option>
        <?php
        foreach ($_data as $activeData):

            $selected = in_array($activeData->term_id,  $categories_Id) ? 'selected' : '';
            ?>
            <option attr="<?php _e(base64_encode(json_encode($activeData))) ?>" value="<?php _e($activeData->term_id) ?>" <?php _e($selected) ?>><?php _e($activeData->name) ?></option>
            <?php
        endforeach;
   
   }
   public function generateSubscriberAuthorTagBox($_data, $_value=array()){
       
        $authors_Id = array();
        foreach ($_value as $thisData) {
           $authors_Id[] = $thisData->term_id;
        }
        ?>
        <option value="" disabled="true">Select Categories</option>
        <?php
        foreach ($_data as $activeData):

            $selected = in_array($activeData['author']->ID,  $authors_Id) ? 'selected' : '';
            ?>
            <option attr="<?php _e(base64_encode(json_encode($activeData))) ?>" value="<?php _e($activeData['author']->ID) ?>" <?php _e($selected) ?> > <?php _e($activeData['author']->display_name) ?></option>
            <?php
        endforeach;
   }
   public function generateAuthorTagbox($_data, $_value=array()) {
     
        
        $authors_Id = array();
        foreach ($_value as $currAuthor) {
           $authors_Id[] = $currAuthor->ID;
        }
        ?>
        <option value="" disabled="true">Select Author</option>
        <?php
        foreach ($_data as $activeData):

            $selected = in_array($activeData['author']->ID,  $authors_Id) ? 'selected' : '';
            ?>
            <option  attr="<?php _e(base64_encode(json_encode($activeData['categories']))) ?>" value="<?php _e($activeData->term_id) ?>" <?php _e($selected) ?>><?php _e($activeData->name) ?></option>
            <?php
        endforeach;
   
   }
   
   public function getUserSubscriptions($_userId){
       $userSubscriptions = Subscription::_get(NULL,'wp_user_Id = '.$_userId);
       $allSubscriptions = array();
       
       
       foreach ($userSubscriptions as $subscription) {
            $subscriptionFormat = array('id' => '', 'tagname' => '', 'name' => '', 'image' => '', 'type' => '', 'subscription_Id');
            if ($subscription->author_Id != 0) {

                $subscriptionFormat['id'] = $subscription->author_Id;
                $currAuthor = get_user_by('ID', $subscription->author_Id);
                $subscriptionFormat['name'] = $currAuthor->first_name . " " . $currAuthor->last_name;
                $subscriptionFormat['image'] = self::get_metronet_image_url($subscription->author_Id);
                $subscriptionFormat['tagname'] = "AUTHOR";
                $subscriptionFormat['subscription_Id'] = $subscription->subscription_Id;
                $allSubscriptions[] = $subscriptionFormat;
            }
            if ($subscription->author_Id == 0 && $subscription->category_Id != 0) {
                $category = get_category($subscription->category_Id);

                $subscriptionFormat['id'] = $subscription->category_Id;
                $subscriptionFormat['name'] = $category->name;
                $subscriptionFormat['image'] =  z_taxonomy_image_url($category ->term_id);
                $subscriptionFormat['tagname'] = "CATEGORY";
                $subscriptionFormat['subscription_Id'] = $subscription->subscription_Id;
                $allSubscriptions[] = $subscriptionFormat;
            }
        }
        return $allSubscriptions;
    }
    public static function  get_metronet_image_url($_user_Id){
            $found_url =  wp_get_attachment_url(get_user_meta($_user_Id,'wp_metronet_image_id',true));
            return $found_url ? $found_url : get_avatar_url($_user_Id);
        }

}
