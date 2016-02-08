<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CartController extends Controller {
    
    public $golfcourseObj = null;
    public $userObj = null;
    public $marketingObj = null;

    public function __construct($app) {
        $this->app = ($app instanceof Slim) ? $app : \Slim\Slim::getInstance();
        $request = $this->app->request();
        $this->data['body'] = json_decode($request->getBody(),true);
        $this->data['header'] = $headers = apache_request_headers();
        $this->navigatorObj = new Navigator();
        $this->prodObj = new Product(DB1);
        
        $this->app->get('/cart', array($this, 'cart'))->name('cart');
        $this->app->post('/cart/addProductToCart', array($this, 'addProductToCart'))->name('addProductToCart');
        $this->app->post('/cart/emptyProductFromCart', array($this, 'emptyProductFromCart'))->name('emptyProductFromCart');
        $this->app->post('/cart/increaseDecreaseCartProductQuantity', array($this, 'increaseDecreaseCartProductQuantity'))->name('increaseDecreaseCartProductQuantity');
        $this->app->post('/cart/deleteProductFromCart', array($this, 'deleteProductFromCart'))->name('deleteProductFromCart');
        $this->app->post('/cart/loginUserCheckout', array($this, 'loginUserCheckout'))->name('loginUserCheckout');
        $this->app->post('/cart/updateShippingAddress', array($this, 'updateShippingAddress'))->name('updateShippingAddress');
        $this->app->post('/cart/saveUser', array($this, 'saveUser'))->name('saveUser');
    }
    
    public function cart(){
        if(!isset($_SESSION)){ 
            session_start();
        }
        $returnArr = array();
        $userDetails = array();
        $login_id = "";
        if( isset( $_SESSION['login_id']) && $_SESSION['login_id'] != ""){
        $login_id = $_SESSION['login_id'];
        }
        $this->userObj = new User(DB1);
        $sesssionID = session_id();
        if($login_id != ""){
        $userDetails = $this->userObj->getUserDetailsById($login_id);
//        echo "<pre>";
//        print_r($userDetails);
        }
        $cartProducts = $this->prodObj->getCartProducts($sesssionID, $login_id, $_SESSION['country_code']);
        foreach ($cartProducts as &$product) {
            if(isset($product['dealID']) && $product['dealID'] !="" && $product['dealID']!= null){
                $dealDetails  = $this->prodObj->getDealByID($product['dealID']);
                $product['Title'] = $dealDetails['Deal_Title'];
                $product['imgURL'] = $dealDetails['ingURL'];
            }
        }
        //error_log("session ID:--".$sesssionID);
       error_log("test golflan :====== ".print_r($cartProducts,1));
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('cart.tpl.php',array('cartProducts'=>$cartProducts,'userDetails'=>$userDetails));
    }
    
    public function addProductToCart(){
        $returnArr =array();
            $returnArr['error'] = 0;
            $productID = isset($_POST['pdoductID']) ? $_POST['pdoductID'] : 0;
            $productPriceID = isset($_POST['productPriceID']) ? $_POST['productPriceID'] : 0;
            $dealID = isset($_POST['deal_ID']) ? $_POST['deal_ID'] : "";
            $userId = "";
            $quantity = 1;
            if(!isset($_SESSION)){
                session_start();
            }
            $sesssionID = session_id();
            if( isset( $_SESSION['login_id']) && $_SESSION['login_id'] != ""){
                $userId = $_SESSION['login_id'];
            }
            //error_log("country code:------".$_SESSION['country_code']);
            $productPrice = $this->prodObj->getProductPriceByIDS($productID, $productPriceID);
            //------------- Deal functionality ---------------------
            if($dealID != ""){
                error_log($dealID);
                $dealDetails  = $this->prodObj->getDealByID($dealID);
                $productListPrice = $this->prodObj->getProductListPriceByIDS($productID, $productPriceID);
                if(isset($dealDetails['dealType'])){
//                    //----------- Percentage off ------------
//                    $percentOff = isset($dealDetails['percentDiscount']) ? $dealDetails['percentDiscount'] : 0;
//                    $productPrice = $productListPrice - (($productListPrice*$percentOff)/100);
//                }else if(isset($dealDetails['dealType']) && $dealDetails['dealType'] == 3){
                    //----------- Percentage off ------------
                    $productPrice = isset($dealDetails['dealPrice']) ? $dealDetails['dealPrice'] : 0;
                }
            }
            //------------- Deal functionality END ---------------------
            $prodExist = $this->prodObj->checkProductExistInCart($userId, $sesssionID, $productID, $productPriceID);
            if($prodExist > 0){
                $this->prodObj->updateProductQuantity($userId, $sesssionID, $productID, $productPriceID, $quantity, $_SESSION['country_code']);
            }else{
                $this->prodObj->insertProductToCart($sesssionID, $userId, $productID, $productPriceID, $quantity, $productPrice, $_SESSION['country_code'], $dealID);
            }
            $cartQuantity = $this->prodObj->getCartQuantity($sesssionID, $userId, $_SESSION['country_code']);
            $returnArr['cart_quantity'] = $cartQuantity;
            echo json_encode($returnArr);
    }
    
    public function emptyProductFromCart(){
        $returnArr = array();
            $returnArr['error'] = 0;
            if(!isset($_SESSION))
            {
                session_start();
            }
            $sesssionID = session_id();
            $userId = 0;
            if( isset( $_SESSION['login_id']) && $_SESSION['login_id'] != ""){
                    $userId = $_SESSION['login_id'];
            }
            $returnArr['success'] = $this->prodObj->emptyProductFromCart($sesssionID, $userId, $_SESSION['country_code']);
            echo json_encode($returnArr);
    }
    
    public function increaseDecreaseCartProductQuantity(){
        $returnArr = array();
            $returnArr['error'] = 0;
            $productID = isset($_POST['productID']) ? $_POST['productID'] : 0;
            $productPriceID = isset($_POST['priceMapID']) ? $_POST['priceMapID'] : 0;
            $userId = 0;
            $quantity = (isset($_POST['qty']) && is_numeric($_POST['qty'])) ? $_POST['qty'] : 1;//1;
            $increaseOrDecrease = isset($_POST['incrementDecrementType']) ? $_POST['incrementDecrementType'] : " + ";
            if(!isset($_SESSION))
            {
                session_start();
            }
            $sesssionID = session_id();
            $userId = 0;
            if( isset( $_SESSION['login_id']) && $_SESSION['login_id'] != ""){
                    $userId = $_SESSION['login_id'];
            }
            if(!isset($_SESSION)){
             session_start();
            }
            $sesssionID = session_id();
            if( isset( $_SESSION['login_id']) && $_SESSION['login_id'] != ""){
                $userId = $_SESSION['login_id'];
            }
            $returnArr['success'] = $this->prodObj->updateProductQuantity($userId, $sesssionID, $productID, $productPriceID, $quantity, $_SESSION['country_code'], $increaseOrDecrease);
            echo json_encode($returnArr);
    }

    public function deleteProductFromCart() {
        $returnArr = array();
        $returnArr['error'] = 0;
        $productID = isset($_POST['productID']) ? $_POST['productID'] : 0;
        $productMapID = isset($_POST['priceMapID']) ? $_POST['priceMapID'] : 0;
        $userId = 0;
        if (!isset($_SESSION)) {
            session_start();
        }
        $sesssionID = session_id();
        if (isset($_SESSION['login_id']) && $_SESSION['login_id'] != "") {
            $userId = $_SESSION['login_id'];
        }
        $returnArr['success'] = $this->prodObj->deleteProductFromCart($productID, $productMapID, $sesssionID, $userId, $_SESSION['country_code']);
        echo json_encode($returnArr);
    }
    
    public function loginUserCheckout(){
        $this->userObj = new User();
        $returnArr = array();
            $returnArr['error'] = 0;
            $email = $_POST['user_email'];
            $password = $_POST['password'];
//            error_log(print_r($_POST,1));
            $exist = $this->userObj->checkUserIsValid($email, $password);
//            error_log(print_r("user = ".$exist,1));
            if($exist == 0){
                $returnArr['error'] = 1;
                $returnArr['error_msg'] = "Invalid Email-ID or Password.";
                echo json_encode($returnArr);exit;
            }
            $userDetails = $this->userObj->getUserDetailsByEmail($email);
//            session_destroy();
            if(!isset($_SESSION)){
                session_start();
            }
            $_SESSION['login_id'] = $userDetails['User_ID'];
            $_SESSION['login_email'] = $email;
             if(!isset($_SESSION)){
                session_start();
            }
            $sesssionID = session_id();
            $this->prodObj->updateProShopCartSessionIdToUserId($sesssionID, $userDetails['User_ID']);
            echo json_encode($returnArr);
            exit;
    }
    
    public function updateShippingAddress() {
        $this->userObj = new User();
        $returnArr = array();
        $returnArr['error'] = 0;
        error_log(print_r($_POST, 1));
        $shipping_address_1 = isset($_POST['shipping_address_1']) ? $_POST['shipping_address_1'] : '';
        $shipping_country = isset($_POST['shipping_country']) ? $_POST['shipping_country'] : '';
        $shipping_state = isset($_POST['shipping_state']) ? $_POST['shipping_state'] : '';
        $shipping_city = isset($_POST['shipping_city']) ? $_POST['shipping_city'] : '';
        $shipping_pincode = isset($_POST['shipping_pincode']) ? $_POST['shipping_pincode'] : '';
        if (!isset($_SESSION)) {
            session_start();
        }
        $sesssionID = session_id();
        unset($_SESSION['voucher_id']);
        unset($_SESSION['voucher_no']);
        unset($_SESSION['discount_amount']);
        $userId = 0;
        if (isset($_SESSION['login_id']) && $_SESSION['login_id'] != "") {
            $userId = $_SESSION['login_id'];
        }
        $this->userObj->updateUserShippingDetails($userId, $shipping_address_1, $shipping_state, $shipping_country, $shipping_city, $shipping_pincode);
        echo json_encode($returnArr);
    }
    
    public function saveUser() {
        if (!isset($_SESSION)) {
            session_start();
        }
        $this->userObj = new User();
        $this->markObj = new Marketing();
        $returnArr = array();
        $returnArr["error"] = 0;
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $contact = $_POST['contact'];
        $user_email = $_POST['user_email'];
        $password = $_POST['password'];
        $userExist = $this->userObj->checkUserExistByEmail($user_email);
        if($userExist == 1){
            $returnArr["error"] = 1;
            $returnArr["error_msg"] = "User Already Exist";
            echo json_encode($returnArr);
            exit();
        }
        $countryCode = $_SESSION['country_code'];
        $register_id = $this->userObj->registertUser($fname, $lname, $contact, $user_email, $password,$countryCode);
        $this->markObj->checkIsCampaign("User registered.");
        if (isset($_POST['during_checkout'])) {
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['login_id'] = $register_id;
            $_SESSION['login_email'] = $user_email;
            if (!isset($_SESSION)) {
                session_start();
            }
        }
        echo json_encode($returnArr);
        exit;
    }

}

