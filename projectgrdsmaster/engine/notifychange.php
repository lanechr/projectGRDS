<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

//DATABASE INFO
include 'config/dbconfig.php';
$changeID = $_REQUEST['changeID'];
$success = FALSE;

// SQL Injection Protection
$changeID = stripslashes($changeID);
$changeID = mysqli_real_escape_string($link, $changeID);

if ($stmt = $link->prepare("SELECT DAID, Reason FROM Changes WHERE ChangeID=?")){
    $stmt->bind_param("s", $changeID);
    $stmt->execute();
    $result=$stmt->get_result();

    if (mysqli_num_rows($result) == 1) {
        //USER EXISTS
        while ($row = mysqli_fetch_row($result)) { 
            $daid = $row[0];
            $reason = $row[1];
        }

        if ($stmt = $link->prepare("SELECT Users.FirstName, Users.LastName, Users.Email, Users.UserID FROM Bookmarks INNER JOIN Users ON Bookmarks.UserID = Users.UserID WHERE Bookmarks.DAID=? AND Bookmarks.Notify='1' AND Users.EmailNotify='1'")){
            $stmt->bind_param("s", $daid);
            $stmt->execute();
            $result=$stmt->get_result();

            if (mysqli_num_rows($result) >= 1) {
                while($row = $result->fetch_array()){
                    $users[] = $row;
                }
                $success = TRUE;
            } else {
                //No one needs to be notified
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
    foreach ($users as $user){
        $fullname = $user[0] . " " . $user[1];
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
        $mail->setFrom($fromemail, 'GRDS Changes');
            $mail->addAddress($user[2], $fullname);     // Add a recipient

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'GRDS: Updates to record class ' . $daid;
            $mail->Body    = "
            <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
 <head>
  <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
  <title>Notify Change Email</title>
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
        <td align='center' style='padding: 40px 0px 0px 0px'> 
          <img src='https://deco3801-alexs-angels.uqcloud.net/img/update.png' alt='update' height='180px'/>
        </td>
      </tr>
      <tr>
        <td align='center' style='padding: 10px 0px 10px 0px; font-size: 24px'> We've made some changes!
        </td>
      </tr>
      <tr>
        <td align='center' style='padding: 10px 100px 10px 100px; color: #979da2; font-size: 14px'> A change has been made to a record class you have bookmarked.
        </td>
      </tr>
      <tr>
        <td align='center' style='padding: 10px 100px 10px 100px; color: #979da2; font-size: 14px'> Record <span style='color: #2a80b2; font-weight: bold'>$daid</span> has been changed due to: <span style='color: #2a80b2; font-weight: bold'>$reason</span>. To see the updated record class, click the button below.
        </td>
      </tr>
      <tr>
        <td align='center' style='padding: 15px 0px 15px 0px'>
            <a href='$websitelocation/index.php?daid=$daid'><input style='border: none; color: white; font-size: 14px; background: #484847; padding: 10px 50px 10px 50px' type='submit' value='See updated record class $daid'/></a>
        </td>
      </tr>
      <tr>
        <td align='center' style='padding: 10px 100px 10px 100px; color: #979da2; font-size: 14px'> Further information and justification for changes may be found in the Appraisal Log. See this by clicking the buttom below or visiting our website.
      </tr>
      <tr>
        <td align='center' style='padding: 15px 0px 50px 0px'>
          <form action='https://deco3801-alexs-angels.uqcloud.net/files/appraisal-log.pdf'>
            <input style='border: none; color: white; font-size: 14px; background: #484847; padding: 10px 50px 10px 50px' type='submit' value='View Appraisal Log'/>
          </form>
        </td>
      </tr>
    </table>
  </td>
 </tr>
 <tr>
  <td align='center' bgcolor='#2a80b2' style='padding: 40px 10px 40px 10px; color: white; font-size: 12px'>
    <p>Department of Science, Information Technology and Innovation | 2017</p>
    <p>To stop receiving these emails, click <a href='$websitelocation/unsubscribe.php?id=$user[3]' style='color: #b2e2ff'>here</a>.</p>
  </td>
 </tr>
 </table>
</body>
</html>
            ";

            $mail->send();
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }
    echo "2";
}

$link->close();

?>