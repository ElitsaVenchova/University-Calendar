<!DOCTYPE html>
<html>
    <head>
		<link rel="stylesheet" href="style/main.css" type="text/css"/>
		<link type="text/css" href="scripts/jquery-ui-themes-1.12.1/themes/base/jquery-ui.css" rel="stylesheet"/>
		<script type="text/JavaScript" src="scripts/jquery-3.2.1.js"></script>
		<script type="text/JavaScript" src="scripts/UserJQueryMessageStyles.js"></script>
		<script type="text/JavaScript" src="scripts/DatePicker.js"></script>
		<script type="text/javascript" src="scripts/jquery-ui-1.12.1/jquery-ui.js"></script>
		<title>Students Calendar</title>
		<meta charset ="utf-8">
		<meta name = "Description" content = "This web page is for students calendar. They can see their calendars, their lecturers and so on.">
		<meta name = "keywords" content = "Students, Calendar, Lecturers">
		<mate name = "author" content = "Elica Venchova, Natalia Ignatova">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
    <body>
		<?php
			include 'header.php';
			include 'models' . DIRECTORY_SEPARATOR . 'Sys' . DIRECTORY_SEPARATOR . 'SysUsers.php';
					if(isset($_SESSION['user_id'])){
					} else{
						header("Location: login.php");
					}
			$username=$_SESSION['user_id'];
			$stmt=$conn->prepare("SELECT courses.short_name,grades.grade FROM grades INNER JOIN courses WHERE student='$username' and grades.course_id=courses.id");
			$stmt->execute();
			while($row=$stmt->fetch()){
				echo '<table class="dataset">';
				echo '<tr><th>Предмет</th> <th>Оценка</th></tr>';
				echo '<tr><td>'.$row['short_name'].'</td><td>'.$row['grade'].'</td></tr>';
				echo '</table>';
			}
			echo '<a href="profile.php">Назад</a>';
		?>
		</body>
</html>