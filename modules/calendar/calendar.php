<?php
/**
 * Created by PhpStorm.
 * User: ZERG
 * Date: 09.08.2017
 * Time: 21:13
 */
Class Module_Calendar extends Module_Base {
    
    
    function render() {
        $smarty = $this->registry->get("smarty");
        return $smarty->fetch(SITE_PATH . "modules/calendar/tmpl/calendar.tpl");
    }
    
    
}