<?php
/**
 * Created by PhpStorm.
 * User: Zerg
 * Date: 11.01.2016
 * Time: 15:43
 */
Class Controller_Index Extends Controller_Base {

  function index() {
    $user = $this->registry->get("user");
    $smarty = $this->registry->get("smarty");
    $smarty->assign("user", $user);
    if($user != null && $user->is_logged() === true) {
      $this->registerModule("calendar/calendar", "center_side");
    } else {
      $this->registerModule("auth/auth", "center_side");
    }
    $this->display();
  }

}