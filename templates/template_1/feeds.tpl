{include file="../`$smarty.const.TEMPLATE_DIR`/header.tpl"}

<section role="main" class="app-main">
    <div class="app-main-inner">

        {if $feeds_new}
            <!---New Feed-->
            <div class="page-header">
                <h3 class="context-section-title">  
                    <i class="context-section-icon icon-embed"></i>
                    {$smarty.const.FEEDS_MSG3}
                </h3>
                <p class="context-section-description">{$smarty.const.FEEDS_MSG1}</p>
                <form accept-charset="UTF-8" action="/feeds/new/0" class="signup-form form-big" id="signup" method="post">

                    <div class="form-field three-up mobile">
                        <div class="input">
                            <input id="feeds_feedid" name="feeds_feedid" type="hidden" value="{$feed.feedid}" readonly>
                        </div>

                        <label class="inline" for="feeds_name">{$smarty.const.FEEDS_FORMS_NAME}</label>
                        <div class="input">
                            <small class="inline form-label-aid">{$smarty.const.SIGNUP_FORMS_USERNAME_DESC}</small>
                            <input class="seven" id="feeds_name" name="feeds_name" placeholder="Feed name" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                        </div>
                        <label class="inline" for="feeds_parser">{$smarty.const.FEEDS_FORMS_PARSER}</label>
                        <div class="input">
                            <small class="inline form-label-aid">{$smarty.const.FEEDS_FORMS_PARSER_DESC}</small>
                            <input id="feeds_parser" name="feeds_parser" type="text" value="{$feeds_parser}">
                        </div>

                        <label class="inline" for="feeds_auto">{$smarty.const.FEEDS_FORMS_AUTO}</label>
                        <div class="checkbox">
                            <input id="feedid" name="feeds_auto" type="checkbox" value="1" >
                            <small class="inline form-label-aid">{$smarty.const.FEEDS_FORMS_AUTO_DESC}</small>
                        </div>
                        <label class="inline" for="feeds_logging">{$smarty.const.FEEDS_FORMS_LOG}</label>
                        <div class="checkbox">
                            <input id="feeds_logging" name="feeds_logging" type="checkbox" value="1" {if $feed.logging == 1} checked {/if}>
                            <small class="inline form-label-aid">{$smarty.const.FEEDS_FORMS_LOG_DESC}</small>
                        </div>
                    </div>

                    <div class="form-actions form-actions-big">
                        <button class="form-action-save button large" type="submit" name="submit" value="{$smarty.const.FORMS_FEEDS_CREATE}">
                            <i class="button-icon icon-checkmark"></i> {$smarty.const.FEEDS_FORMS_SUBMIT}
                        </button>
                    </div>

                </form>

            </div>
            <!--- New Feed End -->

        {elseif $feeds_edit}
            <!--- Edit Feed -->
            <div class="page-header">
                {foreach item="feed" from=$userFeed}
                    <h3 class="context-section-title">  
                        <i class="context-section-icon icon-embed"></i>
                        {$smarty.const.FEEDS_MSG4}: {$feed.name}
                    </h3>
                    <p class="context-section-description">{$smarty.const.FEEDS_MSG5}</p>
                    <form accept-charset="UTF-8" action="/feeds/edit/{$feed.feedid}" class="signup-form form-big" id="signup" method="post">

                        <div class="form-field three-up mobile">
                            <label class="inline" for="feeds_feedid">{$smarty.const.FEEDS_FORMS_ID}: {$feed.feedid}</label>
                            <div class="input">
                                <input id="feeds_feedid" name="feeds_feedid" type="hidden" value="{$feed.feedid}" readonly>
                            </div>

                            <label class="inline" for="feeds_name">{$smarty.const.FEEDS_FORMS_NAME}</label>
                            <div class="input">
                                <small class="inline form-label-aid">{$smarty.const.SIGNUP_FORMS_USERNAME_DESC}</small>
                                <input class="seven" id="feeds_name" name="feeds_name" value="{$feed.name}" placeholder="Feed name" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                            </div>
                            <label class="inline" for="feeds_parser">{$smarty.const.FEEDS_FORMS_PARSER}</label>
                            <div class="input">
                                <small class="inline form-label-aid">{$smarty.const.FEEDS_FORMS_PARSER_DESC}</small>
                                <input id="feeds_parser" name="feeds_parser" type="text" value="{$feed.parser_settings}">
                            </div>

                            <label class="inline" for="feeds_auto">{$smarty.const.FEEDS_FORMS_AUTO}</label>
                            <div class="checkbox">
                                <input id="feeds_auto" name="feeds_auto" type="checkbox" value="1" {if $feed.auto == 1} checked {/if}>
                                <small class="inline form-label-aid">{$smarty.const.FEEDS_FORMS_AUTO_DESC}</small>
                            </div>
                            <label class="inline" for="feeds_logging">{$smarty.const.FEEDS_FORMS_LOG}</label>
                            <div class="checkbox">
                                <input id="feeds_logging" name="feeds_logging" type="checkbox" value="1" {if $feed.logging == 1} checked {/if}>
                                <small class="inline form-label-aid">{$smarty.const.FEEDS_FORMS_LOG_DESC}</small>
                            </div>
                        </div>

                        <div class="form-actions form-actions-big">
                            <button class="form-action-save button large" type="submit" name="submit" value="{$smarty.const.FORMS_FEEDS_UPDATE}">
                                <i class="button-icon icon-checkmark"></i> {$smarty.const.FEEDS_FORMS_SUBMIT}
                            </button>
                        </div>

                    </form>
                {/foreach}

            </div>
            <!--- Edit Feed End-->

        {elseif $feeds_logs}
            <!--- Logs Feed -->
            <div class="page-header">
                <h3 class="context-section-title">  <i class="context-section-icon icon-embed"></i>
                    {$smarty.const.FEEDS_LOGMSG1}
                </h3>
                <p class="context-section-description">{$smarty.const.FEEDS_LOGMSG2}</p>

            </div>


            <div class="legacy-feeds context-section row">
                <div class="twelve columns">

                    <div class="legacy-feeds">
                        <table class="legacy-feeds-table table-unstyled twelve">
                            <thead>
                                <tr>
                                    <th class="legacy-feed-header-name">{$smarty.const.FEEDS_LOGID}</th>
                                    <th class="legacy-feed-header-name five">{$smarty.const.FEEDS_LOGMSG}</th>
                                    <th class="legacy-feed-header-updated two">{$smarty.const.FEEDS_LOGDATE}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {foreach item="log" from=$feedslogs}
                                    <tr>
                                        <td class="legacy-feed-name five">{$log.logid}</a></td>
                                        <td class="legacy-feed-name two">{$log.logmsg}</td>
                                        <td class="legacy-feed-updated">{$log.create_date}</td>
                                    </tr>
                                {/foreach}
                            </tbody>
                        </table>

                    </div>
                </div>


                <!--- Logs Feed End-->
            {else}
                <!--- Feeds -->
                <div class="page-header">
                    <h3 class="context-section-title">  <i class="context-section-icon icon-embed"></i>
                        {$smarty.const.FEEDS}
                    </h3>
                    <p class="context-section-description">{$smarty.const.FEEDS_MSG1}</p>


                    <ul class="context-tiles block-grid three-up mobile">
                        <li class="context-tile">
                            <a class="context-tile-add tile tile-dashed icon-plus" href="{$smarty.const.SITE_URL}feeds/new/0">{$smarty.const.FEEDS_MSG2}</a>
                        </li>
                    </ul>
                </div>


                <div class="legacy-feeds context-section row">
                    <div class="twelve columns">
                        <div class="context-section no-icon">
                            <h3 class="context-section-title">{$smarty.const.FEEDS}</h3>
                            <p class="context-section-description">Total Feeds: {$number_of_feeds_per_user}</p>
                        </div>

                        <div class="legacy-feeds">
                            <table class="legacy-feeds-table table-unstyled twelve">
                                <thead>
                                    <tr>
                                        <th class="legacy-feed-header-name">{$smarty.const.FEEDS_TITLE}</th>
                                        <th class="legacy-feed-header-name">{$smarty.const.FEEDS_ID}</th>
                                        <th class="legacy-feed-header-updated">{$smarty.const.FEEDS_LAST_UPDATE}</th>
                                        <th class="legacy-feed-header-updated">{$smarty.const.FEEDS_ACTION}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {foreach item="feed" from=$userfeeds}
                                        <tr {if $feed.active == 0} style="text-decoration:line-through" {/if}>
                                            <td class="legacy-feed-name five"><a href="{$smarty.const.SITE_URL}feeds/edit/{$feed.feedid}">{$feed.name}</a></td>
                                            <td class="legacy-feed-name two">{$feed.feedid}</td>
                                            <td class="legacy-feed-updated">{$feed.last_update}</td>
                                            <td class="legacy-feed-name three">
                                                <a href="{$smarty.const.SITE_URL}feeds/edit/{$feed.feedid}">{$smarty.const.FEEDS_EDIT}</a>
                                                <a href="{$smarty.const.SITE_URL}feeds/delete/{$feed.feedid}">{$smarty.const.FEEDS_DELETE}</a>
                                                {if $feed.active == 1}
                                                    <a href="{$smarty.const.SITE_URL}feeds/deactivate/{$feed.feedid}">{$smarty.const.FEEDS_DEACTIVATE}</a>
                                                {else}
                                                    <a href="{$smarty.const.SITE_URL}feeds/activate/{$feed.feedid}">{$smarty.const.FEEDS_ACTIVATE}</a>
                                                {/if}
                                                {if $feed.logging == 1}
                                                    <a href="{$smarty.const.SITE_URL}feeds/log/{$feed.feedid}">{$smarty.const.FEEDS_LOG}</a>
                                                {/if}
                                            </td>
                                        </tr>
                                    {/foreach}
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!--- Feeds End -->
                {/if}

            </div>
        </div>
</section>


</div>
{include file="../`$smarty.const.TEMPLATE_DIR`/footer.tpl"}
