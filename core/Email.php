<?php

declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'upload/PHPMailer/src/Exception.php';
require 'upload/PHPMailer/src/PHPMailer.php';
require 'upload/PHPMailer/src/SMTP.php';

class Email
{

    static function readConfig(string $configPath): void
    {
        $config = parse_ini_file($configPath, true);
        $gmailConfig = $config["phpmailer"];

        define("MAILHOST", "smtp.gmail.com");
        define("USERNAME", $gmailConfig["gmailfrom"]);
        define("PASSWORD", $gmailConfig["gmailapppass"]);
        define("SEND_FROM", $gmailConfig["gmailfrom"]);
        define("SEND_FROM_NAME", $gmailConfig["gmailfromname"]);
        define("REPLY_TO_NAME", $gmailConfig["gmailreplyname"]);
    }

    static function send(string $email, string $subject, string $message): bool
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPDebug = 0;
            $mail->Debugoutput = 'html';


            $mail->Host = MAILHOST;
            $mail->Username = USERNAME;
            $mail->Password = PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->CharSet = "UTF-8";

            $mail->setFrom(SEND_FROM, SEND_FROM_NAME);
            $mail->addAddress($email);
            $mail->addReplyTo(SEND_FROM, REPLY_TO_NAME);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->AltBody = strip_tags($message);

            return $mail->send();

        } catch (Exception $e) {
            error_log("PHPMailer error: " . $mail->ErrorInfo);
            return false;
        }
    }
}
