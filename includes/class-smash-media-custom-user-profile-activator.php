<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.opushive.com
 * @since      1.0.0
 *
 * @package    Smash_Media_Custom_User_Profile
 * @subpackage Smash_Media_Custom_User_Profile/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Smash_Media_Custom_User_Profile
 * @subpackage Smash_Media_Custom_User_Profile/includes
 * @author     Tosin Omotayo <tosin@okasho.org>
 */
class Smash_Media_Custom_User_Profile_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
        public static function activate() {
            
           try{
            $bootstrap = new Smash_Media_Custom_User_Profile();
          $class_folders = array('account','common','messaging','subscriber');
                foreach($class_folders as $currFolder){
                   foreach(glob(WP_PLUGIN_DIR.'/'.$bootstrap->get_plugin_name().'/smash_media/'.$currFolder.'/*.*') as $file) {
                       echo "<h1>".$file."</h1>";
                  $file =  basename($file,".php");
                  echo "<h1>{$file}</h1>";
                  $class =  '\\custom_profile\\'. $file;
                  if(class_exists( $class)){
                  $classInstance = new $class(NULL,NULL,NULL);
                  if($classInstance instanceof \smashprofile\IWp || $classInstance instanceof \smash\IWp){
                   $classInstance->createTable();
                  }
                  }
                  
                  }  
                }
           }
           catch(Exception $ex){
               
           }
	}
        
        public static function upgrade(){
      
        $smash_media_custom_profile = new Smash_Media_Custom_User_Profile();
        $current_pugin_version =  get_option( $smash_media_custom_profile->get_plugin_name());
        if(!$current_pugin_version){
            add_option( $smash_media_custom_profile->get_plugin_name(), $smash_media_custom_profile->get_version());
        }else if ($current_pugin_version !=  $smash_media_custom_profile->get_version()){
            echo "<h1>updating ".$current_pugin_version."</h1>";
            self::activate();
            update_option($smash_media_custom_profile->get_plugin_name(),$smash_media_custom_profile->get_version());
        }
    }

}
