<?php
/**
 * Created by PhpStorm.
 * User: Zerg
 * Date: 11.12.2015
 * Time: 11:22
 */

Class Model_User extends DB {

  private $table;

  function __construct() {
    $this->table = DB_PREFIX . "users";
  }

  public function getAll() {
    return $this->getRows(sprintf("SELECT * FROM `%s` WHERE `active` = 1 ORDER BY `email`", $this->table));
  }

  public function get($id) {
    $user = $this->getRow(sprintf("SELECT * FROM `%s` WHERE `id` = %s", $this->table, $id));
    $user["is_admin"] = $user["su"];
    return $user;
  }

  public function getByInviteKey($key) {
    return $this->getRow(sprintf("SELECT * FROM `%s` WHERE `invite_key` = '%s'", $this->table, $key));
  }

  public function getByLogin($login) {
    return $this->getRow(sprintf("SELECT * FROM `%s` WHERE `active` = 1 AND `email` = '%s'", $this->table, $login));
  }

  public function createAdmin($email, $pass) {
    $row = $this->getRow(sprintf("SELECT count(email) as `count_emails` FROM `%s` WHERE `email` = '%s'", $this->table, $email));
    if($row['count_emails'] > 0) {
      return false;
    }
    $id = $this->insert(sprintf("INSERT INTO `%s` (`email`,`display_name`,`pass`, `su`, `invite_key`, `active`) VALUES ('%s','%s',md5('%s'), 1, '', 1)",
        $this->table, $email, "Administrator", $pass));
    return true;
  }

  public function deleteUserByEmail($email) {
    $this->execute(sprintf("DELETE FROM `%s` WHERE `email` = '%s'", $this->table, $email));
  }

  public function add($data) {
    $id = $this->insert(sprintf("INSERT INTO `%s` (`email`,`display_name`,`pass`, `su`, `invite_key`, `active`) VALUES ('%s','%s',md5('%s'), '%s', %s, '', 1)",
        $this->table, $data["email"], $data["display_name"], $data["pass"], $data["su"]));
    return $this->get($id);
  }

  public function invite($email) {
    $uid = md5(uniqid());
    $sql = sprintf("INSERT INTO `%s` (`email`,`display_name`,`pass`, `su`, `invite_key`, `active`) VALUES ('%s','', '', 0, '%s', 0)", $this->table, $email, $uid);
    $this->insert($sql);
    return $uid;
  }

  public function update($data) {
    $this->execute(sprintf("UPDATE `%s` SET `display_name` = '%s', `pass` = '%s', `active` = 1 WHERE `email` = '%s'", $this->table, $data["display_name"], md5($data["password"]), $data["email"]));
  }

  public function acceptInvite($data) {
    $this->execute(sprintf("UPDATE `%s` SET `display_name` = '%s', `pass` = '%s', `active` = 1 WHERE `invite_key` = '%s'", $this->table, $data["display_name"], md5($data["password"]), $data["invite_key"]));
  }

}