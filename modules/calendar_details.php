<?php
	///// SYSTEM REQUIREMENT (do not change)
	require('../includes/ep.page.head.include.php');
	
	///// NEEDED DATA (only change values not data types)

	$_epWebpage->setPageTplName("calendar_details");
	$_epWebpage->setIsModule(true);
	
	///// BEGIN: CONTENT CREATION (built your page here)
	

	
	///// SET DISPLAYED AGTENCY DATA
	$selectedAgencyID = $_epUser->data["user_agencyID"];
	if($_GET["a"]!="") $selectedAgencyID		= $_GET["a"];
	$_epWebpage->assignToPage("selectedAgencyID",$selectedAgencyID);
	
	///// SET DISPLAYED MONTH DATA
	$selectedDay	= date("d");
	$selectedMonth	= date("m");
	$selectedYear	= date("Y");
	if($_GET["d"]!="") $selectedDay		= $_GET["d"];
	if($_GET["m"]!="") $selectedMonth	= $_GET["m"];
	if($_GET["y"]!="") $selectedYear	= $_GET["y"];
	$_epWebpage->assignToPage("selectedDay",$selectedDay);
	$_epWebpage->assignToPage("selectedMonth",$selectedMonth);
	$_epWebpage->assignToPage("selectedYear",$selectedYear);
	$_epWebpage->assignToPage("selectedDate",$selectedDay." ".$_PREF["MISC"]["MONTH_NAMES"][$selectedMonth+0]." ".$selectedYear);
	
	$monthDaysCount = cal_days_in_month(CAL_GREGORIAN,$selectedMonth,$selectedYear); 
	
	
	$dates = array();
	for($i=0;$i<(date("w",mktime(0,0,0,$selectedMonth,1,$selectedYear))-1)%7;$i++){
		$dates[]["day"] = '';
	}
	for($i=1;$i<=$monthDaysCount;$i++){
		$dates[]["day"] = $i;
	}
	$_epWebpage->assignToPage("dates",$dates);
	
	
	
	
	
	
	
	///// END: CONTENT CREATION 
	
	///// SYSTEM REQUIREMENT (do not change)
	require('../includes/ep.page.foot.include.php');
?>