<?php	///// SYSTEM REQUIREMENT (do not change)	require('../includes/ep.page.head.include.php');		///// NEEDED DATA (only change values not data types)	$_epWebpage->setPageTplName("home");	$_epWebpage->setIsModule(true);		///// BEGIN: CONTENT CREATION (built your page here)			///// TODAY NOTES	$notes = $_epDatabase->getCalendarNotesByDate(date("d"),date("m"),date("Y"),$_epUser->data["user_agencyID"]);	if($notes){		$_epWebpage->assignToPage("notesCount",count($notes));	}else{		$_epWebpage->assignToPage("notesCount",0);	}						///// END: CONTENT CREATION 		///// SYSTEM REQUIREMENT (do not change)	require('../includes/ep.page.foot.include.php');?>