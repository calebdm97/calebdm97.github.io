<?php
require '/usr/share/php/libphp-phpmailer/PHPMailerAutoload.php';

//$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail = new PHPMailer();
$mail->SMTPdebug = 1;
$mail->setFrom('noreply@gmail.com');
$mail->addAddress('millardepley@rocketmail.com');
$mail->Subject = ('Test from school');
$mail->Body = ('Test from School');
$mail->isSMTP();
$mail->SMTPSecure = 'ssl';
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Port = 465;

$mail->Username = 'epleymillard@gmail.com';
$mail->Password = '';

if (!$mail->send()) {
	echo 'Email not sent.';
	echo 'Email error: ' . $mail->ErrorInfo;
} else {
	echo 'Email has been sent.';
}
?>
