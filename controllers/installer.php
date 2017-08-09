<?php
/**
 * Created by PhpStorm.
 * User: ZERG
 * Date: 09.08.2017
 * Time: 12:47
 */
Class Controller_Installer Extends Controller_Base {

    function index() {
        $config = new Config();
        $smarty = $this->registry->get("smarty");
        if(Http::post("action") == "save") {
            $error = $this->save();
            if($error != "") {
                $smarty->assign("error", $error);
            }
        }
        $smarty->assign("host", $config->get("/settings/database/host"));
        $smarty->assign("port", $config->get("/settings/database/port"));
        $smarty->assign("user", $config->get("/settings/database/user"));
        $smarty->assign("pass", $config->get("/settings/database/pass"));
        $smarty->assign("name", $config->get("/settings/database/name"));
        $this->display("installer");
    }

    function save() {
        $host = Http::post("db_host");
        $port = Http::post("db_port");
        $user = Http::post("db_user");
        $pass = Http::post("db_pass");
        $name = Http::post("db_name");
        $admin_email = Http::post("admin_email");
        $admin_pass = Http::post("admin_pass");
        if($host == null || $port == null || $user == null || $pass == null || $name == null || $admin_email == null || $admin_pass == null) {
            return "Fill all fields";
        } else {
            $config = new Config();
            $config->set("/settings/database/host", $host);
            $config->set("/settings/database/port", $port);
            $config->set("/settings/database/user", $user);
            $config->set("/settings/database/pass", $pass);
            $config->set("/settings/database/name", $name);

            try {
                $db_link = mysqli_connect($host, $user, $pass, $name, $port);
                if(!$db_link) {
                    return "Error connection to MySQL";
                } else {
                    mysqli_set_charset($db_link, "UTF8");
                    $this->registry->set('dl', $db_link);
                    DB::install();
                    $model = DB::loadModel("user");
                    $model->createAdmin($admin_email, $admin_pass);
                    Http::redirect("/");
                    exit;
                }
            } catch (Exception $ex) {
                return "Error connection to MySQL";
            }
        }
    }
}