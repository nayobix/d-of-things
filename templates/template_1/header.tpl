<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 ielt10 ielt9 ielt8 ielt7 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 ielt10 ielt9 ielt8 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 ielt10 ielt9 lt-ie9 oldie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9 ielt10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->

<html style="" class="iegt9 js no-touch svg inlinesvg svgclippaths no-ie8compat wf-proximanova-n4-inactive wf-proximanova-n7-inactive wf-proximanova-i4-inactive wf-proximanova-i7-inactive wf-proximanova-n3-inactive wf-inactive" lang="{$smarty.const.SITE_LANGUAGE}">
    <!--<![endif]-->
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="application-name" content="i-of-Thnigs">
        <meta name="description" content="{$smarty.const.DESCRIPTION}">
        <meta name="keywords" content="{$smarty.const.KEYWORDS}">

        <title>{$smarty.const.HEADER_WELCOME_MESSAGE}</title>

        <meta name="google-site-verification" content="{$smarty.const.GOOGLE_SITE_VERIFICATION}" />

        {if !$dashboards_visualize}
            <link rel="stylesheet" href="{$smarty.const.SITE_URL}templates/{$smarty.const.TEMPLATE_DIR}/dofthings_files/login-style.css">
            <link rel="stylesheet" href="{$smarty.const.SITE_URL}templates/{$smarty.const.TEMPLATE_DIR}/dofthings_files/style.css">
        {else}
            <link rel="stylesheet" href="{$smarty.const.SITE_URL}templates/{$smarty.const.TEMPLATE_DIR}/dofthings_files/jquery-ui-1.11.2/jquery-ui.css">
            <link rel="stylesheet" href="{$smarty.const.SITE_URL}templates/{$smarty.const.TEMPLATE_DIR}/dofthings_files/style-dashboards.css">
            <link rel="stylesheet" href="{$smarty.const.SITE_URL}templates/{$smarty.const.TEMPLATE_DIR}/dofthings_files/dofthings.dashboard.css">
            <script src="{$smarty.const.SITE_URL}templates/{$smarty.const.TEMPLATE_DIR}/dofthings_files/mqttws31.js" type="text/javascript"></script>
            <script src="{$smarty.const.SITE_URL}templates/{$smarty.const.TEMPLATE_DIR}/dofthings_files/dofthings.dashboard.js" type="text/javascript"></script>
            <script src="{$smarty.const.SITE_URL}templates/{$smarty.const.TEMPLATE_DIR}/dofthings_files/dofthings.mqtt.js" type="text/javascript"></script>
        {/if}
        <script src="{$smarty.const.SITE_URL}templates/{$smarty.const.TEMPLATE_DIR}/dofthings_files/modernizr.2.8.3.js" type="text/javascript"></script>

        <style type="text/css"></style>

    </head>
    <body>
        <div class="container">

            <header class="app-header contain-to-grid" role="banner">


                <nav class="app-header-bar top-bar clearfix" role="navigation">
                    <ul class="app-header-branding">
                        <li class="app-header-logo name">
                            <a href="/">
                                <h1 class="app-header-logo-heading">
                                    <!-- <a class="app-header-logo-link" href="index.html">d-of-Things</a> -->
                                    <img src="{$smarty.const.SITE_URL}/Includes/images/logo4.png">
                                </h1>
                            </a>
                        </li>
                        <li class="app-header-toggle toggle-topbar">
                            <a href="index.html#">
                                <span class="app-header-toggle-text">Menu</span>
                                <i class="icon-menu"></i>
                            </a>
                        </li>
                    </ul>

                    <section class="app-header-content">
                        <!-- Left Nav Section -->
                        <ul class="left">
                            <!--      <li class="app-header-platform has-dropdown "> -->
                            <li class="app-header-platform">
                                <a href="/dashboards"><i class="menu-icon icon-popout"></i>{$smarty.const.MENU1}</a>
                        <!--        <ul class="dropdown"><li class="title back js-generated"><h5><a href="#">{$smarty.const.MENU1}</a></h5></li>
                                  <li><a href="index/">{$smarty.const.SUBMENU1_MENU1}</a></li>
                                  <li><a href="index/">{$smarty.const.SUBMENU2_MENU1}</a></li>
                                  <li><a href="index/">{$smarty.const.SUBMENU3_MENU1}</a></li>
                                  <li><a href="index/">{$smarty.const.SUBMENU4_MENU1}</a></li>
                                </ul>
                                -->
                            </li>
                            <li class="">
                                <a href="/about">{$smarty.const.MENU3}</a>
                            </li>
                            <li class="">
                                <a href="/contact">{$smarty.const.MENU4}</a>
                            </li>
                        </ul>

                        <!-- Right Nav Section -->
                        <ul class="right">
                            <!--
                                  <li class="has-dropdown ">
                              <a href="dev/index.html">Developer Center</a>
                              <ul class="dropdown"><li style="" class="title back js-generated"><h5><a href="#">Developer Center</a></h5></li>
                                <li><a href="dev/index.html">Home</a></li>
                                <li><a href="dev/tutorials/index.html">Tutorials</a></li>
                                <li><a href="dev/libraries/index.html">Libraries</a></li>
                                <li><a href="dev/hardware/index.html">Hardware</a></li>
                                <li><a href="dev/docs/api/index.html">API Docs</a></li>
                                <li><a href="dev/help/index.html">Help</a></li>
                              </ul>
                            </li>
                            -->

                            {if $logged_in}
                                <li class="app-header-login has-dropdown">
                                    <a href="/feeds"><i class="menu-icon "></i>{$smarty.const.MENU5}</a>
                                    <ul class="dropdown">
                                        <li><a href="/feeds"><i class="menu-icon icon-cog"></i>{$smarty.const.SUBMENU1_MENU5}</a></li>
                                        <li><a href="/keys"><i class="menu-icon icon-key"></i>{$smarty.const.SUBMENU2_MENU5}</a></li>
                                        <li><a href="/alarms"><i class="menu-icon icon-stack"></i>{$smarty.const.SUBMENU3_MENU5}</a></li>
                                    </ul>
                                </li>
                                {if $admin}
                                    <li class="app-header-login has-dropdown">
                                        <a href="/settings"><i class="menu-icon "></i>{$smarty.const.MENU0}</a>
                                        <ul class="dropdown">
                                            <li><a href="/settings"><i class="menu-icon icon-cog"></i>{$smarty.const.MENU9}</a></li>
                                            <li><a href="/users"><i class="menu-icon icon-stack"></i>{$smarty.const.MENU10}</a></li>
                                        </ul>
                                    </li>
                                {/if}
                                <li class="user-dropdown has-dropdown">
                                    <a class="user-dropdown-link" href="/profile">
                                        <img alt="{$smarty.const.HEADER_NAV_PROFILE_IMAGE_TEXT}" class="avatar" src="/Includes/images/default.avatar.png" />
                                        {$username}
                                    </a>
                                    <ul class="dropdown">
                                        <li><a href="/profile"><i class="menu-icon icon-wrench"></i>{$smarty.const.MENU8}</a></li>
                                        <li><a href="/login/logoff"><i class="menu-icon icon-enter"></i>{$smarty.const.MENU7}</a></li>
                                    </ul>
                                </li>
                            {else}
                                <li class="app-header-login ">
                                    <a href="/login">{$smarty.const.HEADER_NAV_LINK_LOGIN}</a>
                                </li>
                                <li class="app-header-signup ">
                                    <a class="button" href="/signup">{$smarty.const.HEADER_NAV_LINK_SIGNUP}</a>
                                </li>
                            {/if}
                        </ul>
                    </section></nav>

            </header>

            {if isset($feeds_new_ok) && $feeds_new_ok == 1}
                <div class="alert-box info">
                    <div class="alert-box-inner">
                        {$smarty.const.FEEDS_NEW_MSG_OK}
                        {$feeds_new_feedid}
                    </div>
                </div>
            {elseif isset($feeds_new_ok) && $feeds_new_ok == 99}
                <div class="alert-box alert">
                    <div class="alert-box-inner">
                        {$smarty.const.FEEDS_NEW_MSG_FAIL}
                    </div>
                </div>
            {/if}

            {if isset($feeds_delete_ok) && $feeds_delete_ok == 1}
                <div class="alert-box info">
                    <div class="alert-box-inner">
                        {$smarty.const.FEEDS_DELETE_MSG_OK}
                        {$feeds_new_feedid}
                    </div>
                </div>
            {elseif isset($feeds_delete_ok) && $feeds_delete_ok == 99}
                <div class="alert-box alert">
                    <div class="alert-box-inner">
                        {$smarty.const.FEEDS_DELETE_MSG_FAIL}
                    </div>
                </div>
            {/if}

            {if isset($feeds_deactivate_ok) && $feeds_deactivate_ok == 1}
                <div class="alert-box alert">
                    <div class="alert-box-inner">
                        {$smarty.const.FEEDS_DEACTIVATE_MSG}
                        {$feeds_new_feedid}
                    </div>
                </div>
            {elseif isset($feeds_activate_ok) && $feeds_activate_ok == 1}
                <div class="alert-box info">
                    <div class="alert-box-inner">
                        {$smarty.const.FEEDS_ACTIVATE_MSG}
                        {$feeds_new_feedid}
                    </div>
                </div>
            {/if}

            {if isset($feeds_update_ok) && $feeds_update_ok == 1}
                <div class="alert-box info">
                    <div class="alert-box-inner">
                        {$smarty.const.FEEDS_UPDATE_MSG_OK}
                        {$feeds_edit_msg}
                    </div>
                </div>
            {/if}
            {if isset($keys_deactivate_ok) && $keys_deactivate_ok == 1}
                <div class="alert-box alert">
                    <div class="alert-box-inner">
                        {$smarty.const.KEYS_DEACTIVATE_MSG}
                        {$feeds_new_feedid}
                    </div>
                </div>
            {elseif isset($keys_activate_ok) && $keys_activate_ok == 1}
                <div class="alert-box info">
                    <div class="alert-box-inner">
                        {$smarty.const.KEYS_ACTIVATE_MSG}
                        {$feeds_new_feedid}
                    </div>
                </div>
            {/if}
            {if isset($keys_delete_ok) && $keys_delete_ok == 1}
                <div class="alert-box info">
                    <div class="alert-box-inner">
                        {$smarty.const.KEYS_DELETE_MSG_OK}
                        {$keys_delete_keyid}
                    </div>
                </div>
            {elseif isset($keys_delete_ok) && $keys_delete_ok == 99}
                <div class="alert-box alert">
                    <div class="alert-box-inner">
                        {$smarty.const.KEYS_DELETE_MSG_FAIL}
                    </div>
                </div>
            {/if}
            {if isset($keys_new_ok) && $keys_new_ok == 1}
                <div class="alert-box info">
                    <div class="alert-box-inner">
                        {$smarty.const.KEYS_NEW_MSG_OK}
                    </div>
                </div>
            {elseif isset($keys_new_ok) && $keys_new_ok == 99}
                <div class="alert-box alert">
                    <div class="alert-box-inner">
                        {$smarty.const.KEYS_NEW_MSG_FAIL}
                    </div>
                </div>
            {/if}
            {if isset($keys_update_ok) && $keys_update_ok}
                <div class="alert-box info">
                    <div class="alert-box-inner">
                        {$smarty.const.KEYS_UPDATE_MSG_OK}
                    </div>
                </div>
            {elseif isset($keys_update_ok) && $keys_update_ok == 99}
                <div class="alert-box alert">
                    <div class="alert-box-inner">
                        {$smarty.const.KEYS_UPDATE_MSG_FAIL}
                        {$keys_update_msg}
                    </div>
                </div>
            {/if}
            {if isset($profile_update_ok) && $profile_update_ok == 1}
                <div class="alert-box info">
                    <div class="alert-box-inner">
                        {$smarty.const.PROFILE_UPDATE_MSG_OK}
                        {$profile_update_msg}
                    </div>
                </div>
            {elseif isset($profile_update_ok) && $profile_update_ok == 99}
                <div class="alert-box alert">
                    <div class="alert-box-inner">
                        {$smarty.const.PROFILE_UPDATE_MSG_FAIL}
                        {$profile_update_msg}
                    </div>
                </div>
            {/if}

            {if isset($settings_update_ok) && $settings_update_ok == 1}
                <div class="alert-box info">
                    <div class="alert-box-inner">
                        {$smarty.const.SETTINGS_UPDATE_MSG_OK}
                        {$settings_update_msg}
                    </div>
                </div>
            {elseif isset($settings_update_ok) && $settings_update_ok == 99}
                <div class="alert-box alert">
                    <div class="alert-box-inner">
                        {$smarty.const.SETTINGS_UPDATE_MSG_FAIL}
                        {$settings_update_msg}
                    </div>
                </div>
            {/if}

            {if isset($alarms_new_ok) && $alarms_new_alarmid}
                <div class="alert-box info">
                    <div class="alert-box-inner">
                        {$smarty.const.ALARMS_NEW_MSG_OK}
                    </div>
                </div>
            {elseif isset($alarms_new_ok) && $alarms_new_ok == 99}
                <div class="alert-box alert">
                    <div class="alert-box-inner">
                        {$smarty.const.ALARMS_NEW_MSG_FAIL}
                        {$alarms_update_msg}
                    </div>
                </div>
            {/if}

            {if isset($alarms_update_ok) && $alarms_update_ok}
                <div class="alert-box info">
                    <div class="alert-box-inner">
                        {$smarty.const.ALARMS_UPDATE_MSG_OK}
                    </div>
                </div>
            {elseif isset($alarms_update_ok) && $alarms_update_ok == 99}
                <div class="alert-box alert">
                    <div class="alert-box-inner">
                        {$smarty.const.ALARMS_UPDATE_MSG_FAIL}
                        {$alarms_update_msg}
                    </div>
                </div>
            {/if}
            {if isset($alarms_deactivate_ok) && $alarms_deactivate_ok == 1}
                <div class="alert-box alert">
                    <div class="alert-box-inner">
                        {$smarty.const.ALARMS_DEACTIVATE_MSG}
                        {$alarms_result_msg}
                    </div>
                </div>
            {elseif isset($alarms_activate_ok) && $alarms_activate_ok == 1}
                <div class="alert-box info">
                    <div class="alert-box-inner">
                        {$smarty.const.ALARMS_ACTIVATE_MSG}
                        {$alarms_result_msg}
                    </div>
                </div>
            {/if}
