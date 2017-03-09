{include file="../`$smarty.const.TEMPLATE_DIR`/header.tpl"}

<section role="main" class="app-main">
    <div class="app-main-inner">

        {if $alarms_new}
            <!---New Alarm-->
            <div class="page-header">
                <h3 class="context-section-title">  
                    <i class="context-section-icon icon-embed"></i>
                    {$smarty.const.ALARMS_MSG2}
                </h3>
                <p class="context-section-description">{$smarty.const.ALARMS_MSG5}</p>
                <form accept-charset="UTF-8" action="/alarms/new/{$alarms_type}" class="signup-form form-big" id="signup" method="post">

                    <div class="form-field three-up mobile">
                        <div class="input">
                            <input id="alarms_type" name="alarms_type" type="hidden" value="{$alarms_type}" readonly>
                            <input id="alarms_faid" name="alarms_faid" type="hidden" value="nan" readonly>
                        </div>

                        <label class="inline" for="alarms_label">{$smarty.const.ALARMS_FORMS_NAME}</label>
                        <div class="input">
                            <input class="seven" id="alarms_label" name="alarms_label" value="{$alarm.label}" placeholder="Alarm label" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                            <input class="seven" id="alarms_description" name="alarms_description" value="{$alarm.description}" placeholder="Alarm description" size="1000" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                        </div>

                        <label class="inline" for="alarms_metric">{$smarty.const.ALARMS_FORMS_FEED}</label>
                        <div class="input">
                            <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_FEED_DESC}</small>
                            <select id="form-alarm-minimum-interval" name="alarms_metric">
                                <optgroup label="Sensors">
                                    {foreach item="sensor" from=$sensors}
                                        <option value="{$sensor.feedid}@{$sensor.feed}@{$sensor.deviceID}@{$sensor.device_name}@{$sensor.ObjectType}@{$sensor.Sensor}" >{$sensor.feedid}@{$sensor.feed}@{$sensor.deviceID}@{$sensor.device_name}@{$sensor.ObjectType}@{$sensor.Sensor}</option>
                                    {/foreach}
                                </optgroup>
                                <optgroup label="Methods">
                                    {foreach item="method" from=$methods}
                                        <option value="{$method.feedid}@{$method.feed}@{$method.deviceID}@{$method.device_name}@{$method.ObjectType}@{$method.Method}" >{$method.feedid}@{$method.feed}@{$method.deviceID}@{$method.device_name}@{$method.ObjectType}@{$method.Method}</option>
                                    {/foreach}
                                </optgroup>
                            </select>
                        </div>

                        <label class="inline" for="alarms_threshold">{$smarty.const.ALARMS_FORMS_THRESHOLD}</label>
                        <div class="input">
                            <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_NUMERIC}</small>
                            <input id="alarms_numeric" name="alarms_numeric" type="checkbox" value="1" checked>
                            <input id="alarms_threshold" name="alarms_threshold" type="text" value="">
                        </div>

                        <div class="input">
                            <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_SIGN_DESC}</small>
                            <select id="alarms_sign" name="alarms_sign">
                                <option value="2" >></option>
                                <option value="1" >=</option>
                                <option value="3" ><</option>
                                <option value="4" >!=</option>
                            </select>
                        </div>

                        <label class="inline" for="alarms_options">{$smarty.const.ALARMS_FORMS_OPTIONS}</label>
                        <div class="checkbox">
                            <input id="alarms_logging" name="alarms_logging" type="checkbox" value="1" >
                            <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_LOGGING}</small>
                            <input id="alarms_active" name="alarms_active" type="checkbox" value="1" checked>
                            <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_ACTIVE}</small>
                        </div>
                        <label class="inline" for="alarms_options">{$smarty.const.ALARMS_FORMS_RESET}</label>
                        <div class="input">
                            <input id="alarms_reset" name="alarms_reset" type="checkbox" value="1">
                            <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_RESET_DESC}</small>
                        </div>
                        {if $alarms_type == 2 }
                            <hr />	
                            <!-- Alarm type specific fields -->
                            <label class="inline" for="alarms_timetoalarm">{$smarty.const.ALARMS_FORMS_TIMETOALARM}</label>
                            <div class="input">
                                <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_TIMETOALARM_DESC}</small>
                                <input id="alarms_timetoalarm" name="alarms_timetoalarm" type="text" value="900">
                            </div>

                        {elseif $alarms_type == 3 }
                            <hr />	
                            <!-- Alarm type specific fields -->
                            <label class="inline" for="alarms_counttoalarm">{$smarty.const.ALARMS_FORMS_COUNTTOALARM}</label>
                            <div class="input">
                                <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_COUNTTOALARM_DESC}</small>
                                <input id="alarms_counttoalarm" name="alarms_counttoalarm" type="text" value="3">
                            </div>


                        {/if}
                        <hr />	
                        <!-- Notification fields -->
                        <label class="inline" for="alarms_notiftype">{$smarty.const.ALARMS_FORMS_NOTIFICATION_TYPE}</label>
                        <div class="input">
                            <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_NOTIFICATION_TYPE_DESC}</small>
                            <select id="alarms_notiftype" name="alarms_notiftype">
                                <option value="0" >None</option>
                                <option value="1" >EMAIL</option>
                                <option value="2" >XMPP</option>
                            </select>
                        </div>

                        <div class="input">
                            <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_NOTIFICATION_ADDRESS_DESC}</small>
                            <input class="seven" id="alarms_notifaddress" name="alarms_notifaddress" value="" placeholder="email@email.com/http://xmpp.bg?id=1" size="250" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                        </div>

                        <hr />	
                        <!-- Action execution fields -->
                        <label class="inline" for="alarms_actiontype">{$smarty.const.ALARMS_FORMS_ACTION_TYPE}</label>
                        <div class="input">
                            <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_ACTION_TYPE_DESC}</small>
                            <select id="alarms_actiontype" name="alarms_actiontype">
                                <option value="0" >None</option>
                                <option value="1" >URL</option>
                                <option value="2" >Local script</option>
                            </select>
                        </div>

                        <div class="input">
                            <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_ACTION_ADDRESS_DESC}</small>
                            <input class="seven" id="alarms_actionpath" name="alarms_actionpath" value="" placeholder="URL path/Script path" size="250" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                            <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_ACTION_VALUE_DESC}</small>
                            <input class="seven" id="alarms_actionvalue" name="alarms_actionvalue" value="" placeholder="URL value/Script value" size="250" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                        </div>

                        <label class="inline" for="alarms_user">{$smarty.const.ALARMS_FORMS_CREDENTIALS}</label>
                        <div class="input">
                            <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_USER_DESC}</small>
                            <input id="alarms_user" name="alarms_user" type="text" value="">
                            <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_PASS_DESC}</small>
                            <input id="alarms_pass" name="alarms_pass" type="text" value="">
                        </div>
                    </div>

                    <div class="form-actions form-actions-big">
                        <button class="form-action-save button large" type="submit" name="submit" value="{$smarty.const.FORMS_ALARMS_CREATE}">
                            <i class="button-icon icon-checkmark"></i> {$smarty.const.FEEDS_FORMS_SUBMIT}
                        </button>
                    </div>

                </form>
            </div>
            <!--- New Alarm End -->

        {elseif $alarms_edit}
            <!--- Edit Alarm Feed -->
            <div class="page-header">
                {foreach item="alarm" from=$userAlarm}
                    <h3 class="context-section-title">  
                        <i class="context-section-icon icon-embed"></i>
                        {$smarty.const.ALARMS_MSG4}: {$alarm.name}
                    </h3>
                    <p class="context-section-description">{$smarty.const.ALARMS_MSG6}</p>
                    <form accept-charset="UTF-8" action="/alarms/edit/{$alarm.faid}" class="signup-form form-big" id="signup" method="post">
                        <div class="form-field three-up mobile">
                            <div class="input">
                                <input id="alarms_type" name="alarms_type" type="hidden" value="{$alarm.atid}" readonly>
                                <input id="alarms_faid" name="alarms_faid" type="hidden" value="{$alarm.faid}" readonly>
                            </div>

                            <label class="inline" for="alarms_label">{$smarty.const.ALARMS_FORMS_NAME}</label>
                            <div class="input">
                                <input class="seven" id="alarms_label" name="alarms_label" value="{$alarm.name}" placeholder="Alarm label" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                                <input class="seven" id="alarms_description" name="alarms_description" value="{$alarm.description}" placeholder="Alarm description" size="1000" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                            </div>

                            <label class="inline" for="alarms_metric">{$smarty.const.ALARMS_FORMS_FEED}</label>
                            <div class="input">
                                <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_FEED_DESC}</small>
                                <select id="form-alarm-minimum-interval" name="alarms_metric">
                                    <option value="{$alarm.metric}">{$alarm.metric}</option>
                                    <optgroup label="Sensors">
                                        {foreach item="sensor" from=$sensors}
                                            <option value="{$sensor.feedid}@{$sensor.feed}@{$sensor.deviceID}@{$sensor.device_name}@{$sensor.ObjectType}@{$sensor.Sensor}">{$sensor.feedid}@{$sensor.feed}@{$sensor.deviceID}@{$sensor.device_name}@{$sensor.ObjectType}@{$sensor.Sensor}</option>
                                        {/foreach}
                                    </optgroup>
                                    <optgroup label="Methods">
                                        {foreach item="method" from=$methods}
                                            <option value="{$method.feedid}@{$method.feed}@{$method.deviceID}@{$method.device_name}@{$method.ObjectType}@{$method.Method}" >{$method.feedid}@{$method.feed}@{$method.deviceID}@{$method.device_name}@{$method.ObjectType}@{$method.Method}</option>
                                        {/foreach}
                                    </optgroup>
                                </select>
                            </div>

                            <label class="inline" for="alarms_threshold">{$smarty.const.ALARMS_FORMS_THRESHOLD}</label>
                            <div class="input">
                                <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_NUMERIC}</small>
                                <input id="alarms_numeric" name="alarms_numeric" type="checkbox" value="1" {if $alarm.numeric == 1} checked {/if}>
                                <input id="alarms_threshold" name="alarms_threshold" type="text" value="{$alarm.threshold}">
                            </div>

                            <div class="input">
                                <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_SIGN_DESC}</small>
                                <select id="alarms_sign" name="alarms_sign">
                                    <option value="2" {if $alarm.asid == 2} selected {/if}>></option>
                                    <option value="1" {if $alarm.asid == 1} selected {/if} >=</option>
                                    <option value="3" {if $alarm.asid == 3} selected {/if}><</option>
                                    <option value="4" {if $alarm.asid == 4} selected {/if}>!=</option>
                                </select>
                            </div>

                            <label class="inline" for="alarms_options">{$smarty.const.ALARMS_FORMS_OPTIONS}</label>
                            <div class="checkbox">
                                <input id="alarms_logging" name="alarms_logging" type="checkbox" value="1" {if $alarm.logging == 1} checked {/if}>
                                <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_LOGGING}</small>
                                <input id="alarms_active" name="alarms_active" type="checkbox" value="1" {if $alarm.active == 1} checked {/if}>
                                <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_ACTIVE}</small>
                            </div>
                            <label class="inline" for="alarms_options">{$smarty.const.ALARMS_FORMS_RESET}</label>
                            <div class="input">
                                <input id="alarms_reset" name="alarms_reset" type="checkbox" value="1" {if $alarm.reset == 1} checked {/if}>
                                <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_RESET_DESC}</small>
                            </div>
                            {if $alarm.atid == 2 }
                                <hr />	
                                <!-- Alarm type specific fields -->
                                <label class="inline" for="alarms_timetoalarm">{$smarty.const.ALARMS_FORMS_TIMETOALARM}</label>
                                <div class="input">
                                    <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_TIMETOALARM_DESC}</small>
                                    <input id="alarms_timetoalarm" name="alarms_timetoalarm" type="text" value="{$alarm.timetoalarm}">
                                </div>

                            {elseif $alarm.atid == 3 }
                                <hr />	
                                <!-- Alarm type specific fields -->
                                <label class="inline" for="alarms_counttoalarm">{$smarty.const.ALARMS_FORMS_COUNTTOALARM}</label>
                                <div class="input">
                                    <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_COUNTTOALARM_DESC}</small>
                                    <input id="alarms_counttoalarm" name="alarms_counttoalarm" type="text" value="{$alarm.counttoalarm}">
                                </div>


                            {/if}
                            <hr />	
                            <!-- Notification fields -->
                            <label class="inline" for="alarms_notiftype">{$smarty.const.ALARMS_FORMS_NOTIFICATION_TYPE}</label>
                            <div class="input">
                                <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_NOTIFICATION_TYPE_DESC}</small>
                                <select id="alarms_notiftype" name="alarms_notiftype">
                                    <option value="0" {if $alarm.notiftype == 0} selected {/if}>None</option>
                                    <option value="1" {if $alarm.notiftype == 1} selected {/if}>EMAIL</option>
                                    <option value="2" {if $alarm.notiftype == 2} selected {/if}>XMPP</option>
                                </select>
                            </div>

                            <div class="input">
                                <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_NOTIFICATION_ADDRESS_DESC}</small>
                                <input class="seven" id="alarms_notifaddress" name="alarms_notifaddress" value="{$alarm.notifaddress}" placeholder="email@email.com/http://xmpp.bg?id=1" size="250" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                            </div>

                            <hr />	
                            <!-- Action execution fields -->
                            <label class="inline" for="alarms_actiontype">{$smarty.const.ALARMS_FORMS_ACTION_TYPE}</label>
                            <div class="input">
                                <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_ACTION_TYPE_DESC}</small>
                                <select id="alarms_actiontype" name="alarms_actiontype">
                                    <option value="0" {if $alarm.actiontype == 0} selected {/if}>None</option>
                                    <option value="1" {if $alarm.actiontype == 1} selected {/if}>URL</option>
                                    <option value="2" {if $alarm.actiontype == 2} selected {/if}>Local script</option>
                                </select>
                            </div>

                            <div class="input">
                                <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_ACTION_ADDRESS_DESC}</small>
                                <input class="seven" id="alarms_actionpath" name="alarms_actionpath" value="{$alarm.actionpath}" placeholder="URL path/Script path" size="250" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                                <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_ACTION_VALUE_DESC}</small>
                                <input class="seven" id="alarms_actionvalue" name="alarms_actionvalue" value="{$alarm.actionvalue}" placeholder="URL value/Script value" size="250" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                            </div>

                            <label class="inline" for="alarms_user">{$smarty.const.ALARMS_FORMS_CREDENTIALS}</label>
                            <div class="input">
                                <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_USER_DESC}</small>
                                <input id="alarms_user" name="alarms_user" type="text" value="{$alarm.actionuser}">
                                <small class="inline form-label-aid">{$smarty.const.ALARMS_FORMS_PASS_DESC}</small>
                                <input id="alarms_pass" name="alarms_pass" type="text" value="{$alarm.actiopass}">
                            </div>
                        </div>

                        <div class="form-actions form-actions-big">
                            <button class="form-action-save button large" type="submit" name="submit" value="{$smarty.const.FORMS_ALARMS_UPDATE}">
                                <i class="button-icon icon-checkmark"></i> {$smarty.const.FEEDS_FORMS_SUBMIT}
                            </button>
                        </div>



                    </form>
                {/foreach}

            </div>
            <!--- Edit Alarm End-->
        {elseif ($alarmsActions_logs or $alarmsNotifications_logs)}
            <!--- Logs Alarms -->
            <div class="page-header">
                <h3 class="context-section-title">  <i class="context-section-icon icon-embed"></i>
                    {$smarty.const.ALARMS_LOGMSG1}
                </h3>
                <p class="context-section-description">{$smarty.const.ALARMS_LOGMSG2}</p>

            </div>

            <div class="legacy-alarms context-section row">
                <div class="twelve columns">

                    <div class="legacy-alarms">
                        <table class="legacy-alarms-table table-unstyled twelve">
                            <thead>
                                <tr>
                                    <th class="legacy-alarm-header-name">{$smarty.const.ALARMS_LOGID}</th>
                                    <th class="legacy-alarm-header-name two">{$smarty.const.ALARMS_ADDRESS}</th>
                                    <th class="legacy-alarm-header-name">{$smarty.const.ALARMS_TYPE}</th>
                                    <th class="legacy-alarm-header-name two">{$smarty.const.ALARMS_SUBJECT}</th>
                                    <th class="legacy-alarm-header-name five">{$smarty.const.ALARMS_MESSAGE}</th>
                                    <th class="legacy-alarm-header-updated">{$smarty.const.ALARMS_LOGDATE}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {foreach item="log" from=$alarmsNotificationsLogs}
                                    <tr>
                                        <td class="legacy-alarm-name">{$log.id}</a></td>
                                        <td class="legacy-alarm-name two">{$log.address}</td>
                                        <td class="legacy-alarm-name">{$log.type}</td>
                                        <td class="legacy-alarm-name two">{$log.subject}</td>
                                        <td class="legacy-alarm-name five">{$log.message}</td>
                                        <td class="legacy-alarm-updated">{$log.last_update}</td>
                                    </tr>
                                {/foreach}
                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="legacy-alarms context-section row">
                    <div class="twelve columns">

                        <div class="legacy-alarms">
                            <table class="legacy-alarms-table table-unstyled twelve">
                                <thead>
                                    <tr>
                                        <th class="legacy-alarm-header-name">{$smarty.const.ALARMS_LOGID}</th>
                                        <th class="legacy-alarm-header-name five">{$smarty.const.ALARMS_PATH}</th>
                                        <th class="legacy-alarm-header-name five">{$smarty.const.ALARMS_ANSWER}</th>
                                        <th class="legacy-alarm-header-updated">{$smarty.const.ALARMS_LOGDATE}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {foreach item="log" from=$alarmsActionsLogs}
                                        <tr>
                                            <td class="legacy-alarm-name">{$log.id}</a></td>
                                            <td class="legacy-alarm-name five">{$log.path}</td>
                                            <td class="legacy-alarm-name five">{$log.answer}</td>
                                            <td class="legacy-alarm-updated">{$log.last_update}</td>
                                        </tr>
                                    {/foreach}
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <!--- Logs Feed End-->
                {else}
                    <!--- Alarms -->
                    <div class="page-header">
                        <h3 class="context-section-title">  <i class="context-section-icon icon-embed"></i>{$smarty.const.ALARMS}</h3>
                        <p class="context-section-description">{$smarty.const.ALARMS_MSG1}</p>


                        <ul class="context-tiles block-grid three-up mobile">
                            {foreach item="alarm" from=$alarmtypes}
                                <li class="context-tile">
                                    <p class="context-section-description">{$alarm.description}</p>
                                    <a class="context-tile-add tile tile-dashed icon-plus" href="{$smarty.const.SITE_URL}alarms/new/{$alarm.atid}">{$smarty.const.ALARMS_MSG2} - {$alarm.name}</a>
                                </li>
                            {/foreach}
                        </ul>
                    </div>


                    <div class="legacy-alarms context-section row">
                        <div class="twelve columns">
                            <div class="context-section no-icon">
                                <h3 class="context-section-title">{$smarty.const.ALARMS}</h3>
                                <p class="context-section-description">Total Alarms: {$number_of_alarms_per_user}</p>
                            </div>

                            <div class="legacy-alarms">
                                <table class="legacy-alarms-table table-unstyled twelve">
                                    <thead>
                                        <tr>
                                            <th class="legacy-alarm-header-name">{$smarty.const.ALARMS_ID}</th>
                                            <th class="legacy-alarm-header-name">{$smarty.const.ALARMS_TYPE}</th>
                                            <th class="legacy-alarm-header-name">{$smarty.const.ALARMS_TITLE}</th>
                                            <th class="legacy-alarm-header-updated">{$smarty.const.ALARMS_LAST_UPDATE}</th>
                                            <th class="legacy-alarm-header-updated">{$smarty.const.ALARMS_ACTION}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {foreach item="alarm" from=$useralarms}
                                            <tr {if $alarm.active == 0} style="text-decoration:line-through" {/if}>
                                                <td class="legacy-alarm-name one"><a href="{$smarty.const.SITE_URL}alarms/edit/{$alarm.faid}">{$alarm.faid}</a></td>
                                                <td class="legacy-alarm-name one">{$alarm.type}</td>
                                                <td class="legacy-alarm-name nine">{$alarm.name}</td>
                                                <td class="legacy-alarm-updated">{$alarm.last_update}</td>
                                                <td class="legacy-alarm-name">
                                                    <a href="{$smarty.const.SITE_URL}alarms/edit/{$alarm.faid}">{$smarty.const.ALARMS_EDIT}</a>
                                                    <a href="{$smarty.const.SITE_URL}alarms/delete/{$alarm.faid}">{$smarty.const.ALARMS_DELETE}</a>
                                                    {if $alarm.active == 1}
                                                        <a href="{$smarty.const.SITE_URL}alarms/deactivate/{$alarm.faid}">{$smarty.const.ALARMS_DEACTIVATE}</a>
                                                    {else}
                                                        <a href="{$smarty.const.SITE_URL}alarms/activate/{$alarm.faid}">{$smarty.const.ALARMS_ACTIVATE}</a>
                                                    {/if}
                                                    {if $alarm.logging == 1}
                                                        <a href="{$smarty.const.SITE_URL}alarms/log/{$alarm.faid}">{$smarty.const.ALARMS_LOG}</a>
                                                    {/if}
                                                </td>
                                            </tr>
                                        {/foreach}
                                    </tbody>
                                </table>

                            </div>
                        </div>

                        <!--- Alarms End -->
                    {/if}

                </div>
            </div>
            </section>


        </div>
        {include file="../`$smarty.const.TEMPLATE_DIR`/footer.tpl"}
