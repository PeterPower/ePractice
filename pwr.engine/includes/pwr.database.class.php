<?php 
 
	class pwrDatabase{
	
		private $dbc_host;
		private $dbc_name;
		private $dbc_username;
		private $dbc_password;
		private $dbc_debug;
		private $dbc_tag;
		
		private $dbc_is_open = false;
		private $dbc_connection;
		
		
		
		public function pwrDatabase(){
			global $_PREF;
			$this->dbc_host			= $_PREF["DB"]["HOST"];
			$this->dbc_name			= $_PREF["DB"]["NAME"];
			$this->dbc_username		= $_PREF["DB"]["USERNAME"];
			$this->dbc_password		= $_PREF["DB"]["PASSWORD"];
			$this->dbc_debug		= $_PREF["DB"]["DEBUG"];
			$this->dbc_tag			= $_PREF["DB"]["TAG"];
			
			
			$this->dbc_connection = new mysqli($this->dbc_host,$this->dbc_username,$this->dbc_password,$this->dbc_name);
			
			if($mysqli->connect_error){
				die('Connect Error ('. $mysqli->connect_errno.') '.$mysqli->connect_error);
				$this->dbc_is_open = false;
			}else{
				$this->dbc_is_open = true;
				$this->dbc_connection->query("SET CHARACTER SET utf8");
			}
			
		}
		
		public function getTableName($tableName){
			return $this->dbc_tag.$tableName;
		}
		
		public function close() {
			$this->dbc_connection->close($this->dbc_connection);
			$this->dbc_is_open = false;
						
		}

		
		/* OLD METHOD
		public function getAllRecords($query){
			$records = mysql_query($query);
			if(mysql_num_rows($records)==0) return false;
			if($records){
				do{
					$data = mysql_fetch_assoc($records);
					if($data) $result[] = $data;
				}while($data);
				return $result;
			}else{
				if($this->dbc_debug) echo "Errore nella query: ".$query;
				return false;
			}
		}
		*/
		
		public function getAllRecordsBySql($query){
		
			$results = $this->dbc_connection->query($query);
			
			if($results->num_rows==0) return false;
			if($results){
				do{
					$data = $results->fetch_assoc();
					if($data) $result[] = $data;
				}while($data);
				return $result;
			}else{
				if($this->dbc_debug) echo "Errore nella query: ".$query;
				return false;
			}
		
		}
		
		
		public function getAllRecords($fields,$table,$condition=null,$groupby=null,$orderby=null,$limit1=-1,$limit2=null){
		
			$query = "SELECT ".$fields." FROM ".$this->dbc_tag.$table;
			if($condition)	$query .= " WHERE ".$condition;
			if($groupby)	$query .= " GROUP BY ".$groupby;
			if($orderby)	$query .= " ORDER BY ".$orderby;
			if($limit1>=0)	$query .= " LIMIT ".$limit1;
			if($limit2>0)	$query .= ", ".$limit2;
			
			return $this->getAllRecordsBySql($query);
		}
		
		
		
		public function getFirstRecordBySql($query){
			
			$records = $this->dbc_connection->query($query);
			if($records){
				return $records->fetch_assoc();
			}else{
				if($this->dbc_debug) echo "Errore nella query: ".$query;
				return false;
			}
		}
		
		public function getFirstRecord($fields,$table,$condition=null,$groupby=null,$orderby=null){
		
			$query = "SELECT ".$fields." FROM ".$this->dbc_tag.$table;
			if($condition)	$query .= " WHERE ".$condition;
			if($groupby)	$query .= " GROUP BY ".$groupby;
			if($orderby)	$query .= " ORDER BY ".$orderby;
			$query .= " LIMIT 1";
			
			$records = $this->dbc_connection->query($query);
			if($records){
				return $records->fetch_assoc();
			}else{
				if($this->dbc_debug) echo "Errore nella query: ".$query;
				return false;
			}
		}
		
		
		public function updateRecords($table,$sets,$condition){
		
			$query = "UPDATE ".$this->dbc_tag.$table;
			$query .= " SET ".$sets;
			$query .= " WHERE ".$condition;
			
			$records = $this->dbc_connection->query($query);
			if($records){
				return true;
			}else{
				if($this->dbc_debug) echo "Errore nella query: ".$query;
				return false;
			}
		}
		
		
		
		
		
		
		
		
		
		
		public function doQuery($query) {
			$result = $this->dbc_connection->query($query);
			if($result) {
				return true;
			}else{
				if($this->dbc_debug) echo "Errore nella query: ".$query;
				return false;
			}
		}
		
		public function getCountBySql($query) {
			$results = $this->dbc_connection->query($query);
			if($results) {
				return $results->num_rows;
			}else{
				if($this->dbc_debug) echo "Errore nella query: ".$query;
				return false;
			}
		}
		
		
		
		
		
		
		
		public function updateRecord($tableName,$idField,$id,$data){
			$fullTableName = $this->dbc_tag.$tableName;
			
			unset($data['sys_ownerID']);
			if($this->getFirstRecordBySql("SELECT * FROM ".$fullTableName." WHERE ".$idField."='".$id."'")){
				$columns = $this->getAllRecordsBySql("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='".$this->dbc_name."' AND TABLE_NAME='".$fullTableName."'");
				$isFirst = true;
				$querySET = "";
				foreach($columns as $k =>$column){
					if(array_key_exists($column['COLUMN_NAME'],$data)){
						if(!$isFirst) $querySET .= ", ";
						$querySET .= $column['COLUMN_NAME']."='".str_replace("'","\\'",$data[$column['COLUMN_NAME']])."'";
						$isFirst = false;
					}
				}
				if(!$isFirst) $this->doQuery("UPDATE ".$fullTableName." SET ".$querySET." WHERE ".$idField."='".$id."'");
				//echo "<q>UPDATE ".$fullTableName." SET ".$querySET." WHERE ".$idField."='".$id."'</q>";
				return $id;
			}
		}
		
		public function newRecord($tableName,$idField,$data){
			$fullTableName = $this->dbc_tag.$tableName;
			
			$dbc_tag = $this->dbc_tag;
			$this->dbc_tag = "";
			$columns = $this->getAllRecords("COLUMN_NAME","INFORMATION_SCHEMA.COLUMNS","TABLE_SCHEMA='".$this->dbc_name."' AND TABLE_NAME='".$fullTableName."'");
			$this->dbc_tag = $dbc_tag;
			
			$isFirst = true;
			$sysID = md5($fullTableName.time());
			$queryFIELDS = "sys_ID";
			$queryVALUES = "'".$sysID."'";
			foreach($columns as $k =>$column){
				if(array_key_exists($column['COLUMN_NAME'],$data) && $column['COLUMN_NAME']!=$idField){
					$queryFIELDS .= ",";
					$queryVALUES .= ",";
					
					$queryFIELDS .= $column['COLUMN_NAME'];
					$queryVALUES .= "'".str_replace("'","\\'",$data[$column['COLUMN_NAME']])."'";
					$isFirst = false;
				}
			}
			if(!$isFirst) $this->doQuery("INSERT INTO ".$fullTableName." (".$queryFIELDS.") VALUES (".$queryVALUES.")");
			
			$item = $this->getFirstRecord("*",$tableName,"sys_ID='".$sysID."'");
			$id = $item[$idField];
			
			
			$this->doQuery("UPDATE ".$fullTableName." SET sys_ID='' WHERE sys_ID='".$sysID."'");
			return $id;
		}
		
		public function deleteRecord($tableName,$idField,$id){
			$this->doQuery("DELETE FROM ".$tableName." WHERE ".$idField."='".$id."'");
		}
		
	}
?>