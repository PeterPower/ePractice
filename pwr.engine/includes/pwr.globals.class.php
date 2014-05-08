<?php
	define("EASSISTANT_BUILD", "0.00090");
	
	define("SKEY_EXPIRATION_OFFSET", 14400*1000);
	
	define("ERROR_SKEYEXPIRED",		"00001");
	define("ERROR_LOGINDATA",		"00002");
	define("ERROR_NOTLOGGED",		"00003");
	define("ERROR_NOTACTIVATED",	"00004");
	
		
	// XML GENERATOR FROM DATA
	function getDataXML($key,$item){
		return "<".$key.">".getDataXMLRec($item)."</".$key.">";
	}
	function getDataXMLRec($data){
		if(is_array($data)){
			$xml = "";
			if($data)foreach($data as $key => $item){
				if(is_numeric($key)) $key = "list";
				$xml .= "<".$key.">".getDataXMLRec($item)."</".$key.">";
			}
			return $xml;
		}else{
			return htmlspecialchars($data);
		}
	}
	
	// ERROR HANDLER
	function sendError($errorID){
	
		switch($errorID){
			case ERROR_SKEYEXPIRED: 		$errorDescription = "La sessione utente è scaduta. E' necessario ricaricare la pagina ed effettuare il Login."; break;
			case ERROR_LOGINDATA: 			$errorDescription = "I dati d'accesso non sono corretti. Ricontrollare i dati e riprovare."; break;
			case ERROR_NOTLOGGED: 			$errorDescription = "Accesso non effettuato. E' necessario ricaricare la pagina ed effettuare il Login."; break;
			case ERROR_NOTACTIVATED: 		$errorDescription = "L'account non è attivo. Contattare l'amministratore di sistema per l'attivazione."; break;
				
			default:						$errorDescription = "Si è verificato un'errore. E' necessario ricaricare la pagina ed effettuare il Login. Se l'errore dovesse persistere contattare l'amministratore di sistema."; break;
		}
		
		echo "
			<error>
				<type>error</type>
				<code>".$errorID."</code>
				<description>".$errorDescription."</description>
			</error>";
	
	}
	
	/* creates a compressed zip file */
	function create_zip($files = array(),$fileNames = array(),$destination = '',$overwrite = false) {
		//if the zip file already exists and overwrite is false, return false
		if(file_exists($destination) && !$overwrite) { return false; }
		//vars
		$valid_files = array();
		$valid_fileNames = array();
		//if files were passed in...
		if(is_array($files)) {
			//cycle through each file
			for($i=0;$i<count($files);$i++){
				//make sure the file exists
				if(file_exists($files[$i])) {
					$valid_files[] = $files[$i];
					$valid_fileNames[] = $fileNames[$i];
				}
			}
			/*
			foreach($files as $file) {
				//make sure the file exists
				if(file_exists($file)) {
					$valid_files[] = $file;
					$valid_fileNames = array();
				}
			}
			*/
		}
		
		//print_r($valid_files);
		//print_r($valid_fileNames);
		
		//if we have good files...
		if(count($valid_files)) {
			//create the archive
			$zip = new ZipArchive();
			if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
				return false;
			}
			//add the files
			for($i=0;$i<count($valid_files);$i++){
				$zip->addFile($valid_files[$i],$valid_fileNames[$i]);
			}
			/*
			foreach($valid_files as $file) {
				$zip->addFile($file,$file);
			}
			*/
			//debug
			//echo 'The zip archive contains '.$zip->numFiles.' files with a status of '.$zip->status;
		
			//close the zip -- done!
			$zip->close();
			
		
			//check to make sure the file exists
			return file_exists($destination);
		}else{
			return false;
		}
	}
?>