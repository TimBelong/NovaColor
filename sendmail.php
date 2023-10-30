<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once 'recaptcha/src/autoload.php';

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Подключение к Google reCAPTCHA
$recaptchaSecretKey = '6LfgRdQoAAAAAPrv7_2Du6rwzZMspqh-a1pXryGV';
$recaptchaResponse = isset($_POST['recaptchaToken']) ? $_POST['recaptchaToken'] : null;

$recaptcha = new ReCaptcha\ReCaptcha($recaptchaSecretKey);
$resp = $recaptcha->verify($recaptchaResponse);

if ($resp->isSuccess()) {
    // Если reCAPTCHA успешно пройдена (действительно?))
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 0;
    $mail->CharSet = 'UTF-8';
    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $from = 'info@sterkanazed.cz';
    $namefrom = 'Novacolor';
    $mail->Host = "server303.web-hosting.com";
    $mail->Port = 465;
    $mail->Username = $from;
    $mail->Password = "Novacolor777";
    $mail->SMTPSecure = "ssl";

    $mail->setFrom($from, $namefrom);
    $mail->Subject = 'Zpětná vazba z formuláře od: ' . $namefrom;
    $mail->isHTML();
    $mail->addAddress('mrbelongtim@gmail.com', 'Admin 1');
    $mail->addCC('inne2022@icloud.com', 'Admin 2');

    $body = '<h1>Nové upozornění</h1>';

    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
    $message = isset($_POST['message']) ? $_POST['message'] : null;

    if (!empty($name)) {
        $body .= '<p><strong>Jmeno: </strong>' . trim($name) . '</p>';
    }

    if (!empty($email)) {
        $body .= '<p><strong>E-mail: </strong>' . trim($email) . '</p>';

        $mail->addAddress($email, $name);
    }

    if (!empty($phone)) {
        $body .= '<p><strong>Telefonní číslo: </strong>' . trim($phone) . '</p>';
    }

    if (!empty($message)) {
        $body .= '<p><strong>Text: </strong>' . $message . '</p>';
    }

    $mail->Body = $body;

    $result = $mail->send();

    $response = ['message' => $message, 'result' => $result];
} else {
    // Если reCAPTCHA не пройдена
    $response = ['error' => 'reCAPTCHA verification failed'];
}

header('Content-type: application/json');
echo json_encode($response);
?>
