{include file="../`$smarty.const.TEMPLATE_DIR`/header-login.tpl"}

<section class="app-main" role="main">
    <div class="app-main-inner">

        <div class="page-header">
            <h3 class="context-section-title">  <i class="context-section-icon icon-user"></i> {$smarty.const.HEADER_NAV_LINK_SIGNUP}
            </h3>
            <p class="context-section-description"></p>
        </div>

        {literal}        
            <style type="text/css">
                .no-js #login-form {
                    display:none;
                }
                .no-js #signup {
                    display:none;
                }
                .no-js #get-started {
                    display:none;
                }
                .no-js .page-header{
                    display:none;
                }
                .ielt10 #get-started {
                    display:none;
                }
                .ielt10 .page-header {
                    display:none;
                }
                .js #js-warning {
                    display:none;
                }
                .iegt9 #ie-warning {
                    display:none;
                }
                .ielt10 #ie-warning {
                    padding-top:10px;
                }
                .ielt10 #login-form {
                    display:none;
                }
                .ielt10 #signup {
                    display:none;
                }
            </style>
        {/literal}


        <form accept-charset="UTF-8" action="/signup" class="signup-form form-big" id="signup" method="post">
            <div style="margin:0;padding:0;display:inline">
                <input name="utf8" value="✓" type="hidden"><input name="authenticity_token" value="Qs3NfIC/aKjojF3vay9obE8gpEVKuGixhcSCYSUj91w=" type="hidden">
            </div>
            <input id="context" name="context" type="hidden">
            <input id="user_originid" name="user[originid]" type="hidden">

            <div class="form-field">
                <label class="inline" for="user_login">{$smarty.const.SIGNUP_FORMS_USERNAME}</label><div class="input">
                    <small class="inline form-label-aid">{$smarty.const.SIGNUP_FORMS_USERNAME_DESC}</small>
                    {literal}
                        <input class="seven" id="user_login" name="user" placeholder="Username" size="30" validate="{:presence=&gt;true}" type="text">
                    </div>
                {/literal}
                <label class="inline" for="user_email">{$smarty.const.SIGNUP_FORMS_EMAIL}</label><div class="input">
                    {literal}
                        <input class="seven" id="user_email" name="email" placeholder="Email" size="30" validate="{:presence=&gt;true}" type="text"></div>
                    {/literal}
                <label class="inline" for="user_password">{$smarty.const.SIGNUP_FORMS_PASSWORD}</label>
                {literal}
                    <div class="input"><input class="seven" id="user_password" name="pass" placeholder="Password" size="30" validate="{:presence=&gt;true}" type="password"></div>  </div>
                    {/literal}

            <div class="form-actions form-actions-big">
                <button class="form-action-save button large" type="submit" name="submit" value="{$smarty.const.SIGNUP_FORMS_SIGNUP}"><i class="button-icon icon-checkmark"></i> {$smarty.const.HEADER_NAV_LINK_SIGNUP}</button>
                <p class="form-action-accessory">{$smarty.const.SIGNUP_FORMS_SIGN_DESC}<a href="/terms">{$smarty.const.TOS}</a></p>
            </div>
        </form>

        <div class="boxed-in" id="js-warning">
            <h4>Javascript Required</h4>
            <p class="lead">{$smarty.const.LOGIN_LEAD}</p>
            <p class="color-alert"><strong>{$smarty.const.LOGIN_COLOR_ALERT}</strong></p>
        </div>

        <div class="boxed-in" id="ie-warning">
            <h4>Internet Explorer</h4>
            <p class="lead">{$smarty.const.LOGIN_LEAD2}</p>
        </div>


    </div>
</section>

{include file="../`$smarty.const.TEMPLATE_DIR`/footer.tpl"}
