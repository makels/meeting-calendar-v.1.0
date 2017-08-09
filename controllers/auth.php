<?php

Class Controller_Auth extends Controller_Base {

    function index() {

    }

    function login() {
        $user = new User();
        $user->login = Http::post("login");
        $user->password = Http::post("password");
        $user->auth();
        Http::redirect("/");
    }

    function logout() {
        User::logout();
        $this->registry->set("user", null);
        Http::redirect("/");
    }

}
