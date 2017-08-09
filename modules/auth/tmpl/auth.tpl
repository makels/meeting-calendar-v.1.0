<form action="/auth/login" method="POST">
    <div class="login-window">
        <div class="login-window-title background">
            {fa_icon name="key"}<span>Sign in</span>
        </div>
        <div class="login-window-body">
            <div class="field-v">
                <div class="fa fa-user">&nbsp;</div>
                <input type="text" name="login" placeholder="E-mail" autocomplete="off" />
            </div>
            <div class="field-v">
                <div class="fa fa-lock">&nbsp;</div>
                <input type="password" name="password" placeholder="Pass" autocomplete="off"  />
            </div>
            <div class="buttons">
                <button class="gradient" type="submit">{fa_icon name="sign-in"}Sign in</button>
            </div>
        </div>
    </div>
</form>