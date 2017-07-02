<?php
	include 'models'.DIRECTORY_SEPARATOR.'Sys'.DIRECTORY_SEPARATOR.'SysUsers.php';
	include 'header.php';
		$error=array();
		if(isset($_POST) && $_SERVER['REQUEST_METHOD'] === 'POST'){
			$user=new SysUsers();
			$user->setUsername($_POST['username']);
			$user->setPassword($_POST['password']);
				$sql="SELECT username, password FROM Sys_Users WHERE username=? and password=?";
				$stmt=$conn->prepare($sql);
				$result=$stmt->execute(array($user->getUsername(),$user->getPassword()));
				if($result && $stmt->rowCount() == 1){
					header('Location: profile.php');
					$_SESSION['logged_in'] == true;
					$_SESSION['user_id'] = $user->getUsername();
				} else{
					array_push($error,"Wrong username or password");
					
				}
			}
			
		
		
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel ="stylesheet" href = "style/main.css">
		<title>Students Calendar</title>
		<meta charset = "utf-8">
		<meta name = "Description" content = "This web page is for students calendar. They can see their calendars, their lecturers and so on.">
		<meta name = "keywords" content = "Students, Calendar, Lecturers">
		<mate name = "author" content = "Elica Venchova, Natalia Ignatova">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<div class="edit" id="userInfo">
            <div class="edit_form">
				<div class="loginform">
					<img src="https://susi.uni-sofia.bg/ISSU/forms/img/header.gif" alt="СУ "Климент Охридски"">
					<form action="login.php" method="post">
						<div class="form">
						<label>Потребителско име<input type="text" name="username"></label>
						<label>Парола<input type="password" name="password"></label>
						</div>
						<div class="buttons"><input type="submit" value="ВХОД"></div>
					</form>
				</div>	
		</div>
		</div>
	</body>
</html>