<?php

$monthsNames = array('Януари', 'Февруари', 'Март', 'Април', 'Май', 'Юни', 'Юли', 'Август', 'Септември', 'Октомври', 'Ноември', 'Декември');

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
        "    select STR_TO_DATE(:toDate,'%Y.%m.%d') - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as Date " .
        "    from (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 	union all select 7 union all select 8 union all select 9) as a " .
        "    cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as b " .
        "    cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as c " .
        ") a " .
        "where a.Date between STR_TO_DATE(:fromDate,'%Y.%m.%d') and STR_TO_DATE(:toDate,'%Y.%m.%d') " .
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
        "        and ce.class_date between STR_TO_DATE(:fromDate,'%Y.%m.%d') and STR_TO_DATE(:toDate,'%Y.%m.%d') " .
        "        and ((ce.to_hour between STR_TO_DATE(coalesce(:fromHour, '7:00'), '%H:%i') and STR_TO_DATE(coalesce(:toHour, '7:00'), '%H:%i')  " .
        "                or ce.from_hour between STR_TO_DATE(coalesce(:fromHour, '7:00'), '%H:%i') and STR_TO_DATE(coalesce(:toHour, '7:00'), '%H:%i')  " .
        "                or STR_TO_DATE(coalesce(:fromHour, '7:00'), '%H:%i') between ce.from_hour and ce.to_hour) " .
        "        and WEEKDAY(ce.class_date) = case when :eventType = 'P' then :weekDay else WEEKDAY(ce.class_date) end) " .
        "order by r.id, ce.class_date, ce.from_hour";

/**
 * Тази функция се вика отвън за по-голямо удобство.
 * @param type $conn
 * @param type $roomType
 * @param type $room
 * @param type $eventType
 * @param type $fromDate
 * @param type $toDate
 * @param type $fromHour
 * @param type $toHour
 * @param type $fromWorkStations
 * @param type $toWorkStations
 * @param type $place
 * @param type $weekDay
 */
function searchRooms($conn, $roomType, $room, $eventType, $fromDate, $toDate, $fromHour, $toHour, $fromWorkStations, $toWorkStations, $place, $weekDay) {
searchRoomsNonWrap($conn, $roomType, $room, $eventType, $fromDate, $toDate, $fromHour, $toHour, $fromWorkStations, $toWorkStations, $place, $weekDay, $sqlRoomsData, $sqlEventsData);

}
function searchRoomsNonWrap($conn, $roomType, $room, $eventType, $fromDate, $toDate, $fromHour, $toHour, $fromWorkStations, $toWorkStations, $place, $weekDay, $sqlRoomsData, $sqlEventsData) {

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
    $stmt->bindValue(':place', empty($place) ? null : '%' . strtoupper($place) . '%');
    $stmt->bindValue(':weekDay', $weekDay);

    $stmt->execute();

    $rooms = array();
    while ($row = $stmt->fetch()) {
        $event = new Event($row["room_type_name"], $row["room_id"], $row["room_name"], $row["room_work_stations"], $row["room_place"], $row["room_notes"], $row["date"], $row["from_hour"], $row["to_hour"], null);
        if (!empty($rooms[$row["room_id"]])) {
            $rooms[$row["room_id"]] = array(event);
        } else {
            array_push($rooms[$row["room_id"]], $event);
        }
    }
    print_r($rooms);

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
    $stmt->bindValue(':place', empty($place) ? null : '%' . strtoupper($place) . '%');
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
