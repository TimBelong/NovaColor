<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once 'recaptcha/src/autoload.php';

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$recaptchaSecretKey = '6LfgRdQoAAAAAPbcIgYjRxMBJM16uwst97CkmpLJ';
$recaptchaResponse = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : null;

$recaptcha = new ReCaptcha\ReCaptcha($recaptchaSecretKey);
$resp = $recaptcha->verify($recaptchaResponse);

if ($resp->isSuccess()) {
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 0;
    $mail->CharSet = 'UTF-8';
    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $from = 'info@sterkanazed.cz';
    $namefrom = 'sterkanazed.cz';
    $mail->Host = "server303.web-hosting.com";
    $mail->Port = 465;
    $mail->Username = $from;
    $mail->Password = "Novacolor777";
    $mail->SMTPSecure = "ssl";

    $mail->setFrom($from, $namefrom);
    $mail->Subject = 'Новое письмо с сайта: ' . $namefrom;
    $mail->isHTML();
    $mail->addAddress('info@sterkanazed.cz', 'Admin 1');
    $mail->addCC('novacolor@novacolordesign.cz', 'Admin 2');

    $body = '<h1>Новый запрос</h1>';

    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
    $message = isset($_POST['message']) ? $_POST['message'] : null;

    if (!empty($name)) {
        $body .= '<p><strong>Имя: </strong>' . trim($name) . '</p>';
    }

    if (!empty($phone)) {
        $body .= '<p><strong>Телефонный номер: </strong>' . trim($phone) . '</p>';
    }

    if (!empty($message)) {
        $body .= '<p><strong>Сообщение: </strong>' . $message . '</p>';
    }

    $mail->Body = $body;

    try {
        $result = $mail->send();
        $response = ['message' => $message, 'result' => $result];
    } catch (Exception $e) {
        $response = ['message' => $e->getMessage(), 'result' => false];
    }
} else {
    // Если reCAPTCHA не пройдена
    $response = ['error' => $resp->getErrorCodes()];
}

header('Content-type: application/json');
echo json_encode($response);
?>
