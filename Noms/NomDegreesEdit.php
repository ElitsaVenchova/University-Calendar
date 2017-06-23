<?php
require_once('..'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'Noms'.DIRECTORY_SEPARATOR.'NomDegrees.php');
include '..'.DIRECTORY_SEPARATOR.'header.php';

function save($conn, $post){
	if($post['id'] != null && !empty($post['id'])) {
		$stmt = $conn->prepare("UPDATE NOM_DEGREES SET short_name = ?, name = ?, description = ?, is_active = ? WHERE ID = ?");
		$stmt->execute(array($post['shortName'], $post['name'], $post['description'], $post['isActive'], $post['id']));
	} else {
		$stmt = $conn->prepare("INSERT INTO NOM_DEGREES (short_name, name, description, is_active) VALUES (?,?,?,?)");
		$stmt->execute(array($post['shortName'], $post['name'], $post['description'], $post['isActive']));
	}
	return "Записа беше редактиран успешно!";
}

if(isset($_POST) && isset($_POST['update']) && !empty($_POST['update'])){
	$msg = save($conn, $_POST);
	$degreeId = $_POST['id'];
} else if(isset($_GET) && isset($_GET['degreeId']) && !empty($_GET['degreeId'])){
	$degreeId = $_GET['degreeId'];
}

$currDegrees = new NomDegrees();
if(isset($degreeId)) {
	$sql = "SELECT id, short_name, nd.name, nd.description, nd.is_active FROM NOM_DEGREES nd where nd.id = ?";
	$stmt = $conn->prepare($sql);
	if ($stmt->execute(array($degreeId))) { 
		while ($row = $stmt->fetch()) {
			$currDegrees = new NomDegrees();
			$currDegrees->setId($row['id']);
			$currDegrees->setShortName($row['short_name']);
			$currDegrees->setName($row['name']);
			$currDegrees->setDescription($row['description']);
			$currDegrees->setIsActive($row['is_active']);
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
		<title>Редакция - Степен на образование</title>
	</head>
	<body onKeyPress="return checkSubmit(event)">
		<?php if(isset($msg)): ?>
			<div class="succ">
				<?= $msg?>
			</div>
			<?php $msg = null;?>
		<?php endif; ?> 
		<form name="nom_degrees_edit_form" method="post">
			<input type="hidden" name="update"/>
			<script>
                function checkSubmit(e)
                {
                    var v = document.forms['nom_bgn_bank_types'];
                    if (e && e.keyCode === 13)
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
					<label>№ <input readonly type="text" name="id" required="Y" id="id" readonly value="<?= $currDegrees->getId()?>"/> </label>
					<label>Код <input type="text" required="Y" name="shortName" id="shortName" value="<?= $currDegrees->getShortName()?>"/> </label>
					<label>Име <input type="text" name="name" id="name" value="<?= $currDegrees->getName()?>"/> </label>
					<label>Описание <input type="text" name="description" id="description" value="<?= $currDegrees->getDescription()?>"/> </label>
					<label>Активност <select name="isActive" id="isActive" required="Y">
						<option></option>
						<option value='Y' <?= $currDegrees->getIsActive() != null && strcmp ($currDegrees->getIsActive() , "Y" ) == 0 ? "selected" :"" ?>>Да</option>
						<option value='N' <?= $currDegrees->getIsActive() != null && strcmp ( $currDegrees->getIsActive() , "N" ) == 0 ? "selected" : "" ?>>Не</option>
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