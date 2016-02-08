<?php 
    require_once '../router.php';
    $golfCourse = new GolfCourse(DB1);
    //---- Start date -----
    $startDate = '2015-06-23';
    //---- End date -------
    $endDate = '2015-06-30';

    while (strtotime($startDate) <= strtotime($endDate)) {
 
        $gid = 11;
        $returnArr = $golfCourse->getGCMemberSlots($gid);
        $t1 = strtotime($returnArr['startTime']);
        $t2 = strtotime($returnArr['endTime']);
        $slotInterval = $returnArr['slotIntervalMins'];
        $timeslots[]= date('H:i:s', $t1);
        while ($t1 < $t2) {
            $slotTime = date('H:i:s', $t1);
            $t1 = strtotime('+'.$slotInterval.' minutes', $t1);
            echo "$startDate $slotTime\n";
            $timeslots[] = date('H:i:s', $t1);
            $insertID = $golfCourse->insertGCMemberSlot($gid, $startDate, $slotTime);
            echo "$insertID\n";
        }
        $startDate = date ("Y-m-d", strtotime("+1 day", strtotime($startDate)));
    }
    
?>