<?php

class DBConnect {
private static $conn;	
	public function connect()
    {  
         $host = 'localhost';
         $user = 'root';
         $pass = 'password';
         $db = 'licenses';
         $connection = mysqli_connect($host,$user,$pass,$db); 
         return $connection;
    } 
	public static function getObject()
    {
        if (!self::$conn)
            self::$conn = mysqli_connect("localhost", "root", "password", "licenses");
//var_dump(self::$conn);
        return self::$conn;
    }
	

 public function get_all_alerts($type) {
        $sql = "SELECT id, sitename, featurename, days, hours, emailrecip, warning from alerts WHERE type = '{$type}';";
        return DBConnect::do_query_fetch_array($sql);
    }
	
	 private function do_query_fetch_array($sql) {
            $results = mysqli_query(DBConnect::$conn, $sql);
            $mysqliError = mysqli_error(DBConnect::$conn);
        

       if (!$results) {
            return false;
        }
        return mysqli_fetch_all($results, MYSQLI_BOTH);
    }
	
	public function get_all_licenses() {
        $sql = "select licenses.id,hostname,port,products.name,type,sites.name as site,lamid from licenses,servers,ports,products,types,sites where licenses.serverid=servers.id and licenses.portid=ports.id and licenses.productid = products.id and licenses.typeid = types.id and licenses.siteid = sites.id order by products.name;";
        return DBConnect::do_query_fetch_array($sql);
    }
	
	 public function readCronFile($key){
        $minute = $hour = $day = null;
        // read cron.tab and populate with value
        $cron_file = 'cron.tab';
        $handle = fopen($cron_file, 'r') or die('Cannot open file:  ' . $cron_file);
   
        if ($handle) {
            while (($line = fgets($handle, 4096)) !== false) {
                if (!preg_match("/#/", $line) && strstr($line, $key)) {
                    $tmp = explode(" ", $line);
                    $minute = $tmp[0];
                    $hour = $tmp[1];
                    $day = $tmp[2];
                    $dayaltium= $tmp[4];
                    $month = $tmp[3];
                    $lineUrl = explode($key, $line);
                    parse_str($lineUrl[1], $args);
                }
            }
            
            if (!feof($handle)) {
                echo "Error: unexpected fgets() fail\n";
            }
            
            fclose($handle);
        }
        
        return array("day" => $day, "dayaltium" => $dayaltium, "hour" => $hour, "minute" => $minute, "args" => $args,"month"=>$month);
    }
	
	public function writeCronFile($key, $cronSettings, $args = ""){
		$url =  "http://" . $_SERVER['SERVER_NAME'] .":".$_SERVER['SERVER_PORT']. dirname($_SERVER['REQUEST_URI']);
   
                
        if($args != ""){
            $formattedArgs .= "^&" . http_build_query($args, '', '^&');
            
            if($formattedArgs == "^&"){
                $formattedArgs = "";
            }
        }
        $newline = $cronSettings . '  curl.exe ' . $url.$key . $formattedArgs . "\r\n";
       
        //copy file to prevent double entry
        $file = "cron.tab";
        $newfile = "filetemp.txt";
        copy($file, $newfile) or exit("failed to copy $file");

        //load old cron file into $lines array
        $fc = fopen($file, "r");
        while (!feof($fc)) {
            $buffer = fgets($fc, 4096);
            $lines[] = $buffer;
        }
        fclose($fc);
        
        //open new cron file
        $f = fopen($newfile, "w") or die("couldn't open $file");

        //Parse through each line and overwrite the line that needs to be overwritten
        $keyIsPresent = false;
        foreach ($lines as $line) {
            if (strstr($line, $key)) {
                fwrite($f, $newline);
                $keyIsPresent = true;
            } else {
                fwrite($f, $line);
            }
        }
        
        //If key was not present in old file, create a new line
        if($keyIsPresent == false){
            $fileLine = "\r\n";
			fwrite($f, $fileLine);
            fwrite($f, $newline);
        }
        fclose($f);

        copy($newfile, $file) or exit("failed to copy $newfile");
        exec("net stop cron", $command_out);
        exec("net start cron", $command_out);
    }
	
	 public function get_alert_all_emailrecipt() {
        $sql = "SELECT DISTINCT emailrecip from alerts;";
        $emailitems = DBConnect::do_query_fetch_array($sql);

        foreach ($emailitems as $emailitem) {
            $emaillist[] = $emailitem[0];
        }

        return $emaillist;
    }
	
	public function get_sitename_by_licid($licid) {
        $sql = "select sites.name from licenses,sites where licenses.siteid=sites.id and licenses.id =" . $licid;
        return DBConnect::do_return_single_row($sql);
    }
	
	 public function do_return_single_row($sql) {
            $results = mysqli_query(DBConnect::$conn, $sql);
            $mysqliError = mysqli_error(DBConnect::$conn);
        

       if (!$results) {
            return false;
        }else{
        //return mysqli_fetch_all($results, MYSQLI_BOTH);
		$return = mysqli_fetch_row($results);
			return $return[0];
		}
    }
	
	
	public function do_num_rows($result) {
        return mysqli_num_rows($result);
    }
	
	 public function do_fetch_array($result, $type = MYSQLI_BOTH) {
		 d("hi",mysqli_fetch_all($result, MYSQLI_BOTH));
        return mysqli_fetch_all($result, MYSQLI_BOTH);
    }
	
	 public function do_query($sql) {
		 $results = mysqli_query(DBConnect::$conn, $sql);
            $mysqliError = mysqli_error(DBConnect::$conn);

       if (!$results) {
            return false;
        }
        return mysqli_fetch_all($results, MYSQLI_BOTH);
        return $results;
    }
	
	 public function get_alert_emailrecip($sitename, $featurename, $emailrecip, $type) {

        $sql = "SELECT sitename, featurename, days, hours, emailrecip, warning from alerts where sitename = '" . $sitename . "' and featurename ='" . $featurename . "' and emailrecip = '" . $emailrecip . "' and type = '" . $type . "';";
        return DBConnect::do_return_single_row($sql);
    }
  public function add_alert($sitename, $featurename, $days, $hours, $emailrecip, $warning, $type) {
        $sql = "INSERT INTO alerts (sitename, featurename, days, hours, emailrecip, warning, type) VALUES ('" . $sitename . "','" . $featurename . "','" . $days . "','" . $hours . "','" . $emailrecip . "','" . $warning . "','" . $type . "');";
        DBConnect::do_query($sql);
    }
	
	 public function update_alert_by_id($id, $days, $emailrecip) {
        $sql = "UPDATE alerts SET days = '" . $days . "',emailrecip = '" . $emailrecip . "' WHERE id ='" . $id . "';";
        DBConnect::do_query($sql);
    }
	 public function delete_alert_by_id($id, $type) {
        $sql = "DELETE FROM alerts where id='{$id}' and type = '{$type}';";
        DBConnect::do_query($sql);
    }
	
	public function delete_alert_by_emailrecip($sitename, $featurename, $emailrecip, $type) {
        $sql = "DELETE FROM alerts where sitename ='" . $sitename . "' and featurename = '" . $featurename . "' and emailrecip = '" . $emailrecip . "' and type = '{$type}';";
        DBConnect::do_query($sql);
    }
	
	
}
?>