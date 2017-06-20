<?php
require_once('..\models\Noms\NomDegrees.php');

try {
 $conn = new PDO("mysql:host=$host;dbname=$db",$user,$pass);
catch (PDOException $e) {
 echo 'Connection failed: ' . $e->getMessage();
}
$sql = "SELECT nd.id, nd.short_name, nd.name, nd.description, nd.is_active FROM NOM_DEGREES nd";
$result = $conn->query($sql);
$nomDegreesList = array();
while ($row = $result->fetch(PDO::FETCH_ASSOC))
{
	array_push ( $nomDegreesList , new NomDegreesList($row['ID'], $row['SHORT_NAME'], $row['NAME'], $row['DESCRIPTION'], $row['IS_ACTIVE']) );
}
$currDegrees = new NomDegreesList();
if()
?>
<html>
	<head>
		<title>������� �� �����������</title>
	</head>
	<body>
		<form name="nom_degrees_form">
			<input type="text" name="id" readonly value="<?= $currDegrees->getId()?>"/>
			<input type="text" name="shortName" value="<?= $currDegrees->getShortName()?>"/>
			<input type="text" name="name" value="<?= $currDegrees->getName()?>"/>
			<input type="text" name="description" value="<?= $currDegrees->getDescription()?>"/>
			<select name="isActive" required="Y">
				<option></option>
				<option value='Y' <?= $currDegrees->getIsActive() != null && strcmp ( $currDegrees->getIsActive() , "Y" ) ? "selected"?>>��</option>
				<option value='N' <?= $currDegrees->getIsActive() != null && strcmp ( $currDegrees->getIsActive() , "N" ) ? "selected"?>>��</option>
			</select>
			<div class="buttons">
            	<button type="button" name="Search" value="�����" onclick="searchItem();">�����</button> 
            	<button type="button" name="Clean" value="�������" onclick="cleanItem();">�������</button> 
            	<button type="button" class="right" name="Add" value="������" onclick="doAction(this.form, '<c:url value='/registers/addActivity'/>');">������</button> 
            	<button type="button" class="right" name="Remove" value="������" onclick="removeItem();">������</button>
				<button type="button" class="right" name="Update" value="�������" onclick="doAction(this.form, '<c:url value='/registers/updateActivity'/>');">�������</button>
            </div>
			<table class="dataset">
				<thead>
					<tr>
						<th><a href="#" onclick="setOrder('id')">�</a></th>
                        <th><a href="#" onclick="setOrder('code')">���</a></th>
                        <th><a href="#" onclick="setOrder('code')">���</a></th>
                        <th><a href="#" onclick="setOrder('descr')">��������</a></th>
                        <th><a href="#" onclick="setOrder('is_active')">���������</a></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($nomDegreesList as $val): ?>
						<td><?= $val->getId()) ?> </td>
						<td><?= $val->getShortName()) ?> </td>
						<td><?= $val->getName()) ?> </td>
						<td><?= $val->getDescription()) ?> </td>
						<td><?= $val->getIsActive() != null && strcmp ( $val->getIsActive() , "Y" ) ? "��"  : "��"?> </td>
					<?php endforeach; ?>
				</tbody>
			</table>
		</form>
	</body>
</html>