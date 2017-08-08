<?php
/**
 * Created by PhpStorm.
 * User: Zerg
 * Date: 08.12.2015
 * Time: 11:06
 */

Class Router {

  private $registry;

  private $path;

  private $args = array();

  function __construct($registry) {
    $this->registry = $registry;
  }

  function setPath($path) {
    //$path = trim($path, '/\\');
    $path .= DIRSEP;
    if (is_dir($path) === false) {
      throw new Exception ('Invalid controller path: `' . $path . '`');
    }

    $this->path = $path;
  }

  function getPath() {
    return $this->getPath();
  }

  function delegate()
  {
    $route = !empty($_GET["route"]) ? $_GET["route"] : "";
    $parts = explode("/", $route);
    if(count($parts) > 0 && $parts[0] == "modules") {
      $this->getModule($file, $module, $action, $args);
      if (is_readable($file) == false) {
        die ('404 Not Found');
      }
      include ($file);
      $class = 'Module_' . $module;
      $mod = new $class($this->registry);
      if (is_callable(array($mod, $action)) == false) {
        die ('404 Not Found');
      }
      $mod->$action();
    } else {
      $this->getController($file, $controller, $action, $args);

      if (is_readable($file) == false) {
        die ('404 Not Found');
      }

      include ($file);
      $class = 'Controller_' . $controller;

      $controller = new $class($this->registry);
      if (is_callable(array($controller, $action)) == false) {
        die ('404 Not Found');
      }
      $controller->$action();
    }
  }

  public function getController(&$file, &$controller, &$action, &$args) {
    $route = (empty($_GET['route'])) ? '' : $_GET['route'];
    if (empty($route)) { $route = 'index'; }
    $route = trim($route, '/\\');
    $parts = explode('/', $route);
    $cmd_path = $this->path;
    foreach ($parts as $part) {
      $fullpath = $cmd_path . $part;
      if (is_dir($fullpath)) {
        $cmd_path .= $part . DIRSEP;
        array_shift($parts);
        continue;
      }
      if (is_file($fullpath . '.php')) {
        $controller = $part;
        array_shift($parts);
        break;
      }
    }

    if (empty($controller)) { $controller = 'index'; };
    $action = array_shift($parts);
    if (empty($action)) { $action = 'index'; }
    $file = $cmd_path . $controller . '.php';
    $args = $parts;
  }

  public function getModule(&$file, &$module, &$action, &$args) {
    $route = (empty($_GET['route'])) ? '' : $_GET['route'];
    if (empty($route)) { $route = 'index'; }
    $route = trim($route, '/\\');
    $parts = explode('/', $route);
    $cmd_path = SITE_PATH;
    foreach ($parts as $part) {
      $fullpath = $cmd_path . $part;
      if (is_dir($fullpath)) {
        $cmd_path .= $part . DIRSEP;
        array_shift($parts);
        continue;
      }
      if (is_file($fullpath . '.php')) {
        $module = $part;
        array_shift($parts);
        break;
      }
    }

    if (empty($module)) { $module = 'index'; };
    $action = array_shift($parts);
    if (empty($action)) { $action = 'index'; }
    $file = $cmd_path . $module . '.php';
    $args = $parts;
  }

}
