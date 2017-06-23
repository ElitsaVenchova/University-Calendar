<?php
include '..'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'Noms'.DIRECTORY_SEPARATOR.'NomStudyPrograms.php';
include '..'.DIRECTORY_SEPARATOR.'models\Noms'.DIRECTORY_SEPARATOR.'NomDegrees.php';
include '..'.DIRECTORY_SEPARATOR.'header.php';

/**
 * Проверка по името на колоната дали, тя е сортирана и ако да, то се връща съответния символ за посоката.
 */
function isSortColumn($currCol, $selectedCol, $direction) {
	if ($selectedCol != null && strcmp($selectedCol,$currCol) == 0) {
		if ($direction != null &&  strcmp($direction,"desc") == 0) {
			return "&#9650;";
		} else if ($direction != null && strcmp($direction,"asc") == 0) {
			return "&#9660;";
		}
	}
	return "";
}

/**
 * Връща order by клаузата, което ще се използва в заявката
 */
function order($selectedCol){
	if(isset($selectedCol) && !empty($selectedCol)){
		return " order by ".$selectedCol." ";
	} else {
		return " order by nsp.id ";
	}
}

$selectedCol=isset($_SESSION['selectedCol']) ? $_SESSION['selectedCol'] : "";//кода на колоната
$direction=isset($_SESSION['direction']) ? $_SESSION['direction'] : "";//посока на сортирането

//Определяне на колона и посоката на сортирането
if(isset($_GET) && isset($_GET['sortColName']) && !empty($_GET['sortColName'])){
	if ($selectedCol != null && strcmp($selectedCol,$_GET['sortColName']) == 0) {
		//Сменяме само посоката на сортиране
		if (strcmp($direction,"asc") == 0) {
			$direction = "desc";
		} else if(strcmp($direction,"desc") == 0){
			$selectedCol="";
			$direction = "";
		} else {
			$direction = "asc";
		}
	} else {
		$selectedCol=$_GET['sortColName'];
		$direction = "asc";
	}
}

$_SESSION['selectedCol']=$selectedCol;
$_SESSION['direction']=$direction;

$sql = "SELECT nsp.id, nsp.degree_id, nsp.short_name, nsp.name, nsp.description, nsp.is_active, nd.name degree_name FROM NOM_STUDY_PROGRAMS nsp JOIN NOM_DEGREES nd ON  nd.id = nsp.degree_id ".order($selectedCol).$direction;
$result = $conn->query($sql);
$nomStudyProgramsList = array();
while ($row = $result->fetch(PDO::FETCH_ASSOC))
{
	$nomStudyProgram = new NomStudyPrograms();
	$nomStudyProgram->setId($row['id']);
	
	$nomDegree = new NomDegrees();
	$nomDegree->setId($row['degree_id']);
	$nomDegree->setName($row['degree_name']);
	$nomStudyProgram->setDegreeId($nomDegree);
	
	$nomStudyProgram->setShortName($row['short_name']);
	$nomStudyProgram->setName($row['name']);
	$nomStudyProgram->setDescription($row['description']);
	$nomStudyProgram->setIsActive($row['is_active']);
	array_push ( $nomStudyProgramsList , $nomStudyProgram);
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
		<title>Списък - Степени на образование</title>
	</head>
	<body>
		<form name="nom_study_program_list_form" id='nom_study_program_list_form'>
			<input type="hidden" name="sortColName" id="sortColName"/>
			<script>
				function setOrder(name){
					$('#sortColName').val(name);
					document.getElementById("nom_study_program_list_form").submit();
				}
			</script>
			<table class="dataset">
				<thead>
					<tr>
						<th><a href="nomStudyProgramsEdit.php"><img src="../style/plus.png" title="Нов запис"  style="border: 0" height="16" width="16"></a></th>
						<th><a href="#" onclick="setOrder('id')">№ <?= isSortColumn('id', $selectedCol, $direction)?></a></th>
						<th><a href="#" onclick="setOrder('degree_id')">Степен на образование <?= isSortColumn('degree_id', $selectedCol, $direction)?></a></th>
                        <th><a href="#" onclick="setOrder('short_name')">Код <?= isSortColumn('short_name', $selectedCol, $direction)?></a></th>
                        <th><a href="#" onclick="setOrder('name')">Име <?= isSortColumn('name', $selectedCol, $direction)?></a></th>
                        <th><a href="#" onclick="setOrder('description')">Описание <?= isSortColumn('description', $selectedCol, $direction)?></a></th>
                        <th><a href="#" onclick="setOrder('is_active')">Активност <?= isSortColumn('is_active', $selectedCol, $direction)?></a></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($nomStudyProgramsList as $val): ?>
						<tr>
							<td><a href="nomStudyProgramsEdit.php?studyProgramId=<?= $val->getId() ?>"><img src="../style/edit.png" title="Редактиране"  style="border: 0"></a>
							</td>
							<td><?= $val->getId() ?> </td>
							<td><?= $val->getDegreeId()->getName() ?> </td>
							<td><?= $val->getShortName() ?> </td>
							<td><?= $val->getName() ?> </td>
							<td><?= $val->getDescription() ?> </td>
							<td><?= $val->getIsActiveTxt()?> </td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</form>
	</body>
</html>