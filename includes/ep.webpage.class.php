<?php 
 
	class epWebpage extends pwrWebpage{
	
		public function epWebpage(){
			global $_PREF;
			
			parent::pwrWebpage();
			parent::setMainTplName("_main","_section");
		}
		
		
	}
	
?>