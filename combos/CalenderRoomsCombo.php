<?php
include '..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'Noms' . DIRECTORY_SEPARATOR . 'NomRoomTypes.php';
include '..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'Events' . DIRECTORY_SEPARATOR . 'Rooms.php';
include '..' . DIRECTORY_SEPARATOR . 'header.php';

$typeId = isset($_GET) && isset($_GET['typeId']) && !empty($_GET['typeId']) ? $_GET['typeId'] : null;
$sql = "SELECT r.id, r.num, r.place, r.type_id, r.work_stations, r.description, r.is_active "
        . "FROM Rooms r "
        . "WHERE r.is_active = 'Y' and r.type_id = coalesce(?, r.type_id) order by r.num";
$stmt = $conn->prepare($sql);

$rooms = array();
if ($stmt->execute(array($typeId))) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $room = new Rooms();
        $room->setId($row['id']);
        $room->setNum($row['num']);
        $room->setPlace($row['place']);

        $nomRoomType = new NomRoomTypes();
        $nomRoomType->setId($row['room_type_id']);
        $nomRoomType->setName($row['room_type_name']);
        $room->setTypeId($nomRoomType);

        $room->setWorkStations($row['work_stations']);
        $room->setDescription($row['description']);
        $room->setIsActive($row['is_active']);
        array_push($rooms, $room);
    }
}
?>
<select name="room" id="room" required="Y">
    <option></option>
    <?php foreach ($rooms as $val): ?>
        <option value="<?= $val->getId() ?>"><?= $val->getNum() ?></option>
    <?php endforeach; ?>
</select>