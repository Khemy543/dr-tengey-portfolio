<?php

/*--------------------------------------------------

	Name: 			Contact Form
	Written by: 	Harnish Design
	Website: 		http://www.harnishdesign.net

----------------------------------------------------*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './phpmailer/src/Exception.php';
require './phpmailer/src/PHPMailer.php';
require './phpmailer/src/SMTP.php';


/* --------------------------------------------
  // Receiver's Email
--------------------------------------------- */

$toEmail = 'hagioswilson@gmail.com';// "sam@samaueltengey.com"; // Replace Your Email Address


/* --------------------------------------------
  // Sender's Email
--------------------------------------------- */

$fromEmail = "no-reply@samaueltengey.com";  // Replace Company's Email Address (preferably currently used Domain Name)
$fromName = "Samuel Tengey"; // Replace Company Name


/* --------------------------------------------
  // Subject
--------------------------------------------- */
$subject = "Mail from Your Website"; // Your Subject


if (isset($_POST['name'])) {

	// die(json_encode($_POST));

/*-------------------------------------------------
	PHPMailer Initialization
---------------------------------------------------*/

$mail = new PHPMailer(true);

/* Add your SMTP Codes after this Line */


// End of SMTP

if (filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {

	$mail->AddAddress($toEmail);
	$mail->setFrom($fromEmail, $fromName);
	$mail->addReplyTo($_POST['email'], $_POST['name']);

	$mail->isHTML(true);
	$mail->CharSet = 'UTF-8';
	
	$mail->Subject = $subject . ' [' . $_POST['name'] . ']';

	$mail->Body = '<table align="center" border="0" cellpadding="0" cellspacing="20" height="100%" width="100%">
						<tr>
							<td align="center" valign="top">
								<table width="600" bgcolor="#f8f6fe" cellpadding="7" style="font-size:16px; padding:30px; line-height: 28px;">
									<tr>
										<td style="text-align:right; padding-right: 20px;" width="100" valign="top"><strong>Name:</strong></td>
										<td>' . $_POST['name'] . '</td>
									</tr>
									<tr>
										<td style="text-align:right; padding-right: 20px;" width="100" valign="top"><strong>Email:</strong></td>
										<td>' . $_POST['email'] . '</td>
									</tr>
									<tr>
										<td style="text-align:right; padding-right: 20px;" width="100" valign="top"><strong>Message:</strong></td>
										<td>' . $_POST['form-message'] . '</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>';
	

	$success = "Thank you for contacting us and will be in touch with you very soon."; // Success Message

	try {
		$resp = $mail->send();
		echo json_encode(array('response' => 'success', 'Message' => '<div class="alert alert-success alert-dismissible fade show text-start"><i class="fa fa-check-circle"></i> ' . $success . ' <button type="button" class="btn-close text-1 mt-1" data-bs-dismiss="alert"></button></div>'));
		exit;
	} catch (Exception $e) {
		echo json_encode(array('response' => 'error', 'Message' => '<div class="alert alert-danger alert-dismissible fade show text-start"><i class="fa fa-exclamation-triangle me-1"></i> Message could not be sent: ' . $e->errorMessage() . '<button type="button" class="btn-close text-1 mt-1" data-bs-dismiss="alert"></button></div>'));
		exit;
	} catch (\Exception $e) {
		echo json_encode(array('response' => 'error', 'Message' => '<div class="alert alert-danger alert-dismissible fade show text-start"><i class="fa fa-exclamation-triangle me-1"></i> Message could not be sent: ' . $e->getMessage() . '<button type="button" class="btn-close text-1 mt-1" data-bs-dismiss="alert"></button></div>'));
		exit;
	}
} else {
	echo json_encode(array('response' => 'error', 'Message' => '<div class="alert alert-danger alert-dismissible fade show text-start"><i class="fa fa-exclamation-triangle me-1"></i> There is a invalid <strong>Receivers Email</strong> address! <button type="button" class="btn-close text-1 mt-1" data-bs-dismiss="alert"></button></div>'));
	exit;
}
} else {
    echo json_encode(array('response' => 'error', 'Message' => '<div class="alert alert-danger alert-dismissible fade show text-start"><i class="fa fa-exclamation-triangle me-1"></i> There is a problem with the document! <button type="button" class="btn-close text-1 mt-1" data-bs-dismiss="alert"></button></div>'));
    exit;
}
?>