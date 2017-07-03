<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style/profile.css" type="text/css"/>
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
					if(isset($_SESSION['user_id'])){
						echo $_SESSION['user_id'];
					} else{
						header("Location: login.php");
					}
				?>
				<a href="logout.php">Изход</a>
			</div>
			<div class="nav">
				<ul>
					<?php 
						$username=$_SESSION['user_id'];
						$stmt=$conn->prepare("SELECT role FROM sys_users_roles WHERE username='$username'");
						$stmt->execute();
						while($row=$stmt->fetch()){
							if($stmt && $row['role'] != 'ADMIN'){
								echo '<li><a href="profilered.php">Моят профил</a></li>';
							} else{
								echo '<li><a href="profilered.php">Моят профил</a></li>';
								echo '<li><a href="registration.php">Редакция на профил</a></li>';
								
							}
						}
					?>
                                    <li><a href="Calendar/ReserveEventCalendar.php">Календар</a></li>
					<li><a href="" id="d">Дисциплини</a></li>
						<div class="con">
						<?php 
							echo '<ul class="hidd">';
								$stmt=$conn->prepare("SELECT short_name FROM courses");
								$stmt->execute();
								while($row=$stmt->fetch()){
									echo '<li>'.$row['short_name'].'</li>';
								}
							echo '</ul>'; 
						?>		
						</div>
					
					<li><a href="" id="md">Моите дисциплини</a></li>
						<div class="con">
						<?php
							$username=$_SESSION['user_id'];
							echo '<ul class="hidd">';
							$stmt=$conn->prepare("SELECT courses.short_name FROM courses_students INNER JOIN courses WHERE student='$username' and courses_students.course_id=courses.id");
							$stmt->execute();
								while($row=$stmt->fetch()){
									echo '<li>'.$row['short_name'].'</li>';
								}
							echo '</ul>';
						?>
						</div>
					
					<li><a href="grades.php">Оценки</a></li>
					</ul>
			</div>
			<div class="main">
				<div class="publication">
					<h1>Публикации</h1>
						<?php
							echo '<p>';
							$stmt=$conn->prepare("SELECT title, publication FROM publications");
							$stmt->execute();
								while($row=$stmt->fetch()){
									echo '<h3>'.$row['title'].'</h3>';
									echo '<p>'.$row['publication'].'</p>';
								}
							echo '<p>';
						?>
				</div>
				<div class="news">
					<h1>Новини</h1>
						<?php
							$stmt=$conn->prepare("SELECT title, content FROM news");
							$stmt->execute();
								while($row=$stmt->fetch()){
									echo '<h3>'.$row['title'].'</h3>';
									echo '<p>'.$row['content'].'</p>';
								}
						?>
				
				</div>
			</div>
		</body>

</html>