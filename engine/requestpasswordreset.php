<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

//DATABASE INFO
include 'config/dbconfig.php';
$email = $_REQUEST['email'];
//Generate Random Token
$token = bin2hex(openssl_random_pseudo_bytes(20));
$time = time();
$success = FALSE;

// SQL Injection Protection
$email = stripslashes($email);
$email = mysqli_real_escape_string($link, $email);

if ($stmt = $link->prepare("SELECT UserID FROM Users WHERE Email=?")){
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result=$stmt->get_result();

    if (mysqli_num_rows($result) == 1) {
        //USER EXISTS
        while ($row = mysqli_fetch_row($result)) { 
            $userID = $row[0];
        }

        if ($stmt = $link->prepare("SELECT UserID FROM password_reset WHERE UserID=?")){
            $stmt->bind_param("s", $userID);
            $stmt->execute();
            
            $result=$stmt->get_result();

            if (mysqli_num_rows($result) == 1) {
                //RESET EXISTS
                if ($stmt = $link->prepare("UPDATE password_reset SET user_token=?, timeout=?, valid='1' WHERE UserID=?")){
                    $stmt->bind_param("sss", $token, $time, $userID);
                    if ($stmt->execute()) {
                        $success = TRUE;
                    } else {
                        echo "Reset Error: " . mysqli_error($link);
                    }
                }
            } else {
                //CREATE NEW RESET
                if ($stmt = $link->prepare("INSERT INTO password_reset (UserID, user_token, timeout, valid)
                    VALUES (?, ?, ?, '1')")){
                    $stmt->bind_param("sss", $userID, $token, $time);
                    if ($stmt->execute()) {
                        $success = TRUE;
                    } else {
                        echo "Reset Error: " . mysqli_error($link);
                    }
                }
            }
        }
    } else {
        //USER DOES NOT EXIST
        echo "1";
    }
}

if ($success) {
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    include 'config/emailconfig.php';
    try {
        //Server settings
        $mail->SMTPDebug = $debugemail;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $smtpservers;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = $authsmtp;                               // Enable SMTP authentication
        $mail->Username = $smtpusername;                 // SMTP username
        $mail->Password = $smtppassword;                           // SMTP password
        $mail->SMTPSecure = $securetype;                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $portno;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom($fromemail, 'GRDS Password Reset');
        $mail->addAddress($email);     // Add a recipient

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Reset GRDS Password';
        $mail->Body    = "
        <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
 <head>
  <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
  <title>Password Reset Email</title>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
</head>

<body style='margin: 0; padding: 0; font-family: \"Segoe UI\", \"Arial\"'>
 <table align='center' border='0' cellpadding='0' cellspacing='0' width='600' style='border-collapse: collapse;'>
  <tr>
  <td align='center' bgcolor='#2a80b2' style='padding: 40px 10px 40px 10px; color: white; font-size: 20px'>
   General Retention and Disposal Schedule
  </td>
 </tr>
 <tr bgcolor='#2a80b2' style='padding: 0px 0px 0px 0px'>
  <td style='padding: 0px 50px 0px 50px; color: #484847; font-size: 12pt'>
    <table bgcolor='#f3f8fa' border='0' cellpadding='0' cellspacing='0' width='100%'>
      <tr>
        <td align='center' style='padding: 20px 0px 0px 0px'> 
          <img src='https://deco3801-alexs-angels.uqcloud.net/img/key.png' alt='key'/>
        </td>
      </tr>
      <tr>
        <td align='center' style='padding: 10px 0px 10px 0px; font-size: 24px'> Forgot your password?
        </td>
      </tr>
      <tr>
        <td align='center' style='padding: 10px 100px 10px 100px; color: #979da2; font-size: 14px'> That's okay! Click the button below and follow the prompts to reset your password.
        </td>
      </tr>
      <tr>
        <td align='center' style='padding: 15px 0px 50px 0px'>
        <a href='$websitelocation/resetconfirm.php?token=$token'>
            <input style='border: none; color: white; font-size: 14px; background: #484847; padding: 10px 50px 10px 50px' type='submit' value='Reset my pasword'/>
          </a>
        </td>
      </tr>
    </table>
  </td>
 </tr>
 <tr>
  <td align='center' bgcolor='#2a80b2' style='padding: 40px 10px 40px 10px; color: white; font-size: 12px'>
   Department of Science, Information Technology and Innovation | 2017
  </td>
 </tr>
 </table>
</body>
</html>
        ";
        $mail->send();
        echo "2";
    } catch (Exception $e) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
}

$link->close();
?>