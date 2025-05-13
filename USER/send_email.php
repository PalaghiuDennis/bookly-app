<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'] ?? '';
    $lname = $_POST['lname'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'palaghiudennis38@gmail.com';
        $mail->Password = 'smhk uyhm lvtj drco';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('palaghiudennis38@gmail.com', 'Contact Form');
        $mail->addAddress('palaghiudennis38@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = 'New message from contact form';
        $mail->Body    = "
            <strong>Name:</strong> $fname $lname<br>
            <strong>Email:</strong> $email<br>
            <strong>Message:</strong><br>$message
        ";

        $mail->send();
        header("Location: contact.php?status=success");
        exit;

    } catch (Exception $e) {
        header("Location: contact.php?status=error");
        exit;
    }
}
?>
