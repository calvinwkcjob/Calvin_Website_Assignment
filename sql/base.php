<?php
session_start();

$dbhost = "localhost"; // this will ususally be 'localhost', but can sometimes differ
$dbname = "drugs"; // the name of the database that you are going to use for this project
$dbuser = "drugs"; // the username that you created, or were given, to access your database
$dbpass = "drugs"; // the password that you created, or were given, to access your database

mysql_connect($dbhost, $dbuser, $dbpass) or die("MySQL Error: " . mysql_error());
mysql_select_db($dbname) or die("MySQL Error: " . mysql_error());

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
require_once 'signup-email-verification/class.user.php';
$user_home = new USER();


$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC); 
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if ($actual_link == "http://innogp.com/drugs/info.php"){
  $sql = "SELECT id, name, type, detail, effects FROM drugs";
  $result = mysqli_query($conn, $sql);  	
}else if($actual_link == "http://innogp.com/drugs/youtube.php") {
  $sql = "SELECT id, link FROM youtube";
  $result = mysqli_query($conn, $sql);  	
}


?>