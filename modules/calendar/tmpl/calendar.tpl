<div class="main_content">
    <div id="calendar"></div>
    <div id="users_list_wrapper">
        <div class="ulist_title background">{fa_icon name="users"}Users List</div>
        <div class="ulist_body">
            <ul>
                {foreach from=$users_list item="item"}
                    <li>
                        <input type="checkbox" user_id="{$item.id}" checked />&nbsp;{$item.display_name}
                    </li>
                {/foreach}
            </ul>
        </div>
    </div>
</div>
{include file=$smarty.const.SITE_PATH|cat:"/modules/calendar/tmpl/event.tpl"}