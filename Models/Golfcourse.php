<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Golfcourse
 *
 * @author fermion-ub-02
 */
class Golfcourse {
    
    
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
    
	
    public function getUserAvgHandicap($login_id){
        $query = "select avg(handicap) as handicap from webUserScorecard where MemID = ?";
        $valArr = $this->dbobj->select($query, array($login_id), $this->dbConn);
        return $valArr[0];
    }
	
    
     public function addScoreCard($columnArr, $par, $total, $email, $memberShipNumber, $gcID, $date_time_play){
        $memID = $memberShipNumber;
        $gid = $gcID;
        $aParamArr = array();
        $aParamArr[] = $gid;
        $columns = "";
        $questions = "";
        for ($index = 1; $index <=18; $index++) {
            $columns.=', '. 'hole_'.$index;
            $columns.=', '. 'putt_'.$index;
            $questions.= ',?';
            $questions.= ',?';
            $aParamArr[] = $columnArr["hole_".$index];
            $aParamArr[] = $columnArr["putt_".$index];
        }
        //$aParamArr[19] = $par;
        $aParamArr[] = $total;
        $handicap = $par - $total;
        $aParamArr[] = $handicap;
        $aParamArr[] = $email;
        $aParamArr[] = $memID;
        $aParamArr[] = $memberShipNumber;
        $aParamArr[] = $date_time_play;
        $query = "INSERT INTO webUserScorecard (GID ".$columns.",total,handicap,Email,MemID,memberShipNum,dateTimeOfPlay ) VALUES (? ".$questions.",?,?,?,?,?,?)";
        $valArr = $this->dbobj->insert($query, $aParamArr, $this->dbConn);
        return $valArr;
    }
    
	
	
    public function getAllGolfCourses() {
        $query = "select distinct gm.GID as GID, GCName from golfCourseMaster gm, gcScorecardMaster gsm where gm.GID = gsm.GID and gm.isActive = 1 order by GCName ";
        $valArr = $this->dbobj->select($query, '', $this->dbConn);
        return $valArr;
    }
	
	
    public function getgcScorecardMasterData($gid){
        $query = "select * from gcScorecardMaster WHERE GID = ? ;";
        $valArr = $this->dbobj->select($query, array($gid), $this->dbConn);
        return $valArr;
    }
	
	
    public function scorecardview(){
        $scorecard = array();
        $gid = 11;
        $returnArr = $this->getgcScorecardMasterData($gid);
        $firstBreak = 0;
        $secondBreak = 0;
        $blueOut = 0;
        $blueTotal = 0;
        $blackOut = 0;
        $blackTotal = 0;
        $whiteOut = 0;
        $whiteTotal = 0;
        $scorecard[] = 'Par';
        $blueYard[] = 'Blue';
        $blackYard[] = 'Black';
        $whiteYard[] = 'White';
        for ($index = 0; $index < count($returnArr); $index++) {
            $scorecard[] = $returnArr[$index]['holePAR'];
            $blueYard[] = $returnArr[$index]['yardBlue'];
            $blackYard[] = $returnArr[$index]['yardBlack'];
            $whiteYard[] = $returnArr[$index]['yardWhite'];
            if($index <=8 ){
              $firstBreak+= $returnArr[$index]['holePAR'];
              $blueOut+= $returnArr[$index]['yardBlue'];
              $blackOut+= $returnArr[$index]['yardBlack'];
              $whiteOut+= $returnArr[$index]['yardWhite'];
            }
            if($index >8 ){
              $secondBreak+= $returnArr[$index]['holePAR'];
              $blueTotal+= $returnArr[$index]['yardBlue'];
              $blackTotal+= $returnArr[$index]['yardBlack'];
              $whiteTotal+= $returnArr[$index]['yardWhite'];
            }
            if(($index+1) == 9){
                $scorecard[] = $firstBreak;
                $blueYard[] = $blueOut;
                $blackYard[] = $blackOut;
                $whiteYard[] = $whiteOut;
            }
            if(($index+1) == 18){
                $scorecard[] = $firstBreak + $secondBreak;
                $blueYard[] = $blueOut + $blueTotal;
                $blackYard[] = $blackOut + $blackTotal;
                $whiteYard[] = $whiteOut + $whiteTotal;
            }

            error_log("inside loop".$returnArr[$index]['holeNumber']);
        }
        $returnArr['scorecard'] = $scorecard;
        $returnArr['blueYard'] = $blueYard;
        $returnArr['blackYard'] = $blackYard;
        $returnArr['whiteYard'] = $whiteYard;
        error_log(print_r($returnArr,1));
        return $returnArr;
    }
	
    
    /**
     * Function: getGolfCourses
     * To get Golf-Courses name for search box by name
     * @param $name  search value
     * @retval Golf-courses array containing this search name.
     */
    public function getGolfCourses($name) {
        $query = "select * from golfCourseMaster ";
	$query .= " where (GCName LIKE '%".$name."%' OR City LIKE '%".$name."%' OR Country LIKE '%".$name."%') AND ((isActive=1 AND CoachingAvil=1) OR (isActive=1 AND CoachingAvil=0)) order by GCName";
        $valArr = $this->dbobj->select($query, '', $this->dbConn);
        return $valArr;
    }

    public function removeAsciiCode($returnArr){
        foreach ($returnArr as $row=>&$value) {
            $value['GCName']      = Util::repalceNonAscii($value['GCName']);
            $value['Address']     = Util::repalceNonAscii($value['Address']);
            $value['City']        = Util::repalceNonAscii($value['City']);
            $value['Country']     = Util::repalceNonAscii($value['Country']);
            $value['Address']     = Util::repalceNonAscii($value['Address']);
            $value['LogoURL']     = Util::repalceNonAscii($value['LogoURL']);
            $value['Description'] = Util::repalceNonAscii($value['Description']);
            $value['CurrencyISO'] = Util::repalceNonAscii($value['CurrencyISO']);
            $value['TermsCondition'] = Util::repalceNonAscii($value['TermsCondition']);
            $value['other_info'] = Util::repalceNonAscii($value['other_info']);

        }
        return $returnArr;       
    }
    
    public function removeAsciiCodeFromGCDetails($gcDetails){
        $gcDetails['GCName']      = Util::repalceNonAscii($gcDetails['GCName']);
        $gcDetails['Address']     = Util::repalceNonAscii($gcDetails['Address']);
        $gcDetails['City']        = Util::repalceNonAscii($gcDetails['City']);
        $gcDetails['Country']     = Util::repalceNonAscii($gcDetails['Country']);
        $gcDetails['Address']     = Util::repalceNonAscii($gcDetails['Address']);
        $gcDetails['LogoURL']     = Util::repalceNonAscii($gcDetails['LogoURL']);
        $gcDetails['Description'] = Util::repalceNonAscii($gcDetails['Description']);
        $gcDetails['CurrencyISO'] = Util::repalceNonAscii($gcDetails['CurrencyISO']);
        $gcDetails['TermsCondition'] = Util::repalceNonAscii($gcDetails['TermsCondition']);
        $gcDetails['other_info'] = Util::repalceNonAscii($gcDetails['other_info']); 
        return $gcDetails;
    }
    
    public function getPayNPlaySlotsByGid($gid){
        $query = "select * from paidGolfCourseSlots where GID = ? AND Status !=4";
        $valArr = $this->dbobj->select($query, array($gid), $this->dbConn);
        return $valArr;
    }
    
    
    /**
     * Function: getGolfCourseByID
     * To get Golf-Courses Data by Golf-course ID
     * @param $gid  Golf Course ID
     * @retval Golf-course details array.
     */
    public function getGolfCourseByID($gid) {
        $query = "select * from golfCourseMaster ";
	$query .= " where GID = ".$gid." order by GCName";
        $valArr = $this->dbobj->select($query, '', $this->dbConn);
        return $valArr[0];
    }
    
    public function getSlotPricebyPriceName($gid, $priceName){
        $query = "select gcm.Price, gcm.ListPrice from paidGolfCourseMeta gcm,paidGolfCoursePrice gcp where gcm.GID = ? AND PriceName = ? and gcm.PriceID = gcp.PriceID";
        $valArr = $this->dbobj->select($query, array($gid, $priceName), $this->dbConn);
        if(isset($valArr[0])){
            return $valArr[0];
        }else{
            return "not_available";
        }
    }
    
    public function getSlotPrice($gid, $playDate, $playTime){ 
        $query = "select slotID, listPrice, ourPrice, currencyISO, currencyIcon from paidGolfCourseSlots where GID = ? AND Date = ? and Time = ?";
        $valArr = $this->dbobj->select($query, array($gid, $playDate, $playTime), $this->dbConn);
        if(isset($valArr[0])){
            return $valArr[0];
        }else{
            return "not_available";
        }
    }
    
    /**
     * Function: checkSlotAvail
     * Checks if slot available for particular user for particular slot type
     * @param $userID  User ID
     * @param $slotType  Slot type
     * @retval returns slot available count.
     */
    public function checkSlotAvail($userID, $slotType){
        $query = "select count(1) as count from webUserCards where User_ID = ? AND ".$slotType." > 0";
        $valArr = $this->dbobj->select($query, array($userID), $this->dbConn);
        return $valArr[0]['count'];
    }
    
    /**
     * Function: checkAlreadyBooked
     * Checks if slot is already booked by given User ID, Golfcourse ID, Card No and Slot time
     * @param $gid  Golf course ID
     * @param $userID User ID
     * @param $cardNo Card Number
     * @param $slottime  Slot time
     * @retval returns 1 if already booked by user else 0.
     */
    function checkAlreadyBooked($gid, $userID, $cardNo, $slottime){
        $query = "select count(1) as count from compGolfCourseBook where GID = ? AND User_ID = ? AND  CardNo = ? AND date(dateOfPlay) = ?";
        $valArr = $this->dbobj->select($query, array($gid, $userID, $cardNo, $slottime), $this->dbConn);
        return $valArr[0]['count'];
    }
    
    public function bookSlot($gid, $userID, $cardNo, $dateOfPlay, $slotOfPlay){
        $query = "INSERT INTO compGolfCourseBook (GID, USER_ID, CardNo, dateRequest, dateOfPlay, slotOfPlay, bookingStatus) VALUES (?, ?, ?, now(), ?, ?, ?)";
        $valArr = $this->dbobj->insert($query, array($gid, $userID, $cardNo, $dateOfPlay, $slotOfPlay, "Pending"), $this->dbConn);
        return $valArr;
    }
    
    public function sendMail($subject, $body, $to, $defaultEmail = NULL){
            $fromEmail = FROM_EMAIL_ID ;
            if($defaultEmail!=null){
                $fromEmail = $defaultEmail;
            }
            $mail = new PHPMailer();
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = SMTP_HOST;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = SMTP_AUTH;                               // Enable SMTP authentication
            $mail->Username = SMTP_USERNAME;              // SMTP username
            $mail->Password = SMTP_PASSWORD;                           // SMTP password
            $mail->SMTPSecure = SMTP_SECURE;                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = SMTP_PORT;                                    // TCP port to connect to
            $mail->From = $fromEmail;
            $mail->FromName = FROM_EMAIL_NAME;
            $mail->addReplyTo(SMTP_REPLY_EMAIL_ID, SMTP_REPLY_NAME);
            $mailCC =  explode(",", MAIL_CC);
            foreach($mailCC as $cc) {
                error_log(trim($cc));
                $mail->addCC(trim($cc));
            }
            $mail->isHTML(true);  
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->addAddress($to); // Add a recipient
            $mail->send();
    }
    
    function checkAlreadyBookedPayNPlay($gid, $userID, $date, $slottime){
        $query = "select count(1) as count from paidGolfCourseBook where GID = ? AND User_ID = ? AND date(dateOfPlay) = ? AND slotOfPlay = ?";
        $valArr = $this->dbobj->select($query, array($gid, $userID, $date,  $slottime), $this->dbConn);
        return $valArr[0]['count'];
    }
    
    function bookPayNPlaySlot($slotID, $gid, $userID, $tempDate, $time, $tot_amt, $currencyISO, $currencyIcon){
        $book_status = "pending";
        $pay_status = "payment pending";
        $query = "INSERT INTO paidGolfCourseBook (slotID, GID, USER_ID, dateRequest, dateOfPlay, slotOfPlay, totAmount, bookingStatus, payStatus, currencyISO, currencyIcon) VALUES (?, ?, ?, now(), ?, ?, ?, ?, ?, ?, ?)";
        $valArr = $this->dbobj->insert($query, array($slotID, $gid, $userID, $tempDate, $time, $tot_amt, $book_status, $pay_status, $currencyISO, $currencyIcon), $this->dbConn);
        return $valArr;
    }
    
    function insertFourBall($book_ID, $name, $email, $contact, $bookedByUserID){
        $query = "INSERT INTO fourBallMaster (BookID, fourBallName, fourBallEmail, fourBallPhoneNum, bookedByUserID) VALUES (?, ?, ?, ?, ?)";
        $valArr = $this->dbobj->insert($query, array($book_ID, $name, $email, $contact, $bookedByUserID), $this->dbConn);
        return $valArr;
    }
    
    function updateFourBallIDs($book_ID, $sql){
        $query = "UPDATE paidGolfCourseBook set ".$sql." WHERE BookID = ? ";
        return $this->dbobj->update($query, array($book_ID), $this->dbConn);
    }
    
    function checkVoucher($voucherCode, $countryCode){
        $voucher_status  = VOUCHER_ACTIVE;
        $query = "select count(1) as count from voucherMaster where VoucherNumber = ? AND Status = ? AND countryISO  = ?";
        $valArr = $this->dbobj->select($query, array($voucherCode, $voucher_status, $countryCode), $this->dbConn);
        return $valArr[0]['count'];
    }
    
    public function getVoucherDetails($voucherCode, $countryCode) {
        $voucher_status  = VOUCHER_ACTIVE;
        $query = "select * from voucherMaster where VoucherNumber = ? AND Status = ? AND countryISO  =?";
        $valArr = $this->dbobj->select($query, array($voucherCode, $voucher_status, $countryCode), $this->dbConn);
        return $valArr[0];
    }
    
    function checkVoucherAlreadyApplied($orderID){
        $query = "select count(1) as count from voucherTrans where BookID = ? ";
        $valArr = $this->dbobj->select($query, array($orderID), $this->dbConn);
        return $valArr[0]['count'];
    }
    
    public function updateVoucher($voucherrID){
        $query = "UPDATE voucherMaster set numTimesUsed = numTimesUsed +1 WHERE voucherID = ?";
        return $this->dbobj->update($query, array($voucherrID), $this->dbConn);
    }
    
    public function insertVoucherTrans($voucherrID, $orderID, $voucherrNumber, $emailID, $countryCode){
        $status = 0;
        $query = "INSERT INTO voucherTrans (voucherID, BookID, VoucherNumber, userEmailID, appliedDate, countryISO) VALUES (?, ?, ?, ?, now(), ?)";
        $valArr = $this->dbobj->insert($query, array($voucherrID, $orderID, $voucherrNumber, $emailID, $countryCode), $this->dbConn);
        return $valArr;
    }
    
    public function updatePayNPLayVoucherDetails($orderID, $voucherrID, $voucherrNumber, $totamt){
        $query = "UPDATE paidGolfCourseBook set VoucherApplied  = 1, VoucherID = ?, VoucherNumber = ?, totAmount = ? WHERE BookID = ?";
        return $this->dbobj->update($query, array($voucherrID, $voucherrNumber , $totamt, $orderID), $this->dbConn);
    }
    
    function getDetailsForPayment($book_id){
        $query = "select totAmount, GID, currencyISO from paidGolfCourseBook where BookID = ?";
        $valArr = $this->dbobj->select($query, array($book_id), $this->dbConn);
        return $valArr[0];
    }
    
    public function getExchangeRate($currencyISO){
        $query = "select * from convertCurrency where CurrencyISO = ?";
        $valArr = $this->dbobj->select($query, array($currencyISO), $this->dbConn);
        return $valArr[0];
    }
      
    function checkLearnAlreadyBooked($gid, $userID, $cardNo, $slottime){
        $query = "select count(1) as count from compLearnGolfCourseBook where GID = ? AND User_ID = ? AND  CardNo = ? AND date(dateOfPlay) = ?";
        $valArr = $this->dbobj->select($query, array($gid, $userID, $cardNo, $slottime), $this->dbConn);
        return $valArr[0]['count'];
    }
    
    public function bookLearnSlot($gid, $userID, $cardNo, $dateOfPlay, $slotOfPlay){
        $query = "INSERT INTO compLearnGolfCourseBook (GID, USER_ID, CardNo, dateRequest, dateOfPlay, slotOfPlay, bookingStatus) VALUES (?, ?, ?, now(), ?, ?, ?)";
        $valArr = $this->dbobj->insert($query, array($gid, $userID, $cardNo, $dateOfPlay, $slotOfPlay, "Pending"), $this->dbConn);
        return $valArr;
    }
    
    function getPayNPlayBookingDetails($booking_ID){
        $query = "select wum.Fname, wum.Lname, wum.Login_Name,gcm.GCName, wum.Email, gcm.City, pgcb.slotID, DATE(pgcb.dateOfPlay) as dateOfPlay, pgcb.slotOfPlay, pgcb.BookID, pgcb.GID, pgcb.User_ID, pgcb.fourBall1ID, pgcb.fourBall2ID, pgcb.fourBall3ID from paidGolfCourseBook pgcb, webUserMaster wum, golfCourseMaster gcm where BookID = ? AND pgcb.User_ID = wum.User_ID AND pgcb.GID =gcm.GID";
        $valArr = $this->dbobj->select($query, array($booking_ID), $this->dbConn);
        return $valArr[0];
    }
    
    function updateBookingAndPaymentStatus($book_ID, $booking_status, $paymentStatus){
        $book_status = $booking_status;
        $pay_status = $paymentStatus;
        $query = "UPDATE paidGolfCourseBook set bookingStatus = ?, payStatus = ? WHERE BookID = ? ";
        return $this->dbobj->update($query, array( $book_status, $pay_status, $book_ID), $this->dbConn);
    }
    
    function updatePayNPlaySlot($gid, $date, $time){
        $status = 4;
        $query = "UPDATE paidGolfCourseSlots set Status = ? WHERE GID = ? AND Date = ? AND Time = ?";
        return $this->dbobj->update($query, array($status, $gid, $date, $time), $this->dbConn);
    }
    
    public function getCoachByCoachID($cID){
        $query = "select * from coachMaster where coachID = ?";
        $valArr = $this->dbobj->select($query, array($cID), $this->dbConn);
        return $valArr[0];
    }
    
    public function getCoachesByGid($gid){
        $query = "select * from coachMaster where GID = ?";
        $valArr = $this->dbobj->select($query, array($gid), $this->dbConn);
        return $valArr;
    }
    
    public function getLearnSlotPrice($gid, $coachId){
        $query = "select coachFee from coachMaster  where GID = ? AND coachID = ?";
        $valArr = $this->dbobj->select($query, array($gid, $coachId), $this->dbConn);
        if(isset($valArr[0])){
            return $valArr[0];
        }else{
            return "not_available";
        }
    }
    
    public function checkUserExistByEmail($email){
        $query = "select count(1) as count from webUserMaster wum where wum.Email = ?;";
        $valArr = $this->dbobj->select($query, array($email), $this->dbConn);
        return $valArr[0]['count'];
    }
    
    function checkAlreadyBookedLearnNPlay($gid, $userID, $date, $slottime){
        $query = "select count(1) as count from paidLearnGolfCourseBook where GID = ? AND User_ID = ? AND date(dateOfPlay) = ? AND slotOfPlay = ?";
        $valArr = $this->dbobj->select($query, array($gid, $userID, $date,  $slottime), $this->dbConn);
        return $valArr[0]['count'];
    }
    
    public function bookPayNLearnSlot($gid, $userID, $tempDate, $time, $tot_amt, $coachId){
        $book_status = "pending";
        $pay_status = "payment pending";
        $query = "INSERT INTO paidLearnGolfCourseBook (GID, USER_ID, dateRequest, dateOfPlay, slotOfPlay, totAmount, bookingStatus, payStatus, coachID) VALUES (?, ?, now(), ?, ?, ?, ?, ?, ?)";
        $valArr = $this->dbobj->insert($query, array($gid, $userID, $tempDate, $time, $tot_amt, $book_status, $pay_status, $coachId), $this->dbConn);
        return $valArr;
    }
    
    function getPayNLearnBookingDetails($booking_ID){
        $query = "select wum.Fname, wum.Lname, wum.Login_Name,gcm.GCName, wum.Email, gcm.City, DATE(pgcb.dateOfPlay) as dateOfPlay, pgcb.slotOfPlay, pgcb.BookID, pgcb.GID from paidLearnGolfCourseBook pgcb, webUserMaster wum, golfCourseMaster gcm where BookID = ? AND pgcb.User_ID = wum.User_ID AND pgcb.GID =gcm.GID";
        $valArr = $this->dbobj->select($query, array($booking_ID), $this->dbConn);
        return $valArr[0];
    }
    
    function updateLearnBookingAndPaymentStatus($book_ID, $booking_status, $paymentStatus){
        $book_status = $booking_status;
        $pay_status = $paymentStatus;
        $query = "UPDATE paidLearnGolfCourseBook set bookingStatus = ?, payStatus = ? WHERE BookID = ? ";
        return $this->dbobj->update($query, array( $book_status, $pay_status, $book_ID), $this->dbConn);
    }
    
     function getDetailsForLearnPayment($book_id){
        $query = "select totAmount, GID from paidLearnGolfCourseBook where BookID = ?";
        $valArr = $this->dbobj->select($query, array($book_id), $this->dbConn);
        return $valArr[0];
    }
    
    
    public function getPapPalLOgById($trasaction_id){
        $query = "select * from paypal_log WHERE txn_id = ?;";
        $valArr = $this->select($query, array($trasaction_id), $this->dbConn);
        return $valArr;
    }
    
    public function insertPayPalLog($trasaction_id, $log_array){
        $query = "INSERT INTO paypal_log (txn_id, log, posted_date) VALUES (? , ?, now())";
        $valArr = $this->insert($query, array($trasaction_id, $log_array), $this->dbConn);
        return $valArr;
    }
    
    function updatePayPalLog($log_array, $trasaction_id){
        $query = "UPDATE paypal_log set log = ? WHERE txn_id = ?";
        return $this->update($query, array($log_array, $trasaction_id), $this->dbConn);
    }
	
    public function getUserComplGcList($userID) {
        $query = "select gcm.GID, gcm.GCName, gcm.City, gcm.CountryISO, gcm.CompAvl, gcm.PaidAvl, gcm.CoachingAvil, gcm.CoachingAvilPaid, gcm.payPlayMinDays, gcm.compPlayMinDays, gcm.Description from compGolfCourseBook cgc, golfCourseMaster gcm where gcm.isActive = 1 AND cgc.USER_ID = ? AND cgc.GID = gcm.GID group by cgc.GID";
        $valArr = $this->dbobj->select($query, array($userID), $this->dbConn);
        return $valArr;
    }
    
    public function getUserPaidGcList($userID) {
        $query = "select gcm.GID, gcm.GCName, gcm.City, gcm.CountryISO, gcm.CompAvl, gcm.PaidAvl, gcm.CoachingAvil, gcm.CoachingAvilPaid, gcm.payPlayMinDays, gcm.compPlayMinDays, gcm.Description from paidGolfCourseBook pgcb, golfCourseMaster gcm where gcm.isActive = 1 AND pgcb.USER_ID = ? AND pgcb.GID = gcm.GID group by pgcb.GID";
        $valArr = $this->dbobj->select($query, array($userID), $this->dbConn);
        return $valArr;
    }
    
    public function getUserCityGcList($userID) {
        $query = "select gcm.GID, gcm.GCName, gcm.City, gcm.CountryISO, gcm.CompAvl, gcm.PaidAvl, gcm.CoachingAvil, gcm.CoachingAvilPaid, gcm.payPlayMinDays, gcm.compPlayMinDays, gcm.Description from webUserMaster wum, golfCourseMaster gcm where gcm.isActive = 1 AND wum.USER_ID = ? AND wum.City Like gcm.City group by gcm.GID";
        $valArr = $this->dbobj->select($query, array($userID), $this->dbConn);
        return $valArr;
    }
    
    public function getAllGolfCoursesByFeatureRank() {
        $query = "select * from golfCourseMaster where isActive = 1 order by FeatureRanking LIMIT 12 ";
        $valArr = $this->dbobj->select($query, '', $this->dbConn);
        return $valArr;
    }
    
    public function getPayNPlaySlots($gid){
        $query = "select * from paidGolfCourseConfig where GID = ?";
        $valArr =  $this->dbobj->select($query, array($gid), $this->dbConn);
        return $valArr[0];
    }
    
    public function checkSlotExist($gid, $startDate, $slotTime){
        $query = "select count(1) as count from paidGolfCourseSlots where GID = ? AND Date = ? AND Time = ?";
        $valArr = $this->dbobj->select($query, array($gid, $startDate, $slotTime), $this->dbConn);
        return $valArr[0]['count'];
    }
    
    public function insertPayNPlaySlot($gid, $startDate, $slotTime, $listPrice, $ourPrice, $currencyISO){
        $status = 0;
        $query = "INSERT INTO paidGolfCourseSlots (GID, Date, Time, Status, listPrice, ourPrice, currencyISO) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $valArr = $this->dbobj->insert($query, array($gid, $startDate, $slotTime, $status, $listPrice, $ourPrice, $currencyISO), $this->dbConn);
        return $valArr;
    }
    
    function updatePayNPlaySlotFromScript($gid, $startDate, $slotTime, $listPrice, $ourPrice, $currencyISO){
        $query = "UPDATE `paidGolfCourseSlots` SET `currencyISO` = ?, `listPrice` = ?, `ourPrice` = ? WHERE (GID = ? AND Date = ? AND Time = ?)";
        return $this->dbobj->update($query, array($currencyISO, $listPrice, $ourPrice, $gid, $startDate, $slotTime), $this->dbConn);
    }
    
    public function checkCurrencyExist($currencyISO){
        $query = "select count(1) as count from convertCurrency where currencyISO = ?";
        $valArr = $this->dbobj->select($query, array($currencyISO), $this->dbConn);
        return $valArr[0]['count'];
    }
    
    public function insertCurrencyRate($currencyISO, $baseCurrency, $rate){
        $query = "INSERT INTO convertCurrency (CurrencyISO, BaseCurrency, Rate, DateTimeUpdated) VALUES (?, ?, ?, now())";
        $valArr = $this->dbobj->insert($query, array($currencyISO, $baseCurrency, $rate), $this->dbConn);
        return $valArr;
    }
    
    public function updateCurrencyRate($currencyISO, $baseCurrency, $rate){
        $query = "UPDATE convertCurrency set BaseCurrency = ?, Rate = ?, DateTimeUpdated = now() WHERE CurrencyISO = ?";
        return $this->dbobj->update($query, array($baseCurrency, $rate, $currencyISO), $this->dbConn);
    }
    
    
    public function getAdvtByPage($pageId, $countryCode){
        $query = "select * from advtEngine where locationPage = ? AND countryISO = ? ORDER BY viewCount";
        $valArr = $this->dbobj->select($query, array($pageId, $countryCode), $this->dbConn);
        return $valArr;
    }
    
    function updateAdvtViewCount($advtId, $countryCode){
        $query = "UPDATE advtEngine set viewCount = viewCount + 1 WHERE advtID = ? AND countryISO = ?";
        return $this->dbobj->update($query, array($advtId, $countryCode), $this->dbConn);
    }

    public function getCountryAll() {
        $query = "select * from countryList";
        $valArr = $this->dbobj->select($query, '', $this->dbConn);
		return $valArr;
    }
    public function getScorecardSchemaByGID($gid){
        $query = "select * from gcScorecardMaster where GID = ?";
        $valArr = $this->dbobj->select($query, array($gid), $this->dbConn);
        return $valArr;
    }
    
    public function removeAsciiCodeFromGlobalSearch($returnArr){
        foreach ($returnArr as $row=>&$value) {
            $value['id']      = Util::repalceNonAscii($value['id']);
            $value['name']     = Util::repalceNonAscii($value['name']);
            $value['url']        = Util::repalceNonAscii($value['url']);
        }
        return $returnArr;       
    }
    
    function updateDeclaredHandicap($user_ID, $handicap){
        $query = "UPDATE webUserMaster set declaredHandicap = ? WHERE User_ID = ? ";
        return $this->dbobj->update($query, array($handicap, $user_ID), $this->dbConn);
    }
    
    function updateUserProfileImage($url, $user_ID){
        $query = "UPDATE webUserMaster set usrProfileImgURL = ? WHERE User_ID = ?";
        return $this->dbobj->update($query, array($url, $user_ID), $this->dbConn);
    }
    
    public function saveMemberBooking($gid, $column, $slotID, $memberID, $status){
        $data = array("gid" => $gid, "column" => $column, "slotID" => $slotID, "memberID" => $memberID, "status" => $status );
        $data_string = http_build_query($data);
        $ch = curl_init(PLATEFORM_PATH.'golfcourse/saveMemberBooking');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $result = json_decode($result, 1);
        error_log(print_r($result, 1));
        if(isset($result['update'])){
            return $result['update'];
        }
        return 0;
    }
    
    public function getSlotDetails($gid, $slotID, $slotDate, $slotTime){
        $slotDate = $slotDate;
        $slotTime = $slotTime;
        $slotID = $slotID;
        $gid = $gid;
        $data = array("gid" => $gid, "slotDate" => $slotDate, "slotTime" => $slotTime, "slotID" => $slotID);
        $data_string = http_build_query($data);
        $ch = curl_init(PLATEFORM_PATH.'golfcourse/getSlotByID');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $result = json_decode($result, 1);
        return $result ;
    }
    
    public function getGCByCity($city, $gid) {
        $query = "select * from golfCourseMaster gcm where gcm.isActive = 1 AND GID != ? AND City Like '".$city."' group by gcm.GID";
        $valArr = $this->dbobj->select($query, array($gid), $this->dbConn);
        return $valArr;
    }
    
    public function sendMailWithAttachMent($subject, $body, $to, $attachment = NULL){
            $fromEmail = FROM_EMAIL_ID ;
            $defaultEmail = null;
            if($defaultEmail!=null){
                $fromEmail = $defaultEmail;
            }
            $mail = new PHPMailer();
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = SMTP_HOST;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = SMTP_AUTH;                               // Enable SMTP authentication
            $mail->Username = SMTP_USERNAME;              // SMTP username
            $mail->Password = SMTP_PASSWORD;                           // SMTP password
            $mail->SMTPSecure = SMTP_SECURE;                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = SMTP_PORT;                                    // TCP port to connect to
            $mail->From = $fromEmail;
            $mail->FromName = FROM_EMAIL_NAME;
            $mail->addReplyTo(SMTP_REPLY_EMAIL_ID, SMTP_REPLY_NAME);
            $mailCC =  explode(",", MAIL_CC);
            foreach($mailCC as $cc) {
                error_log(trim($cc));
                $mail->addCC(trim($cc));
            }
            if($attachment != null){
                $mail->addAttachment($attachment);
            }
            $mail->isHTML(true);  
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->addAddress($to); // Add a recipient
            $mail->send();
    }
    
    public function generateAndUploadPDF($pdfUploadLocation, $pdfName, $pdfContent) {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr'); 
        $html2pdf->writeHTML($pdfContent);
        $html2pdf->Output($pdfUploadLocation.$pdfName, "F");
    }
    
    public function getAllGolfCoursesForLastMinuteTeeTime() {
        $query = "select * from golfCourseMaster order by GCName";
        $valArr = $this->dbobj->select($query, '', $this->dbConn);
        return $valArr;
    }
}
