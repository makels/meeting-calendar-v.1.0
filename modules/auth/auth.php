<?php

Class Module_Auth extends Module_Base {

    function render() {
        $smarty = $this->registry->get("smarty");
        return $smarty->fetch(SITE_PATH . "modules/auth/tmpl/auth.tpl");
    }

}