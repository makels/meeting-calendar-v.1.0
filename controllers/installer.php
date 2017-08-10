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
        $smarty->assign("db_user", $config->get("/settings/database/user"));
        $smarty->assign("pass", $config->get("/settings/database/pass"));
        $smarty->assign("name", $config->get("/settings/database/name"));
        $smarty->assign("prefix", $config->get("/settings/database/prefix"));
        $this->display("installer");
    }

    function save() {
        $host = Http::post("db_host");
        $port = Http::post("db_port");
        $user = Http::post("db_user");
        $pass = Http::post("db_pass");
        $name = Http::post("db_name");
        $prefix = Http::post("db_prefix");
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
            $config->set("/settings/database/prefix", $prefix);

            // DB
            define ('IDB_HOST', $config->get("/settings/database/host"));
            define ('IDB_PORT', intval($config->get("/settings/database/port")));
            define ('IDB_NAME', $config->get("/settings/database/name"));
            define ('IDB_PREFIX', $config->get("/settings/database/prefix"));
            define ('IDB_USER', $config->get("/settings/database/user"));
            define ('IDB_PASS', $config->get("/settings/database/pass"));

            try {
                $db_link = mysqli_connect(IDB_HOST, IDB_USER, IDB_PASS, 'mysql', IDB_PORT);
                if(!$db_link) {
                    return "Error connection to MySQL";
                } else {
                    mysqli_set_charset($db_link, "UTF8");
                    $this->registry->set('dl', $db_link);
                    DB::install();
                    $model = DB::loadModel("user");
                    $res = $model->createAdmin($admin_email, $admin_pass);
                    if($res === false) {
                        return "This email address already exists";
                    }
                    Http::redirect("/");
                    exit;
                }
            } catch (Exception $ex) {
                return "Error connection to MySQL: " . $ex->getMessage();
            }
        }
    }
}