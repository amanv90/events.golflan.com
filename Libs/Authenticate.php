<?php

Class Authenticate extends \Slim\Middleware {

    public function __construct($db = 1) {
        $this->dbConn = $db;
    }

    public function call() {
        if (!$this->isValidRequest()) {
            $this->app->response->status(401);
            $this->app->response->header('WWW-Authenticate', INVALID_REQUEST);
            $this->app->stop();
        }
        $this->next->call();
    }

    public function isValidRequest() {
        $authStr = $this->app->request->headers->get(AUTHORISATION_HEADER);
        if(strlen($authStr) > 1) {
            $authArr = explode(':', $authStr);
            $apiKey = $authArr[0];

            if(!AUTHENTICATE_REQUESTS) {
                $userAccessData = $this->getSecretKey($apiKey);
                CommonFunc::setGlobalVar('authPartnerId', $userAccessData['partner_id']);
                CommonFunc::setGlobalVar('authPwineryId', $userAccessData['pwinery_id']);
                CommonFunc::setGlobalVar('cartExpiration', $userAccessData['cart_expiration']);
				CommonFunc::setGlobalVar('partnerName', $userAccessData['partner_name']);
                return true;
            }

            $clientHash = $authArr[1];
            if (strlen($apiKey) > 0 && strlen($clientHash) > 0) {
                $userAccessData = $this->getSecretKey($apiKey);
                if (strlen($userAccessData['secret_key']) > 0) {
                    $reqUrl = $_SERVER['REQUEST_URI'];
                    $reqBody = $this->app->request->getBody();
                    $serverHash = $this->computeHash($userAccessData['secret_key'], $reqUrl, $reqBody);
                    if ($serverHash == $clientHash) {
                        CommonFunc::setGlobalVar('authPartnerId', $userAccessData['partner_id']);
                        CommonFunc::setGlobalVar('authPwineryId', $userAccessData['pwinery_id']);
                        CommonFunc::setGlobalVar('cartExpiration', $userAccessData['cart_expiration']);
						CommonFunc::setGlobalVar('partnerName', $userAccessData['partner_name']);
                        return true;
                    }
                }
            }
        }
        return false;
    }

    private function getSecretKey($apiKey) {
        $partnerObj = new Partners($this->dbConn);
        return $partnerObj->getAccessDetailsByApiKey($apiKey);
    }

    private function computeHash($secretKey, $url, $data = '') {
        return hash_hmac(AUTHENTICATE_METHOD, $url . $data, $secretKey);
    }

}