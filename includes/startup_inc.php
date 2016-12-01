<?php

/**
 * @author      ISES Solutions
 * @copyright   2011
 * @filesource  startup_inc.php
 * @description This file MUST BE INCLUDED at the start of every view page to use the constant
 */

// start 
require_once WP_PLUGIN_DIR."/smash-media-sms-mgr/includes/startup_inc.php";
 

@session_start();
$currentDir = __DIR__;
$seperator = "";
if(strpos($currentDir, '\\') > 0){
    $seperator = '\\';
}
else{
    $seperator = '/';
}

// get path to the startup_inc file folder
$currentDir = substr($currentDir,0,  strripos($currentDir,$seperator));
#define('SMASH_PROFILE_APP_BASE_DIR', $_SERVER['DOCUMENT_ROOT'].'/findadoctor/wp-content/plugins/medical-appointment-booker');  // Production server
 
define('SMASH_PROFILE_APP_BASE_DIR', $currentDir);  // Production server
define('SMASH_PROFILE_SITE_DOMAIN', 'http://'.$_SERVER["HTTP_HOST"]);
//define('SITE_ROOT', SMASH_PROFILE_SITE_DOMAIN.'/okasho');  // legacy - ignore this field
 
 
//define("DATA_FOLDER", SMASH_PROFILE_APP_BASE_DIR. "/data/");
define("SMASH_PROFILE_CLASSES_PATH_ISESS", SMASH_PROFILE_APP_BASE_DIR . "/isess/classes/");
define("SMASH_PROFILE_CLASSES_PATH_TEMP", SMASH_PROFILE_APP_BASE_DIR . "/temp/");
define("CLASSES_PATH_SMASH_PROFILE_MEDIA_SUBSCRIBER", SMASH_PROFILE_APP_BASE_DIR . "/smash_media/subscriber/");
define("CLASSES_PATH_SMASH_PROFILE_MEDIA_MESSAGING", SMASH_PROFILE_APP_BASE_DIR . "/smash_media/messaging/");
define("CLASSES_PATH_SMASH_PROFILE_MEDIA_ACCOUNT", SMASH_PROFILE_APP_BASE_DIR . "/smash_media/account/");

define("CLASSES_PATH_SMASH_PROFILE_COMMON", SMASH_PROFILE_APP_BASE_DIR . "/smash_media/common/");

define("SMASH_PROFILE_CLASSES_PATH_3RDPARTY", SMASH_PROFILE_APP_BASE_DIR . "/isess/3rdParty/");
define("SMASH_PROFILE_CLASSES_PATH_APP", SMASH_PROFILE_APP_BASE_DIR . "/smash_media/");

//define("TELEPHONE_MSG_FOLDER_ABSOLUTE_PATH","http://likita.org/wp-content/plugins/medical-appointment-booker/tel_msgs/");

//
function smash_custom_profile_strip_interface($class,$interface){

    return str_replace($interface."\\", '', $class);
}
function smash_custom_profile_autoloader($class)
{
    // check isess class paths
    // then check 3rdparty class paths
    // finally check utitilies class paths

 
    if (file_exists(SMASH_PROFILE_CLASSES_PATH_ISESS.'util/'.$class.'.php')) {
        require_once (SMASH_PROFILE_CLASSES_PATH_ISESS.'util/'.$class.'.php');
        return true;
    }
    if (file_exists(SMASH_PROFILE_CLASSES_PATH_ISESS.'util/'.smash_custom_profile_strip_interface($class,'custom_profile').'.php')) {
        require_once (SMASH_PROFILE_CLASSES_PATH_ISESS.'util/'.smash_custom_profile_strip_interface($class,'custom_profile').'.php');
        return true;
    }
    if (file_exists(SMASH_PROFILE_CLASSES_PATH_3RDPARTY.$class.'.php')) {
        require_once (SMASH_PROFILE_CLASSES_PATH_3RDPARTY.$class.'.php');
        return true;
    }
    if (file_exists(SMASH_PROFILE_CLASSES_PATH_3RDPARTY.smash_custom_profile_strip_interface($class,'custom_profile').'.php')) {
        require_once (SMASH_PROFILE_CLASSES_PATH_3RDPARTY.smash_custom_profile_strip_interface($class,'custom_profile').'.php');
        return true;
    }
     else if (file_exists(SMASH_PROFILE_CLASSES_PATH_ISESS.'util/interfaces/'.$class.'.php')) {
        require_once (SMASH_PROFILE_CLASSES_PATH_ISESS.'util/interfaces/'.$class.'.php');
        return true;
    }
    else if (file_exists(SMASH_PROFILE_CLASSES_PATH_ISESS.'util/'.smash_custom_profile_strip_interface($class,'custom_profile').'.php')) {
        require_once (SMASH_PROFILE_CLASSES_PATH_ISESS.'util/'.smash_custom_profile_strip_interface($class,'custom_profile').'.php');
        return true;
    }
    else if (file_exists(SMASH_PROFILE_CLASSES_PATH_ISESS.'util/interfaces/'.$class.'.php')) {
        require_once (SMASH_PROFILE_CLASSES_PATH_ISESS.'util/interfaces/'.$class.'.php');
        return true;
    }
    else if (file_exists(SMASH_PROFILE_CLASSES_PATH_ISESS.'util/interfaces/'.smash_custom_profile_strip_interface($class,'custom_profile').'.php')) {
        require_once (SMASH_PROFILE_CLASSES_PATH_ISESS.'util/interfaces/'.smash_custom_profile_strip_interface($class,'custom_profile').'.php');
        return true;
    }
   
    else if (file_exists(SMASH_PROFILE_CLASSES_PATH_ISESS.'3rdParty/mail/'.$class.'.php')) {
        require_once (SMASH_PROFILE_CLASSES_PATH_ISESS.'3rdParty/mail/'.$class.'.php');
        return true;
    }
    
    else if (file_exists(SMASH_PROFILE_CLASSES_PATH_ISESS.'tagsandcategories/'.$class.'.php')) {
        require_once (SMASH_PROFILE_CLASSES_PATH_ISESS.'tagsandcategories/'.$class.'.php');
        return true;
    }
    else if (file_exists(SMASH_PROFILE_CLASSES_PATH_ISESS.'usermgr/'.$class.'.php')) {
        require_once (SMASH_PROFILE_CLASSES_PATH_ISESS.'usermgr/'.$class.'.php');
        return true;
    }
    else if (file_exists(SMASH_PROFILE_CLASSES_PATH_ISESS.'util/'.$class.'.php')) {
        require_once (SMASH_PROFILE_CLASSES_PATH_ISESS.'util/'.$class.'.php');
        return true;
    }
    else if (file_exists(SMASH_PROFILE_CLASSES_PATH_ISESS.'util/tables/'.$class.'.php')) {
        require_once (SMASH_PROFILE_CLASSES_PATH_ISESS.'util/tables/'.$class.'.php');
        return true;
    }
    else if (file_exists(SMASH_PROFILE_CLASSES_PATH_3RDPARTY.$class.'.php')) {
        require_once (SMASH_PROFILE_CLASSES_PATH_3RDPARTY.$class.'.php');
        return true;
    }
    else if (file_exists(SMASH_PROFILE_CLASSES_PATH_APP.'/'.$class.'.php')) {
        require_once (SMASH_PROFILE_CLASSES_PATH_APP.'/'.$class.'.php');
        return true;
    }
    else if (file_exists(SMASH_PROFILE_CLASSES_PATH_APP.'messaging/'.$class.'.php')) {
        require_once (SMASH_PROFILE_CLASSES_PATH_APP.'messaging/'.$class.'.php');
        return true;
    }
    
    
    else if (file_exists(CLASSES_PATH_SMASH_PROFILE_COMMON.$class.'.php')) {
        require_once (CLASSES_PATH_SMASH_PROFILE_COMMON.$class.'.php');
        return true;
    }
   else if (file_exists(CLASSES_PATH_SMASH_PROFILE_COMMON.'interfaces/'.smash_custom_profile_strip_interface($class,'custom_profile').'.php')) {
        require_once (CLASSES_PATH_SMASH_PROFILE_COMMON.'interfaces/'.smash_custom_profile_strip_interface($class,'custom_profile').'.php');
        return true;
    }
    else if (file_exists(CLASSES_PATH_SMASH_PROFILE_COMMON.smash_custom_profile_strip_interface($class,'custom_profile').'.php')) {
        require_once (CLASSES_PATH_SMASH_PROFILE_COMMON.smash_custom_profile_strip_interface($class,'custom_profile').'.php');
        return true;
    }
   
    else if (file_exists(CLASSES_PATH_SMASH_PROFILE_MEDIA_SUBSCRIBER.$class.'.php')) {
        require_once (CLASSES_PATH_SMASH_PROFILE_MEDIA_SUBSCRIBER.$class.'.php');
        return true;
    }
     else if (file_exists(CLASSES_PATH_SMASH_PROFILE_MEDIA_SUBSCRIBER.smash_custom_profile_strip_interface($class,'custom_profile').'.php')) {
        require_once (CLASSES_PATH_SMASH_PROFILE_MEDIA_SUBSCRIBER.smash_custom_profile_strip_interface($class,'custom_profile').'.php');
        return true;
    }
    else if (file_exists(CLASSES_PATH_SMASH_PROFILE_MEDIA_MESSAGING.$class.'.php')) {
        require_once (CLASSES_PATH_SMASH_PROFILE_MEDIA_MESSAGING.$class.'.php');
        return true;
    }else if (file_exists(CLASSES_PATH_SMASH_PROFILE_MEDIA_MESSAGING.smash_custom_profile_strip_interface($class,'custom_profile').'.php')) {
        require_once (CLASSES_PATH_SMASH_PROFILE_MEDIA_MESSAGING.smash_custom_profile_strip_interface($class,'custom_profile').'.php');
        return true;
    }
     else if (file_exists(CLASSES_PATH_SMASH_PROFILE_MEDIA_ACCOUNT.$class.'.php')) {
       
        require_once (CLASSES_PATH_SMASH_PROFILE_MEDIA_ACCOUNT.$class.'.php');
        return true;
    }
    else if (file_exists(CLASSES_PATH_SMASH_PROFILE_MEDIA_ACCOUNT.smash_custom_profile_strip_interface($class,'custom_profile').'.php')) {
        
        require_once (CLASSES_PATH_SMASH_PROFILE_MEDIA_ACCOUNT.smash_custom_profile_strip_interface($class,'custom_profile').'.php');
        return true;
    }
    else if (file_exists(SMASH_PROFILE_APP_BASE_DIR.'/api/v1/'.$class.'.php')) {
        require_once (SMASH_PROFILE_APP_BASE_DIR.'/api/v1/'.$class.'.php');
        return true;
    }
//    else{
//        echo $class."<br>";
//        echo CLASSES_PATH_SMASH_PROFILE_MEDIA_SUBSCRIBER.smash_custom_profile_strip_interface($class,'custom_profile').'.php';
//        require_once  CLASSES_PATH_SMASH_PROFILE_MEDIA_SUBSCRIBER.smash_custom_profile_strip_interface($class,'custom_profile').'.php';
//        echo "<br>". file_exists( CLASSES_PATH_SMASH_PROFILE_MEDIA_SUBSCRIBER.smash_custom_profile_strip_interface($class,'custom_profile').'.php') ? 1: 0;
//        exit();
//    }
    
//    else if (file_exists(SMASH_PROFILE_CLASSES_PATH_3RDPARTY.'Slim/'.$class.'.php')) {
//        \Slim\Slim::autoload('Slim/'.$class);
//        return true;
//    }
     
}

spl_autoload_register('smash_custom_profile_autoloader');

