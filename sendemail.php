<?php
include "DBConnect.php";
require "../PHPMailer-master/class.PHPMailer.php";
require '../kint/Kint.class.php';

// SMTP(mail) Config
$mailer['mailhost'] = 'mail.teameda.com';
$mailer['mailport'] = '25';
$mailer['mailadmin'] = 'kinnari@teameda.com';
$mailer['security'] = 'none';
$mailer['smtpauth'] = 'true';
$mailer['username'] = 'kinnari@teameda.com';
$mailer['password'] = 'yourpassword';


$db1 = new DBConnect();
$db1::getObject();

        $licenses = array();
        $licenses = $db1::get_all_licenses();
		$url = 'expire.json'; // path to your JSON file with expire license details
		$data = file_get_contents($url); // put the contents of the file into a variable
		$result = json_decode($data,true);
		
        $message = "";
        $message_header = "Expiration Alert";
    
        $recordset= $db1::get_all_alerts('expi');
		$key = array_keys($result);
		//d($result,$licenses,$recordset);
        foreach ($recordset as $row_alert){
			$site = $row_alert['sitename'];
			$email = $row_alert['emailrecip'];
			if(in_array($site,$key)){
				//d($site,$result[$site]);
				$due_date = date('d/m/Y', strtotime("+30 days"));
				 $message.= "Hello,<br>Your license key for {$site} is expiring within 30 days.It is time to renew and save 30% off of the original price.It is important to keep your license up to date in order to continue getting updates for product and continued support.<br>If you wish to renew your license, simply click the link below and follow the instructions.<br>Your license expires on: {$due_date}.<br><br>Best regards,<br>Your Company";
			}
			
			if ($message != '') {
                //Create a new PHPMailer instance
                $mail = new PHPMailer();

                //Tell PHPMailer to use SMTP
                $mail->IsSMTP();

                //Enable SMTP debugging
                // 0 = off (for production use)
                // 1 = client messages
                // 2 = client and server messages
                $mail->SMTPDebug = 0;

                //Ask for HTML-friendly debug output
                $mail->Debugoutput = 'html';

                //Set the hostname of the mail server
                $mail->Host = $mailer['mailhost'];

                //Set the SMTP port number - likely to be 25, 465 or 587
                $mail->Port = $mailer['mailport'];

                //Whether to use SMTP security
                if ($mail->SMTPSecure = $mailer['security'] != 'none') {
                    $mail->SMTPSecure = $mailer['security'];
                }

                if ($mailer['smtpauth'] == 'true') {
                    $mail->SMTPAuth = $mailer['smtpauth'];
                    $mail->Username = $mailer['username'];
                    $mail->Password = $mailer['password'];
                }

                //Set who the message is to be sent from
                $mail->SetFrom($mailer['mailadmin'], 'LamUm Alert Monitor');

                //Set who the message is to be sent to
                //$mail->AddAddress($recip, 'LamUm Admin');

                $mail->AddAddress($email, $email);

                //echo mysql_num_rows($recordset);
                //Set the subject line
                $mail->Subject = 'License Expiration Alert';
                $mail->MsgHTML($message_header . $message );
                $message = "";
                if (!$mail->Send()) {
                    errorlog('1', __FILE__, __LINE__, "Mailer Error: " . $mail->ErrorInfo);
                }
            }
        
			
			d("Msg sent sucessfully");
			
			
		}
	
		
		
		
            
		?>
    
