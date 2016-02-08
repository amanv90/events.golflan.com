<?php

//echo "test";
//exit();
require_once '../Config/config.php';
require_once '../Config/constants.php';
 
require_once API_PATH . 'Slim/Slim.php';
require_once API_PATH . 'Libs/AutoLoader.php';

//register our class autoloader
spl_autoload_register('AutoLoader::customAutoloader');

\Slim\Slim::registerAutoloader();

$app = new Slim\Slim(array(
	'debug' => SLIM_DEBUG,   
    'templates.path' => '../Templates/',      
	'mode' => SLIM_MODE
));

// Controller for test controller

//if(strpos($app->request()->getPathInfo(), '/user') === 0 ){
//    new UserController($app);
//}

if(strpos($app->request()->getPathInfo(), '/') === 0 ) {
    new GolfcourseController($app);
}

if(strpos($app->request()->getPathInfo(), '/test') === 0 ) {
    new GolfcourseController($app);
}

if(strpos($app->request()->getPathInfo(), '/golfcourse') === 0 ) {
    new GolfcourseController($app);
}

if(strpos($app->request()->getPathInfo(), '/contact') === 0 || strpos($app->request()->getPathInfo(), '/paynlearn') === 0 || strpos($app->request()->getPathInfo(), '/paynplay') === 0 || strpos($app->request()->getPathInfo(), '/playnow') === 0 || strpos($app->request()->getPathInfo(), '/contactus') === 0 || strpos($app->request()->getPathInfo(), '/termsandconditions') === 0) {
    new GolfcourseController($app);
}

if(strpos($app->request()->getPathInfo(), '/product') === 0 ) {
    new ProductController($app);
}

if(strpos($app->request()->getPathInfo(), '/cart') === 0 ) {
    new CartController($app);
}

$app->response->headers->set('Content-Type', 'application/json');
$app->response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate');
$app->response->headers->set('Pragma', 'no-cache');
$app->run();

