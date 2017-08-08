<?php
/**
 * Created by PhpStorm.
 * User: Zerg
 * Date: 12.12.2015
 * Time: 15:49
 */
Abstract Class Module_Base {

  protected $registry;

  protected $modules = array();

  function __construct($registry) {
    $this->registry = $registry;
  }

  abstract function render();




}