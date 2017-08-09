<?php
session_start();

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 0);

// PATH
define ('DIRSEP', DIRECTORY_SEPARATOR);
define ('SITE_PATH', realpath(dirname(__FILE__)) . DIRSEP);
define ('ROOT_PATH', realpath($_SERVER["DOCUMENT_ROOT"]) . DIRSEP);
define ('MODELS_PATH', SITE_PATH . "models" . DIRSEP);
define ('MODULES_PATH', SITE_PATH . "modules" . DIRSEP);
define ('TMPL_PATH', SITE_PATH . "views" . DIRSEP);

if(is_dir(SITE_PATH."tmp") === false) mkdir(SITE_PATH."tmp");

require "startup.php";

$registry = new Registry;

// Smarty
$smarty = new Smarty;
$smarty->compile_check = true;
$smarty->debugging = false;
$registry->set('smarty', $smarty);

// Templates
$template = new Template($registry);
$registry->set('template', $template);

// MySQL
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
  $db_link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
  if(!$db_link) {
    if (Http::get("route") != "installer") {
      Http::redirect("/installer");
      exit;
    }
  } else {
    mysqli_set_charset($db_link, "UTF8");
    $registry->set('dl', $db_link);
  }
} catch (Exception $ex) {
  if(Http::get("route") != "installer") {
    Http::redirect("/installer");
    exit;
  }
}

// Router
$router = new Router($registry);
$registry->set ('router', $router);
$router->setPath (SITE_PATH . 'controllers');
$router->getController($file, $controller, $action, $args);
$registry->set("controller", array(
  "file" => $file,
  "controller" => $controller,
  "action" => $action,
  "args" => $args
));

$system_config = new Config();
$smarty->assign("system_config", json_encode($system_config->getAll()));
$smarty->assign("controller", $registry->get("controller"));

// User
$user = User::getCurrent();
$registry->set("user", $user);

$router->delegate();