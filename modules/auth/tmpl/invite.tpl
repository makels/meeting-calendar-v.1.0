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
                text-align: justify;
                color: #1e5799;
            }

            .invite_body label {
                line-height: 22px;
            }

            .invite_body button {
                margin-top: 10px;
                padding: 5px;
                background-color: #1e5799;
                border: none;
                color: #fff;
                border-radius: 3px;
                cursor: pointer;
            }
        </style>
        {/literal}
    </head>
    <body>
        <div class="invite_title">Meeting Calendar</div>
        <div class="invite_body">
            <p>You receive this email for registration in Meeting Calendar system. Please fill a few fields and push button "Registration."</p>
            <form method="post" action="meeting.makels.com/auth/register">
                <input type="hidden" name="invite_key" value="{$invite_key}" />
                <label>Name:</label><input type="text" name="name" /><br><br>
                <label>Email:</label><input type="email" name="email" value="{$email}" /><br><br>
                <label>Password:</label><input type="password" name="password" /><br><br>
                <button type="submit">Registration</button>
            </form>
        </div>
    </body>
</html>