<?php
    require_once '../../Config/config.php';
    require_once '../../Config/constants.php';
    require_once API_PATH . 'Slim/Slim.php';
    require_once API_PATH . 'Libs/AutoLoader.php';
    //register our class autoloader
    spl_autoload_register('AutoLoader::customAutoloader');
    $golfCourse = new Golfcourse(DB1);
//echo __DIR__ . '/app/Mage.php';exit;
//    $jsonurl = "http://apilayer.net/api/live?access_key=".CURRENCY_API_ACCESS_KEY."currencies=AUD,EUR,GBP,PLN,INR,SGD";
//    $json = file_get_contents($jsonurl,0,null,null);
//    $json_output = json_decode($json);
//    error_log(print_r($json_output,1));
//    
//    $address1 = $address;
    $url = "http://apilayer.net/api/live?access_key=".CURRENCY_API_ACCESS_KEY;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);
    
//    print_r($response_a['quotes']);
    if(isset($response_a['quotes'])){
        foreach ($response_a['quotes'] as $key => $value) {
            $baseCurrency = BASE_CURRENCY;
            $currencyISO = str_replace(BASE_CURRENCY, "", $key);
            if($currencyISO == ""){
                $currencyISO = BASE_CURRENCY;
            }
            $rate = $value;
            $currencyExist = $golfCourse->checkCurrencyExist($currencyISO);
            if($currencyExist == 0){
                $golfCourse->insertCurrencyRate($currencyISO, $baseCurrency, $rate);
                echo "Inserted $currencyISO\n";
            }else{
                $golfCourse->updateCurrencyRate($currencyISO, $baseCurrency, $rate);
                echo "Updated $currencyISO\n";
            }
        }
    }
?>
