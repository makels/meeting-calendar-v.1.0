<header class="background">
    <div class="header-wrapper">
        <div class="logo">
            <h2>Meeting Calendar v.1.0</h2>
        </div>
        {if $user != null && $user->is_logged() === true}
        <div class="user_info">
            <button onclick="document.location.href = '/auth/logout';">Sign out</button>
            {if $user->is_admin() === true}<button onclick="">Invite user</button>{/if}
            {$user->display_name}&nbsp;&nbsp;
        </div>
        {/if}
    </div>
</header>