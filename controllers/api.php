<?php
/**
 * Created by PhpStorm.
 * User: ZERG
 * Date: 10.08.2017
 * Time: 7:58
 */

Class Controller_Api extends Controller_Base {

    function index() {
        echo json_encode(array("result" => false, "msg" => "command not found"));
    }

    function getEventsOwners() {
        $model = DB::loadModel("user");
        $owners = $model->getAll();
        echo json_encode(array("result" => true, "msg" => "success", "owners" => $owners));
    }

    function getEvents() {
        $start = Http::post("start");
        $end = Http::post("end");
        $owners = Http::post("owners") != null ? Http::post("owners") : array();
        $model = DB::loadModel("events");
        $events = $model->getEvents($start, $end, $owners);
        echo json_encode(array("result" => true, "msg" => "success", "events" => $events));
    }

    function getEvent() {
        $event_id = Http::post("id");
        $model = DB::loadModel("events");
        $event = $model->getEvent($event_id);
        echo json_encode(array("result" => true, "msg" => "success", "event" => $event));
    }

    function saveEvent() {
        $user = $this->registry->get("user");
        $data = Http::post("form_data");
        $model = DB::loadModel("events");
        if($data["id"] == 0) {
            $model->addEvent($data);
        } else {
            $event = $model->getEvent($data["id"]);
            if($user->su != 1 && $event["owner_id"] != $user->id) {
                echo json_encode(array("result" => false, "msg" => "not have permissions"));
                exit;
            }
            $model->saveEvent($data);
        }
        echo json_encode(array("result" => true, "msg" => "success"));
    }

    function deleteEvent() {
        $user = $this->registry->get("user");
        $id = Http::post("id");
        if($id > 0) {
            $model = DB::loadModel("events");
            $event = $model->getEvent($id);
            if($user->su != 1 && $event["owner_id"] != $user->id) {
                echo json_encode(array("result" => false, "msg" => "not have permissions"));
                exit;
            }
            $model->deleteEvent($id);
        }
        echo json_encode(array("result" => true, "msg" => "success"));
    }

    function moveEvent() {
        $user = $this->registry->get("user");
        $id = Http::post("id");
        $model = DB::loadModel("events");
        $event = $model->getEvent($id);
        if($user->su != 1 && $event["owner_id"] != $user->id) {
            echo json_encode(array("result" => false, "msg" => "not have permissions"));
            exit;
        }
        $event = $model->getEvent($id);
        $event["start"] = Http::post("start");
        $event["end"] = Http::post("end");
        $model->saveEvent($event);
        echo json_encode(array("result" => true, "msg" => "success"));
    }


}