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
    $user = $this->registry->get("user");
    $model = DB::loadModel("user");
    $users_list = $model->getAll();
    $smarty->assign("users_list", $users_list);
    $smarty->assign("user", $user);
    if($user != null && $user->is_logged() === true) {
      $this->registerModule("calendar/calendar", "center_side");
    } else {
      $this->registerModule("auth/auth", "center_side");
    }

    $this->display();
  }

}