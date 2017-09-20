
<!DOCTYPE HTML>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8 ie7"{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9 ie8"{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}><![endif]-->
<!--[if gt IE 8]> <html class="no-js ie9"{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}><![endif]-->
<html{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}>
    <head>
        <meta charset="utf-8" />
        <title>{$meta_title|escape:'html':'UTF-8'}</title>
        {if isset($meta_description) AND $meta_description}
            <meta name="description" content="{$meta_description|escape:'html':'UTF-8'}" />
        {/if}
        {if isset($meta_keywords) AND $meta_keywords}
            <meta name="keywords" content="{$meta_keywords|escape:'html':'UTF-8'}" />
        {/if}
        <meta name="generator" content="VisitorTrip" />
        <meta name="robots" content="{if isset($nobots)}no{/if}index,{if isset($nofollow) && $nofollow}no{/if}follow" />
        <meta name="viewport" content="width=device-width, minimum-scale=0.25, maximum-scale=1.6, initial-scale=1.0" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <link rel="icon" type="image/vnd.microsoft.icon" href="{$favicon_url}?{$img_update_time}" />
        <link rel="shortcut icon" type="image/x-icon" href="{$favicon_url}?{$img_update_time}" />
        {if isset($css_files)}
            {foreach from=$css_files key=css_uri item=media}
                <link rel="stylesheet" href="{$css_uri|escape:'html':'UTF-8'}" type="text/css" media="{$media|escape:'html':'UTF-8'}" />
            {/foreach}
        {/if}
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <style type="text/css">
            @media(min-width:992px){
                .cusheight{
                    max-height: 350px;
                    overflow-y: auto;
                }
            }
        </style>
        {if isset($js_defer) && !$js_defer && isset($js_files) && isset($js_def)}
            {$js_def}
            {foreach from=$js_files item=js_uri}
                <script type="text/javascript" src="{$js_uri|escape:'html':'UTF-8'}"></script>
            {/foreach}
        {/if}
        {$HOOK_HEADER}
        <link rel="stylesheet" href="http{if Tools::usingSecureMode()}s{/if}://fonts.googleapis.com/css?family=Open+Sans:300,600&amp;subset=latin,latin-ext" type="text/css" media="all" />
        <!--[if IE 8]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body{if isset($page_name)} id="{$page_name|escape:'html':'UTF-8'}"{/if} class="{if isset($page_name)}{$page_name|escape:'html':'UTF-8'}{/if}{if isset($body_classes) && $body_classes|@count} {implode value=$body_classes separator=' '}{/if}{if $hide_left_column} hide-left-column{else} show-left-column{/if}{if $hide_right_column} hide-right-column{else} show-right-column{/if}{if isset($content_only) && $content_only} content_only{/if} lang_{$lang_iso}">
        <script type="text/javascript">
            {literal}
                (function (i, s, o, g, r, a, m) {
                    i['GoogleAnalyticsObject'] = r;
                    i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
                    a = s.createElement(o),
                            m = s.getElementsByTagName(o)[0];
                    a.async = 1;
                    a.src = g;
                    m.parentNode.insertBefore(a, m)
                })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
                ga('create', 'UA-76242442-1', 'auto');
                ga('send', 'pageview');
            {/literal}
        </script>
        <div id="fb-root"></div>
        <script type="text/javascript">
            {literal}
                (function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id))
                        return;
                    js = d.createElement(s);
                    js.id = id;
                    js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.5";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
            {/literal}
        </script> 
        <style type="text/css">
            .cusheight {
                z-index: 1001;
            }
            .dropdown-menu{
                margin: 2px 0 0 !important;}
            </style>
            <div id="page">
            <nav class="navbar navbar-default navbar-fixed-top" id="header" role="navigation">
                <div class="container">
                    <div class="navbar-header">
                        <button data-target="#main_navbar_items" data-toggle="collapse" class="navbar-toggle" type="button">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" style="padding: 7px;" href="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}" title="{$shop_name|escape:'html':'UTF-8'}">
                            <img border="0" style="vertical-align: middle;" class="logo img-responsive" src="{$logo_url}" alt="{$shop_name|escape:'html':'UTF-8'}"/>
                        </a>
                    </div>
                    <div class="navbar-collapse collapse" id="main_navbar_items">
                        <ul class="nav navbar-nav">
                            {foreach from=$catoptlist key=catkey item=catlist}
                                {if $catlist['sub_cats']}
                                    <li class="dropdown clearfix">
                                        <a title="{$catlist['name']}{l s=' - VisitorTrip'}" data-toggle="dropdown" class="dropdown-toggle text-uppercase" href="{$link->getCategoryLink($catlist['id'], $catlist['link_rewrite'])|escape:'html':'UTF-8'}">{$catlist['name']}<span class="caret"></span></a>
                                        <ul role="menu" class="dropdown-menu {if $catlist['id']=="30"} cusheight {/if}" data-no-collapse="true">
                                            {foreach from=$catlist['sub_cats'] key=subcatkey item=subcatlist}
                                                <li><a title="{$subcatlist['name']}{l s=' - VisitorTrip'}" href="{$link->getCategoryLink($subcatlist['id'], $subcatlist['link_rewrite'])|escape:'html':'UTF-8'}"><span>{$subcatlist['name']}</span></a></li>
                                                        {/foreach}
                                        </ul>
                                    </li>
                                {else}
                                    <li class="text-uppercase"><a href="" title="{$catlist['name']}{l s='- VisitorTrip'}">{$catlist['name']}</a></li>
                                    {/if}
                                {/foreach}
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li style="">
                            {if isset($HOOK_TOP)}{$HOOK_TOP}{/if}
                        </li>

                        {if $is_logged}
                            <li>
                                <a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" title="{l s='my account'}" class="account" rel="nofollow">
                                    <span>{$cookie->customer_firstname} {$cookie->customer_lastname}</span>
                                </a>
                            </li>
                        {/if}
                        <li>
                            {if $is_logged}
                                <a class="" href="{$link->getPageLink('index', true, NULL, "mylogout")|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Log me out' mod='blockuserinfo'}">
                                    <span class="glyphicon glyphicon-log-out text-color-green"></span>&nbsp;&nbsp;LOG OUT
                                </a>
                            {else}
                                <a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Login'}">
                                    <span class="glyphicon glyphicon-log-in text-color-green"></span>&nbsp;&nbsp;LOG IN | REGISTER
                                </a>
                            {/if}
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container margin-header-custom" id='columns' style="padding:0px;">
            {if $page_name !='index' && $page_name !='pagenotfound'}
                {include file="$tpl_dir./breadcrumb.tpl"}
            {/if}
        {capture name='displayTopColumn'}{hook h='displayTopColumn'}{/capture}
        {if $smarty.capture.displayTopColumn}
            <div id="top_column">{$smarty.capture.displayTopColumn}</div>
        {/if}
        {if isset($left_column_size) && !empty($left_column_size)}
            <div id="left_column" class="column col-xs-12 col-sm-{$left_column_size|intval}">{$HOOK_LEFT_COLUMN}</div>
        {/if}
{if isset($left_column_size) && isset($right_column_size)}{assign var='cols' value=(12 - $left_column_size - $right_column_size)}{else}{assign var='cols' value=12}{/if}
<div id="center_column" style="padding:0px;" class="center_column col-xs-12 col-sm-{$cols|intval}">














    {*
        
    {if !isset($content_only) || !$content_only}
    {if isset($restricted_country_mode) && $restricted_country_mode}
    <div id="restricted-country">
    <p>{l s='You cannot place a new order from your country.'}{if isset($geolocation_country) && $geolocation_country} <span class="bold">{$geolocation_country|escape:'html':'UTF-8'}</span>{/if}</p>
    </div>
    {/if}
    <div id="page">
    <div class="header-container">
    <header id="header">
    {capture name='displayBanner'}{hook h='displayBanner'}{/capture}
    {if $smarty.capture.displayBanner}
    <div class="banner">
    <div class="container">
    <div class="row">
    {$smarty.capture.displayBanner}
    </div>
    </div>
    </div>
    {/if}
    {capture name='displayNav'}{hook h='displayNav'}{/capture}
    {if $smarty.capture.displayNav}
    <div class="nav">
    <div class="container">
    <div class="row">
    <nav>{$smarty.capture.displayNav}</nav>
    </div>
    </div>
    </div>
    {/if}
    <div>
    <div class="container">
    <div class="row">
    <div id="header_logo">
    <a href="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}" title="{$shop_name|escape:'html':'UTF-8'}">
    <img class="logo img-responsive" src="{$logo_url}" alt="{$shop_name|escape:'html':'UTF-8'}"{if isset($logo_image_width) && $logo_image_width} width="{$logo_image_width}"{/if}{if isset($logo_image_height) && $logo_image_height} height="{$logo_image_height}"{/if}/>
    </a>
    </div>
    {if isset($HOOK_TOP)}{$HOOK_TOP}{/if}
    </div>
    </div>
    </div>
    </header>
    </div>
    <div class="columns-container">
    <div id="columns" class="container">
    {if $page_name !='index' && $page_name !='pagenotfound'}
    {include file="$tpl_dir./breadcrumb.tpl"}
    {/if}
    <div id="slider_row" class="row">
    {capture name='displayTopColumn'}{hook h='displayTopColumn'}{/capture}
    {if $smarty.capture.displayTopColumn}
    <div id="top_column" class="center_column col-xs-12 col-sm-12">{$smarty.capture.displayTopColumn}</div>
    {/if}
    </div>
    <div class="row">
    {if isset($left_column_size) && !empty($left_column_size)}
    <div id="left_column" class="column col-xs-12 col-sm-{$left_column_size|intval}">{$HOOK_LEFT_COLUMN}</div>
    {/if}
    {if isset($left_column_size) && isset($right_column_size)}{assign var='cols' value=(12 - $left_column_size - $right_column_size)}{else}{assign var='cols' value=12}{/if}
    <div id="center_column" class="center_column col-xs-12 col-sm-{$cols|intval}">
    {/if}
    *}
    <script type="text/javascript">
        $('.navbar-collapse').find('.dropdown').each(function () {
            $(this).children('a').each(function () {
                var url = $(this).attr('href');
                if (url != '#') {
                    $(this).attr('data-url', url);
                    $(this).attr('href', '#');
                }
            });
            $(this).children('a').click(function (e) {
                e.preventDefault();
            });
            if ($(window).width() < 700) {
                console.log('hhh');
                if ($(this).closest('.navbar-toggle').css('display') !== 'none') { // only on collapsed nav
                    $(this).on({
                        "click": function (e) {
                            if (e.target == $(this).children('a').first().get(0)) {
                                if ($(this).hasClass('open')) {
                                    document.location.href = $(this).children('a').first().attr("data-url");
                                } else {
                                    $(this).addClass('open');
                                }
                                e.stopImmediatePropagation();
                                e.preventDefault();
                                return false;
                            }
                        },
                        "hide.bs.dropdown": function (e) {
                            e.preventDefault();
                            return false;
                        }
                    });
                }
            }
        });</script>