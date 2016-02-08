<?php

class Controller {

	protected $app;

	public function __construct() { }

	public function authorizeRequest() {
		if(!$this->isAuthorized()) {
			$this->app->response->status(401);
			$this->app->response->header('WWW-Authenticate', 'Can not authenticate request.');
			$this->app->stop();
		}
	}

	public function isAuthorized() {
		if($this->isValidRequest() || !AUTHENTICATE_REQUESTS) {
			return true;
		}
		return false;
	}

	public function isValidRequest() {
			$app = \Slim\Slim::getInstance();
			$authStr = $app->request->headers->get('x_authorize');
			$authArr = explode(':', $authStr);
			$userUid = $authArr[0];
			$clientHash = $authArr[1];
            $reqUrl = API_WEB_PATH.''.$_SERVER['REQUEST_URI'];
            $reqBody = $app->request->getBody();            
			if(strlen($userUid) > 0 && strlen($clientHash) > 0) {
//                $userSecretKey = $this->getSecretKey($userUid);
                $serverHash = $this->computeHash($userSecretKey, $reqUrl, $reqBody);
//                $activeFlag = $this->getUserStatus($userUid);
//                if($activeFlag == ACTIVE){
//                    if($serverHash == $clientHash){
                        return true;
//                    }
//                }
			}
			return false;
	}

	private function getSecretKey($apiKey) {
			$userObj = new User();
			return $userObj->getUserSecretKey($apiKey);
	}

	private function computeHash($secretKey, $url, $data = '') {
			return hash_hmac(AUTHENTICATE_METHOD, $url.$data, $secretKey);
	}

//	private function getUserStatus($userUID){
//        $userObj = new User();
//        return $userObj->checkActiveUser($userUID);
//	}
}
