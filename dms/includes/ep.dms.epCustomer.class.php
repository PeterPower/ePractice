<?php 
 
	class epCustomer extends pwrDmsItem{
	
		public function epCustomer($_database){
			
			parent::pwrDmsItem("customers",$_database);
			
			$this->className	= "epCustomer";
			
		}
		
		public function setArchiveFieldsList(){
			$this->archiveTitle	= "Archivio Clienti";
			
			$this->archiveFieldsList = array();
			$this->archiveFieldsList[]		= new pwrDmsItemArchiveField("firstName",			"Nome",				180);
			$this->archiveFieldsList[]		= new pwrDmsItemArchiveField("lastName",			"Cognome",			180);
			$this->archiveFieldsList[]		= new pwrDmsItemArchiveField("telephone1",			"Telefono",			180);
			$this->archiveFieldsList[]		= new pwrDmsItemArchiveField("location",			"Località",			300);
		}
		
		public function setFormFieldsList(){
			$this->formTitle	= "Scheda Cliente";
			
			$this->formFieldsList = array();
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"type",					"",							0,		false,		false);
			
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"firstName",			"Nome",						0,		true,		false);
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"lastName",				"Cognome",					0,		true,		false);
			
			$this->formFieldsList[]			= new pwrDmsItemFormField("SELECT",				"gender",				"Sesso",					0,		false,		false);
			$this->getFormFieldByName("gender")->addSelectOption("M","Maschile");
			$this->getFormFieldByName("gender")->addSelectOption("F","Femminile");
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"code",					"Codice Fiscale",			0,		false,		false);
			
			$this->formFieldsList[]			= new pwrDmsItemFormField("SELECT",				"documentType",			"Tipologia Documento",		0,		false,		false);
			$this->getFormFieldByName("documentType")->addSelectOption(1,"Patente di Guida");
			$this->getFormFieldByName("documentType")->addSelectOption(2,"Carta d'Identità");
			$this->getFormFieldByName("documentType")->addSelectOption(3,"Passaporto");
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"documentNumber",		"Numero Documento",			0,		false,		false);
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"documentReleaseDate",	"Data Rilascio Documento",	0,		false,		false);
			
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"job",					"Professione",				0,		false,		false);
			
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"birthLocation",		"Luogo di Nascita",			0,		false,		false);
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"birthDate",			"Data di Nascita",			0,		false,		false);
			
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"homeAddress",			"Indirizzo",				0,		false,		false);
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"homeCap",				"CAP",						0,		false,		false);
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"homeCity",				"Località",					0,		false,		false);
			
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"contactMobile",		"Cellulare",				0,		false,		false);
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"contactTelephone",		"Telefono Fisso",			0,		false,		false);
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"contactFax",			"Fax",						0,		false,		false);
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"contactEmail",			"Indirizzo Email",			0,		false,		false);
		}
	}
?>