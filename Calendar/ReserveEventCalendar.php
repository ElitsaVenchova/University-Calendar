<?php
include '..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'Noms' . DIRECTORY_SEPARATOR . 'NomRoomTypes.php';
include '..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'Events' . DIRECTORY_SEPARATOR . 'Rooms.php';
include '..' . DIRECTORY_SEPARATOR . 'header.php';

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
        . "WHERE r.is_active = 'Y' order by r.num";
$result = $conn->query($sql);
$rooms = array();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
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
        <form name="nom_degrees_edit_form" method="post">
            <input type="hidden" name="search"/>
            <script>
                function reloadRoomsCombo() {
                    var typeId = $('#roomType').val();
                    $('#roomsSpan').load(encodeURI("../combos/CalenderRoomsCombo.php?typeId=" + typeId));
                }

                function changeDateOption() {
                    var eventType = $('#eventType').val();
                    if (eventType === 'O') {
                        $('#periodicDate').html("<label>Дата<span class=\"required\">*</span>" +
                                "<input type=\"text\" required=\"Y\" name=\"date\" id=\"date\"/> </label>");
                    } else {
                        $('#periodicDate').html("<label class=\"inline-show\" style=\"float: left\">От дата<span class=\"required\">*</span> " +
                                "<input type=\"text\" required=\"Y\" name=\"fromDate\" id=\"fromDate\"/> </label>" +
                                "<label class=\"inline-show\">До дата<span class=\"required\">*</span> " +
                                "<input type=\"text\" name=\"toDate\" id=\"toDate\" required=\"Y\"/> </label>" +
                                "<label>Ден от седмицата<span class=\"required\">*</span>" +
                                "<select type=\"text\" required=\"Y\" name=\"weekDay\" id=\"weekDay\"> " +
                                "<option value='1'>Понеделник</option> " +
                                "<option value='2'>Вторник</option> " +
                                "<option value='3'>Сряда</option> " +
                                "<option value='4'>Четвъртък</option> " +
                                "<option value='5'>Петък</option> " +
                                "<option value='6'>Събота</option> " +
                                "<option value='7'>Неделя</option> " +
                                "</label>");
                    }
                }

                function search() {
                }

                function reseveRoom() {
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
                                <option value="<?= $val->getId() ?>"> <?= $val->getName() ?></option>
                            <?php endforeach; ?>
                        </select> </label>
                    <label>Зала<span class="required">*</span> <span id="roomsSpan"><select name="room" id="room" required="Y">
                                <option></option>
                                <?php foreach ($rooms as $val): ?>
                                    <option value="<?= $val->getId() ?>"><?= $val->getNum() ?></option>
                                <?php endforeach; ?>
                            </select></span> </label>
                    <label>Периодичност<span class="required">*</span> <select name="eventType" id="eventType" required="Y" onchange="changeDateOption()">
                            <option value='O'>Еднократно</option>
                            <option value='P'>Периодичност</option>
                            <option></option>
                        </select> </label>
                    <span id="periodicDate">
                        <label>Дата<span class="required">*</span><input type="text" required="Y" name="date" id="date"/> </label>
                    </span>
                    <label class="inline-show" style="float: left">От час<span class="required">*</span> <input type="text" required="Y" name="fromHour" id="fromHour"/> </label>
                    <label class="inline-show">До час<span class="required">*</span> <input type="text" name="toHour" id="toHour" required="Y"/> </label>
                    <label class="inline-show" style="float: left">От брой места<span class="required">*</span> <input type="text" required="Y" name="fromWorkStations" id="fromWorkStations"/> </label>
                    <label class="inline-show">До брой места<span class="required">*</span> <input type="text" name="toWorkStations" required="Y" id="toWorkStations"/> </label>
                    <label>Място <input type="text" name="place" id="place"/> </label>
                </div>
                <div class="buttons">
                    <button type="button" name="Update" value="Промени" onclick="search();">Търси</button>
                    <button type="button" name="Clean" value="Изчисти" onclick="clearFields();">Изчисти</button>
                    <button type="button" class='right' name="Update" value="Промени" onclick="reseveRoom();">Заяви зала</button> 
                </div>
            </div>
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
