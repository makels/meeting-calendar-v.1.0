<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        {literal}
        <style>
            body {
                font-family: Arrial, Helvetica, "Courier New", Courier, monospace;
                font-size: 14px;
            }

            .invite_title {
                width: 400px;
                color: #fff;
                padding: 10px;
                background-color: #1e5799;
                border-top-left-radius: 5px;
                border-top-right-radius: 5px;
                border: 1px solid #1e5799;
                border-bottom: none;
            }

            .invite_body {
                width: 400px;
                background-color: #eee;
                padding: 10px;
                color: #555;
                border: 1px solid #999;
                border-top: none;
            }

            .invite_body input {
                padding: 5px;
                float: right;
                width: 260px;
            }

            .invite_body p {
                color: #333;
            }

            .invite_body label {
                line-height: 22px;
            }

            .invite_body a {
                color: #1e5799;
            }
        </style>
        {/literal}
    </head>
    <body>
        <div class="invite_title">Meeting Calendar</div>
        <div class="invite_body">
            <p>You received this email for registration in "Meeting Calendar" system. Please go to link:</p>
            <a href="http://{$smarty.const.HTTP_HOST}/auth/register?invite_key={$invite_key}">http://{$smarty.const.HTTP_HOST}/auth/register?invite_key={$invite_key}</a>
        </div>
    </body>
</html>