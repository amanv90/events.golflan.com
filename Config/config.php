<?php

// CAUTION
// Do not update values below if you do not know what is this file about **

	// Application deployment information
define('API_PATH', '/var/www/html/events.golflan.com/'); //With trailing slash
define('WEB_PATH', 'https://events.golflan.com/');
define("STATIC_URL", '');
define('IMG_WEB_PATH', '');
//define('IMG_WEB_PATH', 'https://glmedia.golflan.com');
define('IMG_EMAIL_WEB_PATH', 'https://glmedia.golflan.com');
//DEFINE("IMG_DEPLOY_PATH",'/var/www/html/golflan_new/Templates/static/img/');
DEFINE("IMG_DEPLOY_PATH",'https://glmedia.golflan.com');
//DEFINE("PLATEFORM_PATH",'http://platformapi.golflan.com/');
//define('STATIC_URL', 'http://static.trux.com');
 DEFINE("PLATEFORM_PATH",'http://ec2-52-28-238-211.eu-central-1.compute.amazonaws.com/');
//DEFINE("PLATEFORM_EMAIL_PATH",'http://lab.communicate.golflan.com/');
//Database access configuration
DEFINE("PLATEFORM_CHECKEMAIL_PATH",'https://golflan.com/');

DEFINE("PLATEFORM_EMAIL_PATH",'');

//Database access configuration
define("DB1", 1);
$databases = array();
$databases[DB1] = array('host' => '', 'database' => '', 'user' => 'root', 'password' => '');

//Memcache Servers
$memcachedServers[0] = array('127.0.0.1', '11211');

define('MEMCACHE_EXPIRATION_DEFAULT', 86400 * 30);

//Slim constants
define('SLIM_DEBUG', true);
define('SLIM_MODE', 'development');

//API request authentication configs
define('AUTHENTICATE_REQUESTS', false);
define('AUTHORISATION_HEADER', 'authorize');

//Other configurations
define('AUTHENTICATE_METHOD', 'sha256');
define("HASH_KEY_SPLIT", 100);
define('SESS_TIMEOUT', '10800');

