<?php 
 
	abstract class pwrDmsItem{
	
		private $_database;
		
		public $archiveTitle;
		public $archiveRecordsList;
		public $archiveFieldsList;
		public $archiveTplName;
		
		public $formTitle;
		public $formRecord;
		public $formFieldsList;
		public $formTplName;
		
		
		
		public $tableName;
		public $tableFieldPrefix;
		public $tablePrimaryKey;
		
		
		public $ID;
		public $className;
		
		
		
		

		///// CONSTRUCTOR
		public function pwrDmsItem($tableName,$_database){
			
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
		
		
		///// ARCHIVE METHODS
		public function setArchive(){
			$this->setArchiveRecordsList();
			$this->setArchiveFieldsList();
		}
		
		private function setArchiveRecordsList(){
			$this->archiveRecordsList = $this->_database->getAllRecords("*",$this->tableName);
		}
		
		abstract function setArchiveFieldsList();
		

		///// FORM METHODS
		public function setForm(){
			$this->setFormRecord();
			$this->setFormFieldsList();
			$this->setFormFieldsValues();
		}
		
		
		private function setFormRecord(){
			$this->formRecord = $this->_database->getFirstRecord("*",$this->tableName,$this->tablePrimaryKey."='".$this->ID."'");
		}
		
		abstract function setFormFieldsList();
		
		public function setFormFieldsValues(){
			if($this->formFieldsList)foreach($this->formFieldsList as $k => $field){
				$this->formFieldsList[$k]->startingValue = $this->formRecord[$this->tableFieldPrefix."_".$field->name];
			}
		}
		
		public function getFormFieldByName($name){
			if($this->formFieldsList)foreach($this->formFieldsList as $k => $field){
				if($field->name==$name) return $this->formFieldsList[$k];
			}
			return false;
		}
		
		public function saveForm($dataList){
			$fieldsToSave = array();
			
			if($dataList)foreach($dataList as $k => $data){
				$fieldsToSave[$this->tableFieldPrefix."_".$k] = $data;
			}
			
			if($this->ID!=""){
				$this->_database->updateRecord($this->tableName,$this->tablePrimaryKey,$this->ID,$fieldsToSave);
			}else{
				$this->ID = $this->_database->newRecord($this->tableName,$this->tablePrimaryKey,$fieldsToSave);
			}
		}
		
	}
		
		
		
		
		
		
		/*
		public $prefix; //:String;
		public $ID; //:String;
		public $IDField; //:String;
		public $extID; //:String;
		public $extIDField; //:String;
		public $fieldsList; //:Array;
		public $startingValues; //:Object;
		public $additionalData; //:Object;
		public $formComponent; //:Group;
		public $formComponentClass; //:Class;
		public $container; //:*;
		public $getDataPhpFunction; //:String;
		public $getDataArgs; //:Object = new Object();
		
		
		public $loadingItemsCount; //:Number;
		public $loadCallback; //:Function = function():void{};
		public $constructorLoadCallback; //:Function = function():void{};
		public $parentLoadCallback; //:Function = function():void{};
		
		public $showSaveConfirmaton; //:Boolean;
		public $savingItemsCount; //:Number;
		public $saveCallback; //:Function = function():void{};
		public $formSaveCallback; //:Function = function():void{};
		public $parentSaveCallback; //:Function = function():void{};
		
		public $isDestroyed; //:Boolean = false;
		public $destroyCallback; //:Function = function():void{};
		public $formDestroyCallback; //:Function = function():void{};
		public $parentDestroyCallback; //:Function = function():void{};
		

		public function pwrArchiveItem($container,$prefix,$IDField,$ID,$getDataPhpFunction,$formComponentClass){
			$this->prefix = $prefix;
			$this->fieldsList = array();
			
			$this->ID = $ID;
			$this->IDField = $IDField;
			
			$this->formComponentClass = $formComponentClass;
			
			$this->container = $container;
			//$this->container.removeAllElements();
			//$this->container.addElement(new Cp_Loading());
			
			$this->getDataPhpFunction = $getDataPhpFunction;
		}
		
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/////                                                                                                           /////
		/////                                          SET                                                              /////
		/////                                                                                                           /////
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		public function loadModuleFields(){
			if($this->getDataPhpFunction){
				$this->getDataArgs['itemID'] = $this->ID;
				//C_ServerConnection.getDataFromServer(this.getDataPhpFunction,getDataArgs,setModuleFields);
			}else{
				$this->setModuleFields();
			}
		}
		
		public function setModuleFields($result){
			
			$this->loadingItemsCount = 1;
			//this.formComponent = new this.formComponentClass();
			//this.formComponent['itemObject'] = this;
			
			if($result){
				if($this->ID && $result['itemData']){
					$this->ID = $result['itemData'][$this->prefix + $this->IDField];
					$this->startingValues = $result['itemData'];
					//this.formComponent['itemExists'] = true;
				}
				$this->additionalData = $result['additionalData'];
			}
			
			$this->fieldsList = array();
			
			//this.constructorLoadCallback();
			
			foreach($fieldsList as $k => $field){
				$fieldValue = null;
				if($this->startingValues && $this->startingValues[$this->prefix+$field->name]) $fieldValue = $this->startingValues[$this->prefix + $field->name];
				
				//field.setValue(this.formComponent['tip_'+field.name],fieldValue);
				//if(field.needLabel()) field.setLabel(this.formComponent['lbl_'+field.name]);
				
				if($field->type=='CLASS'){
					$this->loadingItemsCount++;
					//field.fieldObject.parentLoadCallback = this.confirmedLoad;
				}
			}
			
			//this.confirmedLoad();
		}
		
		public function confirmedLoad():void{
			this.loadingItemsCount--;
			if(this.loadingItemsCount==0){
				if(this.formComponent.hasOwnProperty('setItem')) this.formComponent['setItem'](this.startingValues);
				this.formComponent['isFormSet'] = true;
				
				this.container.removeAllElements();
				this.formComponent.visible = true;
				this.container.addElement(this.formComponent);
				
				this.parentLoadCallback();
				this.loadCallback();
			}
		}
		
		public function resetModuleLabels():void{
			for each(var field:C_Field in fieldsList){
				if(field.needLabel()) field.setLabel(this.formComponent['lbl_'+field.name],false);
			}
		}
		
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/////                                                                                                           /////
		/////                                           SAVE                                                            /////
		/////                                                                                                           /////
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		public function save(showSaveConfirmaton:Boolean=true):void{
			if(this.isReadyToSave()){
				this.formComponent.visible = false;
				this.container.addElement(new Cp_Loading());
				this.showSaveConfirmaton = showSaveConfirmaton;
				
				var post_data:Object = new Object();
				
				for each(var field:C_Field in this.fieldsList){
					if(field.type!='CLASS') post_data[prefix+field.name] = field.getPostData(this.formComponent['tip_'+field.name]);
				}
				
				post_data.itemID = this.ID;
				if(this.extID && this.extIDField) post_data[this.prefix+this.extIDField] = this.extID;
				
				C_ServerConnection.getDataFromServer(this.getDataPhpFunction+"?action=save",post_data,saveSubClasses);
			}else{
				Alert.show(
					'Impossibile salvare le modifiche!\n\nAlcuni campi potrebbero non rispettare i vincoli, tali campi saranno indicati dall\'etichetta rossa.\n\n' + C_Globals.STR_BUFFER + "\n",
					'Salvataggio Modifiche',
					mx.controls.Alert.OK,
					C_Globals.APPLICATION, null,
					C_Globals.ALERT_ICON_ERROR,
					mx.controls.Alert.OK);
			}
		}
		
		public function saveSubClasses(httpResult:Object):void{
			this.ID = httpResult.itemID;
			this.savingItemsCount = 0;
			for each(var field:C_Field in this.fieldsList){
				if(field.type=='CLASS' && !field.fieldObject.isDestroyed){
					this.savingItemsCount++;
					field.fieldObject.parentSaveCallback = this.confirmedSave;
					field.fieldObject.extID = this.ID;
					field.fieldObject.save(false);
				}
			}
			if(this.savingItemsCount==0){
				this.savingItemsCount++;
				confirmedSave();
			}
		}
		public function confirmedSave():void{
			this.savingItemsCount--;
			if(this.savingItemsCount==0){
				if(this.showSaveConfirmaton){
					Alert.show(
						'Le modifiche sono state salvate con successo!\n\n',
						'Salvataggio Modifiche',
						mx.controls.Alert.OK,
						C_Globals.APPLICATION, 
						function(event:CloseEvent):void{
							completeSave();
							loadModuleFields();
						},
						C_Globals.ALERT_ICON_SUCCESS,
						mx.controls.Alert.OK);
				}else{
					completeSave();
				}
			}
		}
		public function completeSave():void{
			this.saveCallback();
			this.parentSaveCallback();
			this.formSaveCallback();
		}
		
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/////                                                                                                           /////
		/////                                          DESTROY                                                          /////
		/////                                                                                                           /////
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		public function destroy():void{
			var post_data:Object = new Object();
			post_data.itemID = this.ID;
			
			C_ServerConnection.getDataFromServer(this.getDataPhpFunction+"?action=destroy",post_data,completeDestroy);
		}
		
		public function completeDestroy(httpResult:Object):void{
			this.destroyCallback();
			this.parentDestroyCallback();
			this.formDestroyCallback();
			
			this.isDestroyed = true;
		}
		
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/////                                                                                                           /////
		/////                                          READY TO SAVE                                                    /////
		/////                                                                                                           /////
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		public function isReadyToSave():Boolean{
			var test:Boolean = true;
			C_Globals.STR_BUFFER = "";
			for each(var field:C_Field in fieldsList){
				var itemTest:Boolean = true;
				if(field.needLabel()){
					itemTest = field.isReadyToSave(this.formComponent['lbl_'+field.name],this.formComponent['tip_'+field.name]);
				}else{
					itemTest = field.isReadyToSave(null,this.formComponent['tip_'+field.name]);
				}
				
				//if(!itemTest) trace(field.name);
				
				test = (test && itemTest);
			}
			return test;
		}
		
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/////                                                                                                           /////
		/////                                          MODIFIED                                                         /////
		/////                                                                                                           /////
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		public function isModified():Boolean{
			for each(var field:C_Field in this.fieldsList){
				if(field.isModified(this.formComponent['tip_'+field.name])) return true;
			}
			return false;
		}
		
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/////                                                                                                           /////
		/////                                          RESET                                                            /////
		/////                                                                                                           /////
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		public function reset():void{
			this.setModuleFields();
			this.isReadyToSave();
		}
		
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/////                                                                                                           /////
		/////                                          FIELDS                                                           /////
		/////                                                                                                           /////
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		public function addField(field:C_Field):void{
			this.fieldsList.push(field);
		}
		
		public function removeFieldByName(fieldName:String):void{
			for(var i:int=0;i<fieldsList.length;i++){
				if(fieldsList[i].name==fieldName){
					fieldsList.splice(i,1);
					return;
				}
			}	
		}
		
		public function getFieldByName(fieldName:String):C_Field{
			for each(var field:C_Field in fieldsList){
				if(field.name==fieldName) return field;
			}
			return null;
		}
		
		public function getForm():Group{
			return this.formComponent;
		}
		*/
?>