<?php
	session_start();
	
	$root = "";
	while(!file_exists($root."pwr.engine/pwr.preferences.php")) $root .= "../";
	
	///// INCLUDE SITE PREFERENCES
	require($root.'pwr.engine/pwr.preferences.php');
	
	///// INCLUDE DMS
	require($root.'pwr.engine/includes/dms/pwr.dms.item.class.php');
	require($root.'pwr.engine/includes/dms/pwr.dms.item.field.class.php');
	
	///// INCLUDE AND INITIALIZE DATABASE OBJECT
	require($root.'pwr.engine/includes/pwr.database.class.php');
	require($root.'includes/ep.database.class.php');
	$_epDatabase = new epDatabase();
	
	///// INCLUDE AND INITIALIZE SERVICES OBJECT
	//require($root.'pwr.engine/includes/pwr.services.class.php');
	//require($root.'includes/pl.services.class.php');
	//$_plServices = new plServices($_epDatabase);
	
	///// INCLUDE AND INITIALIZE USER OBJECT
	require($root.'pwr.engine/includes/pwr.user.class.php');
	require($root.'includes/ep.user.class.php');
	$_epUser = new epUser($_epDatabase);
	$_epUser->loadData(session_id(),$_POST['email'],$_POST['password'],$_GET['a']);
	
	///// INCLUDE AND SET RAINTPL
	require($root.'pwr.engine/includes/rain.tpl.class.php');
	raintpl::configure( 'tpl_dir', './tpl/' );
	raintpl::configure( 'cache_dir', $root.'pwr.engine/tmp/' );
	raintpl::configure( 'path_replace', false );
	
	///// SET PAGE INFORMATIONS
	setlocale(LC_TIME,$_PREF["PAGE"]["LOCAL"]);
	
	
	require($root.'pwr.engine/includes/pwr.webpage.class.php');
	require($root.'includes/ep.webpage.class.php');
	$_epWebpage = new epWebpage();
	$_epWebpage->assignToPage("_epUser",$_epUser);
	
?>