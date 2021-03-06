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
				$userRoles = array();
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
					if(isset($_POST['role'])){
					$userRoles = $_POST['role'];
					}
					$sysStmt=$conn->prepare("SELECT username FROM sys_users");
					//if()
					$nstmt=$conn->prepare("INSERT INTO sys_users (username, password, first_name, surname, last_name, title, adress, telefon_number, email, visiting_time, cabinet, rownumber, cathedral_id, study_program_id, adm_group, year_at_university, is_active, notes) VALUES (:username, :password, :first_name, :surname, :last_name, :title, :adress, :telefon_number, :email, :visiting_time, :cabinet, :rownumber, :cathedral_id, :study_program_id, :adm_group, :year_at_university, :is_active, :notes)");
					if(($input_user->getUsername())!=null && strlen($input_user->getUsername()) <= 80){
						$nstmt -> bindparam(':username',$input_user->getUsername());
						echo "1".$input_user->getUsername();
					} else {
						$errors['$input_user->getUsername()'] = "<div class='error'>".'Потребителското име е задължително поле с максимална дължина 80 символа.<br>'."</div>";
					}
					if(($input_user->getPassword())!=null && strlen($input_user->getPassword()) <= 80 && strlen($input_user->getPassword()) >=6){ 
						$nstmt -> bindparam(':password',$input_user->getPassword());
						} else {
							$errors['$input_user->getPassword()'] = "<div class='error'>".'Паролата е задължително поле с максимална дължина 80 символа и минимална дължина 6 символа.<br>'."</div>";
						}
					if(($input_user->getFirstName()) != null && strlen($input_user->getFirstName()) <= 50){
						$nstmt -> bindparam(':first_name',$input_user->getFirstName());
						} else {
							$errors['$input_user->getFirstName()'] = "<div class='error'>".'Името е задължително поле с максимална дължина 50 символа'."</div>";
						}
					if(($input_user->getSurname()) != null && strlen($input_user->getSurname()) <= 50){
						$nstmt -> bindparam(':surname',$input_user->getSurname());
						} else {
							$errors['$input_user->getSurname()'] = "<div class='error'>".'Бащинно име е задължително поле с максимална дължина 50 символа.'."</div>";
						}
					if(($input_user->getLastName()) != null && strlen($input_user->getLastName()) <= 50){
						$nstmt -> bindparam(':last_name',$input_user->getLastName());
						} else {
							$errors['$input_user->getLastName()'] = "<div class='error'>".'Фамилно име е задължително поле с максимална дължина 50 символа.'."</div>";
						}
					if(($input_user->getTitle()) != null && strlen($input_user->getTitle()) <= 50){
						$nstmt -> bindparam(':title',$input_user->getTitle());
						} else {
							$errors['$input_user->getTitle()'] = "<div class='error'>".'Титлата е задължително поле с максимална дължина 50 символа.<br>'."</div>";
						}
					if(($input_user->getAddress()) != null && strlen($input_user->getAddress()) <= 350){
						$nstmt -> bindparam(':adress',$input_user->getAddress());
						} else {
							$errors['$input_user->getAddress()'] = "<div class='error'>".'Адрес е задължително поле с максимална дължина 350 символа.<br>'."</div>";
						}
					if(($input_user->getTelefonNumber()) != null && strlen($input_user->getTelefonNumber()) <= 50){
						$nstmt -> bindparam(':telefon_number',$input_user->getTelefonNumber());
						} else {
							$errors['$input_user->getTelefonNumber()'] = "<div class='error'>".'Номер е задължително поле с максимална дължина 50 символа.<br>'."</div>";
						}
					if(($input_user->getEmail()) != null && strlen($input_user->getEmail()) <= 150){
						$nstmt -> bindparam(':email',$input_user->getEmail());
						} else {
							$errors['$input_user->getEmail()'] = "<div class='error'>".'E-mail е задължително поле с максимална дължина 150 символа.<br>'."</div>";
						}
					if(((($input_user->getVisitingTime()) != null && in_array('LECTURER',$userRoles)) || (($input_user->getVisitingTime()) == null && !in_array('LECTURER',$userRoles)))&& strlen($input_user->getVisitingTime()) <= 450){
						$nstmt -> bindparam(':visiting_time',$input_user->getVisitingTime());
						} else {
							$errors['$input_visitingtime->getVisitingTime()'] = "<div class='error'>".'Приемно време е поле с максимална дължина 450 символа.'."</div>";
						}
					if(((($input_user->getCabinet()) != null && in_array('LECTURER',$userRoles)) || (($input_user->getCabinet()) == null && !in_array('LECTURER',$userRoles)))&& strlen($input_user->getCabinet()) <= 80){
						echo $input_user->getCabinet();
						$nstmt->bindparam(':cabinet',$input_user->getCabinet());
						} else {
							$errors['$input_room->getCabinet()'] = "<div class='error'>".'Кабинет е задължително поле с максимална дължина 80 символа.'."</div>";
						}
					if(((($input_user->getAdmGroup()) != null && in_array('STUDENT',$userRoles)) || ($input_user->getAdmGroup()) == null && !in_array('STUDENT',$userRoles)) && strlen($input_user->getAdmGroup()) <= 2){
						$nstmt->bindparam(':adm_group',$input_user->getAdmGroup());
						} else {
							$errors['$input_user->getAdmGroup()'] = "<div class='error'>".'Административна група е задължително поле с максимална дължина 2 символа.'."</div>";
						}
					if(((($input_user->getYearAtUniversity()) != null && in_array('STUDENT',$userRoles)) || (($input_user->getYearAtUniversity()) == null && !in_array('STUDENT',$userRoles)))&& strlen($input_user->getYearAtUniversity()) <= 1){
						$nstmt->bindparam(':year_at_university', $input_user->getYearAtUniversity());
						} else {
							$errors['$input_year->getYearAtUniversity()'] = "<div class='error'>".'Година е задължително поле с максимална дължина 1 символа.'."</div>";
						}
					if(strlen($input_user->getNotes()) <= 250){
						$nstmt->bindparam(':notes', $input_user->getNotes());
						} else {
							$errors['$input_description->getNotes()'] = "<div class='error'>".'Описание е поле с максимална дължина 250 символа.'."</div>";
						}
					if((($input_user->getRownum()) != null && in_array('STUDENT',$userRoles)) || (($input_user->getRownum()) == null && !in_array('STUDENT',$userRoles))){
						$nstmt->bindparam(':rownumber',$input_user->getRownum());
					} else {
							$errors['$input_description->getNotes()'] = "<div class='error'>".'Факултетен номер е поле с максимална дължина 250 символа.'."</div>";
						}
					if((($input_user->getCathedralId()) != null && in_array('LECTURER',$userRoles)) || (($input_user->getCathedralId()) == null && !in_array('LECTURER',$userRoles))){
						$nstmt->bindparam(':cathedral_id',$input_user->getCathedralId());
						echo $input_user->getCathedralId() == null;
					} else {
							$errors['$input_user->getCathedralId()'] = "<div class='error'>".'Катедра е поле с максимална дължина 250 символа.'."</div>";
						}
					if((($input_user->getStudyProgramId()) != null && in_array('STUDENT',$userRoles)) || (($input_user->getStudyProgramId()) == null && !in_array('STUDENT',$userRoles))){
						$nstmt->bindparam(':study_program_id',$input_user->getStudyProgramId());
					} else {
							$errors['$input_user->getStudyProgramId()'] = "<div class='error'>".'Специалност е поле с максимална дължина 250 символа.'."</div>";
						}
						$nstmt->bindparam(':is_active',$input_user->getIsActive());
					if(!isset($errors) || count($errors)== 0){
						if($nstmt->execute()){
						 echo 'kjlkllklkl';
						} else{
							print_r($nstmt->errorInfo());
						}
					}
				}
				
				$sqlRole='SELECT name,code FROM sys_Roles';
				$statementRole=$conn->query($sqlRole);
				
				$sqlCathedral='SELECT id,short_name,name FROM nom_Cathedrals';
				$statementCathedral=$conn->query($sqlCathedral);
				
				$sqlDegree="SELECT id,short_name,name FROM NOM_DEGREES";
				$statementDegree=$conn->query($sqlDegree);
				
				$sqlStudyProgram='SELECT id,short_name,name FROM NOM_STUDY_PROGRAMS';/* TODO да сложа клауза, за да излизат само спец. за бак. или маг.*/
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
								<input type="checkbox" name="role[]" value="<?=$row['code'];?>"/><?=$row['name'];?><br>
							<?php endwhile; ?></label>
						<label>Приемно време <span class="required">*</span><input type="text" name="vistingtime"></label>
						<label>Кабинет<span class="required">*</span><input type="text" name="room"></label>
						<label>Катедра<span class="required">*</span>
						<select name="cathedra">
								<option></option>
							<?php while($row=$statementCathedral->fetch(PDO::FETCH_ASSOC)): ?>
								<option value="<?=$row['id'];?>"> <?=$row['name'];?></option>
							<?php endwhile; ?>
						</select></label>
						<label>Степен<span class="required">*</span>
						<select name="opt">
							<option></option>
							<?php while($row=$statementDegree->fetch(PDO::FETCH_ASSOC)): ?>
								<option value="<?=$row['id'];?>"> <?=$row['name'];?></option>
							<?php endwhile; ?>
						</select></label>
				
						<label>Специалност <span class="required">*</span>
						<select name="spec">
							<option></option>
							<?php while($row=$statementStudyProgram->fetch(PDO::FETCH_ASSOC)): ?>
								<option value="<?=$row['id'];?>"> <?=$row['name'];?></option>
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

