<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "demo";

// Create connection
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $stmt = $conn->prepare("SELECT n_ame FROM users"); 
    $stmt->execute();
     while($row=$stmt->fetch())
    {
        $e_mail=$row['n_ame'];
    }
    
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
?>
<img src="<?php echo $output; ?>">




