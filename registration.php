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
				$errors = array();
				$clean_data = array();
				$input_username=$input_password=$input_firstname=$input_surname=$input_lastname=$input_title=
				$input_address=$input_telefonnumber=$input_email=$input_role=$input_visitingtime=$input_room=$input_cathedra=
				$input_stepen=$input_specialnost=$input_admgroup=$input_year=$input_active=$input_description="";
				if(isset($_POST)){
					$input_username=$_POST['username'];
					$input_password=$_POST['password'];
					$input_firstname=$_POST['firstname'];
					$input_surname=$_POST['surname'];
					$input_lastname=$_POST['lastname'];
					$input_title=$_POST['title'];
					$input_address=$_POST['address'];
					$input_telefonnumber=$_POST['telefonnumber'];
					$input_email=$_POST['e-mail'];
					$input_visitingtime=$_POST['vistingtime'];
					$input_room=$_POST['room'];
					$input_cathedra=$_POST['cathedra'];
					$input_admgroup=$_POST['adm_group'];
					$input_year=$_POST['year'];
					$input_active=$_POST['active'];
					$input_description=$_POST['description'];
					if($input_username && strlen($input_username) <= 80){
						$clean_data['username'] = $input_username;
						} else {
							$errors['username'] = 'Потребителското име е задължително поле с максимална дължина 80 символа.<br>';
						}
					if($input_password && strlen($input_password) <= 80 && strlen($input_password) >=6){
						$clean_data['password'] = $input_password;
						} else {
							$errors['password'] = 'Паролата е задължително поле с максимална дължина 80 символа и минимална дължина 6 символа.<br>';
						}
					if($input_firstname && strlen($input_firstname) <= 50){
						$clean_data['firstname'] = $input_firstname;
						} else {
							$errors['firstname'] = 'Името е задължително поле с максимална дължина 50 символа.<br>';
						}
					if($input_surname && strlen($input_surname) <= 50){
						$clean_data['surname'] = $input_surname;
						} else {
							$errors['surname'] = 'Бащинно име е задължително поле с максимална дължина 50 символа.<br>';
						}
					if($input_lastname && strlen($input_lastname) <= 50){
						$clean_data['lastname'] = $input_lastname;
						} else {
							$errors['lastname'] = 'Фамилно име е задължително поле с максимална дължина 50 символа.<br>';
						}
					if($input_title && strlen($input_title) <= 50){
						$clean_data['title'] = $input_title;
						} else {
							$errors['title'] = 'Титлата е задължително поле с максимална дължина 50 символа.<br>';
						}
					if($input_address && strlen($input_address) <= 350){
						$clean_data['address'] = $input_address;
						} else {
							$errors['address'] = 'Адрес е задължително поле с максимална дължина 350 символа.<br>';
						}
					if($input_telefonnumber && strlen($input_telefonnumber) <= 50){
						$clean_data['telefonnumber'] = $input_telefonnumber;
						} else {
							$errors['telefonnumber'] = 'Номер е задължително поле с максимална дължина 50 символа.<br>';
						}
					if($input_email && strlen($input_email) <= 150){
						$clean_data['e-mail'] = $input_email;
						} else {
							$errors['e-mail'] = 'E-mail е задължително поле с максимална дължина 150 символа.<br>';
						}
					if($input_visitingtime && strlen($input_visitingtime) <= 450){
						$clean_data['vistingtime'] = $input_visitingtime;
						} else {
							$errors['vistingtime'] = 'Приемно време е поле с максимална дължина 450 символа.<br>';
						}
					if($input_room && strlen($input_room) <= 80){
						$clean_data['room'] = $input_room;
						} else {
							$errors['room'] = 'Името е задължително поле с максимална дължина 80 символа.<br>';
						}
					if($input_admgroup && strlen($input_admgroup) <= 2){
						$clean_data['adm_group'] = $input_admgroup;
						} else {
							$errors['adm_group'] = 'Името е задължително поле с максимална дължина 2 символа.<br>';
						}
					if($input_year && strlen($input_year) <= 1){
						$clean_data['year'] = $input_year;
						} else {
							$errors['year'] = 'Година е задължително поле с максимална дължина 1 символа.<br>';
						}
					if($input_description && strlen($input_description) <= 250){
						$clean_data['description'] = $input_description;
						} else {
							$errors['description'] = 'Описание е поле с максимална дължина 250 символа.<br>';
						}
				}
				$sqlRole='SELECT * FROM sys_roles';
				$statementRole=$connection->query($sqlRole);
				
				$sqlCathedral='SELECT * FROM nom_cathedrals';
				$statementCathedral=$connection->query($sqlCathedral);
				
				$sqlDegree="SELECT * FROM nom_degrees";
				$statementDegree=$connection->query($sqlDegree);
				
				$sqlStudyProgram='SELECT * FROM nom_study_programs';/* TODO да сложа клауза, за да излизат само спец. за бак. или маг.*/
				$statementStudyProgram=$connection->query($sqlStudyProgram);
				
			?>
			
			<form action="registration.php" method=post>
				<label>Потребителско име:</label><input type="text" name="username"><br>
				<label>Парола:</label><input type="password" name="password"><br>
				<label>Име:</label><input type="text" name="firstname"><br>
				<label>Бащино име:</label><input type="text" name="surname"><br>
				<label>Фамилия:</label><input type="text" name="lastname"><br>
				<label>Титла:</label><input type="text" name="title"><br>
				<label>Адрес:</label><input type="text" name="address"><br>
				<label>Телефонен номер</label><input type="text" name="telefonnumber"><br>
				<label>E-mail:</label><input type="email" name="e-mail"><br>
				<label>Роля:</label>				
					<select name="role">
						<?php while($row=$statementRole->fetch(PDO::FETCH_ASSOC)): ?>
							<option> <?=$row['code'];?></option>
						<?php endwhile; ?>
					</select></br>
				<label>Приемно време:</label><input tpye="text" name="vistingtime"><br>
				<label>Кабинет:</label><input type="text" name="room"><br>
				<label>Катедра:</label>
					<select name="cathedra">	
						<?php while($row=$statementCathedral->fetch(PDO::FETCH_ASSOC)): ?>
							<option> <?=$row['short_name'];?></option>
						<?php endwhile; ?>
					</select></br>
				<label>Степен: </label>
					<select name="opt">
						<?php while($row=$statementDegree->fetch(PDO::FETCH_ASSOC)): ?>
							<option> <?=$row['short_name'];?></option>
						<?php endwhile; ?>
					</select></br>
				
				<label>Специалност: </label>
					<select name="spec">
						<?php while($row=$statementStudyProgram->fetch(PDO::FETCH_ASSOC)): ?>
							<option> <?=$row['short_name'];?></option>
						<?php endwhile; ?>				
					</select></br>
				<label>Група:</label><input type="number" name="adm_group" min=0 max=10></br>
				<label>Година:</label><input type="number" name="year" min=1 max=4></br>
				<label>Активен:</label><input type="checkbox" name="active" value="Y" checked></br>
				<label>Бележки:</label><textarea name="description"></textarea></br>
				<input type="submit">
			</form>
	
		</body>

	</html>

