<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
ob_start();


# DATABASE Details
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'Krishan@1998');
define('DB_NAME', 'adm');


# MAIN DATABASE Details
define('BASE_PATH', '/inshortt/');
define('APP_URL', 'http://localhost/inshortt');

# PATH 
define('ASSETS_PATH', BASE_PATH.'assets');
define('IMAGE_PATH', BASE_PATH.'assets/images');
define('ACTION_PATH', BASE_PATH.'app/action');
define('UPLOAD_PATH', BASE_PATH.'uploads');


# URL
define('SITE_URL', APP_URL);
define('MAIN_SITE_URL', 'http://alldatmatterz.com');
define('IMAGE_URL', APP_URL.'/assets/images');
define('ACTION_URL', APP_URL.'/app/action');



# DIR
define('BASE_DIR', dirname(__FILE__) );
define('CLASS_DIR', BASE_DIR.'/app/classes');
define('PROFILE_DIR', BASE_DIR.'/assets/images/user');
define('UPLOAD_DIR', BASE_DIR.'/uploads');

#OTHER
date_default_timezone_set('Asia/Calcutta');
define('PROTOCOL','http');
define('EMAIL_ID','rastogi.lalit12@gmail.com');
define('LANG','en');
