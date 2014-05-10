<?php 
 
	class epCustomer extends pwrDmsItem{
	
		public function epCustomer($_database){
			
			parent::pwrDmsItem("customers",$_database);
			
			$this->className	= "epCustomer";
			
		}
		
		public function setArchiveFieldsList(){
			$this->archiveTitle	= "Archivio Clienti";
			
			$this->archiveFieldsList = array();
			$this->archiveFieldsList[]		= new pwrDmsItemArchiveField("fullName",			"Nome",				200);
			$this->archiveFieldsList[]		= new pwrDmsItemArchiveField("typeName",			"Tipo",				100);
			$this->archiveFieldsList[]		= new pwrDmsItemArchiveField("contactMobile",		"Cellulare",		120);
			$this->archiveFieldsList[]		= new pwrDmsItemArchiveField("contactTelephone",	"Telefono Fisso",	120);
			$this->archiveFieldsList[]		= new pwrDmsItemArchiveField("homeCity",			"Località",			300);
			
			///// EDIT RECORDS LIST
			if($this->archiveRecordsList)foreach($this->archiveRecordsList as $k => $record){
				switch($record["customer_type"]){
					case "PRIVATE":
						$this->archiveRecordsList[$k]["customer_fullName"]	= $record["customer_privateFirstName"] . " " . $record["customer_privateLastName"];
						$this->archiveRecordsList[$k]["customer_typeName"]	= "P. Fisica";
						break;
					case "COMPANY":
						$this->archiveRecordsList[$k]["customer_fullName"] = $record["customer_companyName"];
						$this->archiveRecordsList[$k]["customer_typeName"]	= "P. Giuridica";
						break;
				}
			}
		}
		
		public function setFormFieldsList(){
			$this->formTitle	= "Scheda Cliente";
			
			$this->formFieldsList = array();
			$this->formFieldsList[]			= new pwrDmsItemFormField("HIDDEN",				"type",							"",							10,		false,		false);
			
			///// PRIVATE
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"privateFirstName",				"Nome",						50,		true,		false);
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"privateLastName",				"Cognome",					50,		true,		false);
			
			$this->formFieldsList[]			= new pwrDmsItemFormField("SELECT",				"privateGender",				"Sesso",					1,		false,		false);
				$this->getFormFieldByName("privateGender")->addSelectOption("M","Maschile");
				$this->getFormFieldByName("privateGender")->addSelectOption("F","Femminile");
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"privateTaxCode",				"Codice Fiscale",			50,		false,		false);
			
			$this->formFieldsList[]			= new pwrDmsItemFormField("SELECT",				"privateDocumentType",			"Tipologia Documento",		20,		false,		false);
				$this->getFormFieldByName("privateDocumentType")->addSelectOption("DRIVE LICENSE"	,"Patente di Guida");
				$this->getFormFieldByName("privateDocumentType")->addSelectOption("ID CARD"			,"Carta d'Identità");
				$this->getFormFieldByName("privateDocumentType")->addSelectOption("PASSPOURT"		,"Passaporto");
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"privateDocumentNumber",		"Numero Documento",			20,		false,		false);
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"privateDocumentReleaseDate",	"Data Rilascio Documento",	10,		false,		false);
			
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"privateJob",					"Professione",				250,	false,		false);
			
			/////COMPANY
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"companyName",					"Ragione Sociale",			250,	true,		false);
			
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"companyTaxCode",				"Partita IVA",				50,		false,		false);
			
			
			///// COMMON
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"birthLocation",				"Luogo di Nascita",			250,	false,		false);
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"birthDate",					"Data di Nascita",			10,		false,		false);
			
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"homeAddress",					"Indirizzo",				250,	false,		false);
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"homeCap",						"CAP",						10,		false,		false);
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"homeCity",						"Località",					250,	false,		false);
			
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"contactMobile",				"Cellulare",				20,		false,		false);
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"contactTelephone",				"Telefono Fisso",			20,		false,		false);
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"contactFax",					"Fax",						20,		false,		false);
			$this->formFieldsList[]			= new pwrDmsItemFormField("VARCHAR",			"contactEmail",					"Indirizzo Email",			250,	false,		false);

		}
	}
?>