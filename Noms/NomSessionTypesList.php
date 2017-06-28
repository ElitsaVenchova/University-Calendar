<?php
include '..'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'Noms'.DIRECTORY_SEPARATOR.'NomSessionTypes.php';
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
		return " order by nst.id ";
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

$sql = "SELECT nst.id, nd.short_name, nst.name, nst.description, nst.is_active FROM NOM_SESSION_TYPES nst ".order($selectedCol).$direction;
$result = $conn->query($sql);
$nomSessionTypesList = array();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	$nomSessionType = new NomSemesterTypes();
	$nomSessionType->setId($row['id']);
	$nomSessionType->setShortName($row['short_name']);
	$nomSessionType->setName($row['name']);
	$nomSessionType->setDescription($row['description']);
	$nomSessionType->setIsActive($row['is_active']);
	array_push ($nomSessionTypesList , $nomSessionType);
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
		<title>Списък - Типове сесии</title>
	</head>
	<body>
		<form name="nom_session_types_form" id='nom_session_types_form'>
			<input type="hidden" name="sortColName" id="sortColName"/>
			<script>
				function setOrder(name){
					$('#sortColName').val(name);
					document.getElementById("nom_session_types_form").submit();
				}
			</script>
			<table class="dataset">
				<thead>
					<tr>
						<th><a href="NomSessionTypesEdit.php"><img src="../style/plus.png" title="Нов запис"  style="border: 0" height="16" width="16"></a></th>
						<th><a href="#" onclick="setOrder('id')">№</a> <?= isSortColumn('id', $selectedCol, $direction)?></th>
                        <th><a href="#" onclick="setOrder('short_name')">Код</a> <?= isSortColumn('short_name', $selectedCol, $direction)?></th>
                        <th><a href="#" onclick="setOrder('name')">Име<?= isSortColumn('name', $selectedCol, $direction)?></a></th>
                        <th><a href="#" onclick="setOrder('description')">Описание<?= isSortColumn('description', $selectedCol, $direction)?></a></th>
                        <th><a href="#" onclick="setOrder('is_active')">Активност<?= isSortColumn('is_active', $selectedCol, $direction)?></a></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($nomSessionTypesList as $val): ?>
						<tr>
							<td><a href="NomSessionTypesEdit.php?sessionTypeId=<?= $val->getId() ?>"><img src="../style/edit.png" title="Редактиране"  style="border: 0"></a>
							</td>
							<td><?= $val->getId() ?> </td>
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