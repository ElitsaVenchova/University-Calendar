<!DOCTYPE html>
<html>
		<head>
			<link rel = "stylesheet" href ="style/main.css">
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
				include 'models'.DIRECTORY_SEPARATOR.'Sys'.DIRECTORY_SEPARATOR.'SysUsers.php';
				include 'models'.DIRECTORY_SEPARATOR.'Sys'.DIRECTORY_SEPARATOR.'SysRoles.php';
				$errors = array();
				$clean_data = array();
				$userRoles = array();
				$input_username=$input_password=$input_firstname=$input_surname=$input_lastname=$input_title=
				$input_address=$input_telefonnumber=$input_email=$input_role=$input_visitingtime=$input_room=$input_cathedra=
				$input_stepen=$input_specialnost=$input_admgroup=$input_year=$input_active=$input_description=$input_rownum="";
				if(isset($_POST) && $_SERVER['REQUEST_METHOD'] === 'POST'){
					$input_user = new SysUsers();
					$input_user->setUsername($_POST['username']);
					$input_user->setPassword($_POST['password']);
					$input_user->setFirstName($_POST['firstname']);
					$input_user->setSurname($_POST['surname']);
					$input_user->setLastName($_POST['lastname']);
					$input_user->setTitle($_POST['title']);
					$input_user->setAddress($_POST['address']);
					$input_user->setTelefonNumber($_POST['telefonnumber']);
					$input_user->setEmail($_POST['e-mail']);
					$input_user->setVisitingTime($_POST['vistingtime']);
					$input_user->setRownum($_POST['rownum']);
					$input_user->setCabinet($_POST['room']);
					$input_user->setCathedralId($_POST['cathedra']);
					$input_user->setStudyProgramId($_POST['opt']);
					$input_user->setAdmGroup($_POST['adm_group']);
					$input_user->setYearAtUniversity($_POST['year']);
					$input_user->setIsActive($_POST['active'] != null ? "Y":"N");
					$input_user->setNotes($_POST['description']);
					if(isset($_POST['STUDENT'])){
						$userRoles['STUDENT'] = $_POST['STUDENT'];
						echo "1";
					}
					if(isset($_POST['ADMIN'])){
						$userRoles['ADMIN'] = $_POST['ADMIN'];
						echo "2";
					}
					if(isset($_POST['SECRETARY'])){
						$userRoles['SECRETARY'] = $_POST['SECRETARY'];
					}
					if(isset($_POST['ASSISTENT'])){
						$userRoles['ASSISTENT'] = $_POST['ASSISTENT'];
					}
					if(isset($_POST['LECTURER'])){
						$userRoles['LECTURER'] = $_POST['LECTURER'];
					}
					$nstmt=$conn->prepare("ISERT INTO sys_users (username, password, first_name, surname, last_name, title, adress, telefon_number, email, visiting_time, cabinet, rownumber, cathedral_id, study_program_id, adm_group, year_at_university, is_active, notes) VALUES (:username, :password, :first_name, :surname, :last_name, :title, :adress, :telefon_number, :email, :visiting_time, :cabinet, :rownumber, :cathedral_id, :study_program_id, :adm_group, :year_at_university, :is_active, :notes)");
					if(($input_user->getUsername())!=null && strlen($input_user->getUsername()) <= 80){
						$clean_data['$input_user->getUsername()'] = $input_username;
						$nstmt -> bindparam(':username',$input_username);
					} else {
						$errors['$input_user->getUsername()'] = "<div class='error'>".'Потребителското име е задължително поле с максимална дължина 80 символа.<br>'."</div>";
					}
					if(($input_user->getPassword())!=null && strlen($input_user->getPassword()) <= 80 && strlen($input_user->getPassword()) >=6){ 
						$clean_data['$input_user->getPassword()'] = $input_password;
						$nstmt -> bindparam(':password',$input_password);
						} else {
							$errors['$input_user->getPassword()'] = "<div class='error'>".'Паролата е задължително поле с максимална дължина 80 символа и минимална дължина 6 символа.<br>'."</div>";
						}
					if(($input_user->getFirstName()) != null && strlen($input_user->getFirstName()) <= 50){
						$clean_data['$input_user->getFirstName()'] = $input_firstname;
						$nstmt -> bindparam(':first_name',$input_firstname);
						} else {
							$errors['$input_user->getFirstName()'] = "<div class='error'>".'Името е задължително поле с максимална дължина 50 символа'."</div>";
						}
					if(($input_user->getSurname()) != null && strlen($input_user->getSurname()) <= 50){
						$clean_data['$input_surname->getSurname()'] = $input_surname;
						$nstmt -> bindparam(':surname',$input_surname);
						} else {
							$errors['$input_user->getSurname()'] = "<div class='error'>".'Бащинно име е задължително поле с максимална дължина 50 символа.'."</div>";
						}
					if(($input_user->getLastName()) != null && strlen($input_user->getLastName()) <= 50){
						$clean_data['$input_user->getLastName()'] = $input_lastname;
						$nstmt -> bindparam(':last_name',$input_lastname);
						} else {
							$errors['$input_user->getLastName()'] = "<div class='error'>".'Фамилно име е задължително поле с максимална дължина 50 символа.'."</div>";
						}
					if(($input_user->getTitle()) != null && strlen($input_user->getTitle()) <= 50){
						$clean_data['$input_user->getTitle()'] = $input_title;
						$nstmt -> bindparam(':title',$input_title);
						} else {
							$errors['$input_user->getTitle()'] = "<div class='error'>".'Титлата е задължително поле с максимална дължина 50 символа.<br>'."</div>";
						}
					if(($input_user->getAddress()) != null && strlen($input_user->getAddress()) <= 350){
						$clean_data['$input_user->getAddress()'] = $input_address;
						$nstmt -> bindparam(':adress',$input_address);
						} else {
							$errors['$input_user->getAddress()'] = "<div class='error'>".'Адрес е задължително поле с максимална дължина 350 символа.<br>'."</div>";
						}
					if(($input_user->getTelefonNumber()) != null && strlen($input_user->getTelefonNumber()) <= 50){
						$clean_data['$input_user->getTelefonNumber()'] = $input_telefonnumber;
						$nstmt -> bindparam(':telefon_number',$input_telefonnumber);
						} else {
							$errors['$input_user->getTelefonNumber()'] = "<div class='error'>".'Номер е задължително поле с максимална дължина 50 символа.<br>'."</div>";
						}
					if(($input_user->getEmail()) != null && strlen($input_user->getEmail()) <= 150){
						$clean_data['$input_user->getEmail()'] = $input_email;
						$nstmt -> bindparam(':email',$input_email);
						} else {
							$errors['$input_user->getEmail()'] = "<div class='error'>".'E-mail е задължително поле с максимална дължина 150 символа.<br>'."</div>";
						}
					if(((($input_user->getVisitingTime()) != null && isset($userRoles['LECTURER'])) || (($input_user->getVisitingTime()) == null && !isset($userRoles['LECTURER'])))&& strlen($input_user->getVisitingTime()) <= 450){
						$clean_data['$input_user->getVisitingTime()'] = $input_visitingtime;
						$nstmt -> bindparam(':visiting_time',$input_visitingtime);
						} else {
							$errors['$input_visitingtime->getVisitingTime()'] = "<div class='error'>".'Приемно време е поле с максимална дължина 450 символа.'."</div>";
						}
					if(((($input_user->getCabinet()) != null && isset($userRoles['LECTURER'])) || (($input_user->getCabinet()) == null && !isset($userRoles['LECTURER'])))&& strlen($input_user->getCabinet()) <= 80){
						$clean_data['$input_user->getCabinet()'] = $input_room;
						$nstmt->bindparam(':cabinet',$input_room);
						} else {
							$errors['$input_room->getCabinet()'] = "<div class='error'>".'Кабинет е задължително поле с максимална дължина 80 символа.'."</div>";
						}
					if(((($input_user->getAdmGroup()) != null && isset($userRoles['STUDENT'])) || ($input_user->getAdmGroup()) == null && !isset($userRoles['STUDENT'])) && strlen($input_user->getAdmGroup()) <= 2){
						$clean_data['$input_user->getAdmGroup()'] = $input_admgroup;
						$nstmt->bindparam(':adm_group',$input_admgroup);
						} else {
							$errors['$input_user->getAdmGroup()'] = "<div class='error'>".'Административна група е задължително поле с максимална дължина 2 символа.'."</div>";
						}
					if(((($input_user->getYearAtUniversity()) != null && isset($userRoles['STUDENT'])) || (($input_user->getYearAtUniversity()) == null && !isset($userRoles['STUDENT'])))&& strlen($input_user->getYearAtUniversity()) <= 1){
						$nstmt->bindparam(':year_at_university', $input_year);
						} else {
							$errors['$input_year->getYearAtUniversity()'] = "<div class='error'>".'Година е задължително поле с максимална дължина 1 символа.'."</div>";
						}
					if(strlen($input_user->getNotes()) <= 250){
						$clean_data['$input_user->getNotes()'] = $input_description;
						$nstmt->bindparam(':notes', $input_description);
						} else {
							$errors['$input_description->getNotes()'] = "<div class='error'>".'Описание е поле с максимална дължина 250 символа.'."</div>";
						}
					if((($input_user->getRownum()) != null && isset($userRoles['STUDENT'])) || (($input_user->getRownum()) == null && !isset($userRoles['STUDENT']))){
						$clean_data['$input_user->getRownum()']=$input_rownum;
						$nstmt->bindparam(':rownumber',$input_rownum);
					} else {
							$errors['$input_description->getNotes()'] = "<div class='error'>".'Описание е поле с максимална дължина 250 символа.'."</div>";
						}
					if((($input_user->getCathedralId()) != null && isset($userRoles['LECTURER'])) || (($input_user->getCathedralId()) == null && !isset($userRoles['LECTURER']))){
						$clean_data['$input_user->getCathedralId()']=$input_cathedra;
						$nstmt->bindparam(':cathedral_id',$input_cathedra);
					} else {
							$errors['$input_description->getNotes()'] = "<div class='error'>".'Описание е поле с максимална дължина 250 символа.'."</div>";
						}
					if((($input_user->getStudyProgramId()) != null && isset($userRoles['STUDENT'])) || (($input_user->getStudyProgramId()) == null && !isset($userRoles['STUDENT']))){
						$clean_data['$input_user->getStudyProgramId()']=$input_specialnost;
						$nstmt->bindparam(':study_program_id',$input_specialnost);
					} else {
							$errors['$input_description->getNotes()'] = "<div class='error'>".'Описание е поле с максимална дължина 250 символа.'."</div>";
						}
						$nstmt->bindparam(':is_active',$input_active);
					if(!isset($errors) || count($errors)== 0){
						$nstmt->execute();
					}
				}
				
				$sqlRole='SELECT name,code FROM sys_roles';
				$statementRole=$conn->query($sqlRole);
				
				$sqlCathedral='SELECT short_name,name FROM nom_cathedrals';
				$statementCathedral=$conn->query($sqlCathedral);
				
				$sqlDegree="SELECT short_name,name FROM nom_degrees";
				$statementDegree=$conn->query($sqlDegree);
				
				$sqlStudyProgram='SELECT short_name,name FROM nom_study_programs';/* TODO да сложа клауза, за да излизат само спец. за бак. или маг.*/
				$statementStudyProgram=$conn->query($sqlStudyProgram);
				
			?>
			
			<?php foreach($errors as $error ): ?>
						<?=$error;?>
						<?php endforeach; ?>
			<div class="edit" id="userInfo">
                <div class="edit_form">
					<form action="registration.php" method="POST">
						<label>Потребителско име <span class="required">*</span> <input type="text" name="username"></label>
						<label>Парола<span class="required">*</span> <input type="password" name="password"></label>
						<label>Име<span class="required">*</span> <input type="text" name="firstname"></label>
						<label>Бащино име<span class="required">*</span> <input type="text" name="surname"></label>
						<label>Фамилия<span class="required">*</span> <input type="text" name="lastname"></label>
						<label>Титла<span class="required">*</span><input type="text" name="title"></label>
						<label>Адрес<span class="required">*</span><input type="text" name="address"></label>
						<label>Телефонен номер<span class="required">*</span><input type="text" name="telefonnumber"></label>
						<label>E-mail<span class="required">*</span><input type="email" name="e-mail"></label>
						<label>Роля<span class="required">*</span>	</br>
							<?php while($row=$statementRole->fetch(PDO::FETCH_ASSOC)): ?>
								<input type="checkbox" name="<?=$row['code'];?>" value="<?=$row['code'];?>"><?=$row['name'];?></br>
							<?php endwhile; ?></label>
						<label>Приемно време<span class="required">*</span><input tpye="text" name="vistingtime"></label>
						<label>Кабинет<span class="required">*</span><input type="text" name="room"></label>
						<label>Катедра<span class="required">*</span>
						<select name="cathedra">	
							<?php while($row=$statementCathedral->fetch(PDO::FETCH_ASSOC)): ?>
								<option> <?=$row['name'];?></option>
							<?php endwhile; ?>
						</select></label>
						<label>Степен<span class="required">*</span>
						<select name="opt">
							<?php while($row=$statementDegree->fetch(PDO::FETCH_ASSOC)): ?>
								<option> <?=$row['name'];?></option>
							<?php endwhile; ?>
						</select></label>
				
						<label>Специалност<span class="required">*</span>
						<select name="spec">
							<?php while($row=$statementStudyProgram->fetch(PDO::FETCH_ASSOC)): ?>
								<option> <?=$row['name'];?></option>
							<?php endwhile; ?>				
						</select></label>
						<label>Група<span class="required">*</span><input type="number" name="adm_group" min=0 max=10></label>
						<label>Факултетен номер<span class="required">*</span> <input type="number" name="rownum" min=0></label>
						<label>Година<span class="required">*</span><input type="number" name="year" min=1 max=4></label>
						<label>Активен<input type="checkbox" name="active" value="Y" checked></label>
						<label>Бележки<textarea name="description"></textarea></label>
						<div class="buttons"> <input type="submit"> </div>
					</form>
				</div>
			</div>
	
		</body>

	</html>

