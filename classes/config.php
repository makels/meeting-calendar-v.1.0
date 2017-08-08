<?php
/**
 * Created by PhpStorm.
 * User: Zerg
 * Date: 12.12.2015
 * Time: 20:26
 */

Class Config {

  private $config_xml;

  function __construct() {
    if(file_exists(ROOT_PATH . "config.xml"))
      $this->config_xml = simplexml_load_file(ROOT_PATH . "config.xml");
  }

  function get($path) {
    $val = end(explode("/", $path));
    $path = str_replace("/".$val, "", $path);
    $res = $this->config_xml->xpath($path);
    return $res[0]->$val;
  }

  function set($path, $value) {
    $val = end(explode("/", $path));
    $path = str_replace("/".$val, "", $path);
    $res = $this->config_xml->xpath($path);
    if(count($res) == 0) {
      $res = $this->createPath($path);
    }
    $res[0]->$val = $value;
    $this->config_xml->saveXML(ROOT_PATH . "config.xml");
  }

  function getAll() {
    return $this->config_xml->xpath("/settings");
  }

  function createPath($path) {
    $current_path = "/";
    $path_arr = explode("/", $path);
    foreach($path_arr as $node_name) {
      if($node_name == "") continue;
      $parent = $this->config_xml->xpath("/" . $current_path);
      $current_path .= $node_name;
      $node = $this->config_xml->xpath("/" . $current_path);
      if(count($node) == 0) {
        $parent[0]->addChild($node_name);
      }
    }
    return $this->config_xml->xpath($path);
  }
}