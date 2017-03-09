{include file="../`$smarty.const.TEMPLATE_DIR`/header.tpl"}

<section role="main" class="app-main">
    <div class="app-main-inner">

        <!--- Edit Profile -->
        <div class="page-header">
            <h3 class="context-section-title">  
                <i class="context-section-icon icon-embed"></i>
                {$smarty.const.PROFILE_MSG1}
            </h3>
            <p class="context-section-description">{$smarty.const.PROFILE_MSG2}</p>
            <form accept-charset="UTF-8" action="/profile" class="profile-form form-big" id="profile" method="post">

                <div class="form-field three-up mobile">
                    <label class="inline" for="user_uid">{$smarty.const.PROFILE_FORMS_ID}: {$user.uid} - {$smarty.const.PROFILE_REG_DATE}: {$user.reg_date} - {$smarty.const.PROFILE_LAST_ACTIVE}: {$user.last_active}</label>
                    <div class="input">
                        <input id="user_uid" name="user_uid" type="hidden" value="{$user.uid}" readonly>
                    </div>

                    <label class="inline" for="user_pass">{$smarty.const.PROFILE_FORMS_PASS}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.PROFILE_FORMS_PASS_DESC}</small>
                        <input class="seven" id="user_pass" name="user_pass" value="{$user.pass}" placeholder="Password" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>

                    <label class="inline" for="user_email">{$smarty.const.PROFILE_FORMS_EMAIL}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.PROFILE_FORMS_EMAIL_DESC}</small>
                        <input class="seven" id="user_email" name="user_email" value="{$user.email}" placeholder="email@server.com" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>

                    <label class="inline" for="user_fname">{$smarty.const.PROFILE_FORMS_FNAME}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.PROFILE_FORMS_FNAME_DESC}</small>
                        <input class="seven" id="user_fname" name="user_fname" value="{$user.fname}" placeholder="First name" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>

                    <label class="inline" for="user_lname">{$smarty.const.PROFILE_FORMS_LNAME}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.PROFILE_FORMS_LNAME_DESC}</small>
                        <input class="seven" id="user_lname" name="user_lname" value="{$user.lname}" placeholder="Last name" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>

                    <label class="inline" for="user_phone">{$smarty.const.PROFILE_FORMS_PHONE}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.PROFILE_FORMS_PHONE_DESC}</small>
                        <input class="seven" id="user_phone" name="user_phone" value="{$user.phone}" placeholder="001234567890" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>

                    <label class="inline" for="user_address">{$smarty.const.PROFILE_FORMS_ADDRESS}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.PROFILE_FORMS_ADDRESS_DESC}</small>
                        <input class="seven" id="user_address" name="user_address" value="{$user.address}" placeholder="bul. Andrey Lyapchev, N: 1" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>

                    <label class="inline" for="user_city">{$smarty.const.PROFILE_FORMS_CITY}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.PROFILE_FORMS_CITY_DESC}</small>
                        <input class="seven" id="user_city" name="user_city" value="{$user.city}" placeholder="Sofia" size="120" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>

                    <label class="inline" for="user_notes">{$smarty.const.PROFILE_FORMS_NOTES}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.PROFILE_FORMS_NOTES_DESC}</small>
                        <input class="seven" id="user_notes" name="user_notes" value="{$user.notes}" placeholder="Some user notes" size="240" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>

                    <label class="inline" for="user_image">{$smarty.const.PROFILE_FORMS_IMAGE}</label>
                    <div class="input">
                        <small class="inline form-label-aid">{$smarty.const.PROFILE_FORMS_IMAGE_DESC}</small>
                        <input class="seven" id="user_image" name="user_image" value="{$user.image}" placeholder="URL image" size="240" {literal} validate="{:presence=&gt;true}" {/literal} type="text">
                    </div>

                </div>

                <div class="form-actions form-actions-big">
                    <button class="form-action-save button large" type="submit" name="submit" value="UPDATE">
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
