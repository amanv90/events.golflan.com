<?php
/** This file is part of the Bollywood Review Project <http://www.bollywoodreview.com>.
 * Copyright (C) 2012 Fermion Infotech Private Limited. All rights reserved. (info@fermion.in)
 */

/**
 * @file    Admin.php
 * @version 1.0
 * @brief   Admin Class
 * @date    Nov 28, 2012
 * @author  Anshul Rejoonia <anshulr@fermion.in>
 */

/* @class   Admin
 * @brief   This is the class for Admin Login/logout
 */

class User{

    /*! @privatesection */

    // A private attribute to store db connection object
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
    
	public function memberbook($Name, $Mobile, $Email, $Card) {
       
        $query = "INSERT INTO memberRegister (Name, Mobile, Email, CardNo) VALUES (?, ?, ?, ?)";
        $valArr = $this->dbobj->insert($query, array($Name, $Mobile, $Email, $Card), $this->dbConn);
        return $valArr;
    }
	
	public function memberbook1($SeasonID, $Name, $Mobile, $Email, $Card, $date, $GCName) {
       
        $query = "INSERT INTO memberRegister (SeasonID, Name, Mobile, Email, CardNo, DateOfPlay, GCName) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $valArr = $this->dbobj->insert($query, array($SeasonID, $Name, $Mobile, $Email, $Card, $date, $GCName), $this->dbConn);
        return $valArr;
    }
	
	public function memberbook2($SeasonID, $ParentID, $Name, $Mobile, $Email, $Card, $date, $GCName) {
       
        $query = "INSERT INTO memberRegister (SeasonID, ParentId, Name, Mobile, Email, CardNo, DateOfPlay, GCName) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $valArr = $this->dbobj->insert($query, array($SeasonID, $ParentID, $Name, $Mobile, $Email, $Card, $date, $GCName), $this->dbConn);
        return $valArr;
    }
	
	public function getParentID($Email, $CardNo){
        $query = "select * from memberRegister WHERE Email = ? AND CardNo = ? ORDER BY Srno DESC";
        $valArr = $this->dbobj->select($query, array($Email, $CardNo), $this->dbConn);
        return $valArr;
    }
	
	
    public function getWebUserCardDetail($userId){
        $query = "select * from webUserCards WHERE User_ID =".$userId;
        $valArr = $this->dbobj->select($query, '', $this->dbConn);
        return $valArr;

    }
        
    
    

}

