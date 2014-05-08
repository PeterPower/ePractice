<?php
	class pwrServices{
	
		public	$dbConnection;
		
		public function pwrServices($dbConnection){
			$this->dbConnection = $dbConnection;
		}
		
		
		public function sendEmail($to, $object, $text){
			global $_PREF;
			
			$headers  = "From: ".$_PREF["EMAIL"]["ADMIN_NAME"]." <".$_PREF["EMAIL"]["ADMIN_ADDRESS"]."> \r\n";
			$headers .= "Reply-To: <".$_PREF["EMAIL"]["ADMIN_ADDRESS"]."> \r\n";
			$headers .= "X-Mailer: PHP/".phpversion();
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-Type: text/html; charset=\"utf-8\"\n";
			$headers .= "Content-Transfer-Encoding: 7bit\n\n";
			
			return mail($to,$object,$text,$headers);
		}
		
		
		
	}
	
?>