<?php
if ($_POST) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $institution = $_POST['institution'];
}

$username = "poiq2362_admin";
$passwd = "Su.}6U46?l%P";
try {
    $db = new PDO('mysql:host=localhost:3306;dbname=poiq2362_testing', 'poiq2362_admin', 'Su.}6U46?l%P');
  echo "Connected\n";
} catch (PDOException $e) {
  die("Unable to connect: " . $e->getMessage());
}
try {
  $db->beginTransaction();
  $db->exec("INSERT INTO webinar (name, email, dob, gender, phone, institution) VALUES ('$name', '$email', '$dob', '$gender', '$phone', '$institution')");
  $db->commit();
} catch (Exception $e) {
  $dbh->rollBack();
  echo "Failed: " . $e->getMessage();
}
?>