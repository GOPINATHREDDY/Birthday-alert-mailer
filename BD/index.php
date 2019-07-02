<?php
require 'MailingScripts/PHPMailerAutoload.php';

// make connection to database
function makeConnection(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "employeedb";
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $connection;
}

function fetchCC($connection, $day, $month){
    $sql = "SELECT email FROM employees where MONTH(dob)!=$month or DAY(dob)!=$day;";
    $stmt = $connection->prepare($sql);
    $stmt->execute();

    $cc_guys = array();
    while ($result = $stmt->fetch())
        array_push($cc_guys, $result['email']);
    return $cc_guys;
}

function fetchBD($connection, $day, $month){
    $sql = "SELECT ename, email FROM `employees` WHERE MONTH(dob)=$month and DAY(dob)=$day";
    $stmt = $connection->prepare($sql);
    $stmt->execute();

    $bd_guys = array();
    while ($result = $stmt->fetchObject())
        array_push($bd_guys, $result);

    return $bd_guys;
}

function sendEmail($empObject, $ccMails) {
    $mail = new PHPMailer;

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'dwijesh.daka@gmail.com';                 // SMTP username
    $mail->Password = 'Daka@12345@';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom('dwijesh.daka@gmail.com', 'Mailer');
    $mail->addAddress($empObject->email);     // Add a recipient

    foreach ($ccMails as $email) {
        $mail->addCC($email);
    }
 
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Birthday Greetings';              
    $mail->Body    = '<tbody>

  <tr>
<td style="border:none;padding:.75pt .75pt .75pt .75pt">
<p class="MsoNormal" align="center" style="text-align:center"><tr>
<td style="border:none;background:#ffd7ff;padding:.75pt .75pt .75pt .75pt">
<p class="MsoNormal" align="center" style="text-align:center"><span style="font-size:18.0pt;font-family:Pristina;color:#660033">Dear
</span><span style="font-size:18.0pt;font-family:Pristina;color:#632523">'.$empObject->ename.',</span><span style="font-size:18.0pt;font-family:Pristina;color:#660033"><br>
</span><br>
<span style="font-size:18.0pt;font-family:Pristina;color:#660033">All of us at Teejay India are pleased to wish you a very</span><br>
<strong><span style="font-size:36.0pt;font-family:Vivaldi;color:#660033">Happy Birthday.</span></strong><span style="font-size:36.0pt;font-family:Vivaldi;color:#660033">
</span><br>
<br>
<span style="font-size:18.0pt;font-family:Pristina;color:#660033">On your birthday we wish you a future full of shinning possibilities.</span><u></u><u></u></p>
</td>
</tr><span style="font-size:18.0pt;font-family:Pristina;color:#660033"><img width="800" height="599" id="m_-1633613486742719186Picture_x0020_4" src="http://www.nexternal.com/wttc/images/Bday_choc_sm_0890w.jpg" alt="cid:image001.jpg@01D2579A.11CB4540"></span><u></u><u></u></p>
</td>
</tr>
<tr>
<td style="border:none;background:#ffd7ff;padding:.75pt .75pt .75pt .75pt">
<p class="MsoNormal" align="center" style="text-align:center"><span style="font-size:18.0pt;font-family:Pristina;color:#660033">Warm Regards<br>
HR Team<br>
</span><img width="140" height="56" id="m_-1633613486742719186Picture_x0020_3" src="https://static.wixstatic.com/media/7482c7_6e5aee7d7f9b456b85c12c8f9a0038df~mv2.png/v1/fill/w_414,h_385,al_c,usm_0.66_1.00_0.01/7482c7_6e5aee7d7f9b456b85c12c8f9a0038df~mv2.png" alt="cid:image004.png@01D258FC.008B2E90"><u></u><u></u></p>
</td>
</tr>
</tbody> ';

    $mail->AltBody = '';

    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }

    return;
}

// main Driver function
function main() {
    $conn = makeConnection();
    $day = date('d');
    $month = date('m');

    $cc = fetchCC($conn, $day, $month);
    $bd = fetchBD($conn, $day, $month);
    // print_r($cc);
    // echo "<br>";
    // print_r($bd);

    foreach ($bd as $emp) {
        sendEmail($emp, $cc);
    }

    return;
}

// call driver function;
main();

?>
