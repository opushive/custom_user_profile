<?php
//define("SMASH_ADMIN_SENDER_NUMBER",32811);
//define("APP_NAME","Likita");
//define("DEFAULT_LOCATION","Nigeria");
//define("SYSTEM_TIMEZONE","Africa/Lagos");
//define('APPLICATION_NAME', 'OKASHO Likita Service');
//define('SEARCH_LINK','/search/');
//define('CONFIRM_APPOINTMENT_API_LINK','/api/v1/provider/appointment/:id/confirm/:code');
//define('DENY_APPOINTMENT_API_LINK','/cancel-appointment/:id/:code');
//define('PATIENT_CONFIRM_APPOINTMENT_API_LINK','/api/v1/provider/appointment/:id/patient/confirm/:code');
//define('PATIENT_DENY_APPOINTMENT_API_LINK','/cancel-patient-appointment/:id/:code');
////define('DENY_APPOINTMENT_API_LINK',SITE_DOMAIN.'/api/v1/provider/appointment/:id/deny/:code');
//define('NO_AVAILABILITY_MESSAGE','The appointment was cancelled because the slot you booked was taken by another customer, please try again');
//
//// REMINDER TIMINGS
////define("LAST_REMINDER_BEFORE_APPOINTMENT_FREQUENCY","00:00:00");
////define("FIRST_REMINDER_BEFORE_APPOINTMENT_PERIOD","00:00:00");
////define("LAST_REMINDER_BEFORE_APPOINTMENT_PERIOD","24:00:00");
//define("LAST_REMINDER_BEFORE_APPOINTMENT_FREQUENCY","20:00:00");
//define("LAST_REMINDER_BEFORE_APPOINTMENT_PERIOD","1440"); // set this to 22 hours
//define("LAST_REMINDER_BEFORE_APPOINTMENT_TIMEOUT",1);
//define("FIRST_REMINDER_BEFORE_APPOINTMENT_FREQUENCY","00:00:00");
//define("FIRST_REMINDER_BEFORE_APPOINTMENT_PERIOD","168");
//define("FIRST_REMINDER_BEFORE_APPOINTMENT_TIMEOUT",1);
//
//// GOOGLE AUTH
////https://developers.google.com/api-client-library/php/auth/service-accounts
//define('GOOGLE_CALENDAR_DEV_KEY', 'AIzaSyDfG9ki3KxB4KjFCopa830gl8ZrbbqZh7g');
////define('CLIENT_SECRET_PATH',$_SERVER['DOCUMENT_ROOT'].'/sct/client_secret.json');
////define('SERVER_SERVER_KEY',$_SERVER['DOCUMENT_ROOT'].'/sct/findadoctor-e2e23b5a8832.p12');
//define('CLIENT_SECRET_PATH','/var/www/vhosts/likita.org/sct/client_secret.json');
//define('SERVER_SERVER_KEY','/var/www/vhosts/likita.org/sct/findadoctor-e2e23b5a8832.p12');
//define('CLIENT_EMAIL', 'account-2@findadoctor-1139.iam.gserviceaccount.com');
//define('GOOGLE_OAUTH_CALLBACK','/wp-content/plugins/medical-appointment-booker/auth/calendar/');
//define('GOOGLE_OAUTH_CALLBACK_RETURN_PATH','/wp-content/plugins/medical-appointment-booker/okasho/appointment/AppointmentMgr.php');
//
//// EVENTS AND RULES
//
// !defined("ACTION_FOLDER") ? define("ACTION_FOLDER",APP_BASE_DIR."/actions") : "";
//define("SUPPORT_EMAIL","support@likita.org");
//// SMS SERVER
//define("SMS_SERVER_URL","http://isessolutions.smsrouter.gtsmessenger.com");
//define("SMS_SERVER_USERNAME","admin");
//define("SMS_SERVER_PASSWORD","3a5ff8e2");
//// TWILLIO SMS SETTINGS
//define("TWILLIO_SMS_USERNAME","ACbb715f917b49ba09dc0836bb8b5f70cd");
//define("TWILLIO_SMS_TOKEN","9417257ef305b5c069144b1fa7d6126b");
//define("SMS_GATEWAY","TWILLIO");
//define("ALTERNATE_SMS_GATEWAY","GTS");
//define("MENU_SEPERATOR","Menu Seperator");
//define("DEFAULT_SMS_MESSAGE_SIZE",125);
//define("ADMIN_SENDER_NUMBER",32811);
//define("ADMIN_SENDER_TWILLIO_NUMBER","+18555347085"); // OLD NUMBER
//define("ALTERNATE_ADMIN_SENDER_TWILLIO_NUMBER","+447481342555");
//define("FAILED_SMS_HANDLER","http://likita.org/wp-content/plugins/medical-appointment-booker/cron/failedsmshandler.php");
//
//// EMAIL SETTINGS
//define("EMAIL_HOST_IP","smtp.gmail.com");
//define("EMAIL_HOST_PORT","587");
//define("SENDMAIL_OWNER_ID","admin@likita.org");
//define("SENDMAIL_OWNER_PASSWORD","20Ki!ta?_3Z");
////define("SENDMAIL_OWNER_ID","administrator@likita.org");
////define("SENDMAIL_OWNER_PASSWORD",'*LiK1ta"0!^');
//// MESSAGES
//define("USER_ACCOUNT_EXISTS","User Account Exists");
//define("USER_ACCOUNT_CREATED","User Account Created");
//define("USER_ACCOUNT_CREATION_FAILED_USER_ERROR","Account Creation Failed Invalid Username");
//define("USER_ACCOUNT_CREATION_FAILED_ADDRESS_ERROR","Account Creation Failed Invalid Address");
//define("USER_ACCOUNT_CREATION_FAILED_USERDETAILS_ERROR","Account Creation Failed Invalid User Details");
//define("USER_ACCOUNT_CREATION_FAILED_ACCESSROLES_ERROR","Account Creation Failed Invalid Access Roles");
//define("USER_DOES_NOT_EXIST","User does not exist");
//define("USER_NOT_CONFIRMED_TITLE","User not confirmed");
//define("USER_DETAILS_NOT_VALID","User Credential are invalid");
//define('REGISTERED_USER_ADMIN_MAIL', 'Admin Email');
//define('REGISTERED_USER_ADMIN_SUPERVISOR_MAIL', 'Admin Supervisor Email');
//define('COMPANY_ADMIN_MAIL', 'Company Email');
//define('USER_REGISTRATION_ADMIN_COMMAND_MSG_TITLE', 'User Registration Form Data');
//define('USER_REGISTRATION_CONFIRM_MSG_TITLE', 'User Registration Confirmation Message');
//// TEST
//define('ADMINSTRATOR_EMAIL_NAME', 'Likita Administrator');
//define('USER_REQUEST_ID', 'ur');
//define('MAIL_CLIENT_ID', 'mc');
//define('FAILED_USER_MSG', 'msg');
//define('CONFIRM_USER', 'cm');
//define('CONFIRMATION_CODE_ID', 'ccid');
//define('CONFIRM_USER_ID', 'id');
//define('END_DATE_INTERVAL_IN_DAYS',7);
//
////SYSTEM ESCALATION CONFUGRATIONS
//define('SYSTEM_ESCALATE_EMAIL','pm@okasho.org');
//
//define('SYSTEM_ESCALATE_TIMEOUT','1');
//define('SYSTEM_ESCALATE_PERIOD','00:10:00');
//define('SYSTEM_ESCALATE_TEL','10');
//define('SYSTEM_ESCALATE_MEDIUM','EMAIL');