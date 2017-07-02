<?php
$host="localhost";
$db="universitycalender";
$user="root";
$pass="";
try {
 $conn=new PDO("mysql:host=$host;dbname=$db;charset=utf8",$user,$pass);
} catch (PDOException $e) {
 echo 'Connection failed: ' . $e->getMessage();
}
?>