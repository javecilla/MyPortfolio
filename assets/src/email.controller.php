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

	if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		
		//create a new object
		$mail = new PHPMailer();

		//enable verbose debug output
		$mail->SMTPDebug = 2;
		$mail->Debugoutput = 'html';

		//stmp settings
		$mail->isSMTP();
		$mail->Host ="ssl://smtp.gmail.com";
		$mail->Port = 465;
		$mail->SMTPSecure = 'ssl';
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
    	echo "Failed to send email: " . $mail->ErrorInfo;
    }

	} else {
		echo "Invalid Email address";
	}
}

?>