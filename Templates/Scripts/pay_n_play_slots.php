<?php 
    require_once '../../Config/config.php';
    require_once '../../Config/constants.php';
    require_once API_PATH . 'Slim/Slim.php';
    require_once API_PATH . 'Libs/AutoLoader.php';
    //register our class autoloader
    spl_autoload_register('AutoLoader::customAutoloader');

    $daysToInsert = array(1,2,3,4,5,6,7); //1=>Monday, 2=> tuesday, 3=>wednesday, 4=>Thursday, 5=>friday, 6=>Saturday, 7=>Sunday
    $golfcourseObj = new Golfcourse(DB1);
    //---- Start date -----
    $startDate = '2015-12-28';
    //---- End date -------
    $endDate = '2016-01-31';
    $allowUpdate = true;
    while (strtotime($startDate) <= strtotime($endDate)) {
        $dayNum = date('N', strtotime($startDate));
        if(in_array($dayNum, $daysToInsert)){
            //--------- variables ------------
            $gid = 11;
            $listPrice = 188; 
            $ourPrice = 160;
            $currencyISO = 'INR';
            //---------------------------------
            $returnArr = $golfcourseObj->getPayNPlaySlots($gid);
            $t1 = strtotime($returnArr['startTime']);
            $t2 = strtotime($returnArr['endTime']);
            $slotInterval = $returnArr['slotIntervalMins'];
            $timeslots[]= date('H:i:s', $t1);
            while ($t1 < $t2) {
                $slotTime = date('H:i:s', $t1);
                $t1 = strtotime('+'.$slotInterval.' minutes', $t1);
                echo "$startDate $slotTime\n";
                $timeslots[] = date('H:i:s', $t1);
                $isExist = $golfcourseObj->checkSlotExist($gid, $startDate, $slotTime);
                if($isExist == 0){
                    $insertID = $golfcourseObj->insertPayNPlaySlot($gid, $startDate, $slotTime, $listPrice, $ourPrice, $currencyISO);
                    echo "$insertID\n";
                }else{
                    if($allowUpdate){
                        $timestamp = strtotime($startDate);
                        $playDate = date('Y-m-d', $timestamp);
                        $insertID = $golfcourseObj->updatePayNPlaySlotFromScript($gid, $playDate, $slotTime, $listPrice, $ourPrice, $currencyISO);
                        if($insertID > 0){
                            echo "Updated ";
                        }else{
                            echo "Unable to update ";
                        }
                    }else{
                        echo "Already Exist ";
                    }
                }
            }
        }
        $startDate = date ("Y-m-d", strtotime("+1 day", strtotime($startDate)));
    }
    
?>
