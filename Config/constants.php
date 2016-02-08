<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


// --------[INDIA]------------
DEFINE("INDIA_PremiumAndRegular",0);
DEFINE("INDIA_TrophyPrice",4000);
DEFINE("INDIA_TrophyPlusPrice",6000);
DEFINE("INDIA_NoDaysAdvance",4);

Define("INDIA_NO_OF_DAYS_ADVANCE_WEEKDAY_MMG",2);
Define("INDIA_NO_OF_DAYS_ADVANCE_WEEKEND_MMG",7);
Define("INDIA_NO_OF_DAYS_DISPLAY_MAX_MMG",21);
// --------- [UAE] -----------
        

DEFINE("MERCHANT_ID",'');
DEFINE("CURRENT_WORKING_KEY",'');
DEFINE("REDIRECT_URL", 'http://dev.golflan_new.com/paynplay/redirecturl');
DEFINE("REDIRECT_LEARN_URL", 'http://dev.golflan_new.com/paynlearn/redirecturl');
DEFINE("REDIRECT_URL_PROSHOP", 'http://dev.golflan_new.com/product/proshop/redirecturl');
DEFINE("CHECK_ONLY_COMP_GAMES_INDIA", true);


DEFINE("VOUCHER_ACTIVE", 1);
DEFINE("VOUCHER_REEDEMED", 2);
DEFINE("VOUCHER_APPLICABLE_TO_ALL_GOLFCOURSES", 0);

// ------------------ MAIL SMTP CONFIGURATIONS ---------------------
DEFINE("FROM_EMAIL_ID",'customer.care@golflan.com');
DEFINE("MAIL_CC",'');

DEFINE('SMTP_HOST', 'smtp.gmail.com');
DEFINE('SMTP_AUTH', true);
DEFINE('SMTP_USERNAME', 'customer.care@golflan.com');
DEFINE('SMTP_PASSWORD', '');
DEFINE('SMTP_SECURE', 'tls');
DEFINE('SMTP_PORT', 587);
DEFINE('FROM_EMAIL_NAME', 'Golflan Customer Care');
DEFINE('SMTP_REPLY_EMAIL_ID', 'customer.care@golflan.com');
DEFINE('SMTP_REPLY_NAME', 'Information');


//---------------
DEFINE('PROSHOP_ORDER_NO_PREFIX','dev_proshop1_');
DEFINE('MMG_ORDER_NO_PREFIX','dev_MMG_');
DEFINE('MMG_LEARN_ORDER_NO_PREFIX','dev_MMG_Learn_');


//-------------------- Paypal credentials ----------------- 
DEFINE('PAYPAL_EMAIL','vickyb-facilitator@fermion.in');//DEFINE('PAYPAL_EMAIL','dhruv@golflan.com');//
DEFINE('PAYPAL_RETURN_URL','http://dev.golflan.com/paypal/returnurl.php');
DEFINE('PAYPAL_CANCEL_URL','http://dev.golflan.com/paypal/cancelurl.php');
DEFINE('PAYPAL_NOTIFY_EMAIl','vickyb@fermion.in');

DEFINE('SANDBOX_TESTING', true);
DEFINE('PAYPAL_INVOICE_NO_PREFIX', 'DEV_TOWERLINKS_');

DEFINE('PAYMENT_GATEWAY_CCAVENUE',0);
DEFINE('PAYMENT_GATEWAY_PAYPAL',1);


DEFINE('CURRENCY_API_ACCESS_KEY','859a862684c010355581441cfbcde9d6');
DEFINE('BASE_CURRENCY','USD');
DEFINE('CURRENCY_API_ACCESS_KEY_FERMION','1f70f95dd8a4c26a218da7730a133fde');


//-------------------- Location Constants -----------------------

DEFINE("LOCATION_INDEX_PAGE", 1);




DEFINE("IS_LIVE", false);

DEFINE("PLAY_PG_COMP_GC_COUNT", 3);
DEFINE("PLAY_PG_PLAY_GC_COUNT", 3);
DEFINE("CITY_PG_PLAY_GC_COUNT", 3);
