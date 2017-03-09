{include file="../`$smarty.const.TEMPLATE_DIR`/header.tpl"}

<section role="main" class="app-main">
    <div class="app-main-inner">

        <!--- Edit Profile -->
        <div class="page-header">
            <h3 class="context-section-title">  
                <i class="context-section-icon icon-embed"></i>
                {$smarty.const.SETTINGS_MSG1}
            </h3>
            <p class="context-section-description">{$smarty.const.SETTINGS_MSG2}</p>
            <form accept-charset="UTF-8" action="/settings" class="settings-form form-big" id="settings" method="post">

                <div class="form-field three-up mobile">
                    <label class="inline" for="settings_url">{$smarty.const.SETTINGS_FORMS_SITE}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_SITE_DESC}</small>
                        <input class="seven" id="settings_url" name="site_url" value="{$s.site_url}" placeholder="Site url" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>
                    <label class="inline" for="settings_vhost">{$smarty.const.SETTINGS_FORMS_VHOST}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_VHOST_DESC}</small>
                        <input class="seven" id="settings_vhost" name="site_vhost" value="{$s.site_vhost}" placeholder="Virtual host" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>
                    <label class="inline" for="settings_admin_name">{$smarty.const.SETTINGS_FORMS_ANAME}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_ANAME_DESC}</small>
                        <input class="seven" id="settings_admin_name" name="admin_name" value="{$s.admin_name}" placeholder="Admin name" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>
                    <label class="inline" for="settings_admin_email">{$smarty.const.SETTINGS_FORMS_AEMAIL}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_AEMAIL_DESC}</small>
                        <input class="seven" id="settings_admin_email" name="admin_email" value="{$s.admin_email}" placeholder="Admin email" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>
                    <label class="inline" for="settings_site_name">{$smarty.const.SETTINGS_FORMS_SITE_NAME}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_SITE_NAME_DESC}</small>
                        <input class="seven" id="settings_admin_email" name="site_name" value="{$s.site_name}" placeholder="Site name" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>
                    <label class="inline" for="settings_description">{$smarty.const.SETTINGS_FORMS_DESCRIPTION}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_DESCRIPTION_DESC}</small>
                        <input class="seven" id="settings_description" name="description" value="{$s.description}" placeholder="Description" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>
                    <label class="inline" for="settings_keywords">{$smarty.const.SETTINGS_FORMS_KEYWORDS}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_KEYWORDS_DESC}</small>
                        <input class="seven" id="settings_keywords" name="keywords" value="{$s.keywords}" placeholder="Keyword1, Keyword2, Keyword3" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>
                    <label class="inline" for="settings_site_lang">{$smarty.const.SETTINGS_FORMS_SITE_LANG}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_SITE_LANG_DESC}</small>
                        <input class="seven" id="settings_site_lang" name="site_lang" value="{$s.site_lang}" placeholder="Site language" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>
                    <label class="inline" for="settings_template">{$smarty.const.SETTINGS_FORMS_TEMPLATE}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_TEMPLATE_DESC}</small>
                        <input class="seven" id="settings_template" name="template" value="{$s.template}" placeholder="Site template" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>
                    <label class="inline" for="settings_users_delete_after_days">{$smarty.const.SETTINGS_FORMS_USERS_DELETE}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_USERS_DELETE_DESC}</small>
                        <input class="seven" id="settings_users_delete_after_days" name="users_delete_after_days" value="{$s.users_delete_after_days}" placeholder="Days" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>
                    <label class="inline" for="settings_email_after_days">{$smarty.const.SETTINGS_FORMS_EMAIL_DAYS}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_EMAIL_DAYS_DESC}</small>
                        <input class="seven" id="settings_email_after_days" name="email_after_days" value="{$s.email_after_days}" placeholder="Days" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>
                    <label class="inline" for="settings_google_code">{$smarty.const.SETTINGS_FORMS_GOOGLE_CODE}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_GOOGLE_CODE_DESC}</small>
                        <input class="seven" id="settings_google_code" name="google_code" value="{$s.google_code}" placeholder="Google webmaster tools code" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>
                    <label class="inline" for="settings_cron">{$smarty.const.SETTINGS_FORMS_CRON}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_CRON_DESC}</small>
                        <input class="seven" id="settings_cron" name="cron_access_key" value="{$s.cron_access_key}" placeholder="Cron key" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>
                    <label class="inline" for="settings_smtp">{$smarty.const.SETTINGS_FORMS_SMTP}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_SMTP_SERVER}</small>
                        <input class="seven" id="smtpserver" name="smtpserver" value="{$s.smtpserver}" placeholder="smtp_server.com" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_SMTP_PORT}</small>
                        <input class="seven" id="smtpport" name="smtpport" value="{$s.smtpport}" placeholder="smtp port" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_SMTP_USER}</small>
                        <input class="seven" id="smtpuser" name="smtpuser" value="{$s.smtpuser}" placeholder="smtp_user@domain.com" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_SMTP_PASS}</small>
                        <input class="seven" id="smtppass" name="smtppass" value="{$s.smtppass}" placeholder="smtp pass" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>
                    <label class="inline" for="settings_xmpp">{$smarty.const.SETTINGS_FORMS_XMPP}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_XMPP_SERVER}</small>
                        <input class="seven" id="xmppserver" name="xmppserver" value="{$s.xmppserver}" placeholder="xmpp_server.com" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_XMPP_PORT}</small>
                        <input class="seven" id="xmppport" name="xmppport" value="{$s.xmppport}" placeholder="xmpp port" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_XMPP_USER}</small>
                        <input class="seven" id="xmppuser" name="xmppuser" value="{$s.xmppuser}" placeholder="xmpp_user@domain.com" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_XMPP_PASS}</small>
                        <input class="seven" id="xmpppass" name="xmpppass" value="{$s.xmpppass}" placeholder="xmpp pass" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_XMPP_DOMAIN}</small>
                        <input class="seven" id="xmppdomain" name="xmppdomain" value="{$s.xmppdomain}" placeholder="xmpp_server_domain.com" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_XMPP_TEXT}</small>
                        <input class="seven" id="xmpptext" name="xmpptext" value="{$s.xmpptext}" placeholder="xmpp text" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>
                    <label class="inline" for="settings_xmpp">{$smarty.const.SETTINGS_FORMS_OTHERCRED}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_OTHERCRED_DESC}</small>
                        <input class="seven" id="other_credentials" name="other_credentials" value="{$s.other_credentials_escaped}" placeholder="In JSON format" size="600" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>
                    <label class="inline" for="settings_site_mode">{$smarty.const.SETTINGS_FORMS_SITE_MODE}</label>
                    <div class="checkbox">
                        <input id="settings_site_mode" name="site_mode" type="checkbox" value="1" {if $s.site_mode == 1} checked {/if}>
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_SITE_MODE_DESC}</small>
                    </div>
                    <label class="inline" for="settings_use_verify_email">{$smarty.const.SETTINGS_FORMS_USE_VERIFY_EMAIL}</label>
                    <div class="checkbox">
                        <input id="settings_use_verify_email" name="use_verify_email" type="checkbox" value="1" {if $s.use_verify_email == 1} checked {/if}>
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_USE_VERIFY_EMAIL_DESC}</small>
                    </div>
                    <label class="inline" for="settings_visitor_tracking">{$smarty.const.SETTINGS_FORMS_VISITOR_TRACK}</label>
                    <div class="checkbox">
                        <input id="settings_visitor_tracking" name="visitor_tracking" type="checkbox" value="1" {if $s.visitor_tracking == 1} checked {/if}>
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_VISITOR_TRACK_DESC}</small>
                    </div>
                    <label class="inline" for="settings_force_compiled_enabled">{$smarty.const.SETTINGS_FORMS_FORCE_COMPILE}</label>
                    <div class="checkbox">
                        <input id="settings_force_compiled_enabled" name="force_compile_enabled" type="checkbox" value="1" {if $s.force_compile_enabled == 1} checked {/if}>
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_FORCE_COMPILE_DESC}</small>
                    </div>
                    <label class="inline" for="settings_use_fancy_urls">{$smarty.const.SETTINGS_FORMS_FANCY}</label>
                    <div class="checkbox">
                        <input id="settings_use_fancy_urls" name="use_fancy_urls" type="checkbox" value="1" {if $s.use_fancy_urls == 1} checked {/if}>
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_FANCY_DESC}</small>
                    </div>
                    <label class="inline" for="settings_use_user_approval">{$smarty.const.SETTINGS_FORMS_USER_APPROVAL}</label>
                    <div class="checkbox">
                        <input id="settings_use_user_approval" name="use_user_approval" type="checkbox" value="1" {if $s.use_user_approval == 1} checked {/if}>
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_USER_APPROVAL_DESC}</small>
                    </div>
                    <label class="inline" for="settings_maint_mode">{$smarty.const.SETTINGS_FORMS_MAINT_MODE}</label>
                    <div class="checkbox">
                        <input id="settings_maint_mode" name="maint_mode" type="checkbox" value="1" {if $s.maint_mode == 1} checked {/if}>
                        <small class="inline form-label-aid">{$smarty.const.SETTINGS_FORMS_MAINT_MODE_DESC}</small>
                    </div>

                </div>

                <div class="form-actions form-actions-big">
                    <button class="form-action-save button large" type="submit" name="submit" value="{$smarty.const.SETTINGS_FORMS_UPDATE}">
                        <i class="button-icon icon-checkmark"></i> {$smarty.const.FEEDS_FORMS_SUBMIT}
                    </button>
                </div>

            </form>

        </div>
        <!--- Edit Profile End-->

    </div>
</div>
</section>


</div>
{include file="../`$smarty.const.TEMPLATE_DIR`/footer.tpl"}
