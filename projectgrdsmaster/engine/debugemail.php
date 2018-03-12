<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

//DATABASE INFO
include 'config/dbconfig.php';

    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    include 'config/emailconfig.php';
        try {
            //Server settings
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $smtpservers;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = $authsmtp;                               // Enable SMTP authentication
        $mail->Username = $smtpusername;                 // SMTP username
        $mail->Password = $smtppassword;                           // SMTP password
        $mail->SMTPSecure = $securetype;                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $portno;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom($fromemail, 'GRDS Debug');
            $mail->addAddress($debugaddress, "Test");     // Add a recipient

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'GRDS Email Debug';
            $mail->Body    = "If you are receiving this the email system is working";

            $mail->send();
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }

$link->close();

?>