<?php
/**
 * Created by PhpStorm.
 * User: Zerg
 * Date: 09.12.2015
 * Time: 11:11
 */

Class Http {

  public static function redirect($url) {
    header("Location: ".$url, true, 307);
  }

  public static function unautorize() {
    header("WWW-Authenticate: Basic realm=\"My Realm\"");
    header("HTTP/1.0 401 Unauthorized");
  }

  public static function post($key) {
    if (isset($_POST[$key])) {
      return $_POST[$key];
    }
    return null;
  }

  public static function get($key) {
    if (isset($_GET[$key])) {
      return $_GET[$key];
    }
    return null;
  }

  public static function file($key) {
    if(isset($_FILES[$key]) && $_FILES[$key]["name"] != "") {
      return $_FILES[$key];
    }
    return null;
  }
}