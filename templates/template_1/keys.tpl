{include file="../`$smarty.const.TEMPLATE_DIR`/header.tpl"}

<section role="main" class="app-main">
    <div class="app-main-inner">

        {if $keys_new}
            <!---New Key-->
            <div class="page-header">
                <h3 class="context-section-title">  
                    <i class="context-section-icon icon-embed"></i>
                    {$smarty.const.KEYS_MSG2}
                </h3>
                <p class="context-section-description">{$smarty.const.KEYS_MSG5}</p>
                <form accept-charset="UTF-8" action="/keys/new/0" class="signup-form form-big" id="signup" method="post">

                    <div class="form-field three-up mobile">
                        <label class="inline" for="keys_keyid">{$smarty.const.KEYS_FORMS_ID}: ---</label>
                        <div class="input">
                            <input id="keys_keyid" name="keys_keyid" type="hidden" value="0" readonly>
                        </div>

                        <label class="inline" for="keys_keyhash">{$smarty.const.KEYS_FORMS_HASHID}: ---</label>
                        <div class="input">
                            <input id="keys_keyhash" name="keys_keyhash" type="hidden" value="0" readonly>
                        </div>
                        <label class="inline" for="keys_keyhash">{$smarty.const.KEYS_FORMS_FEED}</label>
                        <div class="input">
                            <select id="form-key-minimum-interval" name="keys_feedid">
                                <option value="" >Select Feed</option>
                                {foreach item="feed" from=$userfeeds}
                                    <option value="{$feed.feedid}" >{$feed.name}</option>
                                {/foreach}
                            </select>
                        </div>
                        <label class="inline" for="keys_label">{$smarty.const.KEYS_FORMS_LABEL}</label>
                        <div class="input">
                            <small class="inline form-label-aid">{$smarty.const.SIGNUP_FORMS_USERNAME_DESC}</small>
                            <input class="seven" id="keys_label" name="keys_label" value="{$key.label}" placeholder="Key label" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                        </div>

                        <label class="inline" for="keys_perms">{$smarty.const.KEYS_FORMS_PERMS}</label>
                        <div class="input">
                            <select id="form-key-minimum-interval" name="keys_perms">
                                <option value="1" >{$smarty.const.KEYS_FORMS_PERMS_1}</option>
                                <option value="2" >{$smarty.const.KEYS_FORMS_PERMS_2}</option>
                                <option value="3" >{$smarty.const.KEYS_FORMS_PERMS_3}</option>
                                <option value="4" selected >{$smarty.const.KEYS_FORMS_PERMS_4}</option>
                            </select>
                        </div>

                        <label class="inline" for="push_keys_sourceip">{$smarty.const.KEYS_FORMS_PUSH_IP}</label>
                        <div class="input">
                            <small class="inline form-label-aid">{$smarty.const.KEYS_FORMS_PULL_IP_DESC}</small>
                            <input id="push_keys_sourceip" name="push_keys_sourceip" type="text" value="ALL">
                        </div>

                        <label class="inline" for="pull_keys_sourceip">{$smarty.const.KEYS_FORMS_PULL_IP}</label>
                        <div class="input">
                            <small class="inline form-label-aid">{$smarty.const.KEYS_FORMS_PULL_IP_DESC}</small>
                            <input id="pull_keys_sourceip" name="pull_keys_sourceip" type="text" value="ALL">
                        </div>

                        <label class="inline" for="execute_keys_sourceip">{$smarty.const.KEYS_FORMS_EXECUTE_IP}</label>
                        <div class="input">
                            <small class="inline form-label-aid">{$smarty.const.KEYS_FORMS_EXECUTE_IP_DESC}</small>
                            <input id="execute_keys_sourceip" name="execute_keys_sourceip" type="text" value="ALL">
                        </div>

                        <label class="inline" for="keys_perms">{$smarty.const.KEYS_FORMS_ACTIVE}</label>
                        <div class="checkbox">
                            <input id="keyid" name="keys_active" type="checkbox" value="1" >
                            <small class="inline form-label-aid">{$smarty.const.KEYS_FORMS_ACTIVE_DESC}</small>
                        </div>

                    </div>

                    <div class="form-actions form-actions-big">
                        <button class="form-action-save button large" type="submit" name="submit" value="{$smarty.const.FORMS_KEYS_CREATE}">
                            <i class="button-icon icon-checkmark"></i> {$smarty.const.FEEDS_FORMS_SUBMIT}
                        </button>
                    </div>

                </form>
            </div>
            <!--- New Key End -->

        {elseif $keys_edit}
            <!--- Edit Key Feed -->
            <div class="page-header">
                {foreach item="key" from=$feedKey}
                    <h3 class="context-section-title">  
                        <i class="context-section-icon icon-key"></i>
                        {$smarty.const.KEYS_MSG4}: {$key.label}
                    </h3>
                    <p class="context-section-description">{$smarty.const.KEYS_MSG6}</p>
                    <form accept-charset="UTF-8" action="/keys/edit/{$key.keyid}" class="signup-form form-big" id="signup" method="post">

                        <div class="form-field three-up mobile">
                            <label class="inline" for="keys_keyid">{$smarty.const.KEYS_FORMS_ID}: {$key.keyid}</label>
                            <div class="input">
                                <input id="keys_keyid" name="keys_keyid" type="hidden" value="{$key.keyid}" readonly>
                            </div>

                            <label class="inline" for="keys_keyhash">{$smarty.const.KEYS_FORMS_HASHID}: {$key.keyhash}</label>
                            <div class="input">
                                <input id="keys_keyhash" name="keys_keyhash" type="hidden" value="{$key.keyhash}" readonly>
                            </div>

                            <label class="inline" for="keys_feedid">{$smarty.const.KEYS_FORMS_FEED2} {$key.feed_name}</label>
                            <div class="input">
                                <input id="keys_keyhash" name="keys_feedid" type="hidden" value="{$key.feedid}" readonly>
                            </div>

                            <label class="inline" for="keys_label">{$smarty.const.KEYS_FORMS_LABEL}</label>
                            <div class="input">
                                <small class="inline form-label-aid">{$smarty.const.SIGNUP_FORMS_USERNAME_DESC}</small>
                                <input class="seven" id="keys_label" name="keys_label" value="{$key.label}" placeholder="Key label" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                            </div>

                            <label class="inline" for="keys_perms">{$smarty.const.KEYS_FORMS_PERMS}</label>
                            <div class="input">
                                <select id="form-key-minimum-interval" name="keys_perms">
                                    <option value="1" {if $key.perms == 1} selected {/if}>{$smarty.const.KEYS_FORMS_PERMS_2}</option>
                                    <option value="2" {if $key.perms == 2} selected {/if}>{$smarty.const.KEYS_FORMS_PERMS_1}</option>
                                    <option value="3" {if $key.perms == 3} selected {/if}>{$smarty.const.KEYS_FORMS_PERMS_3}</option>
                                    <option value="4" {if $key.perms == 4} selected {/if}>{$smarty.const.KEYS_FORMS_PERMS_4}</option>
                                </select>
                            </div>

                            <label class="inline" for="push_keys_sourceip">{$smarty.const.KEYS_FORMS_PUSH_IP}</label>
                            <div class="input">
                                <small class="inline form-label-aid">{$smarty.const.KEYS_FORMS_PUSH_IP_DESC}</small>
                                <input id="push_keys_sourceip" name="push_keys_sourceip" type="text" value="{$key.push_source_ip}">
                            </div>

                            <label class="inline" for="pull_keys_sourceip">{$smarty.const.KEYS_FORMS_PULL_IP}</label>
                            <div class="input">
                                <small class="inline form-label-aid">{$smarty.const.KEYS_FORMS_PULL_IP_DESC}</small>
                                <input id="pull_keys_sourceip" name="pull_keys_sourceip" type="text" value="{$key.pull_source_ip}">
                            </div>

                            <label class="inline" for="execute_keys_sourceip">{$smarty.const.KEYS_FORMS_EXECUTE_IP}</label>
                            <div class="input">
                                <small class="inline form-label-aid">{$smarty.const.KEYS_FORMS_EXECUTE_IP_DESC}</small>
                                <input id="execute_keys_sourceip" name="execute_keys_sourceip" type="text" value="{$key.execute_source_ip}">
                            </div>


                            <label class="inline" for="keys_perms">{$smarty.const.KEYS_FORMS_ACTIVE}</label>
                            <div class="checkbox">
                                <input id="keyid" name="keys_active" type="checkbox" value="1" {if $key.active == 0} checked {/if}>
                                <small class="inline form-label-aid">{$smarty.const.KEYS_FORMS_ACTIVE_DESC}</small>
                            </div>

                        </div>

                        <div class="form-actions form-actions-big">
                            <button class="form-action-save button large" type="submit" name="submit" value="{$smarty.const.FORMS_KEYS_UPDATE}">
                                <i class="button-icon icon-checkmark"></i> {$smarty.const.FEEDS_FORMS_SUBMIT}
                            </button>
                        </div>

                    </form>
                {/foreach}

            </div>
            <!--- Edit Key End-->
        {else}
            <!--- Keys -->
            <div class="page-header">
                <h3 class="context-section-title">  <i class="context-section-icon icon-key"></i>
                    {$smarty.const.KEYS}
                </h3>
                <p class="context-section-description">{$smarty.const.KEYS_MSG1}</p>


                <ul class="context-tiles block-grid three-up mobile">
                    <li class="context-tile">
                        <a class="context-tile-add tile tile-dashed icon-plus" href="{$smarty.const.SITE_URL}keys/new/0">{$smarty.const.KEYS_MSG2}</a>
                    </li>
                </ul>
            </div>


            <div class="legacy-feeds context-section row">
                <div class="twelve columns">
                    <div class="context-section no-icon">
                        <h3 class="context-section-title">{$smarty.const.KEYS}</h3>
                        <p class="context-section-description">Total Keys: {$number_of_feedskeys_per_user}</p>
                    </div>

                    <div class="legacy-feeds">
                        <table class="legacy-feeds-table table-unstyled twelve">
                            <thead>
                                <tr>
                                    <th class="legacy-feed-header-name">{$smarty.const.KEYS_LABEL}</th>
                                    <th class="legacy-feed-header-name">{$smarty.const.KEYS_FEED_NAME}</th>
                                    <th class="legacy-feed-header-name">{$smarty.const.KEYS_ID}</th>
                                    <th class="legacy-feed-header-updated">{$smarty.const.KEYS_LAST_UPDATE}</th>
                                    <th class="legacy-feed-header-updated">{$smarty.const.KEYS_ACTION}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {foreach item="key" from=$feedskeys}
                                    <tr {if $key.active == 0} style="text-decoration:line-through" {/if}>
                                        <td class="legacy-feed-name five"><a href="{$smarty.const.SITE_URL}keys/edit/{$key.keyid}">{$key.label}</a></td>
                                        <td class="legacy-feed-name three">{$key.feed_name}</td>
                                        <td class="legacy-feed-name two">{$key.keyhash}</td>
                                        <td class="legacy-feed-updated">{$key.last_update}</td>
                                        <td class="legacy-feed-name three">
                                            <a href="{$smarty.const.SITE_URL}keys/edit/{$key.keyid}">{$smarty.const.KEYS_EDIT}</a>
                                            <a href="{$smarty.const.SITE_URL}keys/delete/{$key.keyid}">{$smarty.const.KEYS_DELETE}</a>
                                            {if $key.active == 1}
                                                <a href="{$smarty.const.SITE_URL}keys/deactivate/{$key.keyid}">{$smarty.const.KEYS_DEACTIVATE}</a>
                                            {else}
                                                <a href="{$smarty.const.SITE_URL}keys/activate/{$key.keyid}">{$smarty.const.KEYS_ACTIVATE}</a>
                                            {/if}
                                        </td>
                                    </tr>
                                {/foreach}
                            </tbody>
                        </table>

                    </div>
                </div>

                <!--- Keys End -->
            {/if}

        </div>
    </div>
</section>


</div>
{include file="../`$smarty.const.TEMPLATE_DIR`/footer.tpl"}
