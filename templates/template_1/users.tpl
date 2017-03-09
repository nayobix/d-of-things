{include file="../`$smarty.const.TEMPLATE_DIR`/header.tpl"}

<section role="main" class="app-main">
    <div class="app-main-inner">

        <!--- Users -->
        <div class="page-header">
            <h3 class="context-section-title">  <i class="context-section-icon icon-embed"></i>
                {$smarty.const.USERS}
            </h3>
            <p class="context-section-description">{$smarty.const.USERS_MSG1} {$number_of_users}</p>

        </div>

        <div class="legacy-users context-section row">
            <div class="twelve columns">
                <div class="legacy-users">
                    <table class="legacy-users-table table-unstyled twelve">
                        <thead>
                            <tr>
                                <th class="legacy-user-header-name">{$smarty.const.USERS_ID}</th>
                                <th class="legacy-user-header-name">{$smarty.const.USERS_USER}</th>
                                <th class="legacy-user-header-updated">{$smarty.const.USERS_EMAIL}</th>
                                <th class="legacy-user-header-updated">{$smarty.const.USERS_FNAME}</th>
                                <th class="legacy-user-header-updated">{$smarty.const.USERS_LNAME}</th>
                                <th class="legacy-user-header-updated">{$smarty.const.USERS_PHONE}</th>
                                <th class="legacy-user-header-updated">{$smarty.const.USERS_ROLE}</th>
                                <th class="legacy-user-header-updated">{$smarty.const.USERS_ACTION}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach item="user" from=$u}
                                <tr {if $user.activated == 0} style="text-decoration:line-through" {/if}>
                                    <td class="legacy-user-name one"><a href="#">{$user.uid}</a></td>
                                    <td class="legacy-user-name one">{$user.user}</td>
                                    <td class="legacy-user-email">{$user.email}</td>
                                    <td class="legacy-user-fname">{$user.fname}</td>
                                    <td class="legacy-user-lname">{$user.lname}</td>
                                    <td class="legacy-user-phone">{$user.phone}</td>
                                    <td class="legacy-user-role">{$user.role}</td>
                                    <td class="legacy-user-fname three">
                                        <a href="#"></a>
                                        <a href="{$smarty.const.SITE_URL}users/delete/{$user.uid}">{$smarty.const.USERS_DELETE}</a>
                                        {if $user.activated == 1}
                                            <a href="{$smarty.const.SITE_URL}users/deactivate/{$user.uid}">{$smarty.const.USERS_DEACTIVATE}</a>
                                        {else}
                                            <a href="{$smarty.const.SITE_URL}users/activate/{$user.uid}">{$smarty.const.USERS_ACTIVATE}</a>
                                        {/if}
                                        {if $user.role == 99}
                                            <a href="{$smarty.const.SITE_URL}users/makeuser/{$user.uid}">{$smarty.const.USERS_MAKEUSER}</a>
                                        {else}
                                            <a href="{$smarty.const.SITE_URL}users/makeadmin/{$user.uid}">{$smarty.const.USERS_MAKEADMIN}</a>
                                        {/if}
                                    </td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>

                </div>
            </div>

            <!--- Feeds End -->

        </div>
    </div>
</section>


</div>
{include file="../`$smarty.const.TEMPLATE_DIR`/footer.tpl"}
