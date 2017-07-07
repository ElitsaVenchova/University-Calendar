<?php
include '..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'Noms' . DIRECTORY_SEPARATOR . 'NomRoomTypes.php';
include '..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'Events' . DIRECTORY_SEPARATOR . 'Rooms.php';
include '..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'Events' . DIRECTORY_SEPARATOR . 'Event.php';
include '..' . DIRECTORY_SEPARATOR . 'header.php';
include 'ExtractFreeSlots.php';

function isToday($year, $month, $day){
    return $year == date('Y') && $month == date('m') && $day == date('d');
}

$year = isset($_GET['year']) ? $_GET['year'] : date('Y');
$month = isset($_GET['month']) ? $_GET['month'] : date('m');
$month = intval($month);
$year = intval($year);
//TODO: Взимането на събитията за календара

$monthBeginDate = $year . '-' . $month . '-1';
$monthEnd = date('t', strtotime($monthBeginDate));
$monthEndDate = date('Y-m-t', strtotime($monthBeginDate));
$prevMonthBeginDate = $year . '-' . ($month - 1) . '-1';
$prevMonthEnd = date('t', strtotime($prevMonthBeginDate));
$beginDayOfWeek = date('w', strtotime($monthBeginDate));
$endDayOfWeek = date('w', strtotime($monthEndDate));

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
//TODO: Да се направи календара да се отива в месеца, в който се съдържа началната дата.
    $searchResult = searchRooms($conn, $roomType, $room, $eventType, $fromDate, $toDate, $fromHour, $toHour, $fromWorkStations, $toWorkStations, $place, $weekDay);
}

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
            <input type="hidden" name="year" value="<?= $year ?>"/>
            <input type="hidden" name="month"value="<?= intval($month) ?>"/> 
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

                function changeYear(year) {
                    $('input[name=year').val(year);
                    document.forms[0].submit();
                }

                function changeMonth(month) {
                    if (parseInt(month) === 13) {
                        $('input[name=year').val($('input[name=year').val() - (-1));
                        $('input[name=month').val(1);
                    } else if (parseInt(month) === 0) {
                        $('input[name=year').val($('input[name=year').val() - 1);
                        $('input[name=month').val(12);
                    } else {
                        $('input[name=year').val($('input[name=year').val());
                        $('input[name=month').val(month);
                    }
                    document.forms[0].submit();
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
                    <label class="inline-show" style="float: left;width: 111px;">От дата<span class="required">*</span>
                        <input type="text" required="Y" style="width: 111px;" name="fromDate" id="fromDate" value="<?= $fromDate ?>"/> </label>
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
                    <label class="inline-show" style="float: left;width: 111px;">От час<span class="required">*</span> 
                        <select required="Y" name="fromHour" id="fromHour"style="width: 111px;">
                            <option></option>
                            <?php
                            for ($i = 7; $i <= 22; $i++) {
                                ?>
                                <option value="<?= $i ?>:00"><?= $i ?>:00</option>
                            <?php } ?>
                        </select></label>
                    <label class="inline-show">До час<span class="required">*</span>
                        <select name="toHour" id="toHour" required="Y">
                            <option></option>
                            <?php
                            for ($i = 7; $i <= 22; $i++) {
                                ?>
                                <option value="<?= $i ?>:00"><?= $i ?>:00</option>
                            <?php } ?>
                        </select> </label>
                    <label class="inline-show" style="float: left;width: 111px">От брой места<span class="required">*</span> <input type="text" required="Y" style="width: 111px;" name="fromWorkStations" id="fromWorkStations"  value="<?= $fromWorkStations ?>"/> </label>
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
                    <h1>
                        <a href="#" onclick="changeYear(<?= intval($year) - 1 ?>)"><img class="fliped" src="../style/arrow_year.png"></a>
                        <a href="#" onclick="changeMonth(<?= intval($month) - 1 ?>)"><img class="fliped" src="../style/arrow_month.png"></a>
                        <?= $monthsNames[intval($month) - 1] ?> <?= intval($year) ?>
                        <a href="#" onclick="changeMonth(<?= intval($month) + 1 ?>)"><img src="../style/arrow_month.png"></a>
                        <a href="#" onclick="changeYear(<?= intval($year) + 1 ?>)"><img src="../style/arrow_year.png"></a>
                    </h1>
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
                    <?php
                    echo '<ul class="days">';
                    if ($beginDayOfWeek != 1) {
                        for ($i = 1; $i < $beginDayOfWeek; $i++) {
                            echo '<li class="day other-month '.(isToday($year, $month, ($prevMonthEnd + 1 - $beginDayOfWeek + $i)) ? 'today' : '').'">' .
                            '<div class="date">' . ($prevMonthEnd + 1 - $beginDayOfWeek + $i) . '</div>' .
                            '</li>';
                        }
                    }
                    $currDate = 1;
                    for (; $currDate <= 7 - $beginDayOfWeek;) {
                        echo '<li class="day '.(isToday($year, $month, $currDate) ? 'today' : '').'">' .
                        '<div class="date">' . $currDate . '</div>' .
                        '</li>';
                        $currDate++;
                    }
                    echo '</ul>';

                    while ($currDate <= $monthEnd) {
                        echo '<ul class="days">';
                        for ($i = 0; $i < 7 && $currDate <= $monthEnd; $i++) {
                            echo '<li class="day '.(isToday($year, $month, $currDate) ? 'today' : '').'">' .
                            '<div class="date">' . $currDate . '</div>' .
                            '</li>';
                            $currDate++;
                        }
                        if (($endDayOfWeek === 7 && $currDate === $monthEnd) || $currDate < $monthEnd) {
                            echo '</ul>';
                        }
                    }
                    if ($endDayOfWeek !== 7) {
                        for ($i = 1; $i <= 7 - $endDayOfWeek; $i++) {
                            echo '<li class="day other-month '.(isToday($year, $month, $currDate) ? 'today' : '').'">' .
                            '<div class=""day">' . $i . '</div>' .
                            '</li>';
                            $currDate++;
                        }
                        echo '</ul>';
                    }
                    ?>

                    <!-- <div class="event">
                         <div class="event-time">2:00-5:00</div>
                         <div class="event-desc">Career development @ Community College room #402</div>
                     </div> -->   
                </div><!-- /. calendar -->        
            </div><!-- /. wrap -->

        </form>
    </body>
</html>
