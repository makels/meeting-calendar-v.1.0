<header class="background">
    <div class="header-wrapper">
        <div class="logo">
            <h2>{fa_icon name="calendar"}Meeting Calendar v.1.0</h2>
        </div>
        {if $user != null && $user->is_logged() === true}
        <div class="user_info">
            <button onclick="document.location.href = '/auth/logout';">{fa_icon name="sign-out"}Sign out</button>
            {if $user->is_admin() === true}<button onclick="app.invite();">{fa_icon name="envelope-o"}Invite user</button>{/if}
            {fa_icon name="user"}{$user->display_name} - {$user->login}&nbsp;&nbsp;
        </div>
        {/if}
    </div>
</header>