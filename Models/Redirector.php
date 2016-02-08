<?php
/** This file is part of the Bollywood Review Project <http://www.bollywoodreview.com>. 
 * Copyright (C) 2012 Fermion Infotech Private Limited. All rights reserved. (info@fermion.in)
 */

/**
 * @file    Redirector.php
 * @version 1.0
 * @brief   Redirector Class
 * @date    Nov 28, 2012
 * @author  Dhaval Patel <dhavalp@fermion.in>
 */

/* @class   Redirector
 * @brief   Redirector class 
 */

Final class Redirector {

	private function __construct() { }
	private function __deconstruct() { }

	public static function send($url) {
		header('Location: '.$url);
		exit;
	}

	public static function redirect($redirectTo, $queryStr='') {
		switch($redirectTo) {
			case 'LOGIN':
				header('Location: '.API_WEB_PATH.'/login.php');
				break;
            case 'DISPLAY_APPLET':
				header('Location: '.API_WEB_PATH.'/display_applet.php?'.$queryStr);
				break;
			default:
				header('Location: '.API_WEB_PATH.'/'.$redirectTo); 
		}
		exit;
	}
}

?>