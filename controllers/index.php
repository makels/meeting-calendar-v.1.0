<?php
/**
 * Created by PhpStorm.
 * User: Zerg
 * Date: 11.01.2016
 * Time: 15:43
 */
Class Controller_Index Extends Controller_Base {

  function index() {
    $smarty = $this->registry->get("smarty");
    $this->registerModule("constructor/tools", "center_side");
    $this->registerModule("constructor/constructor", "center_side");

    $this->registerModule("constructor/controls", "constructor_controls");
    $smarty->assign('constructor_controls', $this->renderModules("constructor_controls"));
    $this->display();
  }

}