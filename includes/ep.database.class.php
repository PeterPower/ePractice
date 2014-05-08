<?php 
 
	class epDatabase extends pwrDatabase{
	
		public function epDatabase(){
			global $_PREF;
			
			parent::pwrDatabase();
		}
		
		
		public function getCalendarNotesByDate($day,$month,$year,$agencyID){
			global $_epUser;
			$currentDayTimestamp = mktime(0,0,0,$month,$day,$year);
			return $this->getAllRecordsBySql("SELECT calendarNote_ID, calendarNote_fromTime AS timeLabel FROM ea_calendarNotes WHERE (
															(calendarNote_repeatTypeID=0 AND calendarNote_date LIKE '".date('d/m/Y',$currentDayTimestamp)."')																OR
															(calendarNote_repeatTypeID=1 AND calendarNote_date LIKE '".date('d/m/%',$currentDayTimestamp)."'	AND ".date('Ymd',$currentDayTimestamp).">=".date('Ymd').")	OR
															(calendarNote_repeatTypeID=2 AND calendarNote_date LIKE '".date('d/%/%',$currentDayTimestamp)."'	AND ".date('Ymd',$currentDayTimestamp).">=".date('Ymd').")	OR
															(calendarNote_repeatTypeID=3 AND calendarNote_weekDay='".date('w',$currentDayTimestamp)."'			AND ".date('Ymd',$currentDayTimestamp).">=".date('Ymd').")	OR
															(calendarNote_repeatTypeID=4																		AND ".date('Ymd',$currentDayTimestamp).">=".date('Ymd').")
														) AND sys_ownerID='".$agencyID."'");
		}
		
		public function getCalendarAlarmsByDate($day,$month,$year,$agencyID){
			global $_epUser;
			$currentDayTimestamp = mktime(0,0,0,$month,$day,$year);
			
			
			$alarms = array();
			
			
			///// PRACTICE
			$practiceAlarms = $this->getAllRecordsBySql("SELECT * FROM ea_alarms JOIN ea_practices ON alarm_externalID=practice_ID
														WHERE alarm_typeName LIKE 'practice\_%'
														AND alarm_date LIKE '".date('d/m/Y',$currentDayTimestamp)."'
														AND alarm_isOn='1'
														AND (practice_managerID='".$agencyID."' AND practice_statusTypeID<>4)");
														
			if($practiceAlarms)foreach($practiceAlarms as $k =>$alarm){
				$practiceAlarms[$k]['typeName'] = $alarm['alarm_typeName'];
				$practiceAlarms[$k]['timeLabel'] = $alarm['alarm_time'];
				$dateArray = explode('/',$alarm['alarm_date']);
				$practiceAlarms[$k]['day'] = $dateArray[0];
				$alarmsCounts[(int)$practiceAlarms[$k]['day']]++;
				
				$alarms[] = $practiceAlarms[$k];
			}
			
			///// PRACTICE CUSTOMER
			$customerAlarms = $this->getAllRecordsBySql("SELECT * FROM ea_alarms JOIN (ea_practiceCustomers JOIN ea_practices ON practiceCustomer_practiceID=practice_ID) ON alarm_externalID=practiceCustomer_ID
													WHERE alarm_typeName LIKE 'practiceCustomer\_%'
													AND alarm_date LIKE '%/".date('d/m/Y',$currentDayTimestamp)."' AND alarm_isOn='1' 
													AND ((practice_managerID='".$agencyID."' AND practice_statusTypeID<>4) OR ('".$_epUser->data['agency_typeID']."'='0' 
													AND '".agencyID."'='".$_epUser->data['user_agencyID']."' AND alarm_isAdministrative='1'))");
										
			if($customerAlarms)foreach($customerAlarms as $k =>$alarm){
				$customerAlarms[$k]['typeName'] = $alarm['alarm_typeName'];
				$customerAlarms[$k]['timeLabel'] = $alarm['alarm_time'];
				$dateArray = explode('/',$alarm['alarm_date']);
				$customerAlarms[$k]['day'] = $dateArray[0];
				$alarmsCounts[(int)$customerAlarms[$k]['day']]++;
				
				$alarmis[] = $customerAlarms[$k];
				
			}
			
			return $alarms;
		}
			
		
	}
	
?>