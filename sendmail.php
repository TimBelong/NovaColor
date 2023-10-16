<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);
$mail->SMTPDebug = 0;
$mail->CharSet = 'UTF-8';
$mail->isSMTP();
$mail->SMTPAuth = true;

$from = 'novacolor@sterkanazed.cz';
$namefrom = 'Novacolor';
$mail->Host = "smtp.sterkanazed.cz";
$mail->Port = 465;
$mail->Username = $from;
$mail->Password = "8IgMv{cI(7SG";
$mail->SMTPSecure = "ssl";

$mail->setFrom($from, $namefrom);
$mail->addCC($from, $namefrom);
$mail->Subject = 'Zpětná vazba z formuláře od: ' . $namefrom;
$mail->isHTML();
$mail->addAddress('mrbelongtim@gmail.com', 'Admin');

$body = '<h1>Nové upozornění</h1>';

if (trim(!empty($_POST['name']))) {
    $body .= '<p><strong>Jmeno: </strong>' . $_POST['name'] . '</p>';
}
if (trim(!empty($_POST['email']))) {
    $body .= '<p><strong>E-mail: </strong>' . $_POST['email'] . '</p>';
}
if (trim(!empty($_POST['phone']))) {
    $body .= '<p><strong>Telefonní číslo: </strong>' . $_POST['name'] . '</p>';
}
if (trim(!empty($_POST['phone']))) {
    $body .= '<p><strong>Text: </strong>' . $_POST['message'] . '</p>';
}

$mail->Body = $body;

$response = ['message' => $message];

header('Content-type: application/json');
echo json_encode($response);
?>