<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require_once __DIR__ . "/../vendor/PHPMailer/src/Exception.php";
require_once __DIR__ . "/../vendor/PHPMailer/src/PHPMailer.php";
require_once __DIR__ . "/../vendor/PHPMailer/src/SMTP.php";

$contact_first_name = "";
$contact_second_name = "";
$contact_email = "";
$contact_message = "";
$contact_errors = [];
$contact_success_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["contact_form"])) {
    $contact_first_name = trim($_POST["first_name"] ?? "");
    $contact_second_name = trim($_POST["second_name"] ?? "");
    $contact_email = trim($_POST["email"] ?? "");
    $contact_message = trim($_POST["message"] ?? "");

    if ($contact_first_name === "") {
        $contact_errors[] = "Prosím, vložte krstné meno.";
    }

    if ($contact_second_name === "") {
        $contact_errors[] = "Prosím, vložte priezvisko.";
    }

    if (filter_var($contact_email, FILTER_VALIDATE_EMAIL) === false) {
        $contact_errors[] = "Prosím, vložte platný e-mail.";
    }

    if ($contact_message === "") {
        $contact_errors[] = "Prosím, vložte správu.";
    }

    if (empty($contact_errors)) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "araktonis@gmail.com";
            $mail->Password = "pxfkyggolgcsmfen";
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465;

            $mail->setFrom("araktonis@gmail.com");
            $mail->addAddress("gavlakpavol2@gmail.com");
            $mail->Subject = "Vyplnený kontaktný formulár";
            $mail->Body = "Meno: {$contact_first_name} {$contact_second_name}\n"
                . "E-mail: {$contact_email}\n"
                . "Správa: {$contact_message}";

            $mail->send();

            $contact_success_message = "Správa bola úspešne odoslaná.";
            $contact_first_name = "";
            $contact_second_name = "";
            $contact_email = "";
            $contact_message = "";
        } catch (Exception $exception) {
            $contact_errors[] = "Správu sa nepodarilo odoslať. Skúste to, prosím, znova.";
        }
    }
}
