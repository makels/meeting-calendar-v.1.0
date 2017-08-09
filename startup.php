<?php
/**
 * Created by PhpStorm.
 * User: Zerg
 * Date: 08.12.2015
 * Time: 10:54
 */

//if (version_compare(phpversion(), '5.6.0', '<') == true) { die ('PHP5.6 Only'); }
if (version_compare(phpversion(), '5.5.9', '<') == true) { die ('Only PHP 5.5.9 and higher versions'); }

require "classes/config.php";
require SITE_PATH . 'classes/smarty/Smarty.class.php';

$config = new Config();

// DB
define ('DB_HOST', $config->get("/settings/database/host"));
define ('DB_PORT', $config->get("/settings/database/port"));
define ('DB_NAME', $config->get("/settings/database/name"));
define ('DB_PREFIX', $config->get("/settings/database/prefix"));
define ('DB_USER', $config->get("/settings/database/user"));
define ('DB_PASS', $config->get("/settings/database/pass"));
define ('UPLOAD_DIR', SITE_PATH . "uploads/");
define ('CLASSES_DIR', SITE_PATH . "classes/");

function __autoload($class_name) {
  $filename = strtolower($class_name) . '.php';
  $file = CLASSES_DIR . $filename;

  if (file_exists($file) === false) {
    return false;
  }

  require_once($file);
}

