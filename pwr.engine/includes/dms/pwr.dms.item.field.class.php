<?php 
 
	class pwrDmsItemField{
	
		public $type;
		public $name;
	
		public $startingValue;
		public $additionalArgs;
		
		///// TYPE CLASS
		public $class;
		public $classObject;
		
		
		
		///// SELECT
		public $selectOptionsList = [];
		
		///// ARCHIVE
		public $archiveLabel;
		public $archiveWidth;
	
		///// FORM
		public $formLabel;
		public $formMaxSize;
		public $formIsNeeded;
		public $formIsMultiple;
		
		
		///// COSTRUCTOR
		public function pwrDmsItemField($type,$name){
			$this->type		= $type;
			$this->name		= $name;
		}
		
		
		
		
		
		////// SELECT
		public function addSelectOption($value,$label){
			$option["value"] = $value;
			$option["label"] = $label;
			$this->selectOptionsList[] = $option;
		}
		
		
	}
	
	
	
	class pwrDmsItemArchiveField extends pwrDmsItemField{
		public function pwrDmsItemArchiveField($name, $label, $width){
			parent::pwrDmsItemField("VARCHAR",$name);
			$this->archiveLabel		= $label;
			$this->archiveWidth		= $width;
		}
	}
	
	class pwrDmsItemFormField extends pwrDmsItemField{
		public function pwrDmsItemFormField($type, $name, $label, $maxSize, $iNeeded, $isMultiple){
			parent::pwrDmsItemField($type,$name);
			$this->formLabel		= $label;
			$this->formMaxSize		= $maxSize;
			$this->formIsNeeded		= $iNeeded;
			$this->formIsMultiple	= $isMultiple;
		}
	}
	
?>