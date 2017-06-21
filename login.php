<?php
	$host="localhost";
	$db="universitycalender";
	$user="root";
	$pass="";
	try{
		$connection=new PDO("mysql:host=$host;dbname=$db",$user,$pass);
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}
	if(isset($_POST)){
		if(isset($_POST['username'])){
			
		};
	} else{
		
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel = "stylesheet" href = "">
		<title>Students Calendar</title>
		<meta charset = "utf-8">
		<meta name = "Description" content = "This web page is for students calendar. They can see their calendars, their lecturers and so on.">
		<meta name = "keywords" content = "Students, Calendar, Lecturers">
		<mate name = "author" content = "Elica Venchova, Natalia Ignatova">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<img src="https://susi.uni-sofia.bg/ISSU/forms/img/header.gif" alt="СУ "Климент Охридски"">
		<form action="login.php" method=post>
			<label>Потребителско име:</label><input type="text" name="username"></br></br>
			<label>Парола:</label><input type="password" name="password"></br></br>
			<input type="submit" value="ВХОД">
		</form>
	</body>
</html>