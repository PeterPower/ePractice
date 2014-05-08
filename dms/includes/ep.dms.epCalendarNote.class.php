<?php 
 
	class epCalendarNote extends pwrDmsItem{
	
		public function epCalendarNote($_database){
			
			parent::pwrDmsItem("calendarNotes",$_database);
			
			$this->className	= "epCalendarNote";
			
		}
		
		
		public function setFormFieldsList(){
		
			$this->formFieldsList = array();
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"date",				"Data",						0,		true,		false);
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"startingTime",		"Ora Inizio",				0,		true,		false);
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"endingTime",		"Ora Fine",					0,		false,		false);
			
			$this->formFieldsList[]			= new pwrDmsItemFormField("SELECT",				"repetition",		"Ripetizione",				0,		false,		false);
			$this->getFormFieldByName("documentType")->addSelectOption("NEVER","Mai");
			$this->getFormFieldByName("documentType")->addSelectOption("YEAR","Ogni Anno");
			$this->getFormFieldByName("documentType")->addSelectOption("MONTH","Ogni Mese");
			$this->getFormFieldByName("documentType")->addSelectOption("WEEK","Ogni Settimana");
			$this->getFormFieldByName("documentType")->addSelectOption("DAY","Ogni Giorno");
			
			$this->formFieldsList[]			= new pwrDmsItemFormField("TEXT",				"description",		"Descrizione",					0,		false,		false);
			
			$this->formFieldsList[]			= new pwrDmsItemFormField("SELECT",				"competence",		"Competenza",					0,		false,		false);
		}
	}
?>