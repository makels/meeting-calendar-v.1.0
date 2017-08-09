<?php

Class Controller_Auth extends Controller_Base {

    function index() {
        Http::redirect("/");
        exit;
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
    
    function invite() {
        $model = DB::loadModel("user");
        $admin = $this->registry->get("user");
        $from = $admin->login;
        $to = Http::post("email");
        $key = $model->invite($to);
        $smarty = $this->registry->get("smarty");
        $smarty->assign("email", $to);
        $smarty->assign("invite_key", $key);
        $text = $smarty->fetch(SITE_PATH . "modules/auth/tmpl/invite.tpl");
        $subject = "Invite on registration in meeting calendar";
        $header = "From: $from\r\n";
        $header .= "Content-type: text/html; charset=utf-8\r\n";
        $header .= "Content-Transfer-Encoding: base64\r\n";
        $header .= "X-Mailer: PHP/" . phpversion() ."\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        mail($to, $subject, $text, $header);
        echo json_encode(array("result" => "success"));
    }

    function register() {
        $invite_key = Http::post("invite_key");
        $display_name = Http::post("name");
        $email= Http::post("email");
        $password = Http::post("password");
        if($invite_key != null && $display_name != null && $email != null && $password != null) {
            $model = DB::loadModel("user");
            $model->acceptInvite(array(
                "invite_key" => $invite_key,
                "display_name" => $display_name,
                "email" => $email,
                "password" => $password
            ));
            $user = new User();
            $user->login = $email;
            $user->password = $password;
            $user->auth();
        }
        Http::redirect("/");
    }

}
