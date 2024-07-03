<?php
require "connection.php";

require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_POST["fpemail"])) {
    $fpemail = $_POST["fpemail"];
    $status = $_POST["status"];
    $rs = Database::search("SELECT * FROM `customer` WHERE `email`='" . $fpemail . "'");
    $n = $rs->num_rows;

    if ($n == 1) {
        if ($status == 0) {
            $customer_data = $rs->fetch_assoc();
            if ($customer_data["verification_code"] == null) {

                $verificationCode = rand(100000, 999999);

                Database::iud("UPDATE `customer` SET `verification_code`='" . $verificationCode . "' WHERE `email`='" . $fpemail . "'");
                setcookie("vcodeExpirationTime", time() + (60 * 5), time() + (60 * 5));

                $mail = new PHPMailer;
                $mail->IsSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'senanayakesarg@gmail.com';
                $mail->Password = 'tynf xoyr kblz jgfa';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
                $mail->setFrom('senanayakesarg@gmail.com', 'Tech Wiz Support');
                $mail->addReplyTo('senanayakesarg@gmail.com', 'Tech Wiz Support');
                $mail->addAddress($fpemail);
                $mail->isHTML(true);
                $mail->Subject = 'Tech Wiz Forgot Password Verification Code';
                $bodyContent = '<h1 style="color: green;">Your verification code is:<br/>' . $verificationCode . '</h1>';
                $bodyContent .= '<p style="color: green;">******************</p>';
                $mail->Body    = $bodyContent;
                $mail->send();
                
            }
        } elseif ($status == 1) {
            Database::iud("UPDATE `customer` SET `verification_code`= NULL WHERE `email`='" . $fpemail . "'");
        }
    } else {
        echo ("Invalid email address.");
    }
}
