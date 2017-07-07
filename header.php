<?php
//TODO: Тук трябва да се направи някъде дали потребителя има сесия и ако няма да се препраща към login.php

//TODO: Това трябва да се изтрие, защото ще се създава след успешен логин
$host="localhost";
$db="UniversityCalender";
$user="root";
$pass="";
try {
 $conn=new PDO("mysql:host=$host;dbname=$db;charset=utf8",$user,$pass);
} catch (PDOException $e) {
 echo 'Connection failed: ' . $e->getMessage();
}
$_SESSION['conn'] = $conn;
//TODO: До тук трябва да бъде изнесено

session_start();
$now = time();
if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
 session_unset();
 session_destroy();
 session_start();
}
// Сесията ще стой 1 час
$_SESSION['discard_after'] = $now + 3600;
//Създаване на променливата за connection към базата, за да може да се използва наготово
//TODO: Това трябва да се откоментира когато горното се махне
//$conn = $_SESSION['conn'];

?>
