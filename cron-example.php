<?php
// also need crontab
// iterate thru db, get file, check hash, send email if different, update hash
require_once 'swiftmailer/lib/swift_required.php';
$db = new mysqli('localhost', 'root', 'DB PW HERE', 'reddit');
$sql = "select * from zposts";
$results = $db->query($sql);
while($row=$results->fetch_assoc()){
$id = $row['id'];
$url = $row['url'];
$hashold = $row['hash'];
$get = file_get_contents($url);
$hashnew = sha1($get);
if($hashold == $hashnew){
 echo "no change in " . $url;
}
// below should be !== not ==
if ($hashold !== $hashnew){
  echo "New content in " . $url . "!";
  echo "<br />Old: " . $hashold;
  echo "<br />New: " . $hashnew;
  $sqlupdate = "UPDATE zposts SET hash='$hashnew' WHERE hash='$hashold'";
  $results = $db->query($sqlupdate);
  if($results) { echo "Updated"; }
$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
  ->setUsername('email username')
  ->setPassword('password or app password for google apps');

$mailer = Swift_Mailer::newInstance($transport);

$message = Swift_Message::newInstance('Test Subject')
  ->setFrom(array('from email' => 'Subject'))
  ->setTo(array('to email'))
  ->setBody('The post at ' . $url . ' has new comments.');

$result = $mailer->send($message);
}
}
echo "<br /><a href=https://zardwiz.com/r/index.html>Go back and add another post, stalker.";
?>
