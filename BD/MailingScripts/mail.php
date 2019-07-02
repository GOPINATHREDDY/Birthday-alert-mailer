<?php
require 'PHPMailerAutoload.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "demo";

  
  $source="1.jpg";
  $image=imagecreatefromjpeg($source);
  $output="test.jpg";
  $white=imagecolorallocate($image,255,255,255);
  $black=imagecolorallocate($image,0,0,0);
  $fs=40;
  $rot=0;
  $ox=120;
  $oy=120;
  $font="OpenSans-LightItalic.ttf";
  $txt="happy birthday,$e_mail";
  $txt1=imagettftext($image,$fs,$rot,$ox,$oy,$black,$font,$txt);
  $txt1=imagettftext($image,$fs,$rot,$ox+2,$oy,$black,$font,$txt);
  imagejpeg($image,$output,99);


// Create connection
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $stmt = $conn->prepare("SELECT e_mail FROM users"); 
    $stmt->execute();
     while($row=$stmt->fetch())
    {
        $e_mail=$row['e_mail'];
        sendEmail($e_mail);
    }
    //$stmt1 = $conn->prepare("SELECT e_mail FROM users where n_ame='da'"); 
    //$stmt1->execute();
    //while($row=$stmt1->fetch())
    //{
        //$e_mail=$row['e_mail'];
        //sendEmail($e_mail);
    //}


function sendEmail($e_mail)
{
$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'dwijesh.daka@gmail.com';                 // SMTP username
$mail->Password = 'Daka@12345@';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('dwijesh.daka@gmail.com', 'Mailer');
$mail->addAddress($e_mail);     // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC($e_mail1);
//$mail->addBCC('bcc@example.com');

$mail->addAttachment('test.jpg');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
}
?>