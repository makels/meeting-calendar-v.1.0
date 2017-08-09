<?php
/**
 * Created by PhpStorm.
 * User: Zerg
 * Date: 09.12.2015
 * Time: 12:28
 */

Class User {

  public $id;

  public $data;

  public $login;

  public $password;

  public $display_name;

  public $permissions;

  public $group_name;

  public $logged = false;

  public $is_admin = false;

  public function auth() {
    $this->authDB();
    if($this->logged === true) $this->setCurrent();
  }

  public function authDB() {
    $user_model = DB::loadModel("users/user");
    if($this->login != "" && $this->password != "") {
      $user_row = $user_model->getByLogin($this->login);
      if(md5($this->password) == $user_row["pass"]) {
        $this->is_admin = $user_row["su"] == 1;
        $this->display_name = $user_row["display_name"];
        $this->id = $user_row["id"];
        $this->data = $user_row;
        $this->permissions = $this->getPermissions();
        $this->logged = true;
      }
    }
  }

  public function is_admin() {
    return $this->is_admin === true || $this->is_admin == 1 ? true : null;
  }

  public function is_logged() {
    return $this->logged === true || $this->logged == 1 ? true : null;
  }

  public function getPermissions() {
    $user_model = DB::loadModel("users/user");
    $permissions = $user_model->get_permissions($this->id);
    return $permissions;
  }

  public function has_permission($alias) {
    $permissions = $this->getPermissions();
    foreach($permissions as $permission) {
      if($permission["alias"] == $alias) return true;
    }
    return false;
  }

  public function setCurrent() {
    global $registry;
    $registry->set('user', $this);
    $_SESSION['user'] = $this;
  }
}