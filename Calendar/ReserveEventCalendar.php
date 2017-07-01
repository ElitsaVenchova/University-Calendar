<?php
include '..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'Noms' . DIRECTORY_SEPARATOR . 'NomRoomTypes.php';
include '..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'Events' . DIRECTORY_SEPARATOR . 'Rooms.php';
include '..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'Events' . DIRECTORY_SEPARATOR . 'Event.php';
include '..' . DIRECTORY_SEPARATOR . 'header.php';
$sqlRoomsData = "SELECT ri.room_type_name, ri.room_id, ri.room_name, ri.room_work_stations, ri.room_place, ri.room_notes, ti.date, ti.from_hour, ti.to_hour " .
        "FROM (SELECT nrt.name as room_type_name, r.id as room_id, r.num as room_name, r.work_stations as room_work_stations, r.place as room_place, r.description as room_notes " .
        "FROM Rooms r " .
        "join nom_Room_types nrt " .
        "        on nrt.id = r.type_id " .
        "where r.id = coalesce(:room,r.id) and r.type_id = coalesce(:typeId, r.type_id)  " .
        "        and r.work_stations >= case when :fromWorkStations is not null then :fromWorkStations else r.work_stations end " .
        "        and r.work_stations <= case when :toWorkStations is not null then :toWorkStations else r.work_stations end " .
        "        and (:place is null or upper(r.place) like :place)) as ri " .
        "CROSS JOIN (select a.Date as date, STR_TO_DATE(coalesce(:fromHour, '7:00'), '%H:%i') as from_hour, STR_TO_DATE(coalesce(:toHour, '22:00'), '%H:%i') as to_hour " .
        "    select STR_TO_DATE(:toDate,'%d.%m.%Y') - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as Date " .
        "    from (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 	union all select 7 union all select 8 union all select 9) as a " .
        "    cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as b " .
        "    cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as c " .
        ") a " .
        "where a.Date between STR_TO_DATE(:fromDate,'%d.%m.%Y') and STR_TO_DATE(:toDate,'%d.%m.%Y') " .
        "        and WEEKDAY(a.Date) = case when :eventType = 'P' then :weekDay else WEEKDAY(a.Date) end) as ti " .
        "order by ti.date, ri.room_name, ri.from_hour";
$sqlEventsData = "SELECT r.id as room_id, me.is_accept as is_accept, ce.from_hour, ce.to_hour, ce.class_date as date " .
        "FROM Rooms r " .
        "join nom_Room_types nrt " .
        "        on nrt.id = r.type_id " .
        "left join Child_Events ce " .
        "        on ce.room_id = r.id " .
        "join Master_Events me " .
        "        on ce.master_id = me.id " .
        "where r.id = coalesce(:room,r.id) and r.type_id = coalesce(:typeId, r.type_id)  " .
        "        and r.work_stations >= case when :fromWorkStations is not null then :fromWorkStations else r.work_stations end " .
        "        and r.work_stations <= case when :toWorkStations is not null then :toWorkStations else r.work_stations end " .
        "        and (:place is null or upper(r.place) like :place)  " .
        "        and ce.class_date between STR_TO_DATE(:fromDate,'%d.%m.%Y') and STR_TO_DATE(:toDate,'%d.%m.%Y') " .
        "        and ((ce.to_hour between STR_TO_DATE(coalesce(:fromHour, '7:00'), '%H:%i') and STR_TO_DATE(coalesce(:toHour, '7:00'), '%H:%i')  " .
        "                or ce.from_hour between STR_TO_DATE(coalesce(:fromHour, '7:00'), '%H:%i') and STR_TO_DATE(coalesce(:toHour, '7:00'), '%H:%i')  " .
        "                or STR_TO_DATE(coalesce(:fromHour, '7:00'), '%H:%i') between ce.from_hour and ce.to_hour) " .
        "        and WEEKDAY(ce.class_date) = case when :eventType = 'P' then :weekDay else WEEKDAY(ce.class_date) end) " .
        "order by r.id, ce.class_date, ce.from_hour";

function searchRooms($conn, $roomType, $room, $eventType, $fromDate, $toDate, $fromHour, $toHour, $fromWorkStations, $toWorkStations, $place, $weekDay, $sqlRoomsData, $sqlEventsData) {

    $stmt = $conn->prepare($sqlRoomsData);
    $stmt->bindValue(':typeId', empty($roomType) ? null : $roomType);
    $stmt->bindValue(':room', empty($room) ? null : $room);
    $stmt->bindValue(':eventType', $eventType);
    $stmt->bindValue(':fromDate', $fromDate);
    $stmt->bindValue(':toDate', $toDate);
    $stmt->bindValue(':fromHour', empty($fromHour) ? null : $fromHour);
    $stmt->bindValue(':toHour', empty($toHour) ? null : $toHour);
    $stmt->bindValue(':fromWorkStations', empty($fromWorkStations) ? null : $fromWorkStations);
    $stmt->bindValue(':toWorkStations', empty($toWorkStations) ? null : $toWorkStations);
    $stmt->bindValue(':place', empty($place) ? null : '%'.$place.'%');
    $stmt->bindValue(':weekDay', $weekDay);

    echo $stmt->execute();

    $rooms = array();
    while ($row = $stmt->fetch()) {
        $event = new Event($row["room_type_name"], $row["room_id"], $row["room_name"], $row["room_work_stations"], $row["room_place"], $row["room_notes"], $row["date"], $row["from_hour"], $row["to_hour"], null);
        if (!empty($rooms[$row["room_id"]])) {
            $rooms[$row["room_id"]] = array(event);
        } else {
            array_push($rooms[$row["room_id"]], $event);
        }
    }
    
    $stmt = $conn->prepare($sqlEventsData);
    $stmt->bindValue(':typeId', empty($roomType) ? null : $roomType);
    $stmt->bindValue(':room', empty($room) ? null : $room);
    $stmt->bindValue(':eventType', $eventType);
    $stmt->bindValue(':fromDate', $fromDate);
    $stmt->bindValue(':toDate', $toDate);
    $stmt->bindValue(':fromHour', empty($fromHour) ? null : $fromHour);
    $stmt->bindValue(':toHour', empty($toHour) ? null : $toHour);
    $stmt->bindValue(':fromWorkStations', empty($fromWorkStations) ? null : $fromWorkStations);
    $stmt->bindValue(':toWorkStations', empty($toWorkStations) ? null : $toWorkStations);
    $stmt->bindValue(':place', empty($place) ? null : '%'.$place.'%');
    $stmt->bindValue(':weekDay', $weekDay);

    $events = array();
    while ($row = $stmt->fetch()) {
        $event = new Event(null, $row["room_id"], null, null, null, null, $row["date"], $row["from_hour"], $row["to_hour"], $row["is_accept"]);
        if (!empty($events[$row["room_id"]])) {
            $events[$row["room_id"]] = array(event);
        } else {
            array_push($events[$row["room_id"]], $event);
        }
    }

    $result = array();
    foreach ($rooms as $key => $value) {
        $result += calculateRoomGrafic($value, $events[$key]);
        echo $key . ' - ';
        print_r($result);
    }
    return $result;
}

function calculateRoomGrafic($roomData, $events) {
    $result = array();
    for ($i = 0; $i <= count($roomData); $i++) {
        $dateRoomData = $roomData[$i];
        $roomHours = array(array($dateRoomData->getFromHour(), $dateRoomData->getToHour()));
        for ($j = 0; $j <= count($events); $j++) {
            $event = $events[$j];
            if ($dateRoomData->getDate() === $event->getDate()) {
                $tempRoomHours = array();
                for ($k = 0; $k <= count($roomHours); $k++) {
                    $hourPair = $roomHours[$k];
                    if ($hourPair[0] < $event->getFromHour() && $hourPair[1] < $event->getToHour()) {
                        array_push($tempRoomHours, array($hourPair[1], $event->getToHour()));
                    } else if ($event->getFromHour() < $hourPair[0] && $hourPair[1] < $event->getToHour()) {
                        array_push($tempRoomHours, array($event->getFromHour(), $hourPair[0]));
                        array_push($tempRoomHours, array($hourPair[1], $event->getToHour()));
                    } else if ($event->getFromHour() < $hourPair[0] && $event->getToHour() < $hourPair[1]) {
                        array_push($tempRoomHours, array($event->getFromHour(), $hourPair[0]));
                    }
                }
                $roomHours = $tempRoomHours;
            }
        }
        for ($k = 0; $k <= count($roomHours); $k++) {
            $dateRoomData->setFromHour($roomHours[0]);
            $dateRoomData->setToHour($roomHours[1]);
            array_push($result, $dateRoomData);
        }
    }
    return $result;
}

$roomType = isset($_GET['roomType']) ? $_GET['roomType'] : "";
$room = isset($_GET['room']) ? $_GET['room'] : "";
$eventType = isset($_GET['eventType']) ? $_GET['eventType'] : "";
$fromDate = isset($_GET['fromDate']) ? $_GET['fromDate'] : "";
$toDate = isset($_GET['toDate']) ? $_GET['toDate'] : "";
$fromHour = isset($_GET['fromHour']) ? $_GET['fromHour'] : "";
$toHour = isset($_GET['toHour']) ? $_GET['toHour'] : "";
$fromWorkStations = isset($_GET['fromWorkStations']) ? $_GET['fromWorkStations'] : "";
$toWorkStations = isset($_GET['toWorkStations']) ? $_GET['toWorkStations'] : "";
$place = isset($_GET['place']) ? $_GET['place'] : "";
$weekDay = isset($_GET['weekDay']) ? $_GET['weekDay'] : "";

$searchResult = array();
if (isset($_GET['searchRooms']) && !empty($_GET['searchRooms'])) {
    $searchResult = searchRooms($conn, $roomType, $room, $eventType, $fromDate, $toDate, $fromHour, $toHour, $fromWorkStations, $toWorkStations, $place, $weekDay, $sqlRoomsData, $sqlEventsData);
}
print_r($searchResult);

//Списък с видовете зали
$sql = "SELECT nrt.id, nrt.short_name, nrt.name, nrt.description, nrt.is_active FROM nom_Room_types nrt WHERE nrt.is_active = 'Y' order by nrt.name";
$result = $conn->query($sql);
$nomRoomTypes = array();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $nomRoomType = new NomRoomTypes();
    $nomRoomType->setId($row['id']);
    $nomRoomType->setShortName($row['short_name']);
    $nomRoomType->setName($row['name']);
    $nomRoomType->setDescription($row['description']);
    $nomRoomType->setIsActive($row['is_active']);
    array_push($nomRoomTypes, $nomRoomType);
}

//Списък със залите
$sql = "SELECT r.id, r.num, r.place, r.type_id, r.work_stations, r.description, r.is_active, nrt.id as room_type_id, nrt.name as room_type_name "
        . "FROM Rooms r join nom_Room_types nrt on nrt.id = r.type_id  "
        . "WHERE r.is_active = 'Y' and nrt.id = coalesce(?, r.type_id) order by r.num";
$stmt = $conn->prepare($sql);
$rooms = array();
if ($stmt->execute(array(empty($roomType) ? null : $roomType))) {
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
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../style/main.css" type="text/css"/>
        <link type="text/css" href="../scripts/jquery-ui-themes-1.12.1/themes/base/jquery-ui.css" rel="stylesheet"/>
        <script type="text/JavaScript" src="../scripts/jquery-3.2.1.js"></script>
        <script type="text/JavaScript" src="../scripts/UserJQueryMessageStyles.js"></script>
        <script type="text/JavaScript" src="../scripts/DatePicker.js"></script>
        <script type="text/javascript" src="../scripts/jquery-ui-1.12.1/jquery-ui.js"></script>
        <title>Календар</title>
    </head>
    <body>
        <form name="nom_degrees_edit_form">
            <input type="hidden" name="searchRooms"/>
            <input type="hidden" name="reserveRoomField"/>
            <script>
                function reloadRoomsCombo() {
                    var typeId = $('#roomType').val();
                    $('#roomsSpan').load(encodeURI("../combos/CalenderRoomsCombo.php?typeId=" + typeId));
                }

                function changeDateOption() {
                    var eventType = $('#eventType').val();
                    if (eventType === 'O') {
                        $('#weekDay').attr('disabled', 'disabled');
                    } else {
                        $('#weekDay').removeAttr("disabled");
                    }
                }

                function search() {
                    document.forms[0].elements['searchRooms'].value = true;
                    document.forms[0].submit();
                }

                function reseveRoom() {
                    var ok = vallidateForm(document.forms[0]);
                    if (ok)
                    {
                        document.forms[0].elements['reserveRoomField'].value = true;
                        document.forms[0].submit();
                    }
                }

                function clearFields() {
                    $('#roomType').val("");
                    reloadRoomsCombo();
                    $('#eventType').val("O");
                    changeDateOption();
                    $('#fromHour').val("");
                    $('#toHour').val("");
                    $('#fromWorkStations').val("");
                    $('#toWorkStations').val("");
                    $('#place').val("");
                }
            </script>
            <div class="edit" id="userInfo">
                <div class="edit_form">
                    <label>Вид на зала<span class="required">*</span>
                        <select name="roomType" id="roomType" onchange="reloadRoomsCombo()">
                            <option></option>
                            <?php foreach ($nomRoomTypes as $val): ?>
                                <option value="<?= $val->getId() ?>"
                                        <?= $roomType == $val->getId() ? "selected" : "" ?>>
                                    <?= $val->getName() ?></option>
                            <?php endforeach; ?>
                        </select> </label>
                    <label>Зала<span class="required">*</span> <span id="roomsSpan"><select name="room" id="room" required="Y">
                                <option></option>
                                <?php foreach ($rooms as $val): ?>
                                    <option value="<?= $val->getId() ?>"
                                            <?= $room == $val->getId() ? "selected" : "" ?>>
                                        <?= $val->getNum() ?>(<?= $val->getPlace() ?>)</option>
                                <?php endforeach; ?>
                            </select></span> </label>
                    <label>Периодичност<span class="required">*</span> <select name="eventType" id="eventType" required="Y" onchange="changeDateOption()">
                            <option value='O' <?= strcmp($eventType, "O") == 0 ? "selected" : "" ?>>Еднократно</option>
                            <option value='P' <?= strcmp($eventType, "P") == 0 ? "selected" : "" ?>>Периодичност</option>
                        </select> </label> 
                    <label class="inline-show" style="float: left">От дата<span class="required">*</span>
                        <input type="text" required="Y" name="fromDate" id="fromDate" value="<?= $fromDate ?>"/> </label>
                    <label class="inline-show">До дата<span class="required">*</span>
                        <input type="text" name="toDate" id="toDate" required="Y" value="<?= $toDate ?>"/> </label>
                    <label>Ден от седмицата<span class="required">*</span>
                        <select type="text" required="Y" name="weekDay" id="weekDay" <?= strcmp($eventType, "O") == 0 ? "disabled" : "" ?>>
                            <option></option>
                            <option value='2' <?= strcmp($weekDay, "2") == 0 ? "selected" : "" ?>>Понеделник</option> 
                            <option value='3' <?= strcmp($weekDay, "3") == 0 ? "selected" : "" ?>>Вторник</option> 
                            <option value='4' <?= strcmp($weekDay, "4") == 0 ? "selected" : "" ?>>Сряда</option> 
                            <option value='5' <?= strcmp($weekDay, "5") == 0 ? "selected" : "" ?>>Четвъртък</option>
                            <option value='6' <?= strcmp($weekDay, "6") == 0 ? "selected" : "" ?>>Петък</option> 
                            <option value='7' <?= strcmp($weekDay, "7") == 0 ? "selected" : "" ?>>Събота</option>
                            <option value='1' <?= strcmp($weekDay, "1") == 0 ? "selected" : "" ?>>Неделя</option>
                        </select>
                    </label>
                    <label class="inline-show" style="float: left">От час<span class="required">*</span> 
                        <select required="Y" name="fromHour" id="fromHour">
                            <option></option>
                            <?php for ($i = 7; $i <= 22; $i++) { ?>
                                <option value="<?= $i ?>:00"><?= $i ?>:00</option>
                                <option value="<?= $i ?>:30"><?= $i ?>:30</option>
                            <?php } ?>
                        </select></label>
                    <label class="inline-show">До час<span class="required">*</span>
                        <select name="toHour" id="toHour" required="Y">
                            <option></option>
                            <?php for ($i = 7; $i <= 22; $i++) { ?>
                                <option value="<?= $i ?>:00"><?= $i ?>:00</option>
                                <option value="<?= $i ?>:30"><?= $i ?>:30</option>
                            <?php } ?>
                        </select> </label>
                    <label class="inline-show" style="float: left">От брой места<span class="required">*</span> <input type="text" required="Y" name="fromWorkStations" id="fromWorkStations"  value="<?= $fromWorkStations ?>"/> </label>
                    <label class="inline-show">До брой места<span class="required">*</span> <input type="text" name="toWorkStations" required="Y" id="toWorkStations" value="<?= $toWorkStations ?>"/> </label>
                    <label>Място <input type="text" name="place" id="place" value="<?= $place ?>"/> </label>
                </div>
                <div class="buttons">
                    <button type="button" name="Update" value="Промени" onclick="search();">Търси</button>
                    <button type="button" name="Clean" value="Изчисти" onclick="clearFields();">Изчисти</button>
                    <button type="button" class='right' name="Update" value="Промени" onclick="reseveRoom();">Заяви зала</button> 
                </div>
            </div>

            <table class="dataset">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>Зала</th>
                        <th>Дата</th>
                        <th>От/до час</th>
                        <th>Вид зала</th>
                        <th>Брой места</th>
                        <th>Застъпва заявление?</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($searchResult as $val): ?>
                        <tr>
                            <td><a href="#"><img src="../style/edit.png" title="Редактиране"  style="border: 0"></a>
                            </td>
                            <td><?= $val->getRoomName() ?>(<?= $val->getPlace() ?>)</td>
                            <td><?= $val->getDate() ?> </td>
                            <td><?= $val->getFromHour() ?>:<?= $val->getToHour() ?> </td>
                            <td><?= $val->getRoomTypeName() ?> </td>
                            <td><?= $val->getWorkStations() ?> </td>
                            <td><?= $val->getIsRequested() === 'Y' ? 'Да' : "Не" ?> </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div id="calendar-main">            
                <div class="month">
                    <h1>Август 2014</h1>            
                </div>            
                <div id="calendar">                
                    <ul class="weekdays">                    
                        <li>Понеделник</li>                    
                        <li>Вторник</li>                    
                        <li>Сряда</li>                    
                        <li>Четвъртък</li>                    
                        <li>Петък</li>                    
                        <li>Събота</li>                    
                        <li>Неделя</li>                
                    </ul>                
                    <!-- Days from previous month -->                
                    <ul class="days">                    
                        <li class="day other-month">                        
                            <div class="date">27</div>                                          
                        </li>                    
                        <li class="day other-month">                        
                            <div class="date">28</div>                        
                            <div class="event">
                                <div class="event-time">1:00-3:00</div>
                                <div class="event-desc">HTML 5 lecture with Brad Traversy from Eduonix</div>
                            </div>                                          
                        </li>                    
                        <li class="day other-month">                        
                            <div class="date">29</div>                                          
                        </li>                    
                        <li class="day other-month">                        
                            <div class="date">30</div>                                          
                        </li>                    
                        <li class="day other-month">                        
                            <div class="date">31</div>                                          
                        </li>                    
                        <!-- Days in current month -->                    
                        <li class="day">                        
                            <div class="date">1</div>                                           
                        </li>                    
                        <li class="day">                        
                            <div class="date">2</div>                        
                            <div class="event">
                                <div class="event-time">2:00-5:00</div>
                                <div class="event-desc">Career development @ Community College room #402</div>
                            </div>                                          
                        </li>                
                    </ul>                    
                    <!-- Row #2 -->                
                    <ul class="days">                    
                        <li class="day">                        
                            <div class="date">3</div>                                           
                        </li>                    
                        <li class="day">                        
                            <div class="date">4</div>                                           
                        </li>                    
                        <li class="day">                        
                            <div class="date">5</div>                                           
                        </li>                    
                        <li class="day">                        
                            <div class="date">6</div>                                           
                        </li>                    
                        <li class="day">                        
                            <div class="date">7</div>                        
                            <div class="event">
                                <div class="event-time">6:00-8:30</div>
                                <div class="event-desc">Group Project meetup</div>
                            </div>                                          
                        </li>                    
                        <li class="day">                        
                            <div class="date">8</div>                                           
                        </li>                    
                        <li class="day">                        
                            <div class="date">9</div>                                           
                        </li>                
                    </ul>                    
                    <!-- Row #3 -->                
                    <ul class="days">
                        <li class="day">
                            <div class="date">10</div>
                        </li>
                        <li class="day">
                            <div class="date">11</div>
                        </li>
                        <li class="day">
                            <div class="date">12</div>
                        </li>
                        <li class="day">
                            <div class="date">13</div>
                        </li>
                        <li class="day">
                            <div class="date">14</div>
                            <div class="event">
                                <div class="event-time">1:00-3:00</div>
                                <div class="event-desc">Board Meeting</div>
                            </div>                                          
                        </li>                    
                        <li class="day">                        
                            <div class="date">15</div>                                          
                        </li>                    
                        <li class="day">                        
                            <div class="date">16</div>                                          
                        </li>                
                    </ul>                    
                    <!-- Row #4 -->                
                    <ul class="days">                    
                        <li class="day">                        
                            <div class="date">17</div>                                          
                        </li>                    
                        <li class="day">                        
                            <div class="date">18</div>                                          
                        </li>                    
                        <li class="day">                        
                            <div class="date">19</div>                                          
                        </li>                    
                        <li class="day">                        
                            <div class="date">20</div>                                          
                        </li>                    
                        <li class="day">                        
                            <div class="date">21</div>                                          
                        </li>                    
                        <li class="day">                        
                            <div class="date">22</div>                        
                            <div class="event">
                                <div class="event-time">9:00-12:00</div>
                                <div class="event-desc">Conference call</div>
                            </div>                                          
                        </li>                    
                        <li class="day">                        
                            <div class="date">23</div>                                          
                        </li>                
                    </ul>                        
                    <!-- Row #5 -->                
                    <ul class="days">                    
                        <li class="day">                        
                            <div class="date">24</div>                                          
                        </li>                    
                        <li class="day">                        
                            <div class="date">25</div>                        
                            <div class="event">
                                <div class="event-time">1:00-3:00</div>
                                <div class="event-desc">Conference Call</div>
                            </div>                                          
                        </li>                    
                        <li class="day">                        
                            <div class="date">26</div>                                          
                        </li>                    
                        <li class="day">                        
                            <div class="date">27</div>                                          
                        </li>                    
                        <li class="day">                        
                            <div class="date">28</div>                                          
                        </li>                    
                        <li class="day">                        
                            <div class="date">29</div>                                          
                        </li>                    
                        <li class="day">                        
                            <div class="date">30</div>                                          
                        </li>                
                    </ul>                
                    <!-- Row #6 -->                
                    <ul class="days">                    
                        <li class="day">                        
                            <div class="date">31</div>                                          
                        </li>                         
                        <!-- Next Month --> 
                        <li class="day other-month">                        
                            <div class="date">1</div>                                          
                        </li>                
                        <li class="day other-month">                        
                            <div class="date">2</div>                                           
                        </li>                    
                        <li class="day other-month">                        
                            <div class="date">3</div>                                           
                        </li>                    
                        <li class="day other-month">                        
                            <div class="date">4</div>                                           
                        </li>                    
                        <li class="day other-month">                        
                            <div class="date">5</div>                                           
                        </li>                    
                        <li class="day other-month">                        
                            <div class="date">6</div>                                           
                        </li>                
                    </ul>            
                </div><!-- /. calendar -->        
            </div><!-- /. wrap -->

        </form>
    </body>
</html>
