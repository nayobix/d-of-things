{include file="../`$smarty.const.TEMPLATE_DIR`/header.tpl"}

<section class="app-main" role="main">
    <div class="app-main-inner">

        <section class="hero home-hero">
            <div class="home-hero-content">
                <div class="contain clearfix">
                    <h1 class="hero-tagline-big hero-tagline-big-home">{$smarty.const.HOME_DESCRIPTION_H1}</h1>
                    <h2 class="hero-tagline-small hero-tagline-small-home">{$smarty.const.HOME_DESCRIPTION_H2}<br /><br /><br />
                        {if $logged_in}<a href="{$smarty.const.SITE_URL}feeds" class="button large dark hero-get-started">{$smarty.const.MENU5}<i class="button-icon icon-arrow-right"></i></a></h2>
                    {else}<a href="{$smarty.const.SITE_URL}signup" class="button large dark hero-get-started">{$smarty.const.HOME_SIGNUP}<i class="button-icon icon-arrow-right"></i></a></h2>{/if}

                    <div class="hero-actions clearfix">
                        <a href="index.html#" class="hero-video link-light" data-reveal-id="modal-video" data-animation="fade">
                            <span class="hero-video-caption"></span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="content-section content-section-home home-benefits">
            <div class="section-intro first-section contain">
                <h2 class="heading-big">{$smarty.const.HOME_DESCRIPTION_H3}</h2>
            </div>
        </section>

        {include file="../`$smarty.const.TEMPLATE_DIR`/footer.tpl"}
