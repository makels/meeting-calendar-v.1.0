<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        {include file="head.tpl"}
    </head>
    <body>
        {include file="header.tpl"}
    <div class="content">
        <div class="installer module">
            <div class="module-title background">Installer</div>
            <div class="module-wrapper">
                <form action="/installer" method="POST">
                    <input type="hidden" name="action" value="save" />

                    {if $error != ""}
                        <div class="error">{$error}</div>
                    {/if}

                    <div class="fields_group">MySQl settings</div>
                    <table>
                        <tr>
                            <td class="var_name">Host:</td>
                            <td><input type="text" name="db_host" value="{if $host != ""}{$host}{else}{if isset($smarty.post.db_host)}{$smarty.post.db_host}{/if}{/if}" /></td>
                        </tr>
                        <tr>
                            <td class="var_name">Port:</td>
                            <td><input type="text" name="db_port" value="{if $port != ""}{$port}{else}{if isset($smarty.post.db_port)}{$smarty.post.db_port}{else}3306{/if}{/if}" /></td>
                        </tr>
                        <tr>
                            <td class="var_name">User:</td>
                            <td><input type="text" name="db_user" value="{if $db_user != ""}{$db_user}{else}{if isset($smarty.post.db_user)}{$smarty.post.db_user}{/if}{/if}" /></td>
                        </tr>
                        <tr>
                            <td class="var_name">Pass:</td>
                            <td><input type="password" name="db_pass" value="{if $pass != ""}{$pass}{else}{if isset($smarty.post.db_pass)}{$smarty.post.db_pass}{/if}{/if}" /></td>
                        </tr>
                        <tr>
                            <td class="var_name">Database name:</td>
                            <td><input type="text" name="db_name" value="{if $name != ""}{$name}{else}{if isset($smarty.post.db_name)}{$smarty.post.db_name}{else}meeting{/if}{/if}" /></td>
                        </tr>
                        <tr>
                            <td class="var_name">Tables prefix:</td>
                            <td><input type="text" name="db_prefix" value="{if $prefix != ""}{$prefix}{else}{if isset($smarty.post.prefix)}{$smarty.post.prefix}{else}mc_{/if}{/if}" /></td>
                        </tr>
                        <tr>
                            <td class="var_name">Administrator e-mail:</td>
                            <td><input type="text" name="admin_email" {if isset($smarty.post.admin_email)}value="{$smarty.post.admin_email}"{/if} /></td>
                        </tr>
                        <tr>
                            <td class="var_name">Administrator password:</td>
                            <td><input type="password" name="admin_pass" {if isset($smarty.post.admin_pass)}value="{$smarty.post.admin_pass}"{/if} /></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button  style="float: right;margin-top: 10px;" type="submit">{fa_icon name="save"}Сохранить</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
    {include file="footer.tpl"}
    </body>
</html>