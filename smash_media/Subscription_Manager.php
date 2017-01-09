<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Subscription_Manager
 *
 * @author tosin
 */
class Subscription_Manager {
    //put your code here
    
    public function addHooks($_parent) {
      // $_parent->add_action( 'admin_menu',$this,'add_menu_item'); 
     // $_parent->add_action( 'wp_ajax_subscribe_user_ajax',$this,'subscribe_user_ajax'); 
     // $_parent->add_action( 'wp_ajax_unsubscribe_user_ajax',$this,'unsubscribe_user_ajax'); 
    }
    
    public function subscribe_user_ajax(){
        
    }
    
    public function unsubscribe_user_ajax(){
        
    }
}
