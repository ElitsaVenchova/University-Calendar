<?php
include '..'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'Noms'.DIRECTORY_SEPARATOR.'NomDegrees.php';
include '..'.DIRECTORY_SEPARATOR.'header.php';

function save($conn, $post){
	if($post['id'] != null && !empty($post['id'])) {
		$stmt = $conn->prepare("UPDATE NOM_STUDY_PROGRAMS SET degree_id = ?, short_name = ?, name = ?, description = ?, is_active = ? WHERE ID = ?");
		$stmt->execute(array($post['degreeId'], $post['shortName'], $post['name'], $post['description'], $post['isActive'], $post['id']));
	} else {
		$stmt = $conn->prepare("INSERT INTO NOM_STUDY_PROGRAMS (degree_id, short_name, name, description, is_active) VALUES (?,?,?,?,?)");
		$stmt->execute(array($post['degreeId'], $post['shortName'], $post['name'], $post['description'], $post['isActive']));
	}
	return "Записа беше редактиран успешно!";
}

if(isset($_POST) && isset($_POST['update']) && !empty($_POST['update'])){
	$msg = save($conn, $_POST);
	$studyProgramId = $_POST['id'];
} else if(isset($_GET) && isset($_GET['studyProgramId']) && !empty($_GET['studyProgramId'])){
	$studyProgramId = $_GET['studyProgramId'];
}

$currStudyProgram = new NomStudyPrograms();
if(isset($studyProgramId)) {
	$sql = "SELECT nsp.id, nsp.degree_id, nsp.short_name, nsp.name, nsp.description, nsp.is_active, nd.name degree_name ".
	"FROM NOM_STUDY_PROGRAMS nsp JOIN NOM_DEGREES nd ON  nd.id = nsp.degree_id where nsp.id = ?";
	$stmt = $conn->prepare($sql);
	if ($stmt->execute(array($studyProgramId))) { 
		while ($row = $stmt->fetch()) {
			$currStudyProgram = new NomStudyPrograms();
			$currStudyProgram->setId($row['id']);
			
			$nomDegree = new NomDegrees();
			$nomDegree->setId($row['degree_id']);
			$nomDegree->setName($row['degree_name']);
			$currStudyProgram->setDegreeId($nomDegree);
	
			$currStudyProgram->setShortName($row['short_name']);
			$currStudyProgram->setName($row['name']);
			$currStudyProgram->setDescription($row['description']);
			$currStudyProgram->setIsActive($row['is_active']);
		}
	}
}

$sql = "SELECT nd.id, nd.short_name, nd.name, nd.description, nd.is_active FROM NOM_DEGREES nd WHERE nd.is_active = 'Y' order by nd.name";
$result = $conn->query($sql);
$nomDegreesList = array();
while ($row = $result->fetch(PDO::FETCH_ASSOC))
{
	$nomDegree = new NomDegrees();
	$nomDegree->setId($row['id']);
	$nomDegree->setShortName($row['short_name']);
	$nomDegree->setName($row['name']);
	$nomDegree->setDescription($row['description']);
	$nomDegree->setIsActive($row['is_active']);
	array_push ( $nomDegreesList , $nomDegree);
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
                    var v = document.forms['nom_degrees_edit_form'];
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
					$('#degreeId').val("");
					$('#shortName').val("");
					$('#name').val("");
					$('#description').val("");
					$('#isActive').val("");
				}
			</script>
			<div class="edit" id="userInfo">
				<div class="edit_form">
					<label>№ <input readonly type="text" name="id" id="id" readonly required="Y" value="<?= $currStudyProgram->getId()?>"/> </label>
					<label>Степен на образование <select name="degreeId" id="degreeId" required="Y">
						<option></option>
						<?php foreach($nomDegreesList as $val): ?>
						<option value="<?= $val->getId() ?>" 
						<?= $currStudyProgram->getDegreeId() != null && $currStudyProgram->getDegreeId()->getId() == $val->getId() ? "selected" : "" ?>>
						<?= $val->getName() ?>
						</option>
					<?php endforeach; ?>
					</select> </label>
					<label>Код <input type="text" id="shortName" required="Y" name="shortName" value="<?= $currStudyProgram->getShortName()?>"/> </label>
					<label>Име <input type="text" id="name" name="name" required="Y" value="<?= $currStudyProgram->getName()?>"/> </label>
					<label>Описание <input type="text" id="description" name="description" value="<?= $currStudyProgram->getDescription()?>"/> </label>
					<label>Активност <select name="isActive" id="isActive" required="Y">
						<option></option>
						<option value='Y' <?= $currStudyProgram->getIsActive() != null && strcmp ($currStudyProgram->getIsActive() , "Y" ) == 0 ? "selected" :"" ?>>Да</option>
						<option value='N' <?= $currStudyProgram->getIsActive() != null && strcmp ( $currStudyProgram->getIsActive() , "N" ) == 0 ? "selected" : "" ?>>Не</option>
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