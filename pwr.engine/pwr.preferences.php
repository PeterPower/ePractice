<?php

	///// SITE
	$_PREF["SITE"]["LOCAL"]				= "IT_it";									// setlocale(LC_TIME,...)
	$_PREF["SITE"]["AUTHOR"]			= "Peter Power";
	$_PREF["SITE"]["TITLE"]				= "ePractice";
	$_PREF["SITE"]["TITLESEPARATOR"]	= " - ";
	
	
	///// EMAIL
	$_PREF["EMAIL"]["ADMIN_ADDRESS"]		= "info@studiopiccari.it";				// system emails sent from/to ...
	$_PREF["EMAIL"]["ADMIN_NAME"]			= "Studio Piccari";						// system emails sent as ...
	
	/////  USER
	$_PREF["USER"]["SESSION"]["EXPIRATION"]	= 0;									// 0 = no expiration

	///// DATABASE
	$_PREF["DB"]["HOST"]		= "127.0.0.1";
	$_PREF["DB"]["NAME"]		= "db_ePractice";
	$_PREF["DB"]["USERNAME"]	= "root";
	$_PREF["DB"]["PASSWORD"]	= "";
	//$_PREF["DB"]["HOST"]		= "62.149.150.155";
	//$_PREF["DB"]["NAME"]		= "Sql541410_4";
	//$_PREF["DB"]["USERNAME"]	= "Sql541410";
	//$_PREF["DB"]["PASSWORD"]	= "d9ed4665";
	$_PREF["DB"]["DEBUG"]		= true;
	$_PREF["DB"]["TAG"]			= "ep_";
	
	///// MISC
	$_PREF["MISC"]["MONTH_NAMES"]	=  array("","Gennaio","Febbraio","Marzo","Aprile","Maggio","Giugno","Luglio","Agosto","Settembre","Ottobre","Novembre","Dicembre");
	$_PREF["MISC"]["MONTH_SHORTNAMES"]	=  array("","Gen","Feb","Mar","Apr","Mag","Giu","Lug","Ago","Set","Ott","Nov","Dic");
	
	///// ERRORS
	$_PREF["ERRORS"]["0000"]	= "La tua sessione è scaduta!";
	$_PREF["ERRORS"]["0001"]	= "Username e/o Password errati!";

?>