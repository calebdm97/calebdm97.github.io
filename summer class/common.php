<?php
//connect to database
global $dbc;
$dbc = mysqli_connect("localhost","ccc","Binary_Elite","orgs");
?>

<?php
//function for email
function send_email($to, $subject, $body) {

require_once '/usr/share/php/libphp-phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer();
$mail->SMTPdebug = 1;
$mail->setFrom('no-reply@email.com');
$mail->addAddress($to);
$mail->Subject = ($subject);
$mail->Body = "{$body}";
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
}
}
?>
