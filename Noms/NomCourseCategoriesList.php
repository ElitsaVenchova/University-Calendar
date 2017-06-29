<?php
include '..'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'Noms'.DIRECTORY_SEPARATOR.'NomCourseCategories.php';
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
		return " order by ncc.id ";
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

$sql = "SELECT ncc.id, ncc.short_name, ncc.name, ncc.description, ncc.is_active FROM NOM_COURSE_CATEGORIES ncc ".order($selectedCol).$direction;
$result = $conn->query($sql);
$nomCourseCategoriesList = array();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	$nomCourseCategory = new NomCourseCategories();
	$nomCourseCategory->setId($row['id']);
	$nomCourseCategory->setShortName($row['short_name']);
	$nomCourseCategory->setName($row['name']);
	$nomCourseCategory->setDescription($row['description']);
	$nomCourseCategory->setIsActive($row['is_active']);
	array_push ($nomCourseCategoriesList , $nomCourseCategory);
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
		<title>Списък - Категории на курсове</title>
	</head>
	<body>
		<form name="nom_course_categories_list_form" id='nom_course_categories_list_form'>
			<input type="hidden" name="sortColName" id="sortColName"/>
			<script>
				function setOrder(name){
					$('#sortColName').val(name);
					document.getElementById("nom_course_categories_list_form").submit();
				}
			</script>
			<table class="dataset">
				<thead>
					<tr>
						<th><a href="NomCourseCategoriesEdit.php"><img src="../style/plus.png" title="Нов запис"  style="border: 0" height="16" width="16"></a></th>
						<th><a href="#" onclick="setOrder('id')">№</a> <?= isSortColumn('id', $selectedCol, $direction)?></th>
                        <th><a href="#" onclick="setOrder('short_name')">Код</a> <?= isSortColumn('short_name', $selectedCol, $direction)?></th>
                        <th><a href="#" onclick="setOrder('name')">Име<?= isSortColumn('name', $selectedCol, $direction)?></a></th>
                        <th><a href="#" onclick="setOrder('description')">Описание<?= isSortColumn('description', $selectedCol, $direction)?></a></th>
                        <th><a href="#" onclick="setOrder('is_active')">Активност<?= isSortColumn('is_active', $selectedCol, $direction)?></a></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($nomCourseCategoriesList as $val): ?>
						<tr>
							<td><a href="NomCourseCategoriesEdit.php?courseCategoryId=<?= $val->getId() ?>"><img src="../style/edit.png" title="Редактиране"  style="border: 0"></a>
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