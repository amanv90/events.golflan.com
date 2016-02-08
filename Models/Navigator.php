<?php

final class Navigator {

	/**
	* navigatorData navigate the data for the pagination
	* @param INT $totalRecords contains total number of records
	* @param INT $recordsPerPage contains number of records on one page
	* @param String $itemName contains the name of Item
	* <p>This function navigate the data for the pagination</p>
	* @return void
	*/
	public static function navigatorData($totalRecords, $recordsPerPage, $itemName = 'Item', $filter = '') {
		if (!($totalRecords <= $recordsPerPage)) {
			$currentPage = (int) isset($_GET['page']) ? $_GET['page'] : 1;
			$offset = (int) ($currentPage * $recordsPerPage) - ($recordsPerPage);
			if($offset < 1) $offset = 0;
			$totalPages = ceil($totalRecords / $recordsPerPage);
			$sqlLimit = ' LIMIT '. $offset . ',' . $recordsPerPage;
			$firstPage = 1;
			$previousPage = $currentPage == 1 ? 1 : $currentPage - 1;
			$nextPage = $currentPage == $totalPages ? $totalPages : $currentPage + 1;
//			if($currentPage > 1){
//				$filter = '';
//			}
			return array(
				'itemName' => $itemName,
				'starts' => $offset,
				'sql_limit' => $sqlLimit,
				'firstpage' => $firstPage,
				'previouspage' => $previousPage,
				'currentpage' => $currentPage,
				'nextpage' => $nextPage,
				'lastpage' => $totalPages,
				'totalpages' => $totalPages,
				'totalrecords' => $totalRecords,
				'recordsperpage' => $recordsPerPage,
				'pagaData' => $filter,
				'scripturl' => self::getURL()
			);
		}
	}

	/**
	* getURL gets the requested page URL
	* <p>This function gets the requested page URL</p>
	* @return String [ URL ]
	*/
	private static function getURL() {
		$ARGS = null;
		$getParam = $_GET;
//		print_r($getParam);exit;
		if(count($getParam) > 0) {
			unset($getParam['page']);
			unset($getParam['request']);
			foreach ($getParam as $arg => $v) {
//                print_r($v);exit;
				$ARGS .= "$v";
			}
		}

//		return  '?'. $ARGS;
		return  '?';
	}
}
?>