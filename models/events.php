<?php
/**
 * Created by PhpStorm.
 * User: ZERG
 * Date: 10.08.2017
 * Time: 7:49
 */

Class Model_Events extends DB {

    private $table;

    function __construct() {
        $this->table = DB_PREFIX . "events";
    }

    public function getEvents($start, $end, $owners = array()) {
        if(count($owners) > 0) {
            $owners_id = implode(",", $owners);
            $events = $this->getRows(sprintf("SELECT * FROM `%s` WHERE `start` >= DATE('%s') AND `end` <= DATE('%s') AND `owner_id` IN (%s)", $this->table, $start, $end, $owners_id));
        } else {
            $events = $this->getRows(sprintf("SELECT *, `color_text` as textColor FROM `%s` WHERE `start` >= DATE('%s') AND `end` <= DATE('%s')", $this->table, $start, $end));
        }
        return $events;
    }

    public function getEvent($id) {
        return $this->getRow(sprintf("SELECT a.*,a.color_text as textColor, u.`display_name` FROM `%s` a, `%susers` u WHERE a.`id` = %s AND a.`owner_id` = u.`id`", $this->table, DB_PREFIX, $id));
    }

    public function saveEvent($data) {
        $this->execute(sprintf("UPDATE `%s` SET `title` = '%s', `description` = '%s', `status` = '%s', `start` = '%s', `end` = '%s', `color` = '%s', `color_text` = '%s' WHERE `id` = %s",
            $this->table, $data["title"], $data["description"], $data["status"], $data["start"], $data["end"], $data["color"], $data["color_text"], $data["id"]));
    }

    public function addEvent($data) {
        $sql = sprintf("INSERT INTO `%s` (`owner_id`, `title`, `description`, `status`, `start`, `end`, `color`, `color_text`) VALUES (%s, '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
            $this->table, $data["owner_id"], $data["title"], $data["description"], $data["status"], $data["start"], $data["end"], $data["color"], $data["color_text"]);
        $id = $this->insert($sql);
        return $id;
    }

    public function deleteEvent($id) {
        $this->execute(sprintf("DELETE FROM `%s` WHERE `id` = %s", $this->table, $id));
    }

}