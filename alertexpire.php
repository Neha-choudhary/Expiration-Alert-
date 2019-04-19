<?php
include "DBConnect.php";
require '../kint/Kint.class.php';
$db1 = new DBConnect();
$db1::getObject();
	//d($_REQUEST['updateTimeInterval'],$_POST);
		if (isset($_REQUEST['emailrecip'])) {
            $emailrecip = $_REQUEST['emailrecip'];
            $days = $_REQUEST['days'];     
        } else {
            $emailrecip = "N/A";
        }

        //Add alert
        if (isset($_REQUEST['add'])) {
			$str = $_REQUEST['licenseSelect'];
			$licenseEntry = explode(",",$str[0]);
            
            foreach ($licenseEntry as $licId){
                $siteName = $db1::get_sitename_by_licid($licId);
                $checkentry = $db1::get_alert_emailrecip($siteName, 'expi', $emailrecip, 'expi');

                if (count($checkentry) < 1){
                    $db1::add_alert($siteName, 'expi', $days, 0, $emailrecip, 0, 'expi');
                    $message .= "<font color='green'>Alert: $siteName for User: $emailrecip successfully added.</font><br>";
                } else {
                    $message .= "<font color='red'>Failed to add Alert: $siteName for User: {$emailrecip}. Entry already exists.</font><br>";
                }
            }
        }
        
        //Update Alert
        if(isset($_REQUEST['update'])){
            $rowId = $_REQUEST['rowId'];
            $siteName = $_REQUEST['siteName'];
			
            $db1::update_alert_by_id($rowId, $days, $emailrecip);
            $message = "<font color='green'>Alert: $siteName for User: {$emailrecip} successfully updated.</font>";
        }

        //Delete Alert
        if (isset($_REQUEST['delete'])) {
            $siteName = $_REQUEST['siteName'];
            $db1::delete_alert_by_emailrecip($siteName, 'expi', $emailrecip, 'expi');

            $message = "<font color='green'>Alert: $siteName for User: {$emailrecip} successfully deleted.</font>";
        }
        
        //Delete existing selected license expiration alert(s)
        if (isset($_REQUEST['nm']) && !empty($_REQUEST['nm'])) {
            $alertids = explode(";", $_REQUEST['nm']);  //convert to array
            foreach ($alertids as $alertid) {           // run the array
                // delete each alert record by id
                $db1::delete_alert_by_id($alertid, 'expi');
            }
            $message = "<font color='green'>Alert (License Expiration): " . count($alertids) . " alerts successfully deleted.</font>";            
        }
		
		$recordset = $db1::get_all_alerts('expi');
		 if (count($recordset) > 0) {
            foreach ($recordset as $row) {
                $saved[] = $row;
            }
        }
	
        $result = array();
        $result[] = array('emailrecip' => $emailrecip);

        $licensesList = $db1::get_all_licenses();
        
        foreach ($licensesList as $licensesValue){
            $licensesArray[] = array(
                'id' => $licensesValue['id'],
                'text' => $licensesValue['name'] . "(" . $licensesValue['site'] . ")  " . $licensesValue['port'] . "@" . $licensesValue['hostname']
            );
        }
		
		//d($saved,$result,$licensesList,$licensesArray);
		$key = '/sendemail.php';
        if (isset($_REQUEST['alerttime'])) {
            $alerttime = $_REQUEST['alerttime'];
            //default value is daily;
             $cronsettings = '0 1 * * *';
            switch($alerttime)
            {
                case 'Daily':
                    $cronsettings = '0 0 * * *';
                    break;
                case 'Weekly':
                    $cronsettings = '0 0 * * 1';
                    break;
            }

            $db1::writeCronFile($key, $cronsettings);
            $message .= "<font color='green'>Time interval successfully changed.</font></br>";
        }else{
            $cronData = $db1::readCronFile($key);
            $min = $cronData["minute"];
            $hour = $cronData["hour"];
            $day = $cronData["dayaltium"];
            
            if($min == '0' && $hour == '0' && $day =='1')
            {
               $alerttime = 'Weekly';
            }else if($min == '0' && $hour == '0' && $day =='*')
            {
              $alerttime = 'Daily';
            }
        }
		$emaillist = $db1::get_alert_all_emailrecipt();
	include("config_expire.php");

        ?>
    
    