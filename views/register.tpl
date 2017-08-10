<!DOCTYPE html>
<html lang="en">
<head>
    {include file="head.tpl"}
</head>
<body>
{include file="header.tpl"}
<div class="content">
    <form action="/auth/accept" method="POST">
        <input type="hidden" name="email" value="{$user_data.email}" />
        <div class="login-window register">
            <div class="login-window-title background">
                {fa_icon name="key"}<span>Sign up</span>
            </div>
            <div class="login-window-body">
                <div class="field-v">
                    <div class="fa fa-user">&nbsp;</div>
                    <input type="email" placeholder="E-mail" disabled value="{$user_data.email}" autocomplete="off" />
                </div>
                <div class="field-v">
                    <div class="fa fa-user">&nbsp;</div>
                    <input type="text" name="display_name" placeholder="Name" autocomplete="off" />
                </div>
                <div class="field-v">
                    <div class="fa fa-lock">&nbsp;</div>
                    <input type="password" name="password" placeholder="Pass" autocomplete="off"  />
                </div>
                <div class="buttons">
                    <button class="gradient" type="submit">{fa_icon name="sign-in"}Sign up</button>
                </div>
            </div>
        </div>
    </form>
</div>
{include file="footer.tpl"}
</body>
</html>