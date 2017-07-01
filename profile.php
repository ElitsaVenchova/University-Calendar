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
			?>
			<div class="head">
				<?php  
					$user = new SysUsers();
					$username=$user->getUsername();
					if(isset($_SESSION['user_id'])){
						$sql="SELECT username FROM Sys_Users WHERE username='$username'";
						$stmt=$conn->query($sql);
						while($result=$stmt->fetch(PDO::FETCH_ASSOC)){
							echo $result['username'];
						} 
					} else{
						header("Location: login.php");
					}
				?>
				<a href="logout.php">Изход</a>
			</div>
			<div class="nav">
				<a href="">Моят профил</a>
				<a href="">Календар</a>
				<a href="">Дисциплини</a>
				<a href="">Моите дисциплини</a>
				<a href="">Оценки</a>
			</div>
			<div class="main">
				<div class="publication">
					<h1>Публикации</h1>
				
				</div>
				<div class="news">
					<h1>Новини</h1>
					<?php ?>
				
				</div>
			</div>
		</body>

</html>