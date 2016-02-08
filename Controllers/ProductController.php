<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ProductController extends Controller {

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
        $this->golfcourseObj = new Golfcourse(DB1);
        
        $this->app->get('/product', array($this, 'product'))->name('product');
        $this->app->get('/product/productDetails/ID/:prodID', array($this, 'getProductsDetailsOld'))->name('getProductsDetailsOld');
        $this->app->get('/product/:countryISO/:brandName/:title', array($this, 'getProductsDetails'))->name('getProductsDetails');
        $this->app->post('/product/getProducts', array($this, 'getProducts'))->name('getProducts');
        $this->app->post('/product/setCountryCode', array($this, 'setCountryCode'))->name('setCountryCode');
        $this->app->post('/product/applyVoucherOnProshopOrder', array($this, 'applyVoucherOnProshopOrder'))->name('applyVoucherOnProshopOrder');
        $this->app->post('/product/generateOrder', array($this, 'generateOrder'))->name('generateOrder');
        $this->app->post('/product/proshopCheckout', array($this, 'proshopCheckout'))->name('proshopCheckout');
        $this->app->post('/product/paypal/proshopCheckout', array($this, 'paypalProshopCheckout'))->name('paypalProshopCheckout');
        $this->app->post('/product/proshop/redirecturl', array($this, 'proshopCheckoutRedirectURL'))->name('proshopCheckoutRedirectURL');
        
        $this->app->post('/product/getProductAttributes', array($this, 'getProductAttributes'))->name('getProductAttributes');
        $this->app->post('/product/getProductPriceByAttr', array($this, 'getProductPriceByAttribute'))->name('getProductPriceByAttribute');
        
        $this->app->post('/product/getProductsByBrand', array($this, 'getProductsByBrand'))->name('getProductsByBrand');
        
    }
    
    public function product(){
        if(!isset($_SESSION)){ 
            session_start();
        }
        $returnArr = array();
        $category  = array();
        $countryCode = isset($_SESSION['country_code']) ? $_SESSION['country_code'] : "IND";
        $returnArr['product'] = $this->prodObj->getFeatureProduct($countryCode);
        $categories = $this->prodObj->getAllCategories();
        $categoryArray = array();
        foreach ($categories as $category) {
            if($category['isParentCategory'] == 1){
                $categoryArray[$category['catID']]['cat_name'] = $category['Description'];
                $categoryArray[$category['catID']]['catID'] = $category['catID'];
            }else{
                $categoryArray[$category['parentCategoryID']]['sub_category'][$category['catID']]['cat_ID'] = $category['catID'];
                $categoryArray[$category['parentCategoryID']]['sub_category'][$category['catID']]['cat_name'] = $category['Description'];
            }
        }
        
        $allBrandsArr = $this->prodObj->getAllBrandsByCountry($countryCode);
        $allBrandsArr1 = $this->prodObj->getAllBrands();
        $brandsProcessedArr = array();
        foreach ($allBrandsArr1 as $brand) {
            $brandsProcessedArr[$brand['brandID']]['name'] = str_replace(" ","-", $brand['brandName']);
        }
        $returnArr['brands'] = $allBrandsArr;
        $returnArr['brandsProcessedArray'] = $brandsProcessedArr;
//        echo print_r($allBrandsArr, 1);
//        exit();
//        error_log("test goldlan :====== ".print_r($returnArr,1));
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('product.tpl.php',array('dataArr' => $returnArr,'categoryArray' =>$categoryArray));
    }
    
    public function getProducts() {
        if (!isset($_SESSION)) {
            session_start();
        }
        $returnArr =array();
            $returnArr['error'] = 0;
        $catID = $_POST['cat_ID'];
        $subCatID = $_POST['sub_cat_ID'];
		
        $ISO =  $_POST['country_iso'];
        
        if($ISO == "")
        {
             $ISO = 'IND';
            
        }
		
        //$ISO = 'IND';
        
        $products = $this->prodObj->getproductByCatgNsubCatg($catID, $subCatID, $ISO);
//        foreach ($products as &$value) {
//            for ($index = 1; $index < count(5); $index++) {
//                if(isset($value['Description'.$index])){
//                    $value['Description'.$index] = Util::repalceNonAscii($value['Description'.$index]) ;
//                }
//            }
//        }
        $allBrandsArr1 = $this->prodObj->getAllBrands();
        $brandsProcessedArr = array();
        foreach ($allBrandsArr1 as $brand) {
            $brandsProcessedArr[$brand['brandID']]['name'] = str_replace(" ","-", $brand['brandName']);
        }
        foreach ($products as &$prod) {
            $brandName = isset($brandsProcessedArr[$prod['brandID']]['name']) ? $brandsProcessedArr[$prod['brandID']]['name'] : "";
            $prod['shopUrl'] = '/product/'.$ISO.'/'.$brandName."/".str_replace(" ","-",$prod['Title'])."-".$prod['prodID'];
        }
        error_log(print_r($products,1));
        if (count($products) < 1) {
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "No Products to display.";
            echo json_encode($returnArr);
            exit;
        }
        $returnArr['products'] = $products;
        $returnArr['currencyIcon'] = $_SESSION['currencyIcon'];
            //error_log("test  controllrt:-------  ".print_r($products,1));
        echo json_encode($returnArr);
        exit;
    }
    
    public function getProductsDetailsOld($prodId){
        if (!isset($_SESSION)) {
            session_start();
        }
        $returnArr =array();
        $returnArr['error'] = 0;
        
        $attributesData = $this->prodObj->getAllAtributes();

        foreach ($attributesData as $attr) {
            $attributesDataProcessed[$attr['attributeID']] = $attr['Description'];
        }

        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('productDetails.tpl.php',array('prodID'=>$prodId));
    }
    
    
     public function getProductsDetails($countryISO, $brandName, $title){
        if (!isset($_SESSION)) {
            session_start();
        }
        $titleArr = explode("-", $title);
        error_log(print_r($titleArr,1));
        error_log(print_r(count($titleArr),1));
        
        $prodId = $titleArr[count($titleArr)-1];
        $returnArr =array();
        $returnArr['error'] = 0;
        
        $attributesData = $this->prodObj->getAllAtributes();

        foreach ($attributesData as $attr) {
            $attributesDataProcessed[$attr['attributeID']] = $attr['Description'];
        }

        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('productDetails.tpl.php',array('prodID'=>$prodId));
    }

    
    public function setCountryCode() {
        $returnArr = array();
        $returnArr['error'] = 0;
        $countryCode = isset($_POST['countryCode']) ? $_POST['countryCode'] : 'IND';
        $countryArr = $this->prodObj->getCountryDetailsByCode($countryCode);
        error_log(print_r($countryArr, 1));
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['country_code'] = $countryCode;
        $currencyIcon = "";
        if ($countryArr['currrency_symbol'] != "" && $countryArr['currrency_symbol'] != null) {
            $currencyIcon = "<i class='fa " . $countryArr['currrency_symbol'] . "'></i>";
        } else {
            $currencyIcon = $countryArr['currency_code'] . " ";
        }
        $_SESSION['currencyIcon'] = $currencyIcon;
        echo json_encode($returnArr);
        exit();
    }
    
    public function applyVoucherOnProshopOrder() {
        $returnArr = array();
        $returnArr["error"] = 0;
        $returnArr['voucher_description'] = "";
        $voucherCode = $_POST['voucherCode'];
        $totAmt = 0;
        error_log(print_r($_POST, 1));
        //-------------------------------
        if (!isset($_SESSION)) {
            session_start();
        }
        $sesssionID = session_id();
        $login_id = 0;
        if (isset($_SESSION['login_id']) && $_SESSION['login_id'] != "") {
            $login_id = $_SESSION['login_id'];
        }
        $cartProducts = $this->prodObj->getCartProducts($sesssionID, $login_id, $_SESSION['country_code']);
        foreach ($cartProducts as $prod) {
            if($prod['dealID'] > 0){
                $returnArr['error'] = 1;
                $returnArr['error_msg'] = "Sorry, Voucher cannot be applied as your cart contains deal product.";
                echo json_encode($returnArr);
                exit;
            }
            $totAmt+=$prod['pricePerItem'] * $prod['Quantity'];
        }
        error_log(print_r($cartProducts, 1));
        error_log(print_r($totAmt, 1));
        //-------------------------------
//            $totAmt = $_POST['total_amt'];
        $amountAfterVoucher = $totAmt;
        $returnArr['revised_amount'] = $amountAfterVoucher;
        error_log(print_r("---------- Golflan Voucher functionlaity ----------", 1));
        error_log(print_r($_POST, 1));
        $isValid = $this->golfcourseObj->checkVoucher($voucherCode, $_SESSION['country_code']);
        error_log("test:::".$_SESSION['country_code']);
        error_log("test:::".$voucherCode);
        error_log("test    ".print_r($isValid, 1));
        if ($isValid == 0) {
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Invalid voucher code.";
            echo json_encode($returnArr);
            exit;
        }
        $currDate = date('d-m-Y H:i:s');
        $voucherDetails = $this->golfcourseObj->getVoucherDetails($voucherCode, $_SESSION['country_code']);
        $issuedDate = $voucherDetails['issuedDate'];
        $expiryDate = $voucherDetails['expiaryDate'];
        $issuedDate = date('d-m-Y H:i:s', strtotime($issuedDate));
        $expiryDate = date('d-m-Y H:i:s', strtotime($expiryDate));
        error_log(print_r($voucherDetails, 1));
        error_log(print_r("currDate = " . $currDate, 1));
        error_log(print_r("issuedDate = " . $issuedDate, 1));
        error_log(print_r("expiryDate = " . $expiryDate, 1));
//            $used = $golfCourse->checkVoucherAlreadyApplied($orderID);
//            if($used > 0){
//                $returnArr['error'] = 1;
//                $returnArr['error_msg'] = "This voucher is already reedemed by you.";
//                echo json_encode($returnArr);exit;
//            }
        if ((strtotime($currDate) <= strtotime($issuedDate)) || (strtotime($currDate) >= strtotime($expiryDate))) {
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "This voucher has been expired.";
            echo json_encode($returnArr);
            exit;
        }
        // Is voucher is applicable on Proshop i.e ( LobApplicable == 2 )
        if ($voucherDetails['LobApplicable'] != 2){
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Invalid voucher code.";
            echo json_encode($returnArr);
            exit;
        }
        
        if ($voucherDetails['numTimesAllowed'] == $voucherDetails['numTimesUsed']) {
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Sorry, This voucher has been used maximum number of times.";
            echo json_encode($returnArr);
            exit;
        }
        //----------- Product specific voucher logic ---------------------
        if ($voucherDetails['PIDApplicable'] != 0){
            foreach ($cartProducts as $prod) {
                if($voucherDetails['PIDApplicable'] != $prod['prodID']){
                    $returnArr['error'] = 1;
                    $returnArr['error_msg'] = "Sorry, This voucher is applicable on specific product. Your cart doesn't contain that product or contains other product(s).";
                    echo json_encode($returnArr);
                    exit;
                }
            }
        }
        //----------------------------------------------------------
        if (isset($voucherDetails['voucherType']) && isset($voucherDetails['Amount'])) {
            if ($voucherDetails['voucherType'] == 0) {
                $returnArr['voucher_description'] = $voucherDetails['Amount'] . ' OFF on ' . $totAmt;
                $amountAfterVoucher = $amountAfterVoucher - $voucherDetails['Amount'];
            } else if ($voucherDetails['voucherType'] == 1) {
                $returnArr['voucher_description'] = $voucherDetails['Amount'] . '% OFF on ' . $totAmt;
                $amountAfterVoucher = $amountAfterVoucher - (($amountAfterVoucher * $voucherDetails['Amount']) / 100);
            }
        }
        error_log(print_r("amountAfterVoucher = " . $amountAfterVoucher, 1));
        if ($amountAfterVoucher < 1) {
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Sorry, Voucher cannot be applied as voucher discount is more than actual amount payable.";
            echo json_encode($returnArr);
            exit;
        }
        if ($amountAfterVoucher < 0) {
            $amountAfterVoucher = 0;
        }
        $returnArr['orignal_amount'] = $totAmt;
        $returnArr['discount_amount'] = $totAmt - $amountAfterVoucher;
        $returnArr['revised_amount'] = $amountAfterVoucher;
        $returnArr['error_msg'] = "Voucher applied successfully .";
        $voucherrID = $voucherDetails['voucherID'];
        $voucherrNumber = $voucherDetails['VoucherNumber'];
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['voucher_id'] = $voucherDetails['voucherID'];
        $_SESSION['voucher_no'] = $_POST['voucherCode'];
        $_SESSION['discount_amount'] = $returnArr['discount_amount'];
        echo json_encode($returnArr);
        exit;
    }
    
    public function generateOrder() {
        $this->userObj = new User(DB1);
        $returnArr = array();
        $productsFromCart = array();
        $returnArr['error'] = 0;
        $voucherID = "";
        $voucherNumber = "";
        $subTotal = 0;
        $grandTotal = 0;
        $discount = 0;
        if (!isset($_SESSION)) {
            session_start();
        }
        $sesssionID = session_id();
        $userId = 0;
        if (isset($_SESSION['login_id']) && $_SESSION['login_id'] != "") {
            $userId = $_SESSION['login_id'];
        }
        if (isset($_SESSION['voucher_id']) && $_SESSION['voucher_id'] != "") {
            $voucherID = $_SESSION['voucher_id'];
        }
        if (isset($_SESSION['voucher_no']) && $_SESSION['voucher_no'] != "") {
            $voucherNumber = $_SESSION['voucher_no'];
        }
        if (isset($_SESSION['discount_amount']) && $_SESSION['discount_amount'] != "") {
            $discount = $_SESSION['discount_amount'];
        }
        unset($_SESSION['voucher_id']);
        unset($_SESSION['voucher_no']);
        unset($_SESSION['discount_amount']);
        error_log(print_r($userId, 1));
        $productsFromCart = $this->prodObj->getProductsFromCart($userId, $_SESSION['country_code']);
        error_log("test:-----   ".print_r($productsFromCart,1));
        foreach ($productsFromCart as $prod) {
            $subTotal+= $prod['pricePerItem'] * $prod['Quantity'];
        }
        $grandTotal = $subTotal - $discount;
        $orderID = $this->prodObj->insertProshopOrder($userId, $subTotal, $discount, $grandTotal, $voucherID, $voucherNumber, $_SESSION['country_code']);
        error_log("order id  .".$orderID);
        $userDetails = $this->userObj->getUserDetailsById($userId);
        $this->golfcourseObj->updateVoucher($voucherID);
        $this->golfcourseObj->insertVoucherTrans($voucherID, PROSHOP_ORDER_NO_PREFIX . $orderID, $voucherNumber, $userDetails['Email'], $_SESSION['country_code']);
        foreach ($productsFromCart as $prod) {
            $prodId = $prod['prodID'];
            $prodPriceMapId = $prod['priceMapID'];
            $qty = $prod['Quantity'];
            $pricePerItem = $prod['pricePerItem'];
            $dealID = $prod['dealID'];
            error_log('deal id here '.$dealID);
            $this->prodObj->insertProshopTransaction($orderID, $prodId, $prodPriceMapId, $userId, $qty, $pricePerItem, $_SESSION['country_code'], $dealID);
        }
//            $product->emptyProductFromCart($sesssionID, $userId);
        $returnArr['order_Id'] = $orderID;
        echo json_encode($returnArr);
    }
    
    function proshopCheckout(){
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('proshop_chechout.tpl.php');
    }
    
    function proshopCheckoutRedirectURL(){
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('redirecturl_proshop.tpl.php');
    }
    
    function getProductAttributes(){
        $returnArr =array();
        $returnArr['error'] = 0;
        $whereClause = "";
        error_log(print_r($_POST,1));
        $prod_ID = isset($_POST['pdoductID']) ? $_POST['pdoductID'] : 0;
        $attrNO = isset($_POST['attrNo']) ? $_POST['attrNo'] : 0;
        $attr = isset($_POST['attr']) ? $_POST['attr'] : 0;
        $whereClause.=" AND Description".$attrNO." = '".$attr."'";
        $productArr = $this->prodObj->getProductAttr($prod_ID, $whereClause);
        $returnArr['product'] = $productArr;
        error_log(print_r($productArr,1));
        echo json_encode($returnArr);
    }
    
    function getProductPriceByAttribute(){
        $returnArr =array();
        $returnArr['error'] = 0;
        $prod_ID = isset($_POST['pdoductID']) ? $_POST['pdoductID'] : 0;
        $attr1 = isset($_POST['attr1']) ? $_POST['attr1'] : '';
        $attr2 = isset($_POST['attr2']) ? $_POST['attr2'] : '';
        $attr3 = isset($_POST['attr3']) ? $_POST['attr3'] : '';
        $attr4 = isset($_POST['attr4']) ? $_POST['attr4'] : '';
        $whereClause ="";
        if($attr1!=""){
            $whereClause.=" AND Description1 = '".$attr1."'";
        }
        if($attr2!=""){
            $whereClause.=" AND Description2 = '".$attr2."'";
        }
        if($attr3!=""){
            $whereClause.=" AND Description3 = '".$attr3."'";
        }
        if($attr4!=""){
            $whereClause.=" AND Description4 = '".$attr4."'";
        }
        error_log(print_r($whereClause,1));
        $product = $this->prodObj->getProductPriceByAttr($prod_ID, $whereClause);
        error_log(print_r($product,1));
        $returnArr['product'] = $product[0];
//            error_log(print_r($products,1));
        echo json_encode($returnArr);
        exit;
    }
    
    function paypalProshopCheckout(){
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('proshop_paypa.tpl.php');
    }
    
    function getProductsByBrand(){
        if (!isset($_SESSION)) {
            session_start();
        }
        $returnArr =array();
        $returnArr['error'] = 0;
        $brandID = isset($_POST['brandID']) ? $_POST['brandID'] : 0;
        $ISO =  $_POST['country_iso'];
        
        if($ISO == "")
        {
             $ISO = 'IND';
            
        }
		
        //$ISO = 'IND';
        
        $products = $this->prodObj->getproductByBrand($brandID, $ISO);
        
        
        $allBrandsArr1 = $this->prodObj->getAllBrands();
        $brandsProcessedArr = array();
        foreach ($allBrandsArr1 as $brand) {
            $brandsProcessedArr[$brand['brandID']]['name'] = str_replace(" ","-", $brand['brandName']);
        }
        foreach ($products as &$prod) {
            $brandName = isset($brandsProcessedArr[$prod['brandID']]['name']) ? $brandsProcessedArr[$prod['brandID']]['name'] : "";
            $prod['shopUrl'] = '/product/'.$ISO.'/'.$brandName."/".str_replace(" ","-",$prod['Title'])."-".$prod['prodID'];
        }
        
        if (count($products) < 1) {
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "No Products to display.";
            echo json_encode($returnArr);
            exit;
        }
        $returnArr['products'] = $products;
        $returnArr['currencyIcon'] = $_SESSION['currencyIcon'];
            //error_log("test  controllrt:-------  ".print_r($products,1));
        echo json_encode($returnArr);
        exit;
    }

}


