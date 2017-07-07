<?php
include '..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'Events' . DIRECTORY_SEPARATOR . 'Rooms.php';
include '..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'Noms' . DIRECTORY_SEPARATOR . 'NomRoomTypes.php';
include '..' . DIRECTORY_SEPARATOR . 'header.php';

/**
 * Проверка по името на колоната дали, тя е сортирана и ако да, то се връща съответния символ за посоката.
 */
function isSortColumn($currCol, $selectedCol, $direction) {
    if ($selectedCol != null && strcmp($selectedCol, $currCol) == 0) {
        if ($direction != null && strcmp($direction, "desc") == 0) {
            return "&#9650;";
        } else if ($direction != null && strcmp($direction, "asc") == 0) {
            return "&#9660;";
        }
    }
    return "";
}

/**
 * Връща order by клаузата, което ще се използва в заявката
 */
function order($selectedCol) {
    if (isset($selectedCol) && !empty($selectedCol)) {
        return " order by " . $selectedCol . " ";
    } else {
        return " order by r.id ";
    }
}

$selectedCol = isset($_SESSION['selectedCol']) ? $_SESSION['selectedCol'] : ""; //кода на колоната
$direction = isset($_SESSION['direction']) ? $_SESSION['direction'] : ""; //посока на сортирането
//Определяне на колона и посоката на сортирането
if (isset($_GET) && isset($_GET['sortColName']) && !empty($_GET['sortColName'])) {
    if ($selectedCol != null && strcmp($selectedCol, $_GET['sortColName']) == 0) {
        //Сменяме само посоката на сортиране
        if (strcmp($direction, "asc") == 0) {
            $direction = "desc";
        } else if (strcmp($direction, "desc") == 0) {
            $selectedCol = "";
            $direction = "";
        } else {
            $direction = "asc";
        }
    } else {
        $selectedCol = $_GET['sortColName'];
        $direction = "asc";
    }
}

$_SESSION['selectedCol'] = $selectedCol;
$_SESSION['direction'] = $direction;

$sql = "SELECT r.id, r.num, r.type_id, r.place, r.work_stations, r.description, r.is_active, nrt.name type_name FROM Rooms r JOIN nom_Room_types nrt ON  nrt.id = r.type_id " . order($selectedCol) . $direction;
$result = $conn->query($sql);
$rooms = array();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $room = new Rooms();
    $room->setId($row['id']);
    $room->setNum($row['num']);
    $room->setPlace($row['place']);

    $nomRoomType = new NomRoomTypes();
    $nomRoomType->setId($row['type_id']);
    $nomRoomType->setName($row['type_name']);
    $room->setTypeId($nomRoomType);

    $room->setWorkStations($row['work_stations']);
    $room->setDescription($row['description']);
    $room->setIsActive($row['is_active']);
    array_push($rooms, $room);
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
        <title>Списък - Стаи</title>
    </head>
    <body>
        <form name="nom_study_program_list_form" id='nom_study_program_list_form'>
            <input type="hidden" name="sortColName" id="sortColName"/>
            <script>
                function setOrder(name) {
                    $('#sortColName').val(name);
                    document.getElementById("nom_study_program_list_form").submit();
                }
            </script>
            <table class="dataset">
                <thead>
                    <tr>
                        <th><a href="RoomsEdit.php"><img src="../style/plus.png" title="Нов запис"  style="border: 0" height="16" width="16"></a></th>
                        <th><a href="#" onclick="setOrder('id')">№ <?= isSortColumn('id', $selectedCol, $direction) ?></a></th>
                        <th><a href="#" onclick="setOrder('type_name')">Вид <?= isSortColumn('type_name', $selectedCol, $direction) ?></a></th>
                        <th><a href="#" onclick="setOrder('num')">Номер <?= isSortColumn('num', $selectedCol, $direction) ?></a></th>
                        <th><a href="#" onclick="setOrder('place')">Място <?= isSortColumn('place', $selectedCol, $direction) ?></a></th>
                        <th><a href="#" onclick="setOrder('work_stations')">Работни станции <?= isSortColumn('work_stations', $selectedCol, $direction) ?></a></th>
                        <th><a href="#" onclick="setOrder('description')">Описание <?= isSortColumn('description', $selectedCol, $direction) ?></a></th>
                        <th><a href="#" onclick="setOrder('is_active')">Активност <?= isSortColumn('is_active', $selectedCol, $direction) ?></a></th>
                    </tr>
                </thead>
                <tbody>
<?php foreach ($rooms as $val): ?>
                        <tr>
                            <td><a href="RoomsEdit.php?roomId=<?= $val->getId() ?>"><img src="../style/edit.png" title="Редактиране"  style="border: 0"></a>
                            </td>
                            <td><?= $val->getId() ?> </td>
                            <td><?= $val->getTypeId()->getName() ?> </td>
                            <td><?= $val->getNum() ?> </td>
                            <td><?= $val->getPlace() ?> </td>
                            <td><?= $val->getWorkStations() ?> </td>
                            <td><?= $val->getDescription() ?> </td>
                            <td><?= $val->getIsActiveTxt() ?> </td>
                        </tr>
<?php endforeach; ?>
                </tbody>
            </table>
        </form>
    </body>
</html>