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
    $user_model = DB::loadModel("user");
    if($this->login != "" && $this->password != "") {
      $user_row = $user_model->getByLogin($this->login);
      if(md5($this->password) == $user_row["pass"]) {
        $this->is_admin = $user_row["su"] == 1;
        $this->display_name = $user_row["display_name"] . " - " . $user_row["email"];
        $this->id = $user_row["id"];
        $this->data = $user_row;
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

  public static function getCurrent() {
    if(isset($_SESSION['user'])) {
      $user_data = json_decode($_SESSION['user']);
      $user = new User();
      $user->login = $user_data->email;
      $user->password = $user_data->pass;
      $user->auth();
      return $user;
    } else return null;
  }

  public static function logout() {
    unset($_SESSION['user']);
  }

  public function setCurrent() {
    global $registry;
    $registry->set('user', $this);
    $_SESSION['user'] = json_encode(array(
        "email" => $this->login,
        "pass" => $this->password,
        "display_name" => $this->display_name,
        "su" => $this->is_admin
    ));
  }
}