{include file="../`$smarty.const.TEMPLATE_DIR`/header-login.tpl"}

<section class="app-main" role="main">
    <div class="app-main-inner">

        <div class="page-header">
            <h3 class="context-section-title">  <i class="context-section-icon icon-user"></i>{$smarty.const.FORMS_LOGIN}</h3>
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

        <form accept-charset="UTF-8" action="/login/login" class="login-form form-big" id="login-form" method="post">
            <div style="margin:0;padding:0;display:inline">
                <input name="utf8" value="✓" type="hidden">
                <input name="authenticity_token" value="ktYy+Q+tHSLPCVqoPMn2xhvp3i99rB8Gg33JyBt9KSo=" type="hidden">
            </div>
            <div class="form-field">

                <label class="inline" for="login">{$smarty.const.FORMS_LOGIN}</label>
                <input autofocus="autofocus" class="seven" id="login" name="user" placeholder="e.g. johndoe" type="text">

                <label class="inline" for="password">{$smarty.const.FORMS_PASSWORD}</label>
                <input class="seven" id="password" name="pass" value="" type="password">

                <small class="form-input-aid"><a href="login.php?forgot_password=1">{$smarty.const.FORMS_FORGOT_PASSWORD}</a></small>

                <p class="accessory-copy no-margin">{$smarty.const.FORMS_NO_ACCOUNT}<a href="signup.php">{$smarty.const.FORMS_SIGN_HERE}</a></p>
            </div>

            <div class="form-actions form-actions-big">
                <button class="form-action-save button large" name="submit" type="submit" value="{$smarty.const.FORMS_LOGIN}">
                    <i class="button-icon icon-checkmark"></i> {$smarty.const.FORMS_LOGIN}
                </button>
                <p class="form-action-accessory">
                    <label class="form-checkbox" for="user-remember">
                        <input checked="checked" id="user-remember" name="remember" type="checkbox">
                        <span class="checkbox"></span> {$smarty.const.REMEMBER_ME}
                    </label>
                </p>
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
