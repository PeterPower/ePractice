<?php
	
	$_epWebpage->assignToMain("_epUser",$_epUser);
	
	///// ASSIGN FOOTER PARTS
	//$_plWebpage->assignToMain("_last5News",$_plDatabase->getLast5News());
	//$_plWebpage->assignToMain("_next5Events",$_plDatabase->getNext5Events());
	
	$_epWebpage->draw();
?>