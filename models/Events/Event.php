<?php

class Event {

    private $roomTypeName;
    private $roomId;
    private $roomName;
    private $roomWorkStations;
    private $roomPlace;
    private $roomNotes;
    private $date;
    private $fromHour;
    private $toHour;
    private $isRequested;

    function __construct($roomTypeName, $roomId, $roomName, $roomWorkStations, $roomPlace, $roomNotes, $date, $fromHour, $toHour, $isRequested) {
        $this->roomTypeName = $roomTypeName;
        $this->roomId = $roomId;
        $this->roomName = $roomName;
        $this->roomWorkStations = $roomWorkStations;
        $this->roomPlace = $roomPlace;
        $this->roomNotes = $roomNotes;
        $this->date = $date;
        $this->fromHour = $fromHour;
        $this->toHour = $toHour;
        $this->isRequested = $isRequested;
    }

    public function getRoomTypeName() {
        return $this->roomTypeName;
    }

    public function setRoomTypeName($roomTypeName) {
        $this->roomTypeName = $roomTypeName;
    }

    public function getRoomId() {
        return $this->roomId;
    }

    public function setRoomId($roomId) {
        $this->roomId = $roomId;
    }

    public function getRoomName() {
        return $this->roomName;
    }

    public function setRoomName($roomName) {
        $this->roomName = $roomName;
    }

    public function getRoomWorkStations() {
        return $this->roomWorkStations;
    }

    public function setRoomWorkStations($roomWorkStations) {
        $this->roomWorkStations = $roomWorkStations;
    }

    public function getRoomPlace() {
        return $this->roomPlace;
    }

    public function setRoomPlace($roomPlace) {
        $this->roomPlace = $roomPlace;
    }

    public function getRoomNotes() {
        return $this->roomNotes;
    }

    public function setRoomNotes($roomNotes) {
        $this->roomNotes = $roomNotes;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getFromHour() {
        return $this->fromHour;
    }

    public function setFromHour($fromHour) {
        $this->fromHour = $fromHour;
    }

    public function getToHour() {
        return $this->toHour;
    }

    public function setToHour($toHour) {
        $this->toHour = $toHour;
    }

    public function getIsRequested() {
        return $this->isRequested;
    }

    public function setIsRequested($isRequested) {
        $this->isRequested = $isRequested;
    }

}

?>