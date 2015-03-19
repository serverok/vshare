<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{if $html_title ne ""}{$html_title} - {$site_name}{else}{$site_name} - Share Your Videos{/if}</title>
<meta name="keywords" content="{if $html_keywords ne ""}{$html_keywords}, {/if}{$meta_keywords}" />
<meta name="description" content="{if $html_description ne ""}{$html_description} {/if}{$meta_description}" />
<link href="{$base_url}/css/bootstrap.min.css" rel="stylesheet">
<link href="{$base_url}/themes/default/css/style.css" rel="stylesheet">
<link rel="alternate" type="application/rss+xml" title="20 Latest videos" href="{$base_url}/rss/new/" />
<link rel="alternate" type="application/rss+xml" title="20 Most Viewed Videos" href="{$base_url}/rss/views/" />
<link rel="alternate" type="application/rss+xml" title="20 Most Commented Videos" href="{$base_url}/rss/comments/" />
<script language="JavaScript" type="text/javascript" src="{$base_url}/js/jquery-1.11.0.min.js"></script>
{if $smarty.session.CSS ne "" && $smarty.session.CSS ne "default"}
<link href="{$img_css_url}/css/{$smarty.session.CSS}/{$smarty.session.CSS}.css" rel="stylesheet" type="text/css" />
{/if}
<link href="{$img_css_url}/css/rating.css" rel="stylesheet" type="text/css" />
{$html_head_extra}
</head>
<body>

<div class="container">
    <header class="row">
        <div class="col-md-4">
            <div class="row">
                <h1>
                    <a href="{$base_url}/index.php" title="{$site_name}">
                        <img class="img-responsive" src="{$img_css_url}/images/logo.jpg">
                    </a>
                </h1>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row text-right">
                {if $smarty.session.USERNAME ne ""}
                <div class="btn-group btn-group-sm">
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="{$base_url}/{$smarty.session.USERNAME}" class="btn btn-default dropdown-toggle text-nowrap" data-toggle="dropdown" aria-expanded="false">
                            <span class="glyphicon glyphicon-user"></span> {$smarty.session.USERNAME} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{$base_url}/{$smarty.session.USERNAME}">My profile</a></li>
                            <li><a href="{$base_url}/{$smarty.session.USERNAME}/account/">My Account</a></li>
                            <li><a href="{$base_url}/{$smarty.session.USERNAME}/public/">Public Videos</a></li>
                            <li><a href="{$base_url}/{$smarty.session.USERNAME}/private/">Private Videos</a></li>
                            <li><a href="{$base_url}/{$smarty.session.USERNAME}/favorites/">Favorites</a></li>
                            <li><a href="{$base_url}/{$smarty.session.USERNAME}/friends/">Friends</a></li>
                            <li><a href="{$base_url}/{$smarty.session.USERNAME}/playlist/">Playlist</a></li>
                            <li><a href="{$base_url}/{$smarty.session.USERNAME}/groups/">Groups</a></li>
                        </ul>
                    </div>
                    <a class="btn btn-default text-nowrap" href="{$base_url}/mail.php?folder=inbox">
                        <span class="glyphicon glyphicon-envelope"></span>
                        ({insert name="msg_count" assign=total_msg}{$total_msg})
                    </a>
                    <a class="btn btn-default text-nowrap" href="{$base_url}/logout/" class="bold">
                        <span class="glyphicon glyphicon-log-out"></span> Log Out
                    </a>
                </div>
                {else}
                <div class="btn-group btn-group-sm">
                    <a class="btn btn-default text-nowrap" href="{$base_url}/signup/">Sign Up</a>
                    <a class="btn btn-default text-nowrap" href="{$base_url}/login/">Log In</a>
                </div>
                {/if}

                <div class="btn-group btn-group-sm">
                    {if $family_filter eq '1'}
                        <a class="btn btn-default text-nowrap" href="{$base_url}/family_filter/">Family Filter {if $smarty.session.FAMILY_FILTER eq '1'}ON{else}OFF{/if}</a>
                    {/if}
                    <a class="btn btn-default text-nowrap" href="{$base_url}/pages/help.html">Help</a>
                    <a class="btn btn-default text-nowrap" href="{$base_url}/rss/new/"><img border="0" src="{$img_css_url}/images/rss.gif" alt="rss" /></a>

                    {if $smarty.session.CSS eq "default"}
                        <a class="btn btn-default text-nowrap" href="{$base_url}/style/black/">
                            <img src="{$img_css_url}/images/style/black.png" alt="Black" />
                        </a>
                    {else}
                        <a class="btn btn-default text-nowrap" href="{$base_url}/style/default/">
                            <img src="{$img_css_url}/images/style/default.png" alt="Default" />
                        </a>
                    {/if}
                </div>
            </div>
            <div class="row">
                <div class="col-md-7 pull-right row">
                    <form method="get" action="{$base_url}/search_videos.php" class="form-horizontal">
                        <input type="hidden" name="type" value="video">
                        <div class="input-group">
                            <input class="form-control" placeholder="Search" required value="{$smarty.request.search_string}" name="search_string" />
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default">Search</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="row">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <div class="row">
                        <ul class="nav nav-tabs navbar-nav nav-justified">
                            <li><a href="{$base_url}/index.php"><strong>HOME</strong></a></li>
                            <li><a href="{$base_url}/upload/"><strong>UPLOAD</strong></a></li>
                            <li><a href="{$base_url}/recent/"><strong>WATCH</strong></a></li>
                            <li><a href="{$base_url}/tags/"><strong>TAGS</strong></a></li>
                            <li><a href="{$base_url}/channels/"><strong>CHANNELS</strong></a></li>
                            <li><a href="{$base_url}/groups/featured/1"><strong>GROUPS</strong></a></li>
                            <li><a href="{$base_url}/friends/"><strong>FRIENDS</strong></a></li>
                            <li><a href="{$base_url}/members/"><strong>PEOPLE</strong></a></li>
                        </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    {if $sub_menu ne ""}
        <div id="menu-sub">
            {include file=$sub_menu}
        </div>
    {/if}

    {insert name=advertise adv_name='banner_top'}

    {*{include file="search_box.tpl"}*}

    <div class="row">

        {include file="error.tpl"}
