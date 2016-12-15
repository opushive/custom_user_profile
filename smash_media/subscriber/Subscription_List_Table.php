<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Message_List_Table
 *
 * @author tosin
 */
if (!class_exists('WP_List_Table')) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Subscription_List_Table extends WP_List_Table {
    public $isSubscriber = false;
    //put your code here
    function __construct() {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'Subscription',
            'plural' => 'Subscriptions',
            'ajax' => false
        ));
    }
    function column_default($item, $column_name) {
        return $item[$column_name];
    }
    
    function column_subscription_Id($item) {
       if($this->$isSubscriber){
       $actions = array(
            'edit' => sprintf('<a href="#">%s</a>', __('Edit')),
            'delete' => sprintf('<a href="#">%s</a>', __('Delete'))
               
        );  
           return sprintf('%s %s', '<em>' . $item['subscription_Id'] . '</em>', $this->row_actions($actions));
       }
        $actions = array(
            'edit' => sprintf('<a href="?page=smash_subscription_form&subscription_Id=%s">%s</a>', $item['subscription_Id'], __('Edit')),
            'delete' => sprintf('<a href="?page=%s&action=delete&subscription_Id=%s">%s</a>', 
               $_REQUEST['page'], $item['subscription_Id'], __('Delete')),
        );
        return sprintf('%s %s', '<em>' . $item['subscription_Id'] . '</em>', $this->row_actions($actions));
    }
     function column_susbcriber_Id($item) {
      $susbcriber  = new \smash\Subscriber($item['subscriber_Id']);
      
     return '<em>' . $susbcriber->firstname .' '.$susbcriber->surname. '</em>';
     
    }
    function column_author_Id($item) {
        if(!$item['author_Id']){
            return "-";
        }
        $user = get_user_by('id',$item['author_Id']);
        if(!$user){
            return "-";
        }
       
      return '<em>' . $user->display_name . '</em>';   
    }
    function column_category_Id($item) {
        if(!$item['category_Id']){
            return "-";
        }
        $category = get_cat_name($item['category_Id']);
        if(!$category){
            return "-";
        }
           
     return '<em>'. $category .'</em>';   
    }
    
    function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'subscription_Id' => 'ID',
             'author_Id' => 'Author',
            'susbcriber_Id' => 'Subscriber',
            'category_Id' => 'Category'
           
        );
        return $columns;
    }
    
     function prepare_items() {

        $susbcription = $this->get_Subscription();

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $per_page = 10;
        $current_page = $this->get_pagenum();

        $total_items = count($susbcription);

        $preaperd_data = array_slice($susbcription, (($current_page - 1) * $per_page), $per_page);


        $this->set_pagination_args(array(
            'total_items' => $total_items, 
            'per_page' => $per_page            
        ));
        $this->items = $preaperd_data;
       
    }
    function get_Subscription(){
        $user = wp_get_current_user();
       
         if ( in_array( 'subscriber', (array) $user->roles ) ) {
           $isSubscriber = true; 
         return  \custom_profile\Subscription::_get(NULL,   "wp_user_Id = ".$user->ID."  ORDER BY author_Id,category_Id DESC",  \custom_profile\Subscription::ARRAY_A);
        }
        $all_susbscriptions =  \custom_profile\Subscription::_get(NULL,   " 1 ORDER BY author_Id,category_Id DESC",  \custom_profile\Subscription::ARRAY_A);
      
       return $all_susbscriptions;
    }
    
    function get_sortable_columns(){
        $sortable_columns = array(
             'subscription_Id' => 'subscription_Id',
             'subscriber_Id' => 'subscriber_Id',
             'author_Id' => 'author_Id',
             'category_Id' => 'category_Id',
           
        );
        return $sortable_columns;
    }
    
     function get_bulk_actions() {
        $actions = array(
            'delete' => 'Delete'
        );
        return $actions;
    }
    
    function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="subscription_Id[]" value="%s" />',$item['subscription_Id']
        );
    }
}