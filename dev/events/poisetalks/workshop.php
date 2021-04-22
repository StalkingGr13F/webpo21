<?php
$path = '../../frameworks/php';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../frameworks/php/PHPMailer/src/Exception.php';
require '../../frameworks/php/PHPMailer/src/PHPMailer.php';
require '../../frameworks/php/PHPMailer/src/SMTP.php';
$username = "poiq2362_admin";
$passwd = "Su.}6U46?l%P";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
  $mysqli = new mysqli("127.0.0.1", "$username", "$passwd", "poiq2362_form_dev", 3306);
  $mysqli->set_charset("utf8mb4");
  echo "Data recorded";
} catch(Exception $e) {
  error_log($e->getMessage());
  exit('Something went wrong!');
}
$mysqli->set_charset("utf8mb4");

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

$stmt = $mysqli->prepare("INSERT INTO webinar1 (name, email, dob, gender, phone, institution) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss",$_POST['name'], $_POST['email'], $_POST['dob'], $_POST['gender'], $_POST['phone'], $_POST['institution']);
$stmt->execute();
$stmt->close();

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
$mail->Body = "Dear $name,<br><br>Congratulations, you have sucessfully signed up for our <em>Safety Workshop</em> in Process Engineering Series of Events (POISE) 2021.<br><br>Your invoice number is : $xy <br><br>Through this <em>Safety Workshop</em>, we are hoping for you to have such a marvellous experience and gain awareness regarding the importance of safety.<br>We are very excited and looking forward for your participation.<br><br>Let us know if you have any further questions by contacting:<br>LINE: @poiseugm2021 (POISE UGM)<br>Nabila: 081293934283 (WhatsApp)<br>Natasha: 087898502471 (WhatsApp)<br><br>Best regards,<br>POISE UGM";
$mail->send();
?>
