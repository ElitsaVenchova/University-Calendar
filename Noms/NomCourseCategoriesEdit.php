<?php
require_once('..'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'Noms'.DIRECTORY_SEPARATOR.'NomCourseCategories.php');
include '..'.DIRECTORY_SEPARATOR.'header.php';

function save($conn, $post){
	if($post['id'] != null && !empty($post['id'])) {
		$stmt = $conn->prepare("UPDATE nom_Course_categories SET short_name = ?, name = ?, description = ?, is_active = ? WHERE ID = ?");
		$stmt->execute(array($post['shortName'], $post['name'], $post['description'], $post['isActive'], $post['id']));
	} else {
		$stmt = $conn->prepare("INSERT INTO nom_Course_categories (short_name, name, description, is_active) VALUES (?,?,?,?)");
		$stmt->execute(array($post['shortName'], $post['name'], $post['description'], $post['isActive']));
	}
	return "Записа беше редактиран успешно!";
}

if(isset($_POST) && isset($_POST['update']) && !empty($_POST['update'])){
	$msg = save($conn, $_POST);
	$courseCategoryId = $_POST['id'];
} else if(isset($_GET) && isset($_GET['courseCategoryId']) && !empty($_GET['courseCategoryId'])){
	$courseCategoryId = $_GET['courseCategoryId'];
}

$currCourseCategory = new NomCourseCategories();
if(isset($courseCategoryId)) {
	$sql = "SELECT id, short_name, ncc.name, ncc.description, ncc.is_active FROM nom_Course_categories ncc where ncc.id = ?";
	$stmt = $conn->prepare($sql);
	if ($stmt->execute(array($courseCategoryId))) { 
		while ($row = $stmt->fetch()) {
			$currCourseCategory = new NomCourseCategories();
			$currCourseCategory->setId($row['id']);
			$currCourseCategory->setShortName($row['short_name']);
			$currCourseCategory->setName($row['name']);
			$currCourseCategory->setDescription($row['description']);
			$currCourseCategory->setIsActive($row['is_active']);
		}
	}
}
?>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="../style/main.css" type="text/css"/>
		<link type="text/css" href="../scripts/jquery-ui-themes-1.12.1/themes/base/jquery-ui.css" rel="stylesheet"/>
		<script type="text/JavaScript" src="../scripts/jquery-3.2.1.js"></script>
		<script type="text/JavaScript" src="../scripts/UserJQueryMessageStyles.js"></script>
		<script type="text/JavaScript" src="../scripts/DatePicker.js"></script>
		<script type="text/javascript" src="../scripts/jquery-ui-1.12.1/jquery-ui.js"></script>
		<title>Редакция - Категория на курс</title>
	</head>
	<body onKeyPress="return checkSubmit(event)">
		<?php if(isset($msg)): ?>
			<div class="succ">
				<?= $msg?>
			</div>
			<?php $msg = null;?>
		<?php endif; ?> 
		<form name="nom_course_category_edit_form" method="post">
			<input type="hidden" name="update"/>
			<script>
                function checkSubmit(e)
                {
                    var v = document.forms['nom_course_category_edit_form'];
                    if (e.which === 13 && !e.altKey && !e.ctrlKey && !e.shiftKey)
                    {
                        updateRow();
                    }
                }
				
				function updateRow(){
					var ok = vallidateForm(document.forms[0]);
                    if (ok)
                    {
						document.forms[0].elements['update'].value = true;
						document.forms[0].submit();
					}
				}
				
				function clearFields(){
					$('#shortName').val("");
					$('#name').val("");
					$('#description').val("");
					$('#isActive').val("");
				}
			</script>
			<div class="edit" id="userInfo">
				<div class="edit_form">
					<label>№<span class="required">*</span> <input readonly type="text" name="id" required="Y" id="id" readonly value="<?= $currCourseCategory->getId()?>"/> </label>
					<label>Код<span class="required">*</span> <input type="text" required="Y" name="shortName" id="shortName" value="<?= $currCourseCategory->getShortName()?>"/> </label>
					<label>Име <input type="text" name="name" id="name" value="<?= $currCourseCategory->getName()?>"/> </label>
					<label>Описание <input type="text" name="description" id="description" value="<?= $currCourseCategory->getDescription()?>"/> </label>
					<label>Активност<span class="required">*</span> <select name="isActive" id="isActive" required="Y">
						<option></option>
						<option value='Y' <?= $currCourseCategory->getIsActive() != null && strcmp ($currCourseCategory->getIsActive() , "Y" ) == 0 ? "selected" :"" ?>>Да</option>
						<option value='N' <?= $currCourseCategory->getIsActive() != null && strcmp ( $currCourseCategory->getIsActive() , "N" ) == 0 ? "selected" : "" ?>>Не</option>
					</select> </label>
				</div>
				<div class="buttons">
					<button type="button" name="Update" value="Промени" onclick="updateRow();">Промени</button>
					<button type="button" name="Clean" value="Изчисти" onclick="clearFields();">Изчисти</button> 
				</div>
            </div>
		</form>
	</body>
</html>
