<?php
/**
 * Created by PhpStorm.
 * User: Zerg
 * Date: 11.12.2015
 * Time: 11:20
 */

Class DB {

  public function last_id() {
    global $registry;
    $link = $registry->get("dl");
    return mysqli_insert_id($link);
  }

  public function getRow($sql) {
    global $registry;
    $link = $registry->get("dl");
    $res = mysqli_query($link, $sql);
    if($res && $row = $res->fetch_assoc()) return $row;
    else return null;
  }

  public function getRows($sql) {
    global $registry;
    $link = $registry->get("dl");
    $res = mysqli_query($link, $sql);
    $rows = array();
    if($res) {
      while ($row = $res->fetch_assoc()) {
        $rows[] = $row;
      }
    }
    return $rows;
  }

  public function insert($sql) {
    global $registry;
    $link = $registry->get("dl");
    $res = mysqli_query($link, $sql);
    mysqli_stmt_execute($res);
    return $this->last_id();
  }

  public function execute($sql) {
    global $registry;
    $link = $registry->get("dl");
    $res = mysqli_query($link, $sql);
    mysqli_stmt_execute($res);
  }

  public static function loadModel($model) {
    $class_name = ucfirst(end(explode("/", $model)));
    $model_file = MODELS_PATH.mb_strtolower($model).".php";
    $model_name = "Model_".$class_name;
    if(file_exists($model_file)) {
      require_once $model_file;
      return new $model_name;
    }
    return null;
  }

  public static function version() {
    global $registry;
    $link = $registry->get("dl");
    try {
      $res = mysqli_query($link, "SELECT * FROM `version` ORDER BY `version` DESC");
      if ($res && $row = $res->fetch_assoc()) {
        return $row["version"];
      } else return 0;
    } catch(Exception $e) {
      return 0;
    }
  }

  public static function version_update($file_name) {
    global $registry;
    $link = $registry->get("dl");
    $sql = file_get_contents(DB_UPDATE_PATH."/".$file_name);
    $res = mysqli_multi_query($link, $sql);

    mysqli_stmt_execute($res);
  }
  
  public static function install() {
    global $registry;
    $link = $registry->get("dl");

    // Create DATABASE
    DB::execute("CREATE DATABASE IF NOT EXISTS `" . IDB_NAME . "`");
    mysqli_select_db($link, IDB_NAME);
    // Create members
    DB::execute("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "users` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `email` varchar(255) NOT NULL,
                  `display_name` varchar(255) NOT NULL,
                  `pass` varchar(255) NOT NULL,
                  `su` int(11) NOT NULL,
                  `invite_key` varchar(255) NOT NULL,
                  `active` int(11) NOT NULL,
                  PRIMARY KEY (`id`),
                  UNIQUE KEY `email` (`email`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

    // Create events table
    DB::execute("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "events` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `owner_id` int(11) NOT NULL,
                `title` varchar(255) NOT NULL,
                `description` text NOT NULL,
                `status` enum('new','in-progress','done') NOT NULL,
                `start` datetime NOT NULL,
                `end` datetime NOT NULL,
                `color` varchar(255) NOT NULL,
                `color_text` varchar(255) NOT NULL,
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;");
    
  }

}