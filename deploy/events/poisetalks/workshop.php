<?php
$path = '../../frameworks/php';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);
/*
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../frameworks/php/PHPMailer/src/Exception.php';
require '../../frameworks/php/PHPMailer/src/PHPMailer.php';
require '../../frameworks/php/PHPMailer/src/SMTP.php';
*/
$dbconfirm = 0;
$upconfirm = 0;

date_default_timezone_set('Asia/Jakarta');
$uploaddir = '../../../uploads/poisetalks/workshop/';
$curdate = date('Y-m-d');
$tiem = date('H:i:s');
$un = '_';
$filedate = $curdate . $un . $tiem;
$nameformat = $filedate . $un . basename($_FILES['payment']['name']);
$uploadfile = $uploaddir . $nameformat;
if (move_uploaded_file($_FILES['payment']['tmp_name'], $uploadfile)) {
    $upconfirm = 1;
} else {
    $upconfirm = 0;
}

$username = "poiq2362_admin";
$passwd = "Su.}6U46?l%P";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
  $mysqli = new mysqli("127.0.0.1", "$username", "$passwd", "poiq2362_poisetalks", 3306);
  $mysqli->set_charset("utf8mb4");
  $dbconfirm = 1;
} catch(Exception $e) {
  error_log($e->getMessage());
  $dbconfirm = 0;
}
$mysqli->set_charset("utf8mb4");
/*
$stmt = $mysqli->prepare("INSERT INTO counting (reg) VALUES (?)");
$y = 1;
$stmt->bind_param("i", $y);
$stmt->execute();
$idnum = mysqli_insert_id($mysqli);
$stmt->close();
if ($idnum < 10) {
    $xy = "#POISETALKS00$idnum";
} elseif ($idnum < 100) {
    $xy = "#POISETALKS0$idnum";
} else {
    $xy = "#POISETALKS$idnum";
} 
*/

$stmt = $mysqli->prepare("INSERT INTO workshop (name, email, dob, gender, phone, institution, paymethod, filename) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss",$_POST['name'], $_POST['email'], $_POST['dob'], $_POST['gender'], $_POST['phone'], $_POST['institution'], $_POST['paymethod'], $nameformat);
$stmt->execute();
$idnum = mysqli_insert_id($mysqli);
$stmt->close();


/*
$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host       = 'mail.poiseugm.net';
$mail->SMTPAuth   = true;
$mail->Username   = 'notifikasi@poiseugm.net';
$mail->Password   = '({A=&=32~Kn;a@0$>?};9+I&W}?a\P';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->Port       = 465;
$mail->setFrom('notifikasi@poiseugm.net', 'POISE UGM');
$mail->addAddress($_POST['email'], $_POST['name']);
$mail->isHTML(true);
$mail->Subject = 'Notifikasi pendaftaran POISETalks';
$recname = $_POST['name'];
$mail->Body = "Dear $recname,<br><br>Congratulations, you have sucessfully signed up for our <em>Safety Workshop</em> in Process Engineering Series of Events (POISE) 2021.<br><br>Your invoice number is : $xy <br><br>Through this <em>Safety Workshop</em>, we are hoping for you to have such a marvellous experience and gain awareness regarding the importance of safety.<br>We are very excited and looking forward for your participation.<br><br>Let us know if you have any further questions by contacting:<br>LINE: @poiseugm2021 (POISE UGM)<br>Nabila: 081293934283 (WhatsApp)<br>Natasha: 087898502471 (WhatsApp)<br><br>Best regards,<br>POISE UGM";
$mail->send();
*/
$hostnaem  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$suc = 'success.html';
$fai = 'failed.html';
if ($dbconfirm == 1 && $upconfirm == 1) {
    header("Location: https://$hostnaem$uri/$suc");
} else {
    header("Location: https://$hostnaem$uri/$fai");
}
?>
