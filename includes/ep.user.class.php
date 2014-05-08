<?php 
	class epUser extends pwrUser{
	
		public 	$isAdmin = false;
		public 	$isAssociated = false;
	
		public function epUser($_database){
			global $_PREF;
			
			parent::pwrUser("users",$_database);
			
		}
		
		public function loadData($sKey,$username,$password,$action){
			global $_plDatabase;
		
			parent::loadData($sKey,$username,$password,$action);
			
			$this->isAdmin = false;
			if($this->isLogged && $this->data["user_typeID"]==0) $this->isAdmin = true;
			
			$this->isAssociated = false;
			if($this->isLogged && $this->data["user_isAssociated"]==1){
				
				$timestamp = mktime(0,0,0,date("m"),date("d"),date("Y")-1);
				$payments = $_plDatabase->getAllRecordsBySql("SELECT * FROM lp_payments JOIN lp_externalValues ON payment_causeID=externalValue_ID
															WHERE payment_userID='".$this->ID."' AND externalValue_key='QUOTA_ASSOCIATIVA' AND payment_timestamp>".$timestamp);
															
				if($payments){												
					$this->isAssociated = true;
				}
			}
		}
		
		
	}
	
?>