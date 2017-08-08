<?php
/**
 * Created by PhpStorm.
 * User: Zerg
 * Date: 08.12.2015
 * Time: 11:13
 */

Abstract Class Controller_Base {

  protected $registry;

  protected $modules = array();

  function __construct($registry) {
    $this->registry = $registry;
    $this->modules = array(
      "left_side" => array(),
      "center_side" => array(),
      "right_side" => array(),
    );
  }

  abstract function index();

  function display($template = "index") {

    $smarty = $this->registry->get("smarty");

    $smarty->assign('left_side', $this->renderModules("left_side"));
    $smarty->assign('right_side', $this->renderModules("right_side"));
    $smarty->assign('center_side', $this->renderModules("center_side"));
    $smarty->assign('user', $this->registry->get('user'));

    $smarty->display(TMPL_PATH . $template . ".tpl");
  }

  function renderModules($position) {
    $content = "";
    if(count($this->modules[$position]) == 0) return $content;
    foreach($this->modules[$position] as $module) {
      $content .= $module->render();
    }
    return $content;
  }

  function registerModule($name, $position) {
    $class_name = ucfirst(end(explode("/", $name)));
    $module_file = MODULES_PATH.mb_strtolower($name).".php";
    $module_name = "Module_".$class_name;
    if(file_exists($module_file)) {
      require_once $module_file;
      $module = new $module_name($this->registry);
      $this->modules[$position][] = $module;
    }
    return null;
  }
}
