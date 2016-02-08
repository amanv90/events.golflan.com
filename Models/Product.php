<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Product
 *
 * @author user
 */
class Product {
    private $dbConn;

    /*! @publicsection */

    /**
     * Constructor of User Class.
     * @param dbName  The Database Id. Default value: 1.
     */
    public function __construct($db = 1) {
            $this->dbConn = $db;
            $this->dbobj = new Dbop();
    }

    /* ! De Constructor of User Class. */

    public function __deconstruct() {

    }
    
    
    public function getFeatureProduct($country_code) {
        $aParamArray = array();
        $aParamArray[] = $country_code; 
        $where = "";
        $query = "SELECT psm.prodID, psm.Title, psm.brandID, psm.imgURL, psap.ListPrice ,psap.OurPrice, psap.dealID,  psm.imgURL, psap.stockOnHand, psap.attributeID1, psap.Description1
                    FROM proShopMaster psm
                    ,(
                    SELECT MIN( ROUND(ourPrice,0) ) OurPrice, prodID, ROUND(listPrice,0) ListPrice, dealID,  stockOnHand, attributeID1, Description1, isActive
                    FROM proShopAttributePriceMap
                    GROUP BY prodID
                    )psap where psm.prodID = psap.prodID AND psap.isActive = 1 AND countryISO = ? order by FeatureRanking asc limit 12";
        $valArr = $this->dbobj->select($query, $aParamArray, $this->dbConn);
        error_log("test:11=====  ".print_r($valArr,1));
        return $valArr;
    }
    
    public function getFeatureProductByDealID($dealID) {
        $query = "select  Title, ROUND(ListPrice,2) ListPrice ,ROUND(OurPrice,2) OurPrice, dealID, Discount, imgURL, stockOnHand from proShopMaster WHERE dealID = ?";
	$query .= " order by FeatureRanking asc limit 8";
        $valArr = $this->dbobj->select($query, array($dealID), $this->dbConn);
        return $valArr;
    }
    
    public function getCountryDetailsByCode($countryCode){
        $query = "select * from countryList where iso_alpha3 = ?";
        $valArr = $this->dbobj->select($query, array($countryCode), $this->dbConn);
        return $valArr[0];
    }
    
    public function getCartQuantity($sesssionID, $userId, $countryCode){
        $aParamArr = array();
        $where = " sessionID = ? ";
        if($userId != "" && $userId != NULL){
            $where = " User_ID = ? ";
            $aParamArr[] = $userId;
        }else{
            $aParamArr[] = $sesssionID;
        }
        $aParamArr[] = $countryCode;
        $query = "select sum(Quantity) as count from proShopCart where (" . $where . ") AND counryISO = ? ";
        $valArr = $this->dbobj->select($query, $aParamArr , $this->dbConn);
        return $valArr[0]['count'];
    }
   
    
    public function getCartProducts($sesssionID, $userId, $countryCode){
        $aParamArr = array();
        $where = " sessionID = ? ";
        if($userId != "" && $userId != NULL){
            $where = " User_ID = ? ";
            $aParamArr[] = $userId;
        }else{
            $aParamArr[] = $sesssionID;
        }
        $aParamArr[] = $countryCode;
        $query = "select psm.imgURL, psc.Quantity, psc.pricePerItem,  psm.Title, psc.prodID, psc.priceMapID, psc.dealID  from proShopCart psc, proShopMaster psm where (". $where .") AND psm.prodID = psc.prodID AND counryISO = ?";
        $valArr = $this->dbobj->select($query, $aParamArr, $this->dbConn);
        return $valArr;
    }
   
    
    public function getCountryList(){
        $query = "select * from countryList where isActive = 1";
        $valArr = $this->dbobj->select($query, '', $this->dbConn);
        return $valArr;
    }
	
    
    
    public function getAllCategories(){
        $query = "select * from proShopCatgoryMaster";
        $valArr = $this->dbobj->select($query, '', $this->dbConn);
        return $valArr;
    }
    
    public function getproductByCatgNsubCatg($catID, $subCatID, $countryISO){
        $aParamArray = array($catID);
        $aParamArray[] = $countryISO; 
        $where = "";
        if($subCatID != "" && $subCatID!=NULL){
            $where ="  AND psm.subCategory = ? ";
            $aParamArray[] = $subCatID; 
        }
//        $query = "select  Title, ROUND(psap.listPrice,2) ListPrice ,ROUND(psap.ourPrice,2) OurPrice, psap.dealID,  psm.imgURL, psap.stockOnHand, psap.attributeID1, psap.Description1 from proShopMaster psm, proShopAttributePriceMap psap WHERE psap.isActive = 1 AND psm.prodID = psap.prodID AND psm.Category = ?".$where;
        $query = "SELECT psm.prodID, psm.Title, psm.brandID, psm.imgURL, psap.ListPrice ,psap.OurPrice, psap.dealID,  psm.imgURL, psap.stockOnHand, psap.attributeID1, psap.Description1
                    FROM proShopMaster psm
                    ,(
                    SELECT MIN( ROUND(ourPrice,0) ) OurPrice, prodID, ROUND(listPrice,0) ListPrice, dealID,  stockOnHand, attributeID1, Description1, isActive
                    FROM proShopAttributePriceMap
                    GROUP BY prodID
                    )psap where psm.prodID = psap.prodID AND psap.isActive = 1 AND psm.Category = ? AND countryISO = ?".$where;
        $valArr = $this->dbobj->select($query, $aParamArray, $this->dbConn);
        error_log("test:11=====  ".print_r($valArr,1));
        return $valArr;
    }
    
    public function getAllAtributes(){
        $query = "select * from proShopAttributes";
        $valArr = $this->dbobj->select($query, '', $this->dbConn);
        return $valArr;
    }
    
    public function getProduct($product_ID, $country_code){
        $query = "SELECT psm.prodID, psm.Title, psm.imgURL, psm.brandID, psm.Description, psm.countryISO, psm.merchantID,psm.Category, psm.subCategory, psap.*
                    FROM proShopMaster psm, proShopAttributePriceMap psap where psm.prodID = psap.prodID AND psap.isActive = 1 AND psm.prodID = ? AND countryISO = ?";
        $valArr = $this->dbobj->select($query, array($product_ID, $country_code), $this->dbConn);
        return $valArr;
    }
    
    
    public function getMerchantDetailsByID($merchantID){
        $query = "select * from proShopMerchant WHERE merchantID  = ?";
        $valArr = $this->dbobj->select($query, array($merchantID), $this->dbConn);
        return $valArr[0];
    }
   public function getAllCountryList(){
        $query = "select id_countries, name from countryList";
        $valArr = $this->dbobj->select($query, '', $this->dbConn);
        return $valArr;
    }
    
	
	public function getImagePriority(){
        $query = "select * from advtEngine ORDER BY `priority` ASC limit 0,1";
        $valArr = $this->dbobj->select($query, '', $this->dbConn);
        return $valArr[0];
    }
    
    public function getProductPriceByIDS($productID, $productPriceID){
        $query = "SELECT psap.ourPrice ourPrice FROM proShopAttributePriceMap psap where  psap.isActive = 1 AND prodID = ? AND priceMapID = ?";
        $valArr = $this->dbobj->select($query, array($productID, $productPriceID), $this->dbConn);
        return $valArr[0]['ourPrice'];
    }
    public function getImagePriorityUpdate($avtID){
       $query = "UPDATE `advtEngine` set `priority`= `priority`+1 WHERE `advtID` =".$avtID." limit 1";
       $valArr = $this->dbobj->update($query, '', $this->dbConn);
       return $valArr[0];
    }
    
    public function checkProductExistInCart($userId, $sesssionID, $productID, $productPriceID){
        $aParamArr = array();
        $where = " sessionID = ? ";
        if($userId != "" && $userId != NULL){
            $where = " User_ID = ? ";
            $aParamArr[] = $userId;
        }else{
            $aParamArr[] = $sesssionID;
        }
        $aParamArr[] = $productID;
        $aParamArr[] = $productPriceID;
        $query = "select count(1) as count from proShopCart psc where (". $where ." AND prodID = ? AND priceMapID = ?)";
        $valArr = $this->dbobj->select($query, $aParamArr, $this->dbConn);
        return $valArr[0]['count'];
    }
    
    public function updateProductQuantity($userId, $sesssionID, $productID, $productPriceID, $quantity, $countryCode, $increaseOrDecrease = " + " ){
        $aParamArr = array();
        $aParamArr[] = $quantity;
        $where = " sessionID = ? ";
        if($userId != "" && $userId != NULL){
            $where = " User_ID = ? ";
            $aParamArr[] = $userId;
        }else{
            $aParamArr[] = $sesssionID;
        }
        $aParamArr[] = $productID;
        $aParamArr[] = $productPriceID;
        $aParamArr[] = $countryCode;
        $query = "UPDATE proShopCart set Quantity  = ? where (".$where." AND prodID = ? AND priceMapID = ?) AND counryISO = ?";
        return $this->dbobj->update($query, $aParamArr, $this->dbConn);
        return $valArr;
    }
    
    public function deleteProductFromCart($productID, $productMapID, $sesssionID, $userId, $countryCode){
        $aParamArr = array();
        $where = " sessionID = ? ";
        if($userId != "" && $userId != NULL){
            $where = " User_ID = ? ";
            $aParamArr[] = $userId;
        }else{
            $aParamArr[] = $sesssionID;
        }
        $aParamArr[] = $productID;
        $aParamArr[] = $productMapID;
        $aParamArr[] = $countryCode;
        $query = "DELETE FROM proShopCart where (".$where." AND prodID = ? AND priceMapID = ?) AND counryISO = ?";
        $valArr = $this->dbobj->delete($query, $aParamArr, $this->dbConn);
        return $valArr;
    }
    
    public function insertProductToCart($sesssionID, $userId, $productID, $productPriceID, $quantity, $productPrice, $currencyISO, $dealID){
        $query = "INSERT INTO proShopCart (sessionID, User_ID, prodID, priceMapID, Quantity, pricePerItem, counryISO, addedOn, dealID) VALUES (?, ?, ?, ?, ?, ?, ?,now(), ?)";
        $valArr = $this->dbobj->insert($query, array($sesssionID, $userId, $productID, $productPriceID, $quantity, $productPrice, $currencyISO, $dealID), $this->dbConn);
        return $valArr;
    }
    
    public function getProductAttr($prod_ID, $whereClause){
        $query = "SELECT attributeID1, attributeID2, attributeID3, attributeID4, Description1 , Description2, Description3, Description4 
                    FROM proShopAttributePriceMap psap where  psap.isActive = 1 AND prodID = ? ".$whereClause;
        $valArr = $this->dbobj->select($query, array($prod_ID), $this->dbConn);
        return $valArr;
    }
    
    public function emptyProductFromCart($sesssionID, $userId){
        $aParamArr = array();
        $where = " sessionID = ? ";
        if($userId != "" && $userId != NULL){
            $where = " User_ID = ? ";
            $aParamArr[] = $userId;
        }else{
            $aParamArr[] = $sesssionID;
        }
        $query = "DELETE FROM proShopCart where (".$where.")";
        $valArr = $this->dbobj->delete($query, $aParamArr, $this->dbConn);
        return $valArr;
    }
    
    public function updateProShopCartSessionIdToUserId($sessionID, $userID){
        $query = "UPDATE proShopCart set sessionID  = '' , User_ID = ?  where sessionID = ?";
        return $this->dbobj->update($query, array($userID, $sessionID), $this->dbConn);
        return $valArr;
    }
    
    public function getProductsFromCart($userId, $countryCode){
        $query = "select * from proShopCart WHERE User_ID =? AND counryISO = ?";
        $valArr = $this->dbobj->select($query, array($userId, $countryCode), $this->dbConn);
        return $valArr;
    }
    
    public function insertProshopOrder($userId, $subTotal, $discount, $grandTotal, $voucherID, $voucherNumber, $countryCode){
        $paymentStatus = 0;
        $query = "INSERT INTO proShopOrderMaster (User_ID, subTotal, discount, grandTotal, orderDate, paymentStatus, voucherID, voucherNumber, countryISO) VALUES (?, ?, ?, ?, now(), ?, ?, ?, ?)";
        $valArr = $this->dbobj->insert($query, array($userId, $subTotal, $discount, $grandTotal, $paymentStatus, $voucherID, $voucherNumber, $countryCode), $this->dbConn);
        return $valArr;
    }
    
    public function insertProshopTransaction($orderID, $prodId, $prodPriceMapId, $userId, $qty, $pricePerItem, $countryCode, $dealID){
        $shipStatus = 0;
        $query = "INSERT INTO proShopTrans (orderID, prodID, priceMapID, USER_ID, datePurchase, Quantity, pricePerItem, shipStatus, countryISO, dealID) VALUES (?, ?, ?, ?, now(), ?, ?, ?, ?, ?)";
        $valArr = $this->dbobj->insert($query, array($orderID, $prodId, $prodPriceMapId, $userId, $qty, $pricePerItem, $shipStatus, $countryCode, $dealID), $this->dbConn);
        return $valArr;
    }
    
    public function getProShopOrderDeatailsByOrderID($orderID){
        $query = "select psom.grandTotal, psom.orderDate, countryISO, wum.* from proShopOrderMaster psom, webUserMaster wum WHERE orderID =? and psom.User_ID = wum.User_ID";
        $valArr = $this->dbobj->select($query, array($orderID), $this->dbConn);
        return $valArr[0];
    }
    
    public function getProShopTransactionDeatailsByOrderID($orderID){
        $query = "select pst.*, psm.Title from proShopTrans pst, proShopMaster psm WHERE orderID = ? AND pst.prodID = psm.prodID";
        $valArr = $this->dbobj->select($query, array($orderID), $this->dbConn);
        return $valArr;
    }
    
    function updateProshopPaymentStatus($Order_Id){
        $payment_status = 1;
        $query = "UPDATE proShopOrderMaster set paymentStatus = ? WHERE orderID = ? ";
        return $this->dbobj->update($query, array($payment_status, $Order_Id), $this->dbConn);
    }
    
    
    public function getProductPriceByAttr($prod_ID, $whereClause){
        $query = "SELECT psap.listPrice, psap.ourPrice, priceMapID, stockOnHand, psap.dealID 
                    FROM proShopAttributePriceMap psap where  psap.isActive = 1 AND prodID = ? ".$whereClause;
        $valArr = $this->dbobj->select($query, array($prod_ID), $this->dbConn);
        return $valArr;
    }
    
    public function getAllBrands(){
        $query = "select * from proShopBrandMaster order by brandName";
        $valArr = $this->dbobj->select($query, '', $this->dbConn);
        return $valArr;
    }
	
	public function getAllBrandsByCountry($countryCode){
		if($countryCode =='IND')
		{
			 $query = "select * from proShopBrandMaster where INDActive = 1 order by brandName";
		}
		if($countryCode =='MYS')
		{
			 $query = "select * from proShopBrandMaster where MYSActive = 1 order by brandName";
		}
		if($countryCode =='SGP')
		{
			 $query = "select * from proShopBrandMaster where SGPActive = 1 order by brandName";
		}
		if($countryCode =='ARE')
		{
			 $query = "select * from proShopBrandMaster where AREActive = 1 order by brandName";
		}
        //$query = "select * from proShopBrandMaster where INDActive = 1 order by brandName";
        $valArr = $this->dbobj->select($query, '', $this->dbConn);
        return $valArr;
    }
    
    public function getproductByBrand($brandID, $countryISO){
        $aParamArray = array($brandID);
        $aParamArray[] = $countryISO; 
        $where = "";
//        $query = "select  Title, ROUND(psap.listPrice,2) ListPrice ,ROUND(psap.ourPrice,2) OurPrice, psap.dealID,  psm.imgURL, psap.stockOnHand, psap.attributeID1, psap.Description1 from proShopMaster psm, proShopAttributePriceMap psap WHERE psap.isActive = 1 AND psm.prodID = psap.prodID AND psm.Category = ?".$where;
        $query = "SELECT psm.prodID, psm.Title, psm.brandID, psm.imgURL, psap.ListPrice ,psap.OurPrice, psap.dealID,  psm.imgURL, psap.stockOnHand, psap.attributeID1, psap.Description1
                    FROM proShopMaster psm
                    ,(
                    SELECT MIN( ROUND(ourPrice,0) ) OurPrice, prodID, ROUND(listPrice,0) ListPrice, dealID,  stockOnHand, attributeID1, Description1, isActive
                    FROM proShopAttributePriceMap
                    GROUP BY prodID
                    )psap where psm.prodID = psap.prodID AND psap.isActive = 1 AND psm.brandID = ? AND countryISO = ?".$where;
        $valArr = $this->dbobj->select($query, $aParamArray, $this->dbConn);
//        error_log("test:11=====  ".print_r($valArr,1));
        return $valArr;
    }
    
    public function getAllProducts($countryISO, $name){
        $aParamArray[] = $countryISO; 
        $where = "";
        if($name !=""){
            $where = " AND psm.Title LIKE '%".$name."%'";
        }
//        $query = "select  Title, ROUND(psap.listPrice,2) ListPrice ,ROUND(psap.ourPrice,2) OurPrice, psap.dealID,  psm.imgURL, psap.stockOnHand, psap.attributeID1, psap.Description1 from proShopMaster psm, proShopAttributePriceMap psap WHERE psap.isActive = 1 AND psm.prodID = psap.prodID AND psm.Category = ?".$where;
        $query = "SELECT psm.prodID, psm.Title, psm.imgURL, psap.ListPrice ,psap.OurPrice, psap.dealID,  psm.imgURL, psap.stockOnHand, psap.attributeID1, psap.Description1
                    FROM proShopMaster psm
                    ,(
                    SELECT MIN( ROUND(ourPrice,0) ) OurPrice, prodID, ROUND(listPrice,0) ListPrice, dealID,  stockOnHand, attributeID1, Description1, isActive
                    FROM proShopAttributePriceMap
                    GROUP BY prodID
                    )psap where psm.prodID = psap.prodID AND psap.isActive = 1 AND countryISO = ?".$where;
        $valArr = $this->dbobj->select($query, $aParamArray, $this->dbConn);
        error_log("test:11=====  ".print_r($valArr,1));
        return $valArr;
    }
    
     public function getDeals($countryISO){
        $query = "select * from dealMaster where counryISO = ? AND isActive = 1 order by FeatureRanking Limit 16";
        $valArr = $this->dbobj->select($query, array($countryISO), $this->dbConn);
        return $valArr;
    }
    
    public function getDealByID($dealId){
        $query = "select * from dealMaster WHERE DealID = ? AND isActive = 1";
        $valArr = $this->dbobj->select($query, array($dealId), $this->dbConn);
        if(isset($valArr[0])){
            return $valArr[0];
        }else{
            return $valArr;
        }
    }
    
    public function getProductListPriceByIDS($productID, $productPriceID){
        $query = "SELECT psap.listPrice listPrice FROM proShopAttributePriceMap psap where  psap.isActive = 1 AND prodID = ? AND priceMapID = ?";
        $valArr = $this->dbobj->select($query, array($productID, $productPriceID), $this->dbConn);
        return $valArr[0]['listPrice'];
    }
    
    function updateDealClaimed($dealId, $quantity){
        $query = "UPDATE dealMaster set numUnitsSold = numUnitsSold + ".$quantity." WHERE DealID = ? ";
        return $this->dbobj->update($query, array($dealId), $this->dbConn);
    }
    
    public function getCatDespById($catID){
        $query = "select * from proShopCatgoryMaster where catID = ?";
        $valArr = $this->dbobj->select($query, array($catID), $this->dbConn);
        return $valArr;
    }
    
    public function getBrandNameById($brandId){
        $query = "select * from proShopBrandMaster where brandID = ?";
        $valArr = $this->dbobj->select($query, array($brandId), $this->dbConn);
        return $valArr;
    }
    
    
    public function getProductWithoutISOCode($product_ID){
        $query = "SELECT psm.prodID, psm.Title, psm.imgURL, psm.brandID, psm.Description, psm.countryISO, psm.merchantID,psm.Category, psm.subCategory, psap.*
                    FROM proShopMaster psm, proShopAttributePriceMap psap where psm.prodID = psap.prodID AND psap.isActive = 1 AND psm.prodID = ?";
        $valArr = $this->dbobj->select($query, array($product_ID), $this->dbConn);
        return $valArr;
    }
}
