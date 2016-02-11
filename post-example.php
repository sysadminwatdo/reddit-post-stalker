<?php
// Comment out the below if you don't want to IP restrict.
// Since there's no login, it might be a good idea to keep it.
if ($_SERVER['REMOTE_ADDR'] != 'your static ip') {
 die('Restricted system.');
}

$reddit = $_POST['reddit'];
$hash = sha1($reddit);
$db = new mysqli('localhost', 'root', 'DB PW', 'reddit');
$sqladd = "INSERT INTO zposts (url, hash) VALUES ('$reddit', '$hash')";
$insert = $db->query($sqladd);
if($insert){
 echo "OK<br />";
}
echo "I'll keep an eye on " . $reddit . " and let you know if it changes, because I'm creepy like that.";
$reddit = file_get_contents($reddit);
echo "<br />The current hash is " . sha1($reddit);
echo "<br /><a href=index.html>Go back and add another post, stalker.";
?>
