<?php
/**
 * Created by PhpStorm.
 * User: Zerg
 * Date: 11.12.2015
 * Time: 11:22
 */

Class Model_User extends DB {

  private $table = "members";

  public function get($id) {
    $user = $this->getRow(sprintf("SELECT * FROM `%s` WHERE `id` = %s", $this->table, $id));
    $user["is_admin"] = $user["su"];
    return $user;
  }

  public function getByLogin($login) {
    return $this->getRow(sprintf("SELECT * FROM `%s` WHERE `su` = 1 AND `email` = '%s'", $this->table, $login));
  }

  public function createAdmin($email, $pass) {
    $id = $this->insert(sprintf("INSERT INTO `%s` (`email`,`display_name`,`pass`, `su`) VALUES ('%s','%s',md5('%s'), 1)",
        $this->table, $email, "Administrator", $pass));
    return $this->get($id);
  }

  public function deleteUserByEmail($email) {
    $this->execute(sprintf("DELETE FROM `%s` WHERE `email` = '%s'", $this->table, $email));
  }

  public function add($data) {
    $id = $this->insert(sprintf("INSERT INTO `%s` (`email`,`display_name`,`pass`, `su`) VALUES ('%s','%s',md5('%s'), '%s', 1)",
        $this->table, $data["email"], $data["display_name"], $data["pass"], $data["su"]));
    return $this->get($id);
  }

}