<?php
require_once 'PHPMailer\PHPMailerAutoload.php';
require_once 'PHPMailer\credential.php';
// echo '<pre>';
// 	print_r($_POST);
// echo '</pre>';

if(isset($_POST['name']) && isset($_POST['email'])) {
	$name = $_POST['name'];
	$email = strtolower($_POST['email']);
	$subject = $_POST['subject'];
	$message = $_POST['message'];

	try {
    if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		
			//create a new object
			$mail = new PHPMailer();

			//stmp settings
			$mail->isSMTP();
			//enable verbose debug output
			$mail->SMTPDebug = 3;
			$mail->Debugoutput = 'html';

			//for local
			// $mail->Host ="ssl://smtp.gmail.com"; 
			// $mail->Port = 465; 
			// $mail->SMTPSecure = 'ssl'; 
			// $mail->SMTPAuth = true;

			//for live
			$mail->Host ="tls://smtp.gmail.com"; 
			$mail->Port = 587; 
			$mail->SMTPSecure = 'tls'; 
			$mail->SMTPAuth = true;

			//retrieve credentials
			$mail->Username = EMAIL;
			$mail->Password = PASS;

			//email settings
			$mail->isHTML(true);
			$mail->ContentType = 'text/plain';
			$mail->CharSet ="utf-8";

			$mail->setFrom($email, $name);
			$mail->addAddress(EMAIL);
			$mail->Subject = ("$email ($subject)");
			$mail->Body = $message;

			//for debugging for purpose
	    $mail->SMTPOptions = array(
	      'ssl' => array(
	        'verify_peer' => false,
	        'verify_peer_name' => false,
	        'allow_self_signed' => true
	      )
	    );

	    //check mailing
		  if($mail->send()){
		   	//echo "Email sent successfully!";
		  } else {
		  	throw new Exeption("Failed to send email: " . $mail->ErrorInfo);
		  }

		} else {
			throw new Exeption("Invalid email address");
		}
	} catch(Exception $e) {
		echo "An error occured: " . $e->getMessage();
	}
}
?>
