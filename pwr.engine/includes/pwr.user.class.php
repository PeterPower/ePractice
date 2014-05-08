<?php
	class pwrUser{
		
		public	$_database;
		
		private $tableName;
		private	$tablePrimaryKey;
		private $tableFieldPrefix;
		
		public 	$isLogged = false;
		public 	$data;
		public	$ID;
		public 	$sKey;
		
		public	$errorCode;
		
		
		public function pwrUser($tableName,$_database){
			$this->_database = $_database;
			$this->tableName = $tableName;
			
			
			// set table PrimaryKey
			$infos = $this->_database->getFirstRecordBySql("SELECT col.column_name AS PrimaryKey FROM information_schema.table_constraints tc INNER JOIN information_schema.key_column_usage col
																ON col.Constraint_Name = tc.Constraint_Name AND col.Constraint_schema = tc.Constraint_schema
																WHERE tc.Constraint_Type = 'Primary Key' AND col.Table_name = '".$this->_database->getTableName($this->tableName)."'");
			$this->tablePrimaryKey = $infos["PrimaryKey"];
			
			// set table Field Prefix
			$infos = explode('_',$this->tablePrimaryKey);
			$this->tableFieldPrefix = $infos[0];
		}
		
		public function clearData(){
			$this->isLogged = false;
			$this->data = null;
			$this->ID = null;
			$this->sKey = null;
			$this->errorCode = null;
		}
		
		public function loadData($sKey,$username,$password,$action){
			global $_PREF;
			
			$this->clearData();
			
			if($sKey){
				if($action=="logout"){
					///// REMOVE SKEY FROM DB
					$this->_database->updateRecords($this->tableName,$this->tableFieldPrefix."_sKey=''",$this->tableFieldPrefix."_sKey='".$sKey."'");
				}else{
					///// CHECK IF SKEY CAN EXPIRE
					if($_PREF["USER"]["SESSION"]["EXPIRATION"]>0) $sKeyExpirationApp = " AND sKeyExpirationTimestamp>'".time()."'";
					///// GET USER DATA FROM SKEY
					$this->data = $this->_database->getFirstRecord("*",$this->tableName,$this->tableFieldPrefix."_sKey='".$sKey."'".$sKeyExpirationApp);
					
					if(!$this->data){
						///// SESSION EXPIRED
						$errorCode = "0000";
					}
				}
			}
			if($action=="login"){
				///// GET USER FROM USERNAME/PASSWORD
				$this->data = $this->_database->getFirstRecord("*",$this->tableName,$this->tableFieldPrefix."_email='".$username."' AND ".$this->tableFieldPrefix."_password='".md5($password)."' AND ".$this->tableFieldPrefix."_isActive=1");
				
				if($this->data){
					///// USER EXISTS
					///// ASSIGN SKEY TO THE USER
					$this->_database->updateRecords($this->tableName,$this->tableFieldPrefix."_sKey='".$sKey."'",$this->tableFieldPrefix."_ID='".$this->data[$this->tableFieldPrefix."_ID"]."'");
				}else{	
					///// WRONG USERNAME/PASSWORD
					$errorCode = "0001";						
				}

				//$_dbConnection->doQuery("INSERT INTO ea_accessLog (accessLog_date,accessLog_time,accessLog_ip,accessLog_username,accessLog_password,accessLog_result) VALUES
				//		('".date('d/m/Y')."','".date('H:i')."','".$_SERVER['REMOTE_ADDR']."','".$_POST['username']."','".md5($_POST['password'])."','".$accessResult."')");				
			}
		
			if($this->data){
				///// USER EXISTS
				$this->isLogged = true;
				$this->sKey = $sKey;
				$this->ID = $this->data[$this->tableFieldPrefix."_ID"];
				///// UPDATE USER SKEY EXPIRATION TIMESTAMP
				$this->_database->updateRecords($this->tableName,$this->tableFieldPrefix."_sKeyExpirationTimestamp='".(time()+$_PREF["USER"]["SESSION"]["EXPIRATION"])."'",$this->tableFieldPrefix."_ID='".$this->ID."'");
			}
		}
		
		public function reloadData(){
			$this->loadData($this->sKey,null,null,null);
		}
		
		
		
		/*
		public function pwrUser($sKey = null){
			global $_dbConnection;
			global $_POST;
			
			if($sKey){
			
				if($this->checkSKeyExpiration)
				
				$this->data = 
				
				$this->data = $_dbConnection->getFirstRecord("SELECT * FROM ea_users JOIN ea_agencies ON user_agencyID=agency_ID
															WHERE user_sKey='".$sKey."'"); //AGGIUNGERE CONTROLLO SCADENZA SKEY
															
				if($this->data){
					$this->isLogged = true;
				}else{	
					//sendError(ERROR_SKEYEXPIRED);									
				}
				
			}else{
				
				
				$this->data = $_dbConnection->getFirstRecord("SELECT * FROM ea_users ea_users JOIN ea_agencies ON user_agencyID=agency_ID
															WHERE user_username='".$_POST['username']."' AND user_password='".md5($_POST['password'])."' AND user_isActive=1");
															
				if($this->data){
					$this->isLogged = true;
					$_dbConnection->doQuery("UPDATE ea_users SET
							user_sKey='".$this->data['user_ID']."_".md5($_smUsername.time())."'
							WHERE user_ID='".$this->data[$this->tableFieldPrefix."_ID"]."'");
					$accessResult = "SUCCESS";
				}else{	
					//sendError(ERROR_LOGINDATA);		
					$accessResult = "ERROR";							
				}
				
				$_dbConnection->doQuery("INSERT INTO ea_accessLog (accessLog_date,accessLog_time,accessLog_ip,accessLog_username,accessLog_password,accessLog_result) VALUES
						('".date('d/m/Y')."','".date('H:i')."','".$_SERVER['REMOTE_ADDR']."','".$_POST['username']."','".md5($_POST['password'])."','".$accessResult."')");
				
			
			}
			
			if($this->isLogged){
				$this->ID = $this->data['user_ID'];
				$this->typeID = $this->data['agency_typeID'];
				$_dbConnection->doQuery("UPDATE ea_users SET
						user_SKeyExpirationTime='".(time()+SKEY_EXPIRATION_OFFSET)."'
						WHERE user_ID='".$this->ID."'");
			
			}
		}
		*/
		public function setLastAction($action,$time){
			global $_dbConnection;
			$_dbConnection->doQuery("UPDATE ea_users SET
							".$this->tableFieldPrefix."_lastAction='".$action."',
							".$this->tableFieldPrefix."_lastActionTime='".$time."'
							WHERE ".$this->tableFieldPrefix."_ID='".$this->data[$this->tableFieldPrefix."_ID"]."'");
		}
		
	}
	
?>