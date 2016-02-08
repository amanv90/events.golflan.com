<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Marketing
 *
 * @author user
 */
class Marketing {
   private $dbConn;

    /*! @publicsection */

    /**
     * Constructor of User Class.
     * @param dbName  The Database Id. Default value: 1.
     */
    public function __construct($db = DB2) {
            $this->dbConn = $db;
            $this->dbobj = new Dbop();
    }

    /* ! De Constructor of User Class. */

    public function __deconstruct() {

    }
    
    function insertUserHit($siteID, $advtUnit, $keyWord, $userAction){
        $query = "INSERT INTO userCampaignTraffic (siteID, advtUnit, keyWord, userAction, actionDateTime) VALUES (?, ?, ?, ?, now())";
        $valArr = $this->dbobj->insert($query, array($siteID, $advtUnit, $keyWord, $userAction), $this->dbConn);
        return $valArr;
    }
    
    function checkIsCampaign($action){
        if(!isset($_SESSION)){ 
            session_start();
        } 
        if(isset($_SESSION['SiteID']) || isset($_SESSION['addUnit']) || isset($_SESSION['KeyWord'])){
            $siteID = isset($_SESSION['SiteID']) ? $_SESSION['SiteID'] : "";
            $advtUnit = isset($_SESSION['addUnit']) ? $_SESSION['addUnit'] : "";
            $keyWord = isset($_SESSION['KeyWord']) ? $_SESSION['KeyWord'] : "";
            $userAction = $action ; 
            $this->insertUserHit($siteID, $advtUnit, $keyWord, $userAction);
        }
    }
}
