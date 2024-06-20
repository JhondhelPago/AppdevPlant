<?php
session_start();


require_once 'PHPMailer-master/src/Exception.php';
require_once 'PHPMailer-master/src/PHPMailer.php';
require_once 'PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;




function plantMail($toEmail, $mail) {
    try {
        // Set recipient email address
        $mail->addAddress($toEmail);

        // Set the subject of the email
        $mail->Subject = 'Plant Alert';

        // Set the body of the email
        $mail->Body = "Your Plant action suggestion";

        // Use SMTP for sending emails
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'jhondhelpago2307@gmail.com';  // Replace with your SMTP username
        $mail->Password = 'xpbc upui uole geqs';  // Replace with your SMTP password
        $mail->SMTPSecure = 'tls';  // You can change this to 'ssl' if needed
        $mail->Port = 587;  // You can change this port based on your SMTP server configuration


        // ... (no changes in the remaining email sending code)

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Error sending email: ' . $e->getMessage());
        return false;
    } finally {
        echo '<pre>' . htmlspecialchars($mail->ErrorInfo) . '</pre>';
    }
}


$mail = new PHPMailer(true);

plantMail('pago.j.bscs@gmail.com', $mail);


?>





