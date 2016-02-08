<?php
/** This file is part of the Bollywood Review Project <http://www.bollywoodreview.com>.
 * Copyright (C) 2012 Fermion Infotech Private Limited.  All rights reserved. (info@fermion.in)
 */

/**
 * @file    Util.php
 * @version 1.0
 * @brief   Util Class
 * @date    Nov 28, 2012
 * @author  Sahil Saggar <sahil@fermion.in>
 */

/* @class   Util
 * @brief   This is the class for Utility Functions
 */

final class Util {

    private function __construct() { }


	public static function isGreaterDate($date1,$date2) {
		$start = strtotime($date1);
		$end = strtotime($date2);
		if($date1 >= $date2){
			return 1;
		}
		return 0;
	}

    /*! @publicsection */

    /**
     * Print Array output to the page
     * @param  dataArray  Array to be print
     */

	public static function printArr(array $dataArr) {
		echo '<pre>';
		print_r($dataArr);
		echo '</pre>';
	}

    /**
     * Template Transform
     * @param  dataArray  Array to be transform
     * @param  Tpl File path
     * @retval  HTML output
     */

	public static function tplTransform(array $dataArr, $tplFile) {

		if(isset($_GET['debug'])) {

			if($_GET['debug'] == 1)
				self::printArr($dataArr);
			exit;
		}
		if(strlen($tplFile) < 1) {

			$tplFile = 'index.tpl.php';
		}

		header("Content-type: text/html; charset='utf-8'");
		include_once('tpl/'.$tplFile.'.tpl.php');
	}

    /**
     * Template Transform for Admin part
     * @param  dataArray  Array to be transform
     * @param  Tpl File path
     * @retval  HTML output
     */

	public static function tplTransformAdmin(array $dataArr, $tplFile) {
		if(isset($_GET['debug'])) {
			if($_GET['debug'] == 1)
				self::printArr($dataArr);
			exit;
		}
		if(strlen($tplFile) < 1) {
			$tplFile = 'index.tpl.php';
		}
		header("Content-type: text/html; charset='utf-8'");
		include_once('admin/tpl/'.$tplFile.'.tpl.php');
	}

    /**
     * Template Transform
     * @param  dataArray  Array to be transform
     * @param  Tpl File path
     * @retval  JSON Array
     */
    public static function tplTransformJson(array $dataArr, $tplFile) {
		if(isset($_GET['debug'])) {
			if($_GET['debug'] == 1)
				self::printArr($dataArr);
			exit;
		}
		if(strlen($tplFile) < 1) {
			$tplFile = 'index.tpl.php';
		}
		header("Content-type: application/json");
		include_once('tpl/'.$tplFile.'.tpl.php');
	}

    /**
     * Template Transform form JSON Array
     * @param  dataArray  Array to be transform
     * @param  Tpl File path
     * @retval  XML output
     */
	public static function tplTransformXML(array $dataArr, $tplFile) {
		if(isset($_GET['debug'])) {
			if($_GET['debug'] == 1)
				self::printArr($dataArr);
			exit;
		}
		if(strlen($tplFile) < 1) {
			$tplFile = 'index.tpl.php';
		}
		header("Content-type: text/xml");
		include_once('tpl/'.$tplFile.'.tpl.php');
	}

    /**
     * Template Transform form JSON Array
     * @param  dataArray  Array to be transform
     * @param  Tpl File path
     * @retval  CSV output
     */

	public static function tplTransformCSV(array $dataArr, $tplFile) {
		if(isset($_GET['debug'])) {
			if($_GET['debug'] == 1)
				self::printArr($dataArr);
			exit;
		}
		if(strlen($tplFile) < 1) {
			$tplFile = 'index.tpl.php';
		}
		header("Content-type: application/octet-stream");
		header("Content-disposition: attachment; filename=" . $dataArr['filename']);
		include_once('tpl/'.$tplFile.'.tpl.php');
	}

    /**
     * Process request
     * @param  requestArray  URL REQUEST Object
     * @retval  Page name, action
     */

	public static function processRequest($requestStr) {
		$args = explode("/", $requestStr);
		$page = array_shift($args);
		$action = array_shift($args);
		return array($page, $action);
	}

    /**
     * Process request
     * @param  requestArray  URL REQUEST Object
     * @retval  argument or url parameters
     */

	public static function getRequestVals($requestStr) {
		$args = explode("/", $requestStr);
		$page = array_shift($args);
		$action = array_shift($args);
		return $args;
	}

	/**
     * Mail Template Transform
     * @param  dateArray
     * @param  Mail Template File
     * @retval  HTML Output
     */

	public static function htmlTransform(array $dataArr, $fileName) {
		if(isset($_GET['debug'])) {
			if($_GET['debug'] == 1)
				self::printArr($dataArr);
			exit;
		}
		if(strlen($fileName) < 1) {
			return '';
		}
		$fileHTML = '';
		ob_start();
        header("Content-type: text/html; charset='utf-8'");
		include(DEPLOY_PATH . 'tpl/'.$fileName.'.tpl.php');
		$fileHTML = ob_get_contents();
		ob_clean();
		ob_end_clean();
		return $fileHTML;
	}

    /**
     * Mail Template Transform
     * @param  dateArray
     * @param  Mail Template File
     * @retval  HTML Output
     */

	public static function mailTransform(array $dataArr, $emailFile) {
		if(isset($_GET['debug'])) {
			if($_GET['debug'] == 1)
				self::printArr($dataArr);
			exit;
		}
		if(strlen($emailFile) < 1) {
			return '';
		}
		$emailHTML = '';
		ob_start();
		include(DEPLOY_PATH . 'emails/'.$emailFile.'.tpl.php');
		$emailHTML = ob_get_contents();
		ob_clean();
		ob_end_clean();
		return $emailHTML;
	}

    /**
     * sendEmail - Sending mail
     * @param  to   mail id of receiver
     * @param  toName   Name of receiver
     * @param  from   Sender Mail id
     * @param  fromName   Sender Name
     * @param  subject   Mail subject
     * @param  mailContent  Mail Content to be sent
     * @retval  return true if success, false in case of error
     */

	public static function sendEmail($to, $toName, $from, $fromName, $subject, $mailContent) {
		ini_set('sendmail_from', $from);

		$headers = 'From: ' . $fromName . '<' . $from . '>' . PHP_EOL;
        $headers .= 'Reply-To: ' . FROM_NAME . '<' . FROM_EMAIL . '>' . PHP_EOL;
        $headers .= 'Return-Path: ' . $from . PHP_EOL;
        $headers .= 'X-Mailer: Fermion/' . phpversion() . PHP_EOL;
        $headers .= 'MIME-Version: 1.0' . PHP_EOL;
        $headers .= "Content-Type: text/html; utf-8 " . PHP_EOL;
		return mail($to, $subject, $mailContent, $headers, '-r ' . $from);
	}

    /**
     * Check Request is Ajax or Not
     * @retval  true in case of Ajax Request, else false
     */

	public static function isAjax() {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        }
        return false;
    }

    /**
     * Check the parameter in GUID or not
     * @param  guuid string
     * @retval  true in case of GUID, else false
     */

	public static function isGuid($guid) {
		return preg_match('/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/i', $guid);
	}

    /**
     * get the Action Name from the URL
     * @param  action
     * @retval  action name if success else blank string
     */

    public static function getControllerAction($action, $default = '') {
		if(strlen($action) > 0) {
			return $action;
		}
        $action = (isset($_GET['action']) && strlen($_GET['action']) > 0) ? $_GET['action'] : '';
        if ($action == '') {
            $action = (isset($_POST['action']) && strlen($_POST['action']) > 0) ? $_POST['action'] : $default;
        }
        return strtolower($action);
    }

    /**
     * Validate the parameter is proper email id or not
     * @param  emailid as string
     * @retval  true in case proper email id, else false
     */

    public static function validateEmail($email) {
        return preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", $email);
    }

    /**
     * replace all BR tag to new Line
     * @param  string to be convert
     * @retval  replaced String
     */

    public static function br2nl($string) {
        return preg_replace('/<br\\s*?\/??>/i', '', $string);
    }

    /**
     * replace all non XML Char with XML Char
     * @param  string to be convert
     * @retval  replaced String
     */

    public static function nonxmlcharreplace($str) {
        $string = preg_replace('/[^a-zA-Z0-9\-]/', '-', $str);
        $newstr = preg_replace('/\-\-+/', '-', strtolower($string));
        return $newstr;
    }

    /**
     * replace all non XML Char with XML Char in Title
     * @param  string to be convert
     * @retval  replaced String
     */

    public static function nonxmlcharreplaceTitle($str) {
        $string = preg_replace('/[^a-zA-Z0-9\[\]\(\)\'\-\/:,;!$@%&]/', ' ', $str);
        $newstr = preg_replace('/\s\s+/', ' ', $string);
        return $newstr;
    }

    /**
     * get Hash Key
     * @param  Key
     * @const HASH KEY SPLIT from Config file
     * @retval  return Hash Key
     */

    public static function getHashKey($key) {
        if ($key == 0) {
            return 0;
        } else {
            return $key % HASH_KEY_SPLIT;
        }
    }

    /**
     * Set Cookie
     * @param  Cookie Name
     * @param  Cookie Data
     * @param  validity default:0
     */

    public static function setCookie($cookieName, $cookieData, $validity = 0) {
        if ($validity > 0) {
            setcookie($cookieName, self::encryptData($cookieData), time() + $validity, '/');
        } else {
            setcookie($cookieName, self::encryptData($cookieData), 0, '/');
        }
    }

    /**
     * get Cookie
     * @param  Cookie Name
     * @retval Cookie Value if there else false
     */


    public static function getCookie($cookieName) {
        if (isset($_COOKIE[$cookieName]))
            return @self::decryptData($_COOKIE[$cookieName]);
        else
            return false;
    }

    /**
     * Encrypt Data
     * @param  Data
     * @retval Encrypted Data
     */

    public static function encryptData($data) {
        return strrev(base64_encode($data));
    }

    /**
     * Decrypt Data
     * @param  Data
     * @retval Decrypted Data
     */
    public static function decryptData($data) {
        return base64_decode(strrev($data));
    }

    /**
     * Convert data into Indian Rupee format
     * @param  Data
     * @retval Converted Indian Rupees format
     */

    public static function rupeesFormat($data) {
        return number_format($data, 2, '.', ',');
    }
    /**
     * Convert data array to XML String
     * @param  Data Array
     * @retval Converted XML String
     */

    public static function toXml($array, $tag="xml", $subTag="data", $checkFlag = false) {
		return '<'.$tag.'>'.self::ia2xml($array, $subTag, $checkFlag).'</'.$tag.'>';
	}
    /**
     * Print XML String
     * @param  XML String
     * @retval Print XML String
     */
	public static function printXml($xmlString) {
		header('content-type: text/xml');
		echo $xmlString;
	}
	/**
     * Print JSON Array
     * @param  JSON String
     * @retval Print JSON String
     */
	public static function printJson($jsonString) {
		header('content-type: application/json');
		print $jsonString;
	}
    /**
     * Convert data array to XML String
     * @param  Data Array
     * @param  Sub Tag
     * @retval Converted XML String
     */

    public static function ia2xml($array, $subTag) {
        $xml = '';
        foreach ($array as $key => $value) {
            $key = is_string($key) ? $key : $subTag;
            $key = str_replace(' ', '_', $key);
            if (is_array($value)) {
                $xml .= '<' . $key . '>' . self::ia2xml($value, $subTag) . '</' . $key . '>';
            } else {
                if (is_string($value)) {
                    $xml .= '<' . $key . '><![CDATA[' . $value . ']]></' . $key . '>';
                } else {
                    $xml .= '<' . $key . '>' . $value . '</' . $key . '>';
                }
            }
        }
        return $xml;
    }
    /**
     * Get the date differnce in Days
     * @param  Start Date
     * @param  End date optional default:current date
     * @retval return no of days
     */

	public static function getDurationInDays($startDate, $endDate = '') {
		if ($endDate == '') {
			$endDate = date('Y-m-d');
		}
		return ceil((strtotime($endDate) - strtotime($startDate)) / 86400);
	}
    /**
     * Get the date in specific format
     * @param  date string
     * @param  date format optional default:d-m-Y
     * @retval return date in specific format
     */

	public static function getDate($dateStr, $format='') {
		$dateStr = str_replace('/', '-', $dateStr);
		if($format == '') {
			$format = 'd-m-Y';
		}
		try {
			return date_format(date_create($dateStr), $format);
		} catch(Exception $e1) {
			try {
				return date($format, strtotime($dateStr));
			} catch(Exception $e2) { }
		}
		return date($format);
	}
    /**
     * Add number of days in a date
     * @param  date string
     * @param  number of days to be added
     * @param  date format optional default:d-m-Y
     * @retval return date after adding no of days in specific format
     */
	public static function getDateAdvanceDays($dateStr, $noOfDays, $format = '') {
		if($format == '') {
			$format = 'd-m-Y';
		}
		return date($format, strtotime("+$noOfDays days", strtotime($dateStr)));
	}

    /**
     * Substract minutes in a date
     * @param  date string
     * @param  minutes to be substracted
     * @param  date format optional default:Y-m-d H:i:s
     * @retval return date after substracting minutes in specific format
     */
	public static function getPreviousDateByMinutes($dateStr, $minutes, $format = '') {
		if($format == '') {
			$format = 'Y-m-d H:i:s';
		}
		return date($format, strtotime("-$minutes minutes", strtotime($dateStr)));
	}

    /**
     * get Date & time in 24 hrs format
     * @param  date string
     * @retval return date in 24 hr format
     */
	public static function getDateTime24($dateStr) {
		return date('d-m-Y H:i:s', strtotime($dateStr));
	}
    /**
     * get Date & time in 12 hrs format
     * @param  date string
     * @retval return date in 12 hr format
     */
	public static function getDateTime12($dateStr) {
		return date('d-m-Y h:i:s a', strtotime($dateStr));
	}
    /**
     * get privious date of input date
     * @param  date string optional default:current date
     * @retval return privious date of input date
     */
	public static function getPreviousDayDate($date = '') {
		if($date == '') {
			$date = date('Y-m-d');
		}
		return date('Y-m-d', mktime(0,0,0,date('m',strtotime($date)), date('d',strtotime($date)) - 1, date('Y',strtotime($date))));
	}

    /**
     * get next date of input date
     * @param  date string optional default:current date
     * @retval return next date of input date
     */

	public  static function getNextDayDate($date = '') {
		if($date == '') {
			$date = date('Y-m-d');
		}
		return date('Y-m-d', mktime(0,0,0,date('m',strtotime($date)), date('d',strtotime($date)) + 1, date('Y',strtotime($date))));
	}

    /**
     * convert date to MySql format
     * @param  date string
     * @retval return date in MySql format
     */
    public static function dateToMysql($date) { // date to mysql date
		$date = str_replace('/', '-', $date);
		if(strlen($date) > 0) {
			try {
				return date_format(date_create($date), 'Y-m-d H:i:s');
			} catch(Exception $e1) {
				try {
					return date('Y-m-d H:i:s', strtotime($date));;
				} catch(Exception $e2) { }
			}
		}
		return '0000-00-00 00:00:00';
    }
    /**
     * convert date to MySql date time format
     * @param  date string
     * @retval return date in MySql date time format
     */

	public static function mysqlToDateTime($date) { // mysql date to date
		$date = str_replace('/', '-', $date);
		if(strlen($date) > 0) {
			try {
				return date_format(date_create($date), 'd-m-Y H:i:s');
			} catch(Exception $e1) {
				try {
					return date('d-m-Y H:i:s', strtotime($date));;
				} catch(Exception $e2) { }
			}
		}
		return '';
    }
    /**
     * convert  MySql date to d-m-Y format
     * @param  date string
     * @retval return MySql date to d-m-Y format
     */

    public static function mysqlToDate($date) { // mysql date to date
		if(strlen($date) > 0 && $date != '0000-00-00 00:00:00' && $date != '0000-00-00') {
			try {
				return date_format(date_create($date), 'd/m/Y');
			} catch(Exception $e1) {
				try {
					return date('d/m/Y', strtotime($date));
				} catch(Exception $e2) { }
			}
		}
		return '';
    }
    /**
     * get current timestamp in millisecond
     * @retval return current timestamp in millisecond
     */
    public static function getCurrentTimeInMillisecond() {
        list($timestamp, $sec) = explode(" ", microtime());
        $timestamp += $sec;
        $timestamp = str_replace('.', '', $timestamp);
        return $timestamp;
    }
    /**
     * replace all non Ascii char
     * @param  String
     * @retval return string with non Ascii char
     */

	public static function repalceNonAscii($val) {
		$val = preg_replace('/[^(\x20-\x7F)]*/','', $val);
		return $val;
	}
    /**
     * get the first day of current month
     * @param  format optional default: Y-m-d 00:00:00
     * @retval return the first date of current month
     */
	public static function getFirstOfMonth($format = 'Y-m-d 00:00:00') {
		return date($format, strtotime(date('m').'/01/'.date('Y').' 00:00:00'));
	}
    /**
     * get the last day of current month
     * @param  format optional default: Y-m-d 00:00:00
     * @retval return the last date of current month
     */

	public static function getLastOfMonth($format = 'Y-m-d 00:00:00') {
		return date($format, strtotime('-1 second',strtotime('+1 month',strtotime(date('Y').'-'.date('m').'-01'.' 00:00:00'))));
	}
    /**
     * get the first day of current Week
     * @param  format optional default: Y-m-d 00:00:00
     * @retval return the first date of current Week
     */
	public static function getFirstDayofWeek($format = 'Y-m-d 00:00:00'){
		$currentDateofWeek = date('w');
		return self::getDateAdvanceDays(date('Y-m-d'), $currentDateofWeek * (-1), $format);
	}
    /**
     * get the last day of current Week
     * @param  format optional default: Y-m-d 00:00:00
     * @retval return the last date of current Week
     */
	public static function getLastDayofWeek($format = 'Y-m-d 00:00:00'){
		$currentDateofWeek = date('w');
		return self::getDateAdvanceDays(date('Y-m-d'), 6 - $currentDateofWeek, $format);
	}
    /**
     * get the current date in specific format
     * @param  format optional default: Y-m-d 00:00:00
     * @retval return current date in specific format
     */

	public static function getTodaysDateStartofDay($format = 'Y-m-d 00:00:00'){
		return Util::getDate(date('Y-m-d'), $format);
	}
    /**
     * get the tomorrow date in specific format
     * @param  format optional default: Y-m-d 00:00:00
     * @retval return tomorrow date in specific format
     */
	public static function getTomorrowsDate($format = 'Y-m-d 00:00:00'){
		Util::getDate(Util::getDateAdvanceDays(date('Y-m-d'), 1, 'Y-m-d 00:00:00'), $format);
	}
    /**
     * get the current date in last minute
     * @param  format optional default: Y-m-d 00:00:00
     * @retval return current date in last minute in specific format
     */
	public static function getTodaysDateLastMinute($format = 'Y-m-d 23:59:59'){
		return Util::getDate(date('Y-m-d'), $format);
	}
    /**
     * get array to CSV
     * @param  data array
     * @param  header row optional - true/false default:true
     * @param  column seperator optional default: ,
     * @param  row seperator optional default: new line
     * @param  quote  optional default: double quote
     * @retval return CSV string for array
     */
	public static function array_to_csv($array, $header_row = true, $col_sep = ",", $row_sep = "\n", $qut = '"') {
		if (!is_array($array) or !is_array($array[0])) return false;

		$output = '';
		//Header row.
		if ($header_row) {
			foreach ($array[0] as $key => $val) {
				//Escaping quotes.
				$key = str_replace($qut, "$qut$qut", $key);
				$output .= "$col_sep$qut$key$qut";
			}
			$output = substr($output, 1)."\n";
		}
		//Data rows.
		foreach ($array as $key => $val) {
			$tmp = '';
			foreach ($val as $cell_key => $cell_val) {
				//Escaping quotes.
				$cell_val = str_replace($qut, "$qut$qut", $cell_val);
				$tmp .= "$col_sep$qut$cell_val$qut";
			}
			$output .= substr($tmp, 1).$row_sep;
		}

		return $output;
	}
    /**
     * get Rest Response
     * @param  return type - array/xml default json
     * @param  data array
     * @retval return data in return format specified.
     */

	public static function getRestResponce($returnType, $res){
		switch($returnType){
			case 'array':
				print_r($res);
				break;
			case 'xml':
				$xmlString = Util::toXml($res, 'sharearide');
				self::printXml($xmlString);
				break;
			default:
				$jsonres = json_encode($res);
				self::printJson($jsonres);
				break;
		}
	}
    /**
     * get formatted Date
     * @param  return type - array/xml default json
     * @param  data array
     * @retval return data in return format specified.
     */

    public static function formatDate($date){
//        $createdDate = date_create($date);
//        $date = date_format($createdDate, 'jS F Y');
//        return $date;
        $date = str_replace('/', '-', $date);
		if(strlen($date) > 0) {
			try {
				return date_format(date_create($date), 'jS F Y');
			} catch(Exception $e1) {
				try {
					return date('jS F Y', strtotime($date));;
				} catch(Exception $e2) { }
			}
		}
		return '';
	}
        /**
     * remove removeHyperLink
     */
	public static function removeHyperLink($string){
        return preg_replace('@<a(?:.*)>(.*)</a>@isU',' ', $string);
	}

    /**
     * Validate the parameter is proper name or not
     * @param  name as string
     * @retval  true in case proper name, else false
     */

    public static function validateName($name) {
        return preg_match("/^[a-zA-Z ]*$/", $name);
    }

    /**
     * Validate the parameter is proper url or not
     * @param  url as string
     * @retval  true in case proper url, else false
     */

    public static function validateURL($url) {
        return preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $url);
    }

    /**
     * Generate Random String
     * @param size optional default: 10
     * @retval random string
     */

    public static function generateRandomString($size = 10) {
		return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $size);
	}
}
?>