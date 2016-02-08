<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GOlfController
 *
 * @author fermion-ub-02
 */

use Aws\S3\S3Client;
require API_PATH.'/Models/aws-autoloader.php';


class GolfcourseController extends Controller {
    
    public $golfcourseObj = null;
    public $userObj = null;
    public $marketingObj = null;
    public $prodObj = null;
	//define("SeasonID", 1);
	//$SeasonID = '1';

    public function __construct($app) {
        $this->app = ($app instanceof Slim) ? $app : \Slim\Slim::getInstance();
        $request = $this->app->request();
        $this->data['body'] = json_decode($request->getBody(),true);
        $this->data['header'] = $headers = apache_request_headers();
        $this->navigatorObj = new Navigator();
//            $this->golfcourseObj = new Golfcourse(DB1);
//            $this->userObj =new User(DB1);
        $this->app->get('/', array($this, 'index'))->name('index');
//        $this->app->get('/testEmailAttachment', array($this, 'testEmailAttachment'))->name('testEmailAttachment');
		$this->app->post('/ccavRequestHandler.php', array($this, 'ccavRequestHandler'))->name('ccavRequestHandler');
        $this->app->post('/ccavResponseHandler.php', array($this, 'ccavResponseHandler'))->name('ccavResponseHandler');
        $this->app->get('/dataFrom.php', array($this, 'dataFrom'))->name('dataFrom');
		$this->app->get('/contact', array($this, 'contact'))->name('contact');
		$this->app->post('/contactemail', array($this, 'contactemail'))->name('contactemail');
		
        $this->app->post('/user/login/', array($this, 'userlogin'))->name('userlogin');
		$this->app->get('/user/userlogout/', array($this, 'userlogout'))->name('userlogout');
		$this->app->post('/user/saveUser/', array($this, 'saveUser'))->name('saveUser');
		$this->app->post('/user/saveUserFomQuizPage/', array($this, 'saveUserFomQuizPage'))->name('saveUserFomQuizPage');
        $this->app->post('/user/checkusernameexist/', array($this, 'checkuseremail'))->name('checkuseremail');
		$this->app->post('/user/checkusernameexistQuiz/', array($this, 'checkuseremailQuiz'))->name('checkuseremailQuiz');
        $this->app->get('/signup', array($this, 'signup'))->name('signup');
        $this->app->get('/playnow(/:gid)', array($this, 'playnow'))->name('playnow');
        $this->app->get('/golfcourse/searchGolfCourse/', array($this, 'getGcByName'))->name('getGcByName');
        $this->app->post('/golfcourse/getGolfCourseSlots/', array($this, 'getGolfCourseSlots'))->name('getGolfCourseSlots');
        $this->app->post('/golfcourse/bookComplSlot/', array($this, 'bookComplSlot'))->name('bookComplSlot');
        $this->app->get('/getaways', array($this, 'getaways'))->name('getaways');
        $this->app->post('/golfcourse/updatRateCard/', array($this, 'updatRateCard'))->name('updatRateCard');
        $this->app->get('/indiaMembership', array($this, 'indiaMembership'))->name('indiaMembership');
		$this->app->get('/AreMembership', array($this, 'AreMembership'))->name('AreMembership');
		$this->app->get('/SEAMembership', array($this, 'SEAMembership'))->name('SEAMembership');
		$this->app->get('/SGDMembership', array($this, 'SGDMembership'))->name('SGDMembership');
        $this->app->get('/learnGolf', array($this, 'learnGolf'))->name('learnGolf');
        $this->app->get('/learnInMembership', array($this, 'learnInMembership'))->name('learnInMembership');
        $this->app->get('/learnMeMembership', array($this, 'learnMeMembership'))->name('learnMeMembership');
        $this->app->get('/specialOffer', array($this, 'specialOffer'))->name('specialOffer');
        $this->app->get('/otto', array($this, 'otto'))->name('otto');
        $this->app->get('/aboutUs', array($this, 'aboutUs'))->name('aboutUs');
        $this->app->get('/inPAR', array($this, 'inPAR'))->name('inPAR');
        $this->app->get('/inBirdie', array($this, 'inBirdie'))->name('inBirdie');
        $this->app->get('/inEagle', array($this, 'inEagle'))->name('inEagle');
        $this->app->post('/golfcourse/bookPayNPlaySlot', array($this, 'bookPayNPlaySlot'))->name('bookPayNPlaySlot');
        $this->app->post('/golfcourse/getUserDetailsByBookingID', array($this, 'getUserDetailsByBookingID'))->name('getUserDetailsByBookingID');
        $this->app->post('/golfcourse/applyVoucher', array($this, 'applyVoucher'))->name('applyVoucher');
        $this->app->post('/paynplay/checkout', array($this, 'paynplayCheckout'))->name('paynplayCheckout');
        $this->app->post('/paynlearn/checkout', array($this, 'paynlearnCheckout'))->name('paynlearnCheckout');
        $this->app->post('/golfcourse/bookLearnComplSlot', array($this, 'bookLearnComplSlot'))->name('bookLearnComplSlot');
        $this->app->post('/paynplay/redirecturl', array($this, 'redirecturl'))->name('redirecturl');
        $this->app->post('/golfcourse/getCoachPriceByID', array($this, 'getCoachPriceByID'))->name('getCoachPriceByID');
        $this->app->post('/golfcourse/getCoaches', array($this, 'getCoaches'))->name('getCoaches');
        $this->app->post('/golfcourse/bookPayNLearnSlot', array($this, 'bookPayNLearnSlot'))->name('bookPayNLearnSlot');
        $this->app->post('/paynlearn/redirecturl', array($this, 'redirecturlLearn'))->name('redirecturlLearn');
        $this->app->post('/GPLprocessForm', array($this, 'GPLprocessForm'))->name('GPLprocessForm');
		$this->app->get('/GPL', array($this, 'GPL'))->name('GPL');
		$this->app->get('/GPL.php', array($this, 'GPL'))->name('GPL');
	    $this->app->post('/golfcourse/getLearnUserDetailsByBookingID', array($this, 'getLearnUserDetailsByBookingID'))->name('getLearnUserDetailsByBookingID');
        $this->app->post('/paynplay/paypal', array($this, 'paypal'))->name('paypal');
        $this->app->get('/user/login_new/', array($this, 'loginNew'))->name('loginNew');
        $this->app->get('/user/saveScoreCard/', array($this, 'saveScoreCard'))->name('saveScoreCard');
        $this->app->post('/user/forgetPassword/', array($this, 'forgetPassword'))->name('forgetPassword');
        $this->app->get('/user/profile/', array($this, 'profile'))->name('profile');
        $this->app->post('/user/scorecard/', array($this, 'scorecard'))->name('scorecard');
        $this->app->get('/user/userscorecard/', array($this, 'userscorecard'))->name('userscorecard');
        $this->app->post('/user/updateprofile', array($this, 'updateprofile'))->name('updateprofile');
        $this->app->post('/user/resetPassword', array($this, 'resetPassword'))->name('resetPassword');
        $this->app->get('/bookinghistory', array($this, 'bookinghistory'))->name('bookinghistory');
        $this->app->post('/user/checkEmailIDExist/', array($this, 'checkEmailIDExist'))->name('checkEmailIDExist');
		$this->app->get('/memberAlbatroos', array($this, 'memberAlbatroos'))->name('memberAlbatroos');
		$this->app->get('/memberBirdie', array($this, 'memberBirdie'))->name('memberBirdie');
		$this->app->get('/memberEagle', array($this, 'memberEagle'))->name('memberEagle');
		$this->app->get('/thankucontact', array($this, 'thankucontact'))->name('thankucontact');
		$this->app->get('/changePassword', array($this, 'changePassword'))->name('changePassword');
		$this->app->post('/basephp', array($this, 'basephp'))->name('basephp');
		$this->app->get('/comingSoon', array($this, 'comingSoon'))->name('comingSoon');
       	$this->app->post('/user/getScorecardSchemaByGc', array($this, 'getScorecardSchemaByGc'))->name('getScorecardSchemaByGc');
        $this->app->post('/user/saveuserscorecard', array($this, 'saveUserScorecard'))->name('saveUserScorecard');
		$this->app->get('/QuizStart', array($this, 'QuizStart'))->name('QuizStart');
		$this->app->post('/Quiz', array($this, 'Quiz'))->name('Quiz');
		$this->app->post('/Quiz2', array($this, 'Quiz2'))->name('Quiz2');
		$this->app->post('/Quiz3', array($this, 'Quiz3'))->name('Quiz3');
		$this->app->post('/Quiz4', array($this, 'Quiz4'))->name('Quiz4');
		$this->app->post('/FinalQuiz', array($this, 'FinalQuiz'))->name('FinalQuiz');
        $this->app->get('/golfcourse/getGlobalSearch/', array($this, 'getGlobalSearch'))->name('getGlobalSearch');
        $this->app->get('/glossary', array($this, 'glossary'))->name('glossary');
        $this->app->post('/user/saveDeclaredHandicap', array($this, 'saveDeclaredHandicap'))->name('saveDeclaredHandicap');
        $this->app->get('/test', array($this, 'test'))->name('test');
        $this->app->post('/test/uploadimage', array($this, 'testUploadimage'))->name('testUploadimage');
        $this->app->post('/user/uploadProfileImage', array($this, 'uploadProfileImage'))->name('uploadProfileImage');
        $this->app->get('/management', array($this, 'management'))->name('management');
        $this->app->get('/advisory', array($this, 'advisory'))->name('advisory');
        $this->app->get('/privacy', array($this, 'privacy'))->name('privacy');
        $this->app->get('/rcPolicy', array($this, 'rcPolicy'))->name('rcPolicy');
        $this->app->get('/pshipping', array($this, 'pshipping'))->name('pshipping');
        $this->app->post('/detailsdata', array($this, 'detailsdata'))->name('detailsdata');
        $this->app->post('/user/details', array($this, 'details'))->name('details');
        $this->app->post('/user/findISDcode', array($this, 'findISDcode'))->name('findISDcode');
        $this->app->get('/profileEdit', array($this, 'profileEdit'))->name('profileEdit');
        $this->app->post('/user/profileUpdate', array($this, 'profileUpdate'))->name('profileUpdate');
        $this->app->post('/golfcourse/getGCSlotsByDate', array($this, 'getGCSlotsByDate'))->name('getGCSlotsByDate');
		$this->app->get('/activateMail', array($this, 'activateMail'))->name('activateMail');
		$this->app->get('/gplseason', array($this, 'gplseason'))->name('gplseason');
		$this->app->post('/gplRegister', array($this, 'gplRegister'))->name('gplRegister');
		$this->app->post('/demo', array($this, 'demo'))->name('demo');
		$this->app->get('/demotpl', array($this, 'demotpl'))->name('demotpl');
		
		
		$app->get('/play-golf/:ISO', function ($ISO) {
            echo "Country is: $ISO!";
        })->name('ISO_BASED_CONTENT');

        $app->get('/play-golf/:ISO/:STATE', function ($ISO, $STATE) {

            echo "Country ISO is:" . $ISO;
            echo "STATE is:" . $STATE;
        
        })->name('STATE_BASED_CONTENT');


        $app->get('/play-golf/:ISO/:STATE/:gname', function ($ISO, $STATE, $GNAME) {
            
            $GNAME = strrchr($GNAME , '-');
            
            $GID = preg_replace('/[-]/', '', $GNAME);
            
            $golfCourse = new Golfcourse(DB1);

            $allInformation = $golfCourse->getGolfCourseByID($GID);

            $gcname = str_replace(" ", "-", $allInformation['GCName']);

            $full_GC_NAME = trim($gcname . "-" . $GID);

            $this->app->contentType('text/html; charset=utf-8');

            $this->app->render('playGolfNew.tpl.php', array('ISO' => $ISO, 'STATE' => $STATE, 'GID' => $GID, 'alldetail' => $allInformation, 'full_gc_name' => $full_GC_NAME));
        })->name('GOLF_COURSE_DETAIL_PAGE');
		
           $app->get('/play-golf/:ISO/:STATE/:gname(/:book)', function ($ISO, $STATE, $GNAME, $book) {
            $this->golfcourseObj = new Golfcourse(DB1);

            if ($book == 'book') {
                $GNAME = strrchr($GNAME, '-');

                $GID = preg_replace('/[-]/', '', $GNAME);
                
                $gcdetail = $this->golfcourseObj->getGolfCourseByID($GID);

                $minDaysToBook = isset($gcdetail['payPlayMinDays']) ? $gcdetail['payPlayMinDays'] : 0;
                
                $todayDate = date("Y-m-d", strtotime('+' . $minDaysToBook . ' days'));
                
                $days_available = INDIA_NO_OF_DAYS_DISPLAY_MAX_MMG;

                $later_date = date('Y-m-d', strtotime('+' . ($minDaysToBook + $days_available) . ' days'));
                
                $this->golfcourseObj = new Golfcourse(DB1);

                

                $slot_status = $this->slotStatusForDates($GID, $todayDate, $later_date);

                $slot_status_array = json_decode($slot_status);

                $gcdetail = $this->golfcourseObj->getGolfCourseByID($GID);



                $slot_status_array = json_decode($slot_status);

                $this->app->contentType('text/html; charset=utf-8');
                $this->app->render('courseBooking.tpl.php', array('gcdetail' => $gcdetail, 'slot_status' => $slot_status_array, 'gid' => $GID));
            }
            
        })->name('GOLF_COURSE_BOOK_PAGE');
        
	$this->app->get('/playGolfNew', array($this, 'playGolfNew'))->name('playGolfNew');	
	$this->app->get('/courseBooking', array($this, 'courseBooking'))->name('courseBooking');	
        
	$this->app->get('/lastMinuteGolfer', array($this, 'lastMinuteGolfer'))->name('lastMinuteGolfer');
        $this->app->get('/lastMinuteGolfer/:ISO/:STATE/:gname(/:book)', array($this, 'lastMinuteGolferForGID'))->name('lastMinuteGolferForGID');	
        $this->app->post('/golfcourse/getGCSlotsByDateForLastMinuteGolfer', array($this, 'getGCSlotsByDateForLastMinuteGolfer'))->name('getGCSlotsByDateForLastMinuteGolfer');
    }
     
	
	
	
	
	
	
	 public function gplRegister() {
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('gplRegister.tpl.php');
    }
	public function activateMailVerify($Email, $Card) {
      	
		$data = array("Email" => $Email, "Card" => $Card);
			$data_string = json_encode($data);
			$ch = curl_init();                    // initiate curl
			//echo "activateMail";
			//$url = "http://ottoadmin1.golflan.com/testMail"; // where you want to post data
			curl_setopt($ch, CURLOPT_URL,PLATEFORM_CHECKEMAIL_PATH.'VerifyEmailCard');
			curl_setopt($ch, CURLOPT_POST, true);  // tell curl you want to post something
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string); // define what you want to post
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
			$output = curl_exec ($ch); // execute

			curl_close ($ch); // close curl handle

			//var_dump($output); // show output
			//echo $output;
		return $output;
        
        
    }
	 public function demo() {
		  $user = new User(DB1);
		 if(isset($_POST['Name']))
		 {
			//echo $_POST['Name'];
			// echo $_POST['Mobile'];
			$date = $_POST['date'];
			$GCName = $_POST['GCName'];
			$Name = $_POST['Name'];
			$Mobile =  $_POST['Mobile'];
			$Email =  $_POST['Email'];
			$Card =  $_POST['Card'];
			 $SeasonID = '2';
			 if($Card == ''){
				
				 $Card = 0;
				 $newDate = date('Y-m-d', strtotime($date));
				$memberbook1 = $user->memberbook1($SeasonID, $Name, $Mobile, $Email, $Card, $newDate, $GCName);
				 $demomail = $this->demomail($Name, $Mobile, $Email, $Card, $newDate, $GCName);
				 //$demomail = $this->demomail($Name, $Mobile, $Email, $Card);
				 echo 1; 
			 
			 }else{
				 
				 $activateMailVerify = $this->activateMailVerify($Email, $Card);
				 if($activateMailVerify == 1)
				 {
					 $newDate = date('Y-m-d', strtotime($date));
					 $memberbook1 = $user->memberbook1($SeasonID, $Name, $Mobile, $Email, $Card, $newDate, $GCName);
					 $demomail = $this->demomail($Name, $Mobile, $Email, $Card, $newDate, $GCName);
					 //$demomail = $this->demomail($Name, $Mobile, $Email, $Card);
					echo 1; 
				 }else{

					echo 0; 

				 }
			 }
			 
			 
			 
		 }
		
		 
		 if(isset($_POST['Name1']))
		 {
			//echo $_POST['Name1'];
			// echo $_POST['Name'];
			$Name1 = $_POST['Name1'];
			$Mobile1 =  $_POST['Mobile1'];
			$Email1 =  $_POST['Email1'];
			$Card1 =  $_POST['Card1'];
			$date1 =  $_POST['date1'];
			$GCName1 =  $_POST['GCName1'];
			 
			$Name3 = $_POST['Name3'];
			$Mobile3 =  $_POST['Mobile3'];
			$Email3 =  $_POST['Email3'];
			 
			$Name4 = $_POST['Name4'];
			$Mobile4 =  $_POST['Mobile4'];
			$Email4 =  $_POST['Email4'];
			 $SeasonID = '2';
			//$Name2 = $_POST['Name2'];
			//$Mobile2 =  $_POST['Mobile2'];
			//$Email2 =  $_POST['Email2'];
			
			//$Name3 = $_POST['Name3'];
			//$Mobile3 =  $_POST['Mobile3'];
			//$Email3 =  $_POST['Email3'];
			 if($Card1 == ''){
				
				 $Card1 = 0;
					
				 $newDate = date('Y-m-d', strtotime($date1));
				 $memberbook1 = $user->memberbook1($SeasonID, $Name1, $Mobile1, $Email1, $Card1, $newDate, $GCName1);
				 $arr1 = $user->getParentID($Email1, $Card1);
				 $ParentID = $arr1[0]['Srno'];
				  
				 $memberbook1 = $user->memberbook2($SeasonID, $ParentID, $Name3, $Mobile3, $Email3, $Card1, $newDate, $GCName1);
				 $memberbook1 = $user->memberbook2($SeasonID, $ParentID, $Name4, $Mobile4, $Email4, $Card1, $newDate, $GCName1);
				
				 $demomail = $this->demomail($Name1, $Mobile1, $Email1, $Card1, $newDate, $GCName1);
				 $demomail = $this->demomail($Name3, $Mobile3, $Email3, $Card1, $newDate, $GCName1);
				 $demomail = $this->demomail($Name4, $Mobile4, $Email4, $Card1, $newDate, $GCName1);
				 echo 1; 
			 
			 }else{
				 
				 $activateMailVerify = $this->activateMailVerify($Email1, $Card1);

				 if($activateMailVerify == 1)
				 {
					 $newDate = date('Y-m-d', strtotime($date1));
					 $memberbook1 = $user->memberbook1($SeasonID, $Name1, $Mobile1, $Email1, $Card1, $newDate, $GCName1);
					 $arr1 = $user->getParentID($Email1, $Card1);
					 $ParentID = $arr1[0]['Srno'];
					 //$ParentID = '1'; 
					 $SeasonID = '2'; 
					 $memberbook1 = $user->memberbook2($SeasonID, $ParentID, $Name3, $Mobile3, $Email3, $Card1, $newDate, $GCName1);
					 $memberbook1 = $user->memberbook2($SeasonID, $ParentID, $Name4, $Mobile4, $Email4, $Card1, $newDate, $GCName1);
					 
					 $demomail = $this->demomail($Name1, $Mobile1, $Email1, $Card1, $newDate, $GCName1);
					 $demomail = $this->demomail($Name3, $Mobile3, $Email3, $Card1, $newDate, $GCName1);
					 $demomail = $this->demomail($Name4, $Mobile4, $Email4, $Card1, $newDate, $GCName1);
					 echo 1; 
				 }else{

					echo 0; 

				 }
				 
			 }
		 }
		 	 //$demomail = $this->demomail($Name, $Mobile, $Email, $Card);

		
    }
	
	public function demotpl(){
	
	$this->app->contentType('text/html; charset=utf-8');
    $this->app->render('demo.tpl.php');

}
	
	public function demomail($Name, $Mobile, $Email, $Card, $newDate, $GCName) {
		$BusinessId = '2';
		$TaskTypeId = '1';
		$MailTypeID = '0';
		$data_string = array("Name" => $Name, "Mobile" => $Mobile, "Email" => $Email, "Card" => $Card, "Date" => $newDate, "GCName" => $GCName);
        //$data_string = json_encode($data);
        $slot_status = $this->activateMail($BusinessId, $TaskTypeId, $MailTypeID, $data_string);
       
        }
 public function slotStatusForDates($gid, $curruntdate, $enddate) {
      
        $data = array("gid" => $gid, "curruntdate" => $curruntdate, "enddate" => $enddate);
        $data_string = json_encode($data);
        $ch = curl_init(PLATEFORM_PATH . 'golfcourse/slotStatusForDates');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        return $result;
        
    }
public function activateMail($BusinessId, $TaskTypeId, $MailTypeID, $data_string) {
      	
		$data = array("BusinessId" => $BusinessId, "TaskTypeId" => $TaskTypeId, "MailTypeID" => $MailTypeID);
		$result = array_merge($data,$data_string);
        $data1 = json_encode($result);
			$ch = curl_init();                    // initiate curl
			//echo "activateMail";
			//$url = "http://ottoadmin1.golflan.com/testMail"; // where you want to post data
			curl_setopt($ch, CURLOPT_URL,PLATEFORM_EMAIL_PATH.'/MailData');
			curl_setopt($ch, CURLOPT_POST, true);  // tell curl you want to post something
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data1); // define what you want to post
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
			$output = curl_exec ($ch); // execute

			curl_close ($ch); // close curl handle

			//var_dump($output); // show output
        
        
    }
	public function SignUpDataToMail($RegUserEmail, $RegisterUserName, $CountryISO) {
		$BusinessId = '1';
		$TaskTypeId = '1';
		$MailTypeID = '0';
		$data_string = array("RegUserEmail" => $RegUserEmail, "RegisterUserName" => $RegisterUserName, "CountryISO" => $CountryISO);
        //$data_string = json_encode($data);
        $slot_status = $this->activateMail($BusinessId, $TaskTypeId, $MailTypeID, $data_string);
       
        }
	public function ForgetPassDataToMail($EmailID, $Name, $RandomPassword) {
		$BusinessId = '1';
		$TaskTypeId = '2';
		$MailTypeID = '0';
		$data_string = array("EmailID" => $EmailID, "Name" => $Name, "RandomPassword" => $RandomPassword);
        //$data_string = json_encode($data);
        $slot_status = $this->activateMail($BusinessId, $TaskTypeId, $MailTypeID, $data_string);
       
        }
	public function compSlotBookDetail($EmailID,$FName, $LName, $CardNo, $GCName, $City, $CompPlayDate, $CardName)
	{
		$BusinessId = '1';
		$TaskTypeId = '3';
		$MailTypeID = '0';
		$data_string = array("EmailID" => $EmailID, "FName" => $FName, "LName" => $LName, "CardNo" => $CardNo, "GCName" => $GCName, "City" => $City, "CompPlayDate" => $CompPlayDate, "CardName" => $CardName);
        //$data_string = json_encode($data);
        $slot_status = $this->activateMail($BusinessId, $TaskTypeId, $MailTypeID, $data_string);
	}
    public function getGCSlotsByDate() {

        $returnArr = array();
        $returnArr['error'] = 0;
        if (!isset($_SESSION)) {
            session_start();
        }

        /* $memID = "";
          if (IS_VISITOR_BOOKING_ALLOWED == 1 && isset($_SESSION['login_as_visitor']) && $_SESSION['login_as_visitor'] == 1) {

          } else if (MEMBER_LOGIN_REQUIRED == 1) {
          if (isset($_SESSION['MemID']) && $_SESSION['MemID'] != "" && $_SESSION['MemID'] != null) {
          $memID = $_SESSION['MemID'];
          } else {
          $returnArr['error'] = 2;
          $returnArr['error_msg'] = "Login required.";
          echo json_encode($returnArr);
          exit;
          }
          } */

        $gid = isset($_POST['gid']) ? $_POST['gid'] : 11;
        $startdate = isset($_POST['startdate']) ? $_POST['startdate'] : '2015-12-30';
        $enddate = isset($_POST['enddate']) ? $_POST['enddate'] : '2015-12-30'; 

//        $data = array("gid" => 11, "startdate" => '2015-12-30', "enddate" => '2015-12-30');

        $data = array("gid" => $gid, "startdate" => $startdate, "enddate" => $enddate);
        $data_string = json_encode($data);

        $ch = curl_init(PLATEFORM_PATH . 'golfcourse/getGolfCourseSlotsNew');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        echo  $result;
        exit;
    }
    
    
    public function ccavRequestHandler() {
      
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('ccavRequestHandler.tpl.php');
      
          
      }
	  public function QuizStart() {
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('QuizStart.tpl.php');
      }
	
	public function Quiz() {
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('quiz.tpl.php');
      }
      
	public function glossary() {
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('glossary.tpl.php');
      }
	public function Quiz2() {
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('Quiz2.tpl.php');
      }
	public function gplseason() {
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('gplseason.tpl.php');
      }
	public function Quiz3() {
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('Quiz3.tpl.php');
      }
	public function Quiz4() {
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('Quiz4.tpl.php');
      }
		
	public function FinalQuiz() {
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('FinalQuiz.tpl.php');
      }

	
      
      public function ccavResponseHandler() {
          
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('ccavResponseHandler.tpl.php');
      
      }
      public function comingSoon() {
      
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('comingSoon.tpl.php');
      
          
      }

	 public function basephp(){
		
		$this->app->contentType('text/html; charset=utf-8');
        $this->app->render('basephp.tpl.php');
    }
	
      public function dataFrom() {
      
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('dataform.tpl.php');
      
      }
      
	public function thankucontact(){
		
		$this->app->contentType('text/html; charset=utf-8');
        $this->app->render('thankucontact.tpl.php');
    }
		 
    public function userlogout() {
      // header('Location: index.php');
       session_start();
       session_destroy();
       echo '1';
      }
	
	
	public function memberAlbatroos(){
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('memberAlbatroos.tpl.php');
    }
 
	public function memberBirdie(){
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('memberBirdie.tpl.php');
    }
 
	public function memberEagle(){
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('memberEagle.tpl.php');
    }
	
	public function GPL(){
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('GPL.tpl.php');
    }
	
	public function GPLprocessForm(){
		
		$this->app->contentType('text/html; charset=utf-8');
        $this->app->render('GPLprocessForm.tpl.php');
    }
	
	public function SEAMembership(){
		
		$this->app->contentType('text/html; charset=utf-8');
        $this->app->render('SEAMembership.tpl.php');
    }
	
	public function SGDMembership(){
		
		$this->app->contentType('text/html; charset=utf-8');
        $this->app->render('SGDMembership.tpl.php');
    }
    
	public function saveScoreCard(){
    
          if(!isset($_SESSION)){
                session_start();
            }
            $login_email = "";
            $login_id = "";
            if( isset( $_SESSION['login_id']) && $_SESSION['login_id'] != ""){
                $login_id = $_SESSION['login_id'];
            }
            if( isset($_SESSION['login_email']) && $_SESSION['login_email']!= ""){
                $login_email = $_SESSION['login_email'];
            }
            $returnArr =array();
            $returnArr["error"] = 0;
            $returnArr = array();
            $data = $_POST['data'];
            $email = $login_email;
            $gcID = $_POST['gcID'];
            $date_time_play = $_POST['scorecardDate'];
            $returnArr['error'] = 0;
            error_log("emai:--------- ".$email);
            $par = $data[0][20];
            $total = $data[4][20];
            $columnArr = array();
            for ($r = 0, $rlen = count($_POST['data']); $r < $rlen; $r++) {
                if ($r = 5){
                    error_log("test:---".$rlen);
                    for ($c = 1, $clen = count($_POST['data']['4']); $c < $clen; $c++) {
                        if($c >= 1  && $c <= 9 ){
                            $columnArr[$c] = $_POST['data']['4'][$c];
    //                        $returnArr = $this->golfObj->addScoreCard($c,$_POST['data']['1'][$c] );
                        } elseif ($c >= 12 && $c <= 20) {
                            $cc = $c - 1;
                            $holeNumber = $c - 2;
                            $columnArr[$holeNumber] = $_POST['data']['4'][$cc];
                        }
                    }
                           // $userDetail = $golfCourse->addScoreCard($c,$_POST['data']['2'][$c] );
                }
            }
            $date_time_play = date("Y-m-d H:i:s",  strtotime( $date_time_play));
            $returnArr1 = $golfCourse->addScoreCard($columnArr, $par, $total, $email, $login_id, $gcID, $date_time_play);
            $handArr = array();
            $handArr = $golfCourse->getUserAvgHandicap($login_id);
            error_log(print_r($handArr,1));
            $returnArr['handicap'] = round($handArr['handicap']);
            echo json_encode($returnArr);
        exit();
       
    }
	
	  public function scorecard() {
       $golfCourse = new Golfcourse(DB1);
       if(!isset($_SESSION)){
                session_start();
            }
            $login_email = "";
            $login_id = "";
            if( isset( $_SESSION['login_id']) && $_SESSION['login_id'] != ""){
                $login_id = $_SESSION['login_id'];
            }
            if( isset($_SESSION['login_email']) && $_SESSION['login_email']!= ""){
                $login_email = $_SESSION['login_email'];
            }
            $returnArr =array();
            $returnArr["error"] = 0;
            $returnArr = array();
            $data = $_POST['data'];
            $email = $login_email;
            $gcID = $_POST['gcID'];
            $date_time_play = $_POST['scorecardDate'];
            $returnArr['error'] = 0;
            error_log("emai:--------- ".$email);
            $par = $data[0][20];
            $total = $data[4][20];
            $columnArr = array();
            for ($r = 0, $rlen = count($_POST['data']); $r < $rlen; $r++) {
                if ($r = 5){
                    error_log("test:---".$rlen);
                    for ($c = 1, $clen = count($_POST['data']['4']); $c < $clen; $c++) {
                        if($c >= 1  && $c <= 9 ){
                            $columnArr[$c] = $_POST['data']['4'][$c];
    //                        $returnArr = $this->golfObj->addScoreCard($c,$_POST['data']['1'][$c] );
                        } elseif ($c >= 12 && $c <= 20) {
                            $cc = $c - 1;
                            $holeNumber = $c - 2;
                            $columnArr[$holeNumber] = $_POST['data']['4'][$cc];
                        }
                    }
                           // $userDetail = $golfCourse->addScoreCard($c,$_POST['data']['2'][$c] );
                }
            }
            $date_time_play = date("Y-m-d H:i:s",  strtotime( $date_time_play));
            $returnArr1 = $golfCourse->addScoreCard($columnArr, $par, $total, $email, $login_id, $gcID, $date_time_play);
            $handArr = array();
            $handArr = $golfCourse->getUserAvgHandicap($login_id);
            error_log(print_r($handArr,1));
            $returnArr['handicap'] = round($handArr['handicap']);
            echo json_encode($returnArr);
        exit();
      
    }

   public function userscorecard() {

        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('scorecard.tpl.php');
    }
    

	public function checkEmailIDExist () {
        
          $user = new User(DB1);
          $exist = $user->checkEmailIDExist($_POST['user_email']);
            if($exist == 0){
                echo "true";
            }else{
                echo "false";
            }
            exit;
        
    }
	
	public function checkuseremailQuiz() {
        
        $user_email = $_POST['user_emailQuiz'];
        $WholeQuizID = $_POST['WholeQuizID'];
        //$this->userObj = new User(DB1);
        $user = new User(DB1);
        $exist = $user->checkEmailIDExistQuizByQuizID($user_email,$WholeQuizID);
        if ($exist == 0) {
            echo "true";
        } else {
            echo "false";
        }
     }
    
    public function bookinghistory () {
        
      $this->app->contentType('text/html; charset=utf-8');
      $this->app->render('bookinghistory.tpl.php');
        
    }
    
	
	public function forgetPassword() {
        $user = new User(DB1);

        //-------- MAIL --------
        $mail = new PHPMailer();
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = SMTP_HOST;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = SMTP_AUTH;                               // Enable SMTP authentication
        $mail->Username = SMTP_USERNAME;              // SMTP username
        $mail->Password = SMTP_PASSWORD;                           // SMTP password
        $mail->SMTPSecure = SMTP_SECURE;                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = SMTP_PORT;                                    // TCP port to connect to
        $mail->From = FROM_EMAIL_ID;
        $mail->FromName = FROM_EMAIL_NAME;
        $mail->addReplyTo(SMTP_REPLY_EMAIL_ID, SMTP_REPLY_NAME);
        $mailCC = explode(",", MAIL_CC);
        foreach ($mailCC as $cc) {
            $mail->addCC(trim($cc));
        }
        
        $mail->isHTML(true);           // Set email format to HTML

        $returnArr = array();
        $returnArr['error'] = 0;
        //error_log(print_r($_POST,1));
        $emailID = $_POST['email'];
        $exist = $user->checkEmailIDExist($emailID);
        if ($exist == 0) {
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "This email-id does not exist.";
            echo json_encode($returnArr);
            exit;
        }
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 12; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        $randomPassword = implode($pass); //turn the array into a string
        $updateId = $user->updateUserPassword($emailID, $randomPassword);
        $userDetails = $user->getUserDetailsByEmail($emailID);
        $name = $userDetails['FName'] . ' ' . $userDetails['LName'];
        //error_log(print_r($updateId,1));
        //error_log(print_r($randomPassword,1));
        $mail->clearAllRecipients();
        $ForgetPassDataToMail = $this->ForgetPassDataToMail($emailID, $name, $randomPassword);
		/*
        $mail->Subject = "Golflan Reset password";
        $mail->Body = "<h3>Hi " . $name . ",</h3><br>
                    You recently requested a password reset.Below is the new password, please reset it immedeately after successfull login to keep your account safe.</h3><br>
                    <h4>New Password : " . $randomPassword . "<h4>";
        $mail->addAddress($emailID, $emailID); // Add a recipient
        $mail->send();
		*/
        echo json_encode($returnArr);
        exit;
    }
	
	 public function loginNew() {

        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('login.tpl.php');
    }

	public function resetPassword() {
        $user = new User(DB1);
        $returnArr = array();
        $returnArr['error'] = 0;

        if (!isset($_SESSION)) {
            session_start();
        }
        $oldPassword = $_POST['old_password'];
        $newPassword = $_POST['new_password'];
        $login_email = $_SESSION['login_email'];
        $login_id = $_SESSION['login_id'];

        $exist = $user->checkUserIsValid($login_email, $oldPassword);

        if ($exist == 0) {
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Invalid old Password.";
            echo json_encode($returnArr);
            exit;
        }
        $user->updateUserPassword($login_email, $newPassword);
        echo json_encode($returnArr);
        exit;
    }

	 public function updateprofile() {

        $user = new User(DB1);
        $returnArr = array();
        $returnArr['error'] = 0;
        if (!isset($_SESSION)) {
            session_start();
        }
        $user_ID = $_SESSION['login_id'];

        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $contact = $_POST['contact'];
        $updated = $user->updateUserDetailsByID($fname, $lname, $contact, $user_ID);
        echo json_encode($returnArr);
        exit;
    }
	
    public function profile() {
        if (!isset($_SESSION)) {
            session_start();
        }
        $user_ID = isset($_SESSION['login_id']) ? $_SESSION['login_id'] : 0;
        if($user_ID == 0){
            $this->app->contentType('text/html; charset=utf-8');
            $this->app->render('home.tpl.php');
        }else{
            $this->app->contentType('text/html; charset=utf-8');
            $this->app->render('profile.tpl.php');
        }
    }
        
    public function userlogin() {
      
            $product = new Product(DB1);
            $user = new User(DB1);
           
            $returnArr = array();
            $returnArr['error'] = 0;
            
            $email = $_POST['user_email'];
            $password = $_POST['password'];
            
           
            $exist = $user->checkUserIsValid($email, $password);

            if($exist == 0){
                $returnArr['error'] = 1;
                $returnArr['error_msg'] = "Invalid Email-ID or Password.";
                echo json_encode($returnArr);exit;
            }
            
            $userDetails = $user->getUserDetailsByEmail($email);

            if(!isset($_SESSION)){
                session_start();
            }
            
            $_SESSION['login_id'] = $userDetails['User_ID'];
            $_SESSION['login_email'] = $userDetails['Email'];
            $_SESSION['fname'] = $userDetails['FName'];
            $_SESSION['lname'] = $userDetails['LName'];
            $_SESSION['CardNo'] = $userDetails['CardNo'];
            
            $returnArr['login_email'] = $userDetails['Email'];
            $returnArr['name'] = $userDetails['FName'] . " " .$userDetails['LName'];
             if(!isset($_SESSION)){
                session_start();
            }
            
            $sesssionID = session_id();
            $product->updateProShopCartSessionIdToUserId($sesssionID, $userDetails['User_ID']);
            echo json_encode($returnArr);
            exit;
    }
     
    public function checkuseremail() {
        
        $user_email = $_POST['user_email'];
        $this->userObj = new User(DB1);
        $exist = $this->userObj->checkEmailIDExist($user_email);
        if($exist == 0){
                echo "true";
            }else{
                echo "false";
            }
     }
     
	 public function saveUserFomQuizPage() {
     
         $user = new User(DB1);

        //-------- MAIL --------
        $mail = new PHPMailer();
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = SMTP_HOST;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = SMTP_AUTH;                               // Enable SMTP authentication
        $mail->Username = SMTP_USERNAME;              // SMTP username
        $mail->Password = SMTP_PASSWORD;                           // SMTP password
        $mail->SMTPSecure = SMTP_SECURE;                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = SMTP_PORT;                                    // TCP port to connect to
        $mail->From = FROM_EMAIL_ID;
        $mail->FromName = FROM_EMAIL_NAME;
        $mail->addReplyTo(SMTP_REPLY_EMAIL_ID, SMTP_REPLY_NAME);
        $mailCC = explode(",", MAIL_CC);
        foreach ($mailCC as $cc) {
            $mail->addCC(trim($cc));
        }

        $mail->isHTML(true);       
       
        $returnArr = array();
        $returnArr['error'] = 0;

        $marketing = new Marketing();

        $returnArr = array();
        $returnArr["error"] = 0;
        
        $emailQuiz = $_POST['email'];
        $firstnamequiztaker = $_POST['firstnamequiztaker'];
        $lastnamequiztaker = $_POST['lastnamequiztaker'];
        $country_listquiztaker = $_POST['country_listquiztaker'];
        $mobilequiztaker = $_POST['mobilequiztaker'];

        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 12; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        $randomPassword = implode($pass);

        $register_id = $user->registertUser($firstnamequiztaker, $lastnamequiztaker, $mobilequiztaker, $emailQuiz, $randomPassword, $country_listquiztaker);

        $marketing->checkIsCampaign("User registered.");
        
        $mail->clearAllRecipients();
        $mail->Subject = "Your GolfLan login details";
        $mail->Body = "<h4>Dear " . $firstnamequiztaker . ",</h4><br>
					Welcome to GolfLan.com<br><br>
                    Thank you for registering on GolfLan.com, a platform for golfers & all their golfing needs. Our vision is to make golf more accessible, affordable & exciting globally.<br>
					You can use the below password along with your Email-id to login to your GolfLan account.<br><br>
                    <h4>Password : " . $randomPassword . "</h4><br><br>
					We suggest that you change your password from ‘Change Password’ section after logging in for the first time.<br><br>
					Looking forward to bringing you a golfing delight during the course of our relationship.<br><br><br>
					Regards,<br>
					Team GolfLan";
        $mail->addAddress($emailQuiz, $emailQuiz); // Add a recipient
        $mail->send();

        echo json_encode($returnArr);
        exit;
    }

    public function saveUser() {
     $marketing = new Marketing();
    
     $returnArr =array();
            $returnArr["error"] = 0;
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $contact = $_POST['contact'];
            $user_email = $_POST['user_email'];
            $password = $_POST['password'];
            $country = $_POST['country_list'];
            //$this->userObj = new Golfcourse(DB1);
            $this->userObj = new User(DB1);
            
            $register_id = $this->userObj->registertUser($fname, $lname, $contact, $user_email, $password, $country);            
//$register_id = $user->registertUser($fname, $lname, $contact, $user_email, $password);
            
            $marketing->checkIsCampaign("User registered.");
            //$marketing->checkIsCampaign("User registered.");
            if(isset($_POST['during_checkout'])){
                if(!isset($_SESSION)){
                    session_start();
                }
                $_SESSION['login_id'] = $register_id;
                $_SESSION['login_email'] = $user_email;
                if(!isset($_SESSION)){
                    session_start();
                }
            }
            echo json_encode($returnArr);exit;
           
    }
	
    public function signup(){
       
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('signup.tpl.php');
        
    } 

    public function index(){
        $advtArr['pageID'] = 1; //home
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('home.tpl.php', array('advtArr' => $advtArr));
    }
	 public function inEagle(){
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('inEagle.tpl.php');
    }
	
	 public function inPAR(){
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('inPAR.tpl.php');
    }
	
	public function inBirdie(){
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('inBirdie.tpl.php');
    }
    
    public function contact(){
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('contact.tpl.php');
    }
	
	public function contactemail(){
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('contactemail.tpl.php');
    }
	
	 public function getaways(){
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('getaways.tpl.php');
    }
	public function indiaMembership(){
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('indiaMembership.tpl.php');
    }
	
   public function AreMembership() {

        $this->app->contentType('text/html; charset=utf-8');

        $this->app->render('AREMembership.tpl.php');
    }
	
	 public function learnGolf(){
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('learnGolf.tpl.php');
    }
	public function learnInMembership(){
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('learnInMembership.tpl.php');
    }
	
    public function learnMeMembership(){
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('learnMeMembership.tpl.php');
    }
	
	public function specialOffer(){
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('specialOffer.tpl.php');
    }
    
    public function playnow($gid = 0){
        $this->golfcourseObj = new Golfcourse(DB1);
        $gcArr = array();
        if($gid > 0){
            $gcArr  = $this->golfcourseObj->getGolfCourseByID($gid);
        }
        $returnArr['gcArr'] = $gcArr;
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('playnow.tpl.php', array('dataArr' => $returnArr));
    }
	public function otto(){
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('otto.tpl.php');
    }
	public function aboutUs(){
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('aboutUs.tpl.php');
    }
    
    public function getGcByName(){
        $name = $_GET['term'];
       $this->golfcourseObj = new Golfcourse(DB1);
       $returnArr =  $this->golfcourseObj->getGolfCourses($name);
        foreach ($returnArr as &$value) {
            $src = IMG_WEB_PATH.'/GCImages/'.$value['GID'].'.jpg';
            $value['ImgURL_new'] = $src;
            if (file_exists(IMG_DEPLOY_PATH.'/GCImages/'.$value['GID'].'a.jpg')) {
                $src = IMG_WEB_PATH.'/GCImages/'.$value['GID'].'a.jpg';
                $value['ImgURL_new'] = $src;
            }
        }
        header("Content-type: application/json");
        $returnArr = $this->golfcourseObj->removeAsciiCode($returnArr);
        echo json_encode($returnArr);
        exit;
    }
    
    public function getGolfCourseSlots(){
        $this->golfcourseObj = new Golfcourse(DB1);
        $returnArr =array();
        $returnArr["error"] = 0;
        $gid = $_POST['gid'];
        $availDays = array();
        $tentaviveAvailDays = array();
        $availTime = array();
        $availDays["1970-01-01"] = "08:00";
        $tentaviveAvailDays["1970-01-01"] = "08:00";
        //-------------------------- NEW ----------------------------------
        $payNPlaySlots = $this->golfcourseObj->getPayNPlaySlotsByGid($gid);
        $availTime = array();
        $timeOfSlot = "";
        foreach ($payNPlaySlots as $payNPlaySlot) {
            $timeOfSlot = $payNPlaySlot['Time'];
            $tempDate = date("Y-m-d",  strtotime( $payNPlaySlot['Date']));
            $aDate = explode('-', $tempDate);
            $aDate[1] = ltrim($aDate[1], '0');
            $aDate[2] = ltrim($aDate[2], '0');
            $date = implode('-', $aDate);
            //------ No of days required to book ------
            $current_date = new DateTime(date('Y-m-d'));
            $end_date = new DateTime($date);
            $interval = $current_date->diff($end_date);
            $daysToGo = $interval->format('%a');
            $weekend = null;
            if( (date("w", strtotime($date)) == 0) || (date("w", strtotime($date)) == 6)){
               $weekend = true; 
            }else{
               $weekend = false; 
            }
                if( (($weekend && $daysToGo >= INDIA_NO_OF_DAYS_ADVANCE_WEEKEND_MMG) || (!$weekend && $daysToGo >= INDIA_NO_OF_DAYS_ADVANCE_WEEKDAY_MMG)) && ($daysToGo < INDIA_NO_OF_DAYS_DISPLAY_MAX_MMG)){
                    $aDate = explode('-', $date);
                    $aDate[1] = ltrim($aDate[1], '0');
                    $aDate[2] = ltrim($aDate[2], '0');
                    $date = implode('-', $aDate);
                    if($payNPlaySlot['Status'] == 5){
                         $tentaviveAvailDays[$date][]= $timeOfSlot;
                    }
                    $availDays[$date][]= $timeOfSlot;


                }else{
                }
        }
         array_push($availTime, $timeOfSlot);
        $returnArr["avail_days"] = $availDays;
        $returnArr["tentative_avail_days"] = $tentaviveAvailDays;
        $returnArr["avail_time"] = $availTime;
        echo json_encode($returnArr);exit;
    }
    
    function bookComplSlot(){
        $this->userObj =new User(DB1);
        $this->golfcourseObj = new Golfcourse(DB1);
        $this->marketingObj = new Marketing(DB2);
        $returnArr =array();
        $returnArr["error"] = 0;
        $gid = $_POST['comp_gid'];
        $email = $_POST['email'];
        $cardNo = $_POST['card_number'];
        $exist = $this->userObj->checkUserExist($email, $cardNo);
//            error_log(print_r($_POST,1));
        $tempDate = $_POST['comp_play_date'];
        $tempDate = str_replace("/","-",$tempDate); 
        $timestamp = strtotime($tempDate);
        $tempDate = date('Y-m-d', $timestamp);
        if($exist == 0){
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Invalid Email address or Card Number. \n Please Enter valid card details.";
            echo json_encode($returnArr);exit;
        }
        $userDetails = $this->userObj->getUserDetails($email, $cardNo);
//            error_log(print_r($userDetails,1));
        $cardValidity = $this->userObj->checkCardValidity($userDetails['User_ID'], $cardNo);
        if($cardValidity == 0){
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Your card's validity has been Expired.";
            echo json_encode($returnArr);exit;
        }
//            error_log(print_r($cardValidity,1));
        $slotTime = $_POST['comp_play_time'];
        $dayNum = date('N', strtotime( $tempDate));
//            error_log(print_r("Day : ".$dayNum,1));
        $email = $_POST['email'];
        $card_number = $_POST['card_number'];
//            error_log(print_r($_POST,1));
        $gcArr = $this->golfcourseObj->getGolfCourseByID($gid);
//            error_log(print_r($gcArr,1));
        $holeType = $gcArr['HoleType'];
//            error_log(print_r($holeType,1));
        $day = "";
        if($dayNum >= 1 && $dayNum<=5){
            $day = "Weekday";
        }elseif($dayNum >= 6 && $dayNum <= 7){
            $day = "Weekend";
        }
        $priceName = "";
        if($holeType == 9){
            $priceName = "9Hole".$day; 
        }else if($holeType == 18){
            $priceName = "18Hole".$day;
        }
//            error_log(print_r("Price name = ".$priceName,1));
        $slotPrice = $this->golfcourseObj->getSlotPricebyPriceName($gid, $priceName);
        $avail = 0;
//            error_log(print_r($slotPrice,1));
        if($slotPrice == "not_available" || CHECK_ONLY_COMP_GAMES_INDIA){
//                error_log(print_r("here comp games",1));
            $avail = $this->golfcourseObj->checkSlotAvail($userDetails['User_ID'], "AvlCompGames");
        }else{
            $slotType = "";
            if($slotPrice>INDIA_PremiumAndRegular && $slotPrice<=INDIA_TrophyPrice){
                $slotType = "AvlPNRGames";
            }else if($slotPrice >INDIA_TrophyPrice && $slotPrice<=INDIA_TrophyPlusPrice){
                $slotType = "AvlTrophyGames";
            }else{
                $slotType ="AvlTrophyPGames";
            }
            $avail = $this->golfcourseObj->checkSlotAvail($userDetails['User_ID'], $slotType);
        }
//            error_log(print_r("Slot Price = ".$slotPrice,1));
//            error_log(print_r("Slot Type = ".$slotType,1));
//            error_log(print_r("Available = ".$avail,1));
        if($avail == 1){
//                error_log(print_r("Date of Play  = ".date("Y-m-d",  strtotime( $tempDate)),1));
            $checkBooking = $this->golfcourseObj->checkAlreadyBooked($gcArr['GID'], $userDetails['User_ID'], $userDetails['CardNo'], date("Y-m-d",  strtotime( $tempDate)));
//                error_log(print_r("Already booked = ".$checkBooking,1));
            if($checkBooking == 1){
                $returnArr['error'] = 1;
                $returnArr['error_msg'] = "Slot is already requested by you.";
                echo json_encode($returnArr);exit;
            }
            $bookSlot = $this->golfcourseObj->bookSlot($gcArr['GID'], $userDetails['User_ID'], $userDetails['CardNo'], $tempDate, $slotTime);
//                error_log(print_r("Booking slot = ".$bookSlot,1));
//                $updateAail = $golfCourse->updateAvailGames($slotType, $userDetails['User_ID'], $userDetails['CardNo']);
            //--- Send email ---
			/*workable code starts here for EGC BOOKing
			$compSlotBookDetail = $this->compSlotBookDetail($userDetails['Email'],$userDetails['FName'], $userDetails['LName'], $userDetails['CardNo'], $gcArr['GCName'], $gcArr['City'], $_POST['comp_play_date'], $userDetails['CardName']);
     		workable code ends here for EGC BOOKing
			hide Starts here*/
	      	$to = $userDetails['Email'];
            $subject = "Complimentry booking receieved from ".$userDetails['FName']." ".$userDetails['LName']." Card Number ".$userDetails['CardNo'];
            $txt = "Dear ".$userDetails['FName'].",

            A new complimentary slot request has been received! - Reference ID : GFTTBOOK_1552714408

            UserID : ".$userDetails['User_ID']."
            User Name : ".$userDetails['FName']." ".$userDetails['LName']."
            User Email : ".$userDetails['Email']."
            Course Name - ".$gcArr['GCName'].", ".$gcArr['City']."
            Date and Time - ".$_POST['comp_play_date']."
            Golfer Card Type - ".$userDetails['CardName']." 
            Card Number - ".$userDetails['CardNo']."

            Thank You
            Happy Golfing!
            Admin Support, GolfLan
            Connecting Golfers Worldwide";
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: ".FROM_EMAIL_ID. "\r\n" .
            "CC: ".MAIL_CC;
            // ------ HTML TEMPLATE -------------
            $emailTxt= '<html>'.
            '<head>'.
            '<title>GolfLAN - Connecting Golfer\'s Worldwide</title>'.

            '<style>
                    img{
                    border:0px;
                    }
            </style>
            </head>'.

            '<body style="height: 100%;max-width: 650px;width: 100%;">'.

            '<div id="main" style="background:url("'.IMG_EMAIL_WEB_PATH.'/Email_Template/bg.jpg");border-radius: 5px;width: 90%;padding: 0 0 20px;font-family: "Lato";">'.

                    '<div id="header" style="padding: 0px 10% 6%;">'.

                            '<img src="'.IMG_EMAIL_WEB_PATH.'/Email_Template/logo.png" style="float:left;" width="45%" /> '.

                            '<p style="float:right;margin: 75px 12px 0;">'.
                                '<a href="http://www.golflan.com/"><img src="'.IMG_EMAIL_WEB_PATH.'/Email_Template/home-icon.png" width="17"/></a>'.
                                    '&nbsp;&nbsp;'.
                                    '<a href="http://www.golflan.com/Home/Login/"><img src="'.IMG_EMAIL_WEB_PATH.'/Email_Template/login-icon.png" width="17" /></a>'.
                            '</p>

                    </div>

                    <br/>

                    <div id="content-container" style="background-color: #FFFFFF !important;border: 1px solid #d4d2d2;border-radius: 5px;margin: 0px auto;width: 80%;margin-bottom: -20px;">

                            <div id="content" style="padding: 0 20px 10px;">

                                    <br /><br />
                        <p style="font-size:14px;font-weight:bold;margin-top:20px;">Dear Golfer, </p>

                                    <hr/>

                                    <p style="font-size:14px;">Your request for a complimentary slot has been received!<br/><br/>

                                    We would like to inform you that we have successfully received your complimentary slot request. Your request reference ID is '.$bookSlot.' and it is under process. <br /><br />

                        You requested a complimentary slot for '.$gcArr['GCName'].", ".$gcArr['City'].' for teeing off on '.$_POST['comp_play_date'].' at '.$slotTime.'. We will email you when it is confirmed.<br /><br /> 

                        If you need any assistance or have any questions, feel free to contact us by emailing us at <a href="mailto:customer.care@GolfLAN.com">customer.care@GolfLAN.com</a> or call us at 1800-208-7899.

                        We\'ll keep you posted!<br /><br />

                                    Happy Golfing!<br/><br/>			

                                    Team GolfLAN<br />
                        India\'s Leading Online Golf Consulting Company

                                    </p>



                            </div>

                    </div>

                    <br/>

                    <div id="footer" style="width:80%;margin-left:10%;padding-bottom:3%;font-size:14px;color:#fff;">

                            <p style="float:left;color: #000;">All Bookings powered by OTTO, &copy; GolfLAN.com</p>

                            <p style="float:right"><a href="https://www.facebook.com/GOLFLAN"><img src="'.IMG_EMAIL_WEB_PATH.'/Email_Template/fb.png" /></a>&nbsp;&nbsp;<a href="https://twitter.com/golflan2014"><img src="'.IMG_EMAIL_WEB_PATH.'/Email_Template/tw.png" /></p>

                    </div>

            </div>

            </body>

            </html>';
//                mail($to, $subject, $emailTxt, $headers);
//            $mail->Subject = $subject;
//            $mail->Body    = $emailTxt;
//            $mail->addAddress($to, $userDetails['FName']." ".$userDetails['LName']); // Add a recipient
//            $mail->send();
       /* hide ends here */    
            $this->golfcourseObj->sendMail($subject, $emailTxt, $to);
            $this->marketingObj->checkIsCampaign("Play now Complimentary Booking.");
            echo json_encode($returnArr);exit;
        }else{
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "You have no slots aviailable for this category.";
            echo json_encode($returnArr);exit;
        }
        exit;
    }
    
    function updatRateCard(){
        $this->golfcourseObj = new Golfcourse(DB1);
        $returnArr =array();
        $returnArr["error"] = 0;
        $gid = $_POST['pay_gid'];
        if($gid == ""){
            $returnArr['error'] = 0;
            $returnArr['error_msg'] = "Please select Golf course..";
            echo json_encode($returnArr);exit;
        }
        $tempDate = $_POST['pay_play_date'];
        $tempDate = str_replace("/","-",$tempDate);
        $playTime = $_POST['pay_play_time'];
        $timestamp = strtotime($tempDate);
        $playDate = date('Y-m-d', $timestamp);
        $dayNum = date('N', strtotime( $tempDate));
        $slotPrice = $this->golfcourseObj->getSlotPrice($gid, $playDate, $playTime);
        if($slotPrice == "not_available"){
            $returnArr["error"] = 1;
            $returnArr["error_msg"] = "Not available";
            echo json_encode($returnArr);exit;
        }
        $returnArr["price_indian"] = round($slotPrice['ourPrice']);
        $returnArr["list_price_indian"] = round($slotPrice['listPrice']);
        $currencyIcon = "";
        if($slotPrice['currencyIcon'] !="" && $slotPrice['currencyIcon']!=null){
            $currencyIcon = '<i class="fa '.$slotPrice["currencyIcon"].'" style="color: black"></i>';
        }else{
            $currencyIcon = $slotPrice['currencyISO'];
        }
        $returnArr['currencyIcon'] = $currencyIcon;
        //----
        $slotPrice = $this->golfcourseObj->getSlotPrice($gid, $playDate, $playTime);
        $returnArr["price_expat"] = round($slotPrice['ourPrice']);
        $returnArr["list_price_expat"] = round($slotPrice['listPrice']);
        echo json_encode($returnArr);exit;
    }
    
    function bookPayNPlaySlot(){
        $this->golfcourseObj = new Golfcourse(DB1);
        $this->userObj =new User(DB1);
        $returnArr =array();
        $returnArr["error"] = 0;
        $gid = $_POST['pay_gid'];
        $holeType = isset($_POST['hole_type']) ? $_POST['hole_type'] : 18;
        if($gid == ""){
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Please select Golf course..";
            echo json_encode($returnArr);exit;
        }
        $playerDetails = array();
        $i = 0;
        foreach ($_POST['PlayerName'] as $name) {
            $playerDetails[$i]['name'] = $name;
            $i++;
        }
        $i = 0;
        foreach ($_POST['PlayerPhone'] as $phone) {
            $playerDetails[$i]['phone'] = $phone;
            $i++;
        }
        $i = 0;
        foreach ($_POST['PlayerEmail'] as $email) {
            $playerDetails[$i]['email'] = $email;
            $i++;
        }
//            error_log(print_r($playerDetails,1));
//        $noOfPlayers = count($playerDetails);
        $noOfPlayers = isset($_POST['pay_booking_count']) ? $_POST['pay_booking_count'] :0;
        $slotID = isset($_POST['pay_slotID']) ? $_POST['pay_slotID'] : 0;
        if($noOfPlayers == 0){
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Sorry, temporarily unable to book slot.";
            echo json_encode($returnArr);exit;
        }
        $tempDate = $_POST['pay_play_date'];
        $tempDate = str_replace("/","-",$tempDate);
        if($tempDate == null || $tempDate==""){
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Please select date.";
            echo json_encode($returnArr);exit;
        }
        $timestamp = strtotime($tempDate);
        $playDate = date('Y-m-d', $timestamp);
        $slotTime = $_POST['pay_play_time'];
        if($slotTime == null || $slotTime==""){
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Please select time.";
            echo json_encode($returnArr);exit;
        }
        $name = $playerDetails[0]['name'];
        $contact = $playerDetails[0]['phone'];
        $email = $playerDetails[0]['email'];
        $tot_amt = isset($_POST['total_amt']) ? $_POST['total_amt'] : 0;
        //------ get amount from DB -------
        $dayNum = date('N', strtotime( $tempDate));
        $day = "";
        if($dayNum >= 1 && $dayNum<=5){
            $day = "Weekday";
        }elseif($dayNum >= 6 && $dayNum <= 7){
            $day = "Weekend";
        }
        $priceName = "";
        if($holeType == 9){
            $priceName = "9Hole".$day;
        }else if($holeType == 18){
            $priceName = "18Hole".$day;
        }else{
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Sorry, temporarily unable to book slot.";
            echo json_encode($returnArr);exit;
        }
//        $slotPrice = $this->golfcourseObj->getSlotPrice($gid, $playDate, $slotTime);
        $gcDetails = $this->golfcourseObj->getGolfCourseByID($gid);
        $CurrencyISO  = isset($gcDetails['CurrencyISO']) ? $gcDetails['CurrencyISO']: '';
        $currencyIcon = isset($gcDetails['currencyIcon']) ? $gcDetails['currencyIcon']: '';
        $slotArr = $this->golfcourseObj->getSlotDetails($gid, $slotID, $playDate, $slotTime);
        error_log(print_r($slotArr,1));
        $memberPrice = isset($slotArr['slot']['golflanPrice_18']) ? $slotArr['slot']['golflanPrice_18']: 0;
        error_log('while saving daata');
//        error_log(print_r($slotPrice,1));
        if($memberPrice > 0){
            $tot_amt = round($memberPrice) * $noOfPlayers;
        }else{
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Sorry,temporarily unable to book slot.";
            echo json_encode($returnArr);exit;
        } 
        //
//            error_log(print_r($_POST,1));
        $exist = $this->userObj->checkUserExistByEmail($email);
//            error_log(print_r("user = ".$exist,1));
        $userID ="";
        if($exist == 0){
            $userID = $this->userObj->insertUser($name, $email, $contact);
        }else{
            $userID = $this->userObj->getUserIdByEmail($email);
            $userDetails = $this->userObj->getUserDetailsByEmail($email);
            if($userDetails['Mobile']== NULL || $userDetails['Mobile']==""){
                $this->userObj->updateUserDetailsByID($userDetails['FName'], $userDetails['LName'], $contact, $userID);
            }
        }
        $time = date("H:i:s",strtotime($tempDate));
        $checkBooking = $this->golfcourseObj->checkAlreadyBookedPayNPlay($gid, $userID, date("Y-m-d", strtotime($tempDate)), $time);
        if($checkBooking == 1){
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Slot is already booked by you.";
            echo json_encode($returnArr);exit;
        }
//            error_log(print_r($time,1));
        $book_ID = $this->golfcourseObj->bookPayNPlaySlot($slotID, $gid, $userID, $playDate, $slotTime, $tot_amt, $CurrencyISO, $currencyIcon);
//            error_log(print_r($book_ID,1));
        $count = 0;
        $query ="";
//        foreach ($playerDetails as $player) {
        for ($index = 0; $index < $noOfPlayers; $index++) {
            
            if($count >0){
                $fourBallID = $this->golfcourseObj->insertFourBall($book_ID, $playerDetails[0]['name'],  $playerDetails[0]['email'], $playerDetails[0]['phone'], $userID);
                if($query != ""){
                    $query.=", ";
                }
                $query.= "fourBall".$count."ID = ".$fourBallID;
            }
            $count++;
        }
//        }
        if($query != ""){
             $this->golfcourseObj->updateFourBallIDs($book_ID, $query);
        }
        $userDetails = $this->userObj->getUserDetailsByEmail($email);
        $gcArr = $this->golfcourseObj->getGolfCourseByID($gid);
        //--- Send email ---
        $to = $email;
        $subject = "Pay and Play booking received from ".$userDetails['FName'];
        $txt = "Dear ".$userDetails['FName'].",

        A new complimentary slot request has been received! - Reference ID : GFTTBOOK_1552714408

        UserID : ".$userDetails['User_ID']."
        User Name : ".$userDetails['FName']." ".$userDetails['LName']."
        User Email : ".$userDetails['Email']."
        Course Name - ".$gcArr['GCName'].", ".$gcArr['City']."
        Date and Time - ".$_POST['pay_play_date']."

        Thank You
        Happy Golfing!
        Admin Support, GolfLan
        Connecting Golfers Worldwide";
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: ".FROM_EMAIL_ID. "\r\n" .
        "CC: ".MAIL_CC;
        // ------ HTML TEMPLATE -------------
        $emailTxt= '<html>'.
        '<head>'.
        '<title>GolfLAN - Connecting Golfer\'s Worldwide</title>'.

        '<style>
                img{
                border:0px;
                }
        </style>
        </head>'.

        '<body style="height: 100%;max-width: 650px;width: 100%;">'.

        '<div id="main" style="background:url("'.IMG_EMAIL_WEB_PATH.'/images/Email_Template/bg.jpg");border-radius: 5px;width: 90%;padding: 0 0 20px;font-family: "Lato";">'.

                '<div id="header" style="padding: 0px 10% 6%;">'.

                        '<img src="'.IMG_EMAIL_WEB_PATH.'/images/Email_Template/logo.png" style="float:left;" width="45%" /> '.

                        '<p style="float:right;margin: 75px 12px 0;">'.
                            '<a href="http://www.golflan.com/"><img src="'.IMG_EMAIL_WEB_PATH.'/images/Email_Template/home-icon.png" width="17"/></a>'.
                                '&nbsp;&nbsp;'.
                                '<a href="http://www.golflan.com/Home/Login/"><img src="'.IMG_EMAIL_WEB_PATH.'/images/Email_Template/login-icon.png" width="17" /></a>'.
                        '</p>

                </div>

                <br/>

                <div id="content-container" style="background-color: #FFFFFF !important;border: 1px solid #d4d2d2;border-radius: 5px;margin: 0px auto;width: 80%;margin-bottom: -20px;">

                        <div id="content" style="padding: 0 20px 10px;">

                                <br /><br />
                    <p style="font-size:14px;font-weight:bold;margin-top:20px;">Dear Golfer, </p>

                                <hr/>

                                <p style="font-size:14px;">Your request for a Pay and Play slot has been received!<br/><br/>

                                We would like to inform you that your we have successfully received your Pay and Play slot request. Your request reference ID is '.$book_ID.' is confirmed. <br /><br />

                    You requested a Pay and Play slot for '.$gcArr['GCName'].", ".$gcArr['City'].' for teeing off on '.$_POST['pay_play_date'].' at '.$slotTime.'.<br /><br /> 

                    If you need any assistance or have any questions, feel free to contact us by emailing us at <a href="mailto:customer.care@GolfLAN.com">customer.care@GolfLAN.com</a> or call us at 1800-208-7899.

                                Happy Golfing!<br/><br/>			

                                Team GolfLAN<br />
                    India\'s Leading Online Golf Consulting Company

                                </p>



                        </div>

                </div>

                <br/>

                <div id="footer" style="width:80%;margin-left:10%;padding-bottom:3%;font-size:14px;color:#fff;">

                        <p style="float:left;color: #000;">&copy; GolfLAN.com</p>

                        <p style="float:right"><a href="https://www.facebook.com/GOLFLAN"><img src="'.IMG_EMAIL_WEB_PATH.'/images/Email_Template/fb.png" /></a>&nbsp;&nbsp;<a href="https://twitter.com/golflan2014"><img src="'.IMG_EMAIL_WEB_PATH.'/images/Email_Template/tw.png" /></p>

                </div>

        </div>

        </body>

        </html>';
        //-----------------------------------
        //mail($to,$subject,$emailTxt,$headers);
        $returnArr['book_ID'] = $book_ID;
        echo json_encode($returnArr);exit;
    }
    
    function getUserDetailsByBookingID(){
        $this->golfcourseObj = new Golfcourse(DB1);
        $this->userObj =new User(DB1);
        $returnArr =array();
        $returnArr["error"] = 0;
        $returnArr["error_msg"] = 0;
        $bookingID = $_POST['bookingID'];
        $userDetails = $this->userObj->getUserDetailsByBookingID($bookingID);
        $gid = isset($userDetails['GID']) ? $userDetails['GID'] : 0;
        $gcDetails = $this->golfcourseObj->getGolfCourseByID($gid);
        
        $count = 1;
        if(isset($userDetails['fourBall1ID']) && $userDetails['fourBall1ID']!= null && $userDetails['fourBall1ID']!="" && $userDetails['fourBall1ID'] != 0){
            $count++;
        }
        if(isset($userDetails['fourBall2ID']) && $userDetails['fourBall2ID']!= null && $userDetails['fourBall2ID']!="" && $userDetails['fourBall2ID'] != 0){
            $count++;
        }
        if(isset($userDetails['fourBall3ID']) && isset($userDetails['fourBall3ID'])!= null && isset($userDetails['fourBall3ID'])!="" && $userDetails['fourBall3ID'] != 0){
            $count++;
        }
        $perPlayer = isset($userDetails['totAmount']) ? ($userDetails['totAmount'] / $count) : 0;
        
        $userDetails['totAmount'] = round($userDetails['totAmount']);
        $returnArr['gcDetails'] =  $this->golfcourseObj->removeAsciiCodeFromGCDetails($gcDetails);
        $returnArr['user'] = $userDetails;
        $returnArr['golfers_count'] = $count;
        $returnArr['per_player'] = $perPlayer;
        error_log(print_r($returnArr,1));
        echo json_encode($returnArr);exit;
    }
    
    function applyVoucher(){
        $this->golfcourseObj = new Golfcourse(DB1);
        $this->userObj =new User(DB1);
        $returnArr =array();
        $returnArr["error"] = 0;
        $voucherCode = $_POST['voucher-code'];
        $gid = $_POST['voucher_gid'];
        $gcDetails = $this->golfcourseObj->getGolfCourseByID($gid);
        $countryCode = $gcDetails['CountryISO'];
        $orderID = $_POST['Order_Id'];
        $bookType = isset($_POST['book_type']) ? $_POST['book_type']: "";
        $returnArr['voucher_description'] = "";
        $userDetails = array();
        if($bookType == ""){
            $userDetails = $this->userObj->getUserDetailsByBookingID($orderID);
        }else{
            $userDetails = $this->userObj->getLearnUserDetailsByBookingID($orderID);
        }
        $totAmt = isset($userDetails['totAmount']) ? $userDetails['totAmount'] : 0;
        $amountAfterVoucher = $totAmt;
        $returnArr['revised_amount'] = $amountAfterVoucher;
//            error_log(print_r("---------- Golflan Voucher functionlaity ----------",1));
//            error_log(print_r($_POST, 1));
        $isValid = $this->golfcourseObj->checkVoucher($voucherCode, $countryCode);
        if($isValid == 0){
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Invalid voucher code.";
            echo json_encode($returnArr);exit;
        }
        $currDate = date('d-m-Y H:i:s');
        $voucherDetails = $this->golfcourseObj->getVoucherDetails($voucherCode, $countryCode);
        
         // Is voucher is applicable on MMG i.e ( LobApplicable == 1 ) or Booking is learn
        if ($voucherDetails['LobApplicable'] != 1 || $bookType !=""){
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Invalid voucher code.";
            echo json_encode($returnArr);
            exit;
        }
        
        $issuedDate = $voucherDetails['issuedDate'];
        $expiryDate = $voucherDetails['expiaryDate'];
        $issuedDate = date('d-m-Y H:i:s', strtotime($issuedDate));
        $expiryDate =  date('d-m-Y H:i:s', strtotime($expiryDate));
//            error_log(print_r($voucherDetails,1));
//            error_log(print_r("currDate = ".$currDate,1));
//            error_log(print_r("issuedDate = ".$issuedDate,1));
//            error_log(print_r("expiryDate = ".$expiryDate,1));
        $orderIDForVouchere = '';
        if($bookType == ""){
            $orderIDForVouchere = MMG_ORDER_NO_PREFIX.$orderID;
        }else{
            $orderIDForVouchere = MMG_LEARN_ORDER_NO_PREFIX.$orderID;
        }
        $used = $this->golfcourseObj->checkVoucherAlreadyApplied($orderIDForVouchere);
        if($used > 0){
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "This voucher is already reedemed by you.";
            echo json_encode($returnArr);exit;
        }
        if ((strtotime($currDate) <= strtotime($issuedDate)) || (strtotime($currDate) >= strtotime($expiryDate))){
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "This voucher has expired.";
            echo json_encode($returnArr);exit;
        }
        if($voucherDetails['numTimesAllowed'] == $voucherDetails['numTimesUsed']){
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Sorry, This voucher has been used maximum number of times.";
            echo json_encode($returnArr);exit;
        }
        if(( ($voucherDetails['GIDApplicable'] != VOUCHER_APPLICABLE_TO_ALL_GOLFCOURSES) && ($voucherDetails['GIDApplicable'] != $gid))){
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "This voucher is not applicable for this Golf Course.";
            echo json_encode($returnArr);exit;
        }
        if(isset($voucherDetails['voucherType']) && isset($voucherDetails['Amount'])){
            if($voucherDetails['voucherType'] == 0){
                $returnArr['voucher_description'] = ' - '. $voucherDetails['Amount'];
                $amountAfterVoucher = $amountAfterVoucher - $voucherDetails['Amount'];
            }else if($voucherDetails['voucherType'] == 1){
                $returnArr['voucher_description'] = ' - '.(($amountAfterVoucher * $voucherDetails['Amount'])/100);
                $amountAfterVoucher = $amountAfterVoucher -(($amountAfterVoucher * $voucherDetails['Amount'])/100);
            }
        }
//            error_log(print_r("amountAfterVoucher = ".$amountAfterVoucher,1));
        if($amountAfterVoucher < 1){
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Sorry, Voucher cannot be applied as voucher discount is more than actual amount payable.";
            echo json_encode($returnArr);exit;
         }
        if($amountAfterVoucher < 0){
            $amountAfterVoucher = 0;
        }
        $returnArr['revised_amount'] = round($amountAfterVoucher);
        $returnArr['error_msg'] = "Voucher applied successfully .";
        $voucherrID = $voucherDetails['voucherID'];
        $voucherrNumber = $voucherDetails['VoucherNumber'];
        $this->golfcourseObj->updateVoucher($voucherrID);
        if($bookType == ""){
            $this->golfcourseObj->insertVoucherTrans($voucherrID, MMG_ORDER_NO_PREFIX.$orderID, $voucherrNumber, $userDetails['Email'], $countryCode);
            $this->golfcourseObj->updatePayNPLayVoucherDetails($orderID, $voucherrID, $voucherrNumber, $returnArr['revised_amount']);
        }else{
            $this->golfcourseObj->insertVoucherTrans($voucherrID, MMG_LEARN_ORDER_NO_PREFIX.$orderID, $voucherrNumber, $userDetails['Email'], $countryCode);
            $this->golfcourseObj->updatePayNLearnVoucherDetails($orderID, $voucherrID, $voucherrNumber, $returnArr['revised_amount']);
        }
        echo json_encode($returnArr);exit;
    }
    
    function paynplayCheckout(){
        $this->golfcourseObj = new Golfcourse(DB1);
        $book_id = $_POST['Order_Id']; 
        $paymentArr =  $this->golfcourseObj->getDetailsForPayment($book_id);
        $gid = $paymentArr['GID'];
        $currencyISO = $paymentArr['currencyISO'];
        $exchangeArr = $this->golfcourseObj->getExchangeRate($currencyISO);
        $gcArray = $this->golfcourseObj->getGolfCourseByID($gid);
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('Checkout.tpl.php',array('paymentArr' => $paymentArr,'gcArray' =>$gcArray, 'exchangeArr'=> $exchangeArr));
    }
    function redirecturl(){
        $this->golfcourseObj = new Golfcourse(DB1);
        $this->userObj =new User(DB1);
        $this->marketingObj = new Marketing(DB2);
        $Order_Id = $_POST["Order_Id"];
        $dbOrder_Id = (int) str_replace(MMG_ORDER_NO_PREFIX, '', $Order_Id);
        $bookingDetails = $this->golfcourseObj->getPayNPlayBookingDetails($dbOrder_Id);
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('redirecturl.tpl.php',array('bookingDetails' => $bookingDetails));
    }
    
    function bookLearnComplSlot(){
        $this->golfcourseObj = new Golfcourse(DB1);
        $this->userObj =new User(DB1);
        $this->marketingObj = new Marketing(DB2);
        $returnArr =array();
        $returnArr["error"] = 0;
        $gid = $_POST['comp_gid'];
        $email = $_POST['email'];
        $cardNo = $_POST['card_number'];
        $exist = $this->userObj->checkUserExist($email, $cardNo);
//            error_log(print_r($_POST,1));
        if($exist == 0){
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Invalid Email address or Card Number. \n Please Enter valid card details.";
            echo json_encode($returnArr);exit;
        }
        $userDetails = $this->userObj->getUserDetails($email, $cardNo);
//            error_log(print_r($userDetails,1));
        $cardValidity = $this->userObj->checkCardValidity($userDetails['User_ID'], $cardNo);
        if($cardValidity == 0){
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Your card's validity has been Expired.";
            echo json_encode($returnArr);exit;
        }
//            error_log(print_r($cardValidity,1));
        $tempDate = $_POST['comp_play_date'];
        $tempDate = str_replace("/","-",$tempDate);
        $timestamp = strtotime($tempDate);
        $tempDate = date('Y-m-d', $timestamp);
        $slotTime = $_POST['comp_play_time'];
        $dayNum = date('N', strtotime( $tempDate));
//            error_log(print_r("Day : ".$dayNum,1));
        $email = $_POST['email'];
        $card_number = $_POST['card_number'];
//            error_log(print_r($_POST,1));
        $gcArr = $this->golfcourseObj->getGolfCourseByID($gid);
//            error_log(print_r($gcArr,1));
        $holeType = $gcArr['HoleType'];
//            error_log(print_r($holeType,1));
        $day = "";
        if($dayNum >= 1 && $dayNum<=5){
            $day = "Weekday";
        }elseif($dayNum >= 6 && $dayNum <= 7){
            $day = "Weekend";
        }
        $priceName = "";
        if($holeType == 9){
            $priceName = "9Hole".$day; 
        }else if($holeType == 18){
            $priceName = "18Hole".$day;
        }
//            error_log(print_r("Price name = ".$priceName,1));
        $slotPrice = $this->golfcourseObj->getSlotPricebyPriceName($gid, $priceName);
        $avail = 0;
//            error_log(print_r($slotPrice,1));
        if($slotPrice == "not_available" || CHECK_ONLY_COMP_GAMES_INDIA){
//                error_log(print_r("here comp games",1));
            $avail = $this->golfcourseObj->checkSlotAvail($userDetails['User_ID'], "AvlCompGames");
        }else{
            $slotType = "";
            if($slotPrice>INDIA_PremiumAndRegular && $slotPrice<=INDIA_TrophyPrice){
                $slotType = "AvlPNRGames";
            }else if($slotPrice >INDIA_TrophyPrice && $slotPrice<=INDIA_TrophyPlusPrice){
                $slotType = "AvlTrophyGames";
            }else{
                $slotType ="AvlTrophyPGames";
            }
            $avail = $this->golfcourseObj->checkSlotAvail($userDetails['User_ID'], $slotType);
        }
//            error_log(print_r("Slot Price = ".$slotPrice,1));
//            error_log(print_r("Slot Type = ".$slotType,1));
//            error_log(print_r("Available = ".$avail,1));
        if($avail == 1){
//                error_log(print_r("Date of Play  = ".date("Y-m-d",  strtotime( $tempDate)),1));
            $checkBooking = $this->golfcourseObj->checkLearnAlreadyBooked($gcArr['GID'], $userDetails['User_ID'], $userDetails['CardNo'], date("Y-m-d",  strtotime( $tempDate)));
//                error_log(print_r("Already booked = ".$checkBooking,1));
            if($checkBooking == 1){
                $returnArr['error'] = 1;
                $returnArr['error_msg'] = "Slot is already requested by you.";
                echo json_encode($returnArr);exit;
            }
            $bookSlot = $this->golfcourseObj->bookLearnSlot($gcArr['GID'], $userDetails['User_ID'], $userDetails['CardNo'], $tempDate, $slotTime);
//                error_log(print_r("Booking slot = ".$bookSlot,1));
//                $updateAail = $golfCourse->updateAvailGames($slotType, $userDetails['User_ID'], $userDetails['CardNo']);
            //--- Send email ---
            $to = $userDetails['Email'];
            $subject = " Complimentry Learn booking receieved from ".$userDetails['FName']." ".$userDetails['LName']." Card Number ".$userDetails['CardNo'];
            $txt = "Dear ".$userDetails['FName'].",

            A new complimentary Learn slot request has been received! - Reference ID : GFTTBOOK_1552714408

            UserID : ".$userDetails['User_ID']."
            User Name : ".$userDetails['FName']." ".$userDetails['LName']."
            User Email : ".$userDetails['Email']."
            Course Name - ".$gcArr['GCName'].", ".$gcArr['City']."
            Date and Time - ".$_POST['comp_play_date']."
            Golfer Card Type - ".$userDetails['CardName']." 
            Card Number - ".$userDetails['CardNo']."

            Thank You
            Happy Golfing!
            Admin Support, GolfLan
            Connecting Golfers Worldwide";
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: ".FROM_EMAIL_ID. "\r\n" .
            "CC: ".MAIL_CC;
            // ------ HTML TEMPLATE -------------
            $emailTxt= '<html>'.
            '<head>'.
            '<title>GolfLAN - Connecting Golfer\'s Worldwide</title>'.

            '<style>
                    img{
                    border:0px;
                    }
            </style>
            </head>'.

            '<body style="height: 100%;max-width: 650px;width: 100%;">'.

            '<div id="main" style="background:url("'.IMG_EMAIL_WEB_PATH.'/Email_Template/bg.jpg");border-radius: 5px;width: 90%;padding: 0 0 20px;font-family: "Lato";">'.

                    '<div id="header" style="padding: 0px 10% 6%;">'.

                            '<img src="'.IMG_EMAIL_WEB_PATH.'/Email_Template/logo.png" style="float:left;" width="45%" /> '.

                            '<p style="float:right;margin: 75px 12px 0;">'.
                                '<a href="http://www.golflan.com/"><img src="'.IMG_EMAIL_WEB_PATH.'/Email_Template/home-icon.png" width="17"/></a>'.
                                    '&nbsp;&nbsp;'.
                                    '<a href="http://www.golflan.com/Home/Login/"><img src="'.IMG_EMAIL_WEB_PATH.'/Email_Template/login-icon.png" width="17" /></a>'.
                            '</p>

                    </div>

                    <br/>

                    <div id="content-container" style="background-color: #FFFFFF !important;border: 1px solid #d4d2d2;border-radius: 5px;margin: 0px auto;width: 80%;margin-bottom: -20px;">

                            <div id="content" style="padding: 0 20px 10px;">

                                    <br /><br />
                        <p style="font-size:14px;font-weight:bold;margin-top:20px;">Dear Golfer, </p>

                                    <hr/>

                                    <p style="font-size:14px;">Your request for a complimentary Learn slot has been received!<br/><br/>

                                    We would like to inform you that we have successfully received your complimentary Learn slot request. Your request reference ID is '.$bookSlot.' and it is under process. <br /><br />

                        You requested a complimentary Learn slot for '.$gcArr['GCName'].", ".$gcArr['City'].' for a learning session on '.$_POST['comp_play_date'].' at '.$slotTime.'. We will email you when it is confirmed.<br /><br /> 

                        If you need any assistance or have any questions, feel free to contact us by emailing us at <a href="mailto:customer.care@GolfLAN.com">customer.care@GolfLAN.com</a> or call us at 1800-208-7899.

                        We\'ll keep you posted!<br /><br />

                                    Happy Golfing!<br/><br/>			

                                    Team GolfLAN<br />
                        India\'s Leading Online Golf Consulting Company

                                    </p>



                            </div>

                    </div>

                    <br/>

                    <div id="footer" style="width:80%;margin-left:10%;padding-bottom:3%;font-size:14px;color:#fff;">

                            <p style="float:left;color: #000;">All Bookings powered by OTTO, &copy; GolfLAN.com</p>

                            <p style="float:right"><a href="https://www.facebook.com/GOLFLAN"><img src="'.IMG_EMAIL_WEB_PATH.'/Email_Template/fb.png" /></a>&nbsp;&nbsp;<a href="https://twitter.com/golflan2014"><img src="'.IMG_EMAIL_WEB_PATH.'/Email_Template/tw.png" /></p>

                    </div>

            </div>

            </body>

            </html>';
//                mail($to, $subject, $emailTxt, $headers);
//            $mail->Subject = $subject;
//            $mail->Body    = $emailTxt;
//            $mail->addAddress($to, $userDetails['FName']." ".$userDetails['LName']); // Add a recipient
//            $mail->send();
            $this->golfcourseObj->sendMail($subject, $emailTxt, $to);
            $this->marketingObj->checkIsCampaign("Learn now Complimentary Booking.");
            echo json_encode($returnArr);exit;
        }else{
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "You have no slots aviailable for this category.";
            echo json_encode($returnArr);exit;
        }
    }
    
    function getCoachPriceByID(){
        $this->golfcourseObj = new Golfcourse(DB1);
        $returnArr =array();
        $returnArr["error"] = 0;
        $coachID =($_POST['coachID'] != "" && $_POST['coachID'] != null) ? $_POST['coachID'] : "";
        if($coachID == ""){
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Sorry,temporarily unable to book slot.";
            echo json_encode($returnArr);exit;
        }
        $coachArr = $this->golfcourseObj->getCoachByCoachID($coachID);
        $coachArr['coachFee'] = round($coachArr['coachFee']);
        $returnArr['coach'] = $coachArr;
        echo json_encode($returnArr);exit;
    }
    
    function getCoaches(){
        $this->golfcourseObj = new Golfcourse(DB1);
        $returnArr =array();
        $returnArr["error"] = 0;
        $gid =($_POST['gid'] != "" && $_POST['gid'] != null) ? $_POST['gid'] : "";
        if($gid == ""){
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Sorry,temporarily unable to book slot.";
            echo json_encode($returnArr);exit;
        }
        $coachesArr = $this->golfcourseObj->getCoachesByGid($gid);
        $returnArr['coaches'] = $coachesArr;
        echo json_encode($returnArr);exit;
    }
    
    function bookPayNLearnSlot(){
        $this->golfcourseObj = new Golfcourse(DB1);
        $this->userObj =new User(DB1);
        $returnArr =array();
        $returnArr["error"] = 0;
            error_log(print_r("---------- book pay and playy ----------",1));
            error_log(print_r($_POST,1));
        $gid = $_POST['pay_gid'];
        $holeType = isset($_POST['hole_type']) ? $_POST['hole_type'] : 18;
        $coachId = $_POST['avail_coaches'];
        if($gid == ""){
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Please select Golf course..";
            echo json_encode($returnArr);exit;
        }
        $playerDetails = array();
        $i = 0;
        foreach ($_POST['PlayerName'] as $name) {
            $playerDetails[$i]['name'] = $name;
            $i++;
        }
        $i = 0;
        foreach ($_POST['PlayerPhone'] as $phone) {
            $playerDetails[$i]['phone'] = $phone;
            $i++;
        }
        $i = 0;
        foreach ($_POST['PlayerEmail'] as $email) {
            $playerDetails[$i]['email'] = $email;
            $i++;
        }
//            error_log(print_r($playerDetails,1));
        $noOfPlayers = count($playerDetails);
        if($noOfPlayers == 0){
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Sorry, temporarily unable to book slot.";
            echo json_encode($returnArr);exit;
        }
        $tempDate = $_POST['pay_play_date'];
        $tempDate = str_replace("/","-",$tempDate);
        $timestamp = strtotime($tempDate);
        $playDate = date('Y-m-d', $timestamp);
        $slotTime = $_POST['pay_play_time'];
        $name = $playerDetails[0]['name'];
        $contact = $playerDetails[0]['phone'];
        $email = $playerDetails[0]['email'];
        $tot_amt = isset($_POST['total_amt']) ? $_POST['total_amt'] : 0;
        //------ get amount from DB -------
//            $dayNum = date('N', strtotime( $tempDate));
//            $day = "";
//            if($dayNum >= 1 && $dayNum<=5){
//                $day = "Weekday";
//            }elseif($dayNum >= 6 && $dayNum <= 7){
//                $day = "Weekend";
//            }
//            $priceName = "";
//            if($holeType == 9){
//                $priceName = "9Hole".$day;
//            }else if($holeType == 18){
//                $priceName = "18Hole".$day;
//            }else{
//                $returnArr['error'] = 1;
//                $returnArr['error_msg'] = "Sorry, temporarily unable to book slot.";
//                echo json_encode($returnArr);exit;
//            }
        $slotPrice = $this->golfcourseObj->getLearnSlotPrice($gid, $coachId);
        if(isset($slotPrice['coachFee'])){
            $tot_amt = round($slotPrice['coachFee']) * $noOfPlayers;
        }else{
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Sorry,temporarily unable to book slot.";
            echo json_encode($returnArr);exit;
        } 
        //
//            error_log(print_r($_POST,1));
        $exist = $this->userObj->checkUserExistByEmail($email);
//            error_log(print_r("user = ".$exist,1));
        $userID ="";
        if($exist == 0){
            $userID = $this->userObj->insertUser($name, $email, $contact);
        }else{
            $userID = $this->userObj->getUserIdByEmail($email);
            $userDetails = $this->userObj->getUserDetailsByEmail($email);
            if($userDetails['Mobile']== NULL || $userDetails['Mobile']==""){
                $this->userObj->updateUserDetailsByID($userDetails['FName'], $userDetails['LName'], $contact, $userID);
            }
        }
        $time = date("H:i:s",strtotime($tempDate));
        $checkBooking = $this->golfcourseObj->checkAlreadyBookedLearnNPlay($gid, $userID, date("Y-m-d", strtotime($tempDate)), $time);
        if($checkBooking == 1){
            $returnArr['error'] = 1;
            $returnArr['error_msg'] = "Slot is already booked by you.";
            echo json_encode($returnArr);exit;
        }
//            error_log(print_r($time,1));
        $book_ID = $this->golfcourseObj->bookPayNLearnSlot($gid, $userID, $playDate, $slotTime, $tot_amt, $coachId);
//            error_log(print_r($book_ID,1));
        $count = 0;
        $query ="";
        foreach ($playerDetails as $player) {
            if($count >0){
                $fourBallID = $this->golfcourseObj->insertFourBall($book_ID, $player['name'],  $player['email'], $player['phone'], $userID);
                if($query != ""){
                    $query.=", ";
                }
                $query.= "fourBall".$count."ID = ".$fourBallID;
            }
            $count++;
        }
        if($query != ""){
             $this->golfcourseObj->updateFourBallIDs($book_ID, $query);
        }
        $userDetails = $this->userObj->getUserDetailsByEmail($email);
        $gcArr = $this->golfcourseObj->getGolfCourseByID($gid);
        //--- Send email ---
        $to = $email;
        $subject = "[Testing] Pay and Learn booking received from ".$userDetails['FName'];
        $txt = "Dear ".$userDetails['FName'].",

        A new complimentary slot request has been received! - Reference ID : GFTTBOOK_1552714408

        UserID : ".$userDetails['User_ID']."
        User Name : ".$userDetails['FName']." ".$userDetails['LName']."
        User Email : ".$userDetails['Email']."
        Course Name - ".$gcArr['GCName'].", ".$gcArr['City']."
        Date and Time - ".$_POST['pay_play_date']."

        Thank You
        Happy Golfing!
        Admin Support, GolfLan
        Connecting Golfers Worldwide";
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: ".FROM_EMAIL_ID. "\r\n" .
        "CC: ".MAIL_CC;
        // ------ HTML TEMPLATE -------------
        $emailTxt= '<html>'.
        '<head>'.
        '<title>GolfLAN - Connecting Golfer\'s Worldwide</title>'.

        '<style>
                img{
                border:0px;
                }
        </style>
        </head>'.

        '<body style="height: 100%;max-width: 650px;width: 100%;">'.

        '<div id="main" style="background:url("'.IMG_EMAIL_WEB_PATH.'/images/Email_Template/bg.jpg");border-radius: 5px;width: 90%;padding: 0 0 20px;font-family: "Lato";">'.

                '<div id="header" style="padding: 0px 10% 6%;">'.

                        '<img src="'.IMG_EMAIL_WEB_PATH.'/images/Email_Template/logo.png" style="float:left;" width="45%" /> '.

                        '<p style="float:right;margin: 75px 12px 0;">'.
                            '<a href="http://www.golflan.com/"><img src="'.IMG_EMAIL_WEB_PATH.'/images/Email_Template/home-icon.png" width="17"/></a>'.
                                '&nbsp;&nbsp;'.
                                '<a href="http://www.golflan.com/Home/Login/"><img src="'.IMG_EMAIL_WEB_PATH.'/images/Email_Template/login-icon.png" width="17" /></a>'.
                        '</p>

                </div>

                <br/>

                <div id="content-container" style="background-color: #FFFFFF !important;border: 1px solid #d4d2d2;border-radius: 5px;margin: 0px auto;width: 80%;margin-bottom: -20px;">

                        <div id="content" style="padding: 0 20px 10px;">

                                <br /><br />
                    <p style="font-size:14px;font-weight:bold;margin-top:20px;">Dear Golfer, </p>

                                <hr/>

                                <p style="font-size:14px;">Your request for a Pay and Learn slot has been received!<br/><br/>

                                We would like to inform you that your we have successfully received your Pay and Learn slot request. Your request reference ID is '.$book_ID.' is confirmed. <br /><br />

                    You requested a Pay and Learn slot for '.$gcArr['GCName'].", ".$gcArr['City'].' for teeing off on '.$_POST['pay_play_date'].' at '.$slotTime.'.<br /><br /> 

                    If you need any assistance or have any questions, feel free to contact us by emailing us at <a href="mailto:customer.care@GolfLAN.com">customer.care@GolfLAN.com</a> or call us at 1800-208-7899.

                                Happy Golfing!<br/><br/>			

                                Team GolfLAN<br />
                    India\'s Leading Online Golf Consulting Company

                                </p>



                        </div>

                </div>

                <br/>

                <div id="footer" style="width:80%;margin-left:10%;padding-bottom:3%;font-size:14px;color:#fff;">

                        <p style="float:left;color: #000;">&copy; GolfLAN.com</p>

                        <p style="float:right"><a href="https://www.facebook.com/GOLFLAN"><img src="'.IMG_EMAIL_WEB_PATH.'/images/Email_Template/fb.png" /></a>&nbsp;&nbsp;<a href="https://twitter.com/golflan2014"><img src="'.IMG_EMAIL_WEB_PATH.'/images/Email_Template/tw.png" /></p>

                </div>

        </div>

        </body>

        </html>';
        //-----------------------------------
        //mail($to,$subject,$emailTxt,$headers);
        $returnArr['book_ID'] = $book_ID;
        echo json_encode($returnArr);exit;
    }
    
    function getLearnUserDetailsByBookingID(){
        $this->golfcourseObj = new Golfcourse(DB1);
        $this->userObj =new User(DB1);
        $returnArr =array();
        $returnArr["error"] = 0;
        $returnArr["error_msg"] = 0;
        $bookingID = $_POST['bookingID'];
        $userDetails = $this->userObj->getLearnUserDetailsByBookingID($bookingID);
        $returnArr['user'] = $userDetails;
        echo json_encode($returnArr);exit;
    }
    
    function redirecturlLearn(){
        $this->golfcourseObj = new Golfcourse(DB1);
        $this->userObj =new User(DB1);
        $this->marketingObj = new Marketing(DB2);
        $Order_Id = $_POST["Order_Id"];
        $dbOrder_Id = (int) str_replace(MMG_LEARN_ORDER_NO_PREFIX, '', $Order_Id);
        $bookingDetails = $this->golfcourseObj->getPayNLearnBookingDetails($dbOrder_Id);
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('redirecturl_learn.tpl.php',array('bookingDetails' => $bookingDetails));
    }
    
    function paynlearnCheckout(){
        $this->golfcourseObj = new Golfcourse(DB1);
        $book_id = $_POST['Order_Id']; 
        $paymentArr =  $this->golfcourseObj->getDetailsForLearnPayment($book_id);
        $gid = $paymentArr['GID'];
//        $currencyISO = $paymentArr['currencyISO'];
//        $exchangeArr = $this->golfcourseObj->getExchangeRate($currencyISO);
//        $gcArray = $this->golfcourseObj->getGolfCourseByID($gid);
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('Checkout_Learn.tpl.php',array('paymentArr' => $paymentArr));
    }
    
    function paypal(){
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('paypal.tpl.php');
    }
    
    function changePassword(){
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('changePassword.tpl.php');
    }
    
    function getScorecardSchemaByGc(){
        $this->golfcourseObj = new Golfcourse(DB1);
        $gid = isset($_POST['gid']) ? $_POST['gid'] : 0;
        $returnArr =array();
        $returnArr["error"] = 0;
        $returnArr["error_msg"] = '';
        if($gid == 0){
            $returnArr["error"] = 1;
            $returnArr["error_msg"] = 'Please select Golf Course.';
            echo json_encode($returnArr);exit;
        }
        $scorecardSchema = $this->golfcourseObj->getScorecardSchemaByGID($gid);
        if(!empty($scorecardSchema)){
            $returnArr['schema'] = $scorecardSchema;
        }else{
            $returnArr["error"] = 1;
            $returnArr["error_msg"] = 'Sorry, Scorecard facility is not available for this Golf Course.';
            echo json_encode($returnArr);exit;
        }
        echo json_encode($returnArr);exit;
    }
    
    function saveUserScorecard(){
        error_log(print_r($_POST,1));
        $this->golfcourseObj = new Golfcourse(DB1);
        $returnArr =array();
        $returnArr["error"] = 0;
        $returnArr["error_msg"] = '';
        
        if(!isset($_SESSION)){
            session_start();
        }
        $login_email = "";
        $login_id = "";
        if( isset( $_SESSION['login_id']) && $_SESSION['login_id'] != ""){
            $login_id = $_SESSION['login_id'];
        }
        if( isset($_SESSION['login_email']) && $_SESSION['login_email']!= ""){
            $login_email = $_SESSION['login_email'];
        }
        $returnArr =array();
        $returnArr["error"] = 0;
        $returnArr = array();
//        $data = $_POST['data'];
        $email = $login_email;
        $gcID = isset($_POST['gc_id']) ? $_POST['gc_id'] : 0;
        $scorecardSchema = $this->golfcourseObj->getScorecardSchemaByGID($gcID);
//        error_log(print_r($scorecardSchema,1));exit;
        $date_time_play = $_POST['scorecard_date'];
//        $date_time_play = str_replace("/","-",$date_time_play);
        $date_time_play = strtotime($date_time_play);
        $date_time_play = date('Y-m-d', $date_time_play);
        error_log($date_time_play);
        
        $returnArr['error'] = 0;
        error_log("emai:--------- ".$email);
        $par = 0;
        $total = 0;
        $columnArr = array();
        //---
        for ($index = 1; $index <=18; $index++) {
            $columnArr['hole_'.$index] = isset($_POST['hole_'.$index]) ? $_POST['hole_'.$index] : 0;
            $total+=isset($scorecardSchema[$index-1]['holePAR']) ? $scorecardSchema[$index-1]['holePAR'] : 0;
            $par+=isset($_POST['hole_'.$index]) ? $_POST['hole_'.$index] : 0;
            $columnArr['putt_'.$index] = isset($_POST['hole_'.$index]) ? $_POST['hole_'.$index] : 0;
        }
        //---
//        $date_time_play = date("Y-m-d H:i:s",  strtotime( $date_time_play));
        $returnArr1 = $this->golfcourseObj->addScoreCard($columnArr, $par, $total, $email, $login_id, $gcID, $date_time_play);
        $handArr = array();
        $handArr = $this->golfcourseObj->getUserAvgHandicap($login_id);
        error_log(print_r($handArr,1));
        $returnArr['handicap'] = round($handArr['handicap']);
        echo json_encode($returnArr);exit;
    }
    
    function getGlobalSearch(){
        if (!isset($_SESSION)) {
            session_start();
        }
        $ISO = isset($_SESSION['country_code']) ? $_SESSION['country_code'] : 'IND';
        
        $name = $_GET['term'];
        $this->golfcourseObj = new Golfcourse(DB1);
        $this->prodObj = new Product(DB1);
        $respArr = array();
        $count = 0;
        //------------ Golf courses ----------
        $gcArr =  $this->golfcourseObj->getGolfCourses($name);
        foreach ($gcArr as &$value) {
            $respArr[$count]['id'] = $value['GID'];
            $respArr[$count]['name'] = $value['GCName'];
            $respArr[$count]['url'] = WEB_PATH.'/playnow/'.$value['GID'];
            $count++;
        }
        
        $productsArr = $this->prodObj->getAllProducts($ISO, $name);
        foreach ($productsArr as &$value) {
            $respArr[$count]['id'] = $value['prodID'];
            $respArr[$count]['name'] = $value['Title'];
            $respArr[$count]['url'] = WEB_PATH.'/product/productDetails/ID/'.$value['prodID'];
            $count++;
        }
        
//        error_log(print_r($respArr,1));exit;
        header("Content-type: application/json");
        $returnArr = $this->golfcourseObj->removeAsciiCodeFromGlobalSearch($respArr);
        echo json_encode($returnArr);
        exit;
    }
    
    function saveDeclaredHandicap(){
        if (!isset($_SESSION)) {
            session_start();
        }
        $returnArr =array();
        $returnArr["error"] = 0;
        $returnArr["error_msg"] = '';
        $handicap = isset($_POST['handicap']) ? $_POST['handicap'] : 0;
        $this->golfcourseObj = new Golfcourse(DB1);
        $user_ID = isset($_SESSION['login_id']) ? $_SESSION['login_id'] : 0;
        $this->golfcourseObj->updateDeclaredHandicap($user_ID, $handicap);
        echo json_encode($returnArr);
        exit;
    }
    
    public function test() {
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('test.tpl.php');
    }
    
    public function testUploadimage() {
        
        $fileName = $_FILES["user_img"]["name"];
        // Local path
        $uploadPath = IMG_DEPLOY_PATH . "userProfile/";
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        $filePath = $uploadPath . $_FILES["user_img"]["name"];
        // Move uplaoded file to local path
        move_uploaded_file($_FILES["user_img"]["tmp_name"], $filePath);
        $path = $filePath;
        
        error_log(print_r($_FILES,1));
        if (1) {
            
//            require '/var/www/html/golflan_new/Models/Aws/S3/S3Client.php';
            $s3 = S3Client::factory(array(
                'key'    => AWS_ACCESS_KEY,
                'secret' => AWS_ACCESS_SECRET_KEY,
                'region' => 'eu-central-1', //Franfurt
//                'region' => 'eu-central-1', // Singapore
                'signature' => 'v4' //Signature for authentication mechanism
            ));
//            $transfer = S3Client::upload(AWS_BUCKET.'/golflanmemberimages/', $fileName, fopen($path, 'rb'), 'public-read');
//            print_r($transfer);exit;
            try{
                $result = $s3->putObject(array(
                    'Bucket'     => AWS_BUCKET,
                    'Key'        => '/golflanmemberimages/'.$fileName,
                    'Body' => fopen($path, 'rb'),
                    'ACl' => 'public-read',
                ));
                echo "<pre>";
//                echo $result['ObjectURL'] . "\n";exit;
                print_r($result);exit;
                print_r($result->getData()->VersionId);
                exit;
            }catch(S3Exception $e){
                die("There was error uploading file.");
            }
            exit;
            $time = (string) time();
            //create s3 object
            $this->s3Obj = new S3Client(AWS_ACCESS_KEY, AWS_ACCESS_SECRET_KEY);
            //file path inside s3 bucket
            $filePath = "golflanmemberimages/" . $time . "_" . $fileName;
            //move file to s3 bucket
            $this->s3Obj->putObjectFile($path, AWS_BUCKET, $filePath, S3::ACL_PUBLIC_READ);
            //append s3 url to complte path
            $path = AWSASSETSBucketURL . '/' . $filePath;
        }
    }
    
    function getExtension($str){
             $i = strrpos($str,".");
             if (!$i) { return ""; } 

             $l = strlen($str) - $i;
             $ext = substr($str,$i+1,$l);
             return $ext;
    }
    
    function uploadProfileImage(){
        $t = time();
        $valid_formats = array("jpg", "png", "jpeg","PNG", "JPG", "JPEG");
        if (!isset($_SESSION)) {
            session_start();
        }
        $user_ID = isset($_SESSION['login_id']) ? $_SESSION['login_id'] : 0;
        if($user_ID > 0){
            $this->golfcourseObj = new Golfcourse(DB1);
            $returnArr =array();
            $returnArr["error"] = 0;
            $returnArr["error_msg"] = '';
//            error_log(print_r($_FILES,1));
            $fileName = $_FILES["user_img"]["name"];
            // Local path
            $uploadPath = IMG_DEPLOY_PATH . "userProfile/";
//            if (!file_exists($uploadPath)) {
//                mkdir($uploadPath, 0777, true);
//            }
            $filePath = $uploadPath . $_FILES["user_img"]["name"];
            // Move uplaoded file to local path
//            move_uploaded_file($_FILES["user_img"]["tmp_name"], $filePath);
            
            $path = $_FILES["user_img"]["tmp_name"] ; //$filePath;
            
            $size = $_FILES['user_img']['size'];
            $ext = $this->getExtension($fileName);
            $fileName = $user_ID.'_profile_image.'.$ext;
            
            if(in_array($ext, $valid_formats)){
                if($size<(1024*1024)){
                    if (1) {
                        $s3 = S3Client::factory(array(
                            'key'    => AWS_ACCESS_KEY,
                            'secret' => AWS_ACCESS_SECRET_KEY,
                            'region' => 'eu-central-1', //Franfurt
                //                'region' => 'eu-central-1', // Singapore
                            'signature' => 'v4' //Signature for authentication mechanism
                        ));
                        try{
                            $result = $s3->putObject(array(
                                'Bucket'     => AWS_BUCKET,
                                'Key'        => '/golflanmemberimages/'.$fileName,
                                'Body' => fopen($path, 'rb'),
                                'ACl' => 'public-read',
                            ));
                            error_log($result['ObjectURL']);
                            $imgUrl = isset($result['ObjectURL']) ? $result['ObjectURL'] : '';
                            $this->golfcourseObj->updateUserProfileImage($imgUrl, $user_ID);
                            $returnArr['img_url'] = $result['ObjectURL'];
                            echo json_encode($returnArr);
                            exit;
                        }catch(S3Exception $e){
                            $returnArr["error"] = 1;
                            $returnArr["error_msg"] = 'There was error uploading file.';
                            echo json_encode($returnArr);
                            exit;
                        }
                    }
                }else{
                    $returnArr["error"] = 1;
                    $returnArr["error_msg"] = 'Image size Max 1 MB.';
                    echo json_encode($returnArr);
                    exit;
                }
            }else{
                $returnArr["error"] = 1;
                $returnArr["error_msg"] = 'Invalid file, please upload image file. Allowed formats are jpg, jpeg and png';
                echo json_encode($returnArr);
                exit;
            }
        }else{
            $returnArr["error"] = 1;
            $returnArr["error_msg"] = 'Please Login first to upload image.';
            echo json_encode($returnArr);
            exit;
        }
    }
    
    public function advisory() {
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('advisory.tpl.php');
    }
    
    public function management() {
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('management.tpl.php');
    }
    public function privacy() {
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('privacy.tpl.php');
    }
    public function rcPolicy() {
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('rcPolicy.tpl.php');
    }
	
    public function pshipping() {
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('pshipping.tpl.php');
    }
    public function details() {
		//echo $_POST['register-username'];
		$golfcourse = new Golfcourse(DB1);
		$marketing = new Marketing();
		$product = new Product(DB1);
		//$user = new User(DB1);
		$p = new paypal_class(); // paypal class
		$p->admin_mail 	= PAYPAL_NOTIFY_EMAIl; // set notification email
		$action 		= "success";
		/*
		switch($action){
			case "success": // success case to show the user payment got success
			//echo $_POST['register-username'];

				$to = $_POST['user_email'];
				//echo $to;
									$subject = "Welcome to GolfLan.com ";
									$headers = "MIME-Version: 1.0" . "\r\n";
									$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
									$headers .= "From: ".FROM_EMAIL_ID. "\r\n" .
									"CC: ".MAIL_CC;
									// ------ HTML TEMPLATE -------------
									$html="";
									$template = 'signup.html';
									if (file_exists(API_PATH."/Templates/static/email_templates/$template")) {
										$tpl_name = API_PATH."/Templates/static/email_templates/$template";
										$buffer = file_get_contents($tpl_name);
										//echo $buffer; 
										$html = $buffer;
										$html = str_replace("#Email#", $_POST['register-username'], $html);

									}
									$emailTxt= $html;
									//print_r($emailTxt); exit;
									//-------------- MAIL ---------------------
								   $golfcourse->sendMail($subject, $emailTxt, $to);
			break;

		}
		*/
		$this->userObj = new User(DB1);
		$arr = $this->userObj->FindISDCode($_POST['country_list']);
		$GetCountryISO = $arr[0]['iso_alpha3'];
		$SignUpDataToMail = $this->SignUpDataToMail($_POST['user_email'], $_POST['register-username'], $GetCountryISO);
      
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('details.tpl.php');
      
          
      }
	public function detailsdata() {
      
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('detailsdata.tpl.php');
      
          
      }
    public function findISDcode() {
		
	  	$country_value = $_POST['country_value'];
		
		$this->userObj =new User(DB1);
		
		$arr=$this->userObj->FindISDCode($country_value);
		
		echo json_encode($arr[0]['isdCode']);
		
	}
	
	public function profileEdit() {
      
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('profileEdit.tpl.php');
       }
	public function profileUpdate() {
		$user = new User(DB1);
		$updateUserProfileByID=$user->updateUserProfileByID($_POST['declaredHandicap'],$_POST['Mobile'],$_POST['MyHomeCourse'],$_POST['City'],$_POST['Country'],$_POST['profile-bio'],$_POST['UpdateUserID']);
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('profileEdit.tpl.php');
    }
    
    public function playGolfNew() {
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('playGolfNew.tpl.php');
   }
   
    public function courseBooking() {
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('courseBooking.tpl.php');
   }
   
   public function testEmailAttachment(){
       $this->golfcourseObj = new Golfcourse(DB1);
       $subject = "Pdf Testing";
       $emailTxt = "<HTML><body><h1>PFA of Invoice</h1></body></HTML>";
       $pdfContent = "<HTML><body><h1>Order here dfdsfds</h1></body></HTML>";
       $to = "vickyb@fermion.in";
       $pdfUploadLocation = API_PATH."/Templates/static/Order_pdf/";
       $pdfName = "proshoporder_1001.pdf";
       $this->golfcourseObj->generateAndUploadPDF($pdfUploadLocation, $pdfName, $pdfContent);
       $attachment = $pdfUploadLocation.$pdfName;
       $this->golfcourseObj->sendMailWithAttachMent($subject, $emailTxt, $to, $attachment);
       exit();
   }
   
    public function lastMinuteGolfer() {
        $this->golfcourseObj = new Golfcourse(DB1);
        $gcdetailProcessedArr = array();
        $gcdetail = $this->golfcourseObj->getAllGolfCoursesForLastMinuteTeeTime();
        foreach ($gcdetail as $gcArr) {
            $gcdetailProcessedArr[$gcArr['GID']] = $gcArr;
        }
        $minDaysToBook = 0;
        $todayDate = date("Y-m-d");
        $days_available = LAST_MINUTE_TEE_TIME_NO_OF_DAYS_DISPLAY_MAX_MMG;
        $later_date = date('Y-m-d', strtotime('+' . ($minDaysToBook + $days_available) . ' days'));
        $slot_status = $this->slotStatusForDatesForLastMinuteGolfer($todayDate, $later_date);
        $slot_status_array = json_decode($slot_status);
                
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('lastMinuteGolfer.tpl.php', array('gcdetail' => $gcdetailProcessedArr, 'slot_status' => $slot_status_array, 'gid' => 0));
   }
   
   public function lastMinuteGolferForGID($ISO, $STATE, $GNAME, $book) {
        $this->golfcourseObj = new Golfcourse(DB1);
        $gcdetailProcessedArr = array();
        $GNAME = strrchr($GNAME, '-');
        $GID = preg_replace('/[-]/', '', $GNAME);
        
        $gcdetail = $this->golfcourseObj->getAllGolfCoursesForLastMinuteTeeTime();
        foreach ($gcdetail as $gcArr) {
            $gcdetailProcessedArr[$gcArr['GID']] = $gcArr;
        }
        $minDaysToBook = 0;
        $todayDate = date("Y-m-d");
        $days_available = LAST_MINUTE_TEE_TIME_NO_OF_DAYS_DISPLAY_MAX_MMG;
        $later_date = date('Y-m-d', strtotime('+' . ($minDaysToBook + $days_available) . ' days'));
        $slot_status = $this->slotStatusForDatesForLastMinuteGolfer($todayDate, $later_date, $GID);
        $slot_status_array = json_decode($slot_status);
                
        $this->app->contentType('text/html; charset=utf-8');
        $this->app->render('lastMinuteGolfer.tpl.php', array('gcdetail' => $gcdetailProcessedArr, 'slot_status' => $slot_status_array, 'gid' => $GID));
   }
   
   public function getGCSlotsByDateForLastMinuteGolfer() {

        $gid = isset($_POST['gid']) ? $_POST['gid'] : 0;
        $startdate = isset($_POST['startdate']) ? $_POST['startdate'] : '2015-12-30';
        $enddate = isset($_POST['enddate']) ? $_POST['enddate'] : '2015-12-30'; 

        $data = array("gid" => $gid, "startdate" => $startdate, "enddate" => $enddate);
        $data_string = http_build_query($data);

        $ch = curl_init(PLATEFORM_PATH . 'golfcourse/getGolfCourseSlotsForLastMinuteGolfer');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        echo  $result;
        exit;
    }
    
    
    public function slotStatusForDatesForLastMinuteGolfer($curruntdate, $enddate, $GID = 0) {
        $data = array("gid" => $GID ,"curruntdate" => $curruntdate, "enddate" => $enddate);
        $data_string = http_build_query($data);
        $ch = curl_init(PLATEFORM_PATH . 'golfcourse/getSlotStatusForLastMinuteGolfers');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        return $result;
        
        
    }
    
}
