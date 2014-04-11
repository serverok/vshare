<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{if $html_title ne ""}{$html_title} - {$site_name}{else}{$site_name} - Share Your Videos{/if}</title>
<meta name="keywords" content="{if $html_keywords ne ""}{$html_keywords}, {/if}{$meta_keywords}" />
<meta name="description" content="{if $html_description ne ""}{$html_description} {/if}{$meta_description}" />
<link rel="alternate" type="application/rss+xml" title="20 Latest videos" href="{$base_url}/rss/new/" />
<link rel="alternate" type="application/rss+xml" title="20 Most Viewed Videos" href="{$base_url}/rss/views/" />
<link rel="alternate" type="application/rss+xml" title="20 Most Commented Videos" href="{$base_url}/rss/comments/" />
<link href="{$img_css_url}/css/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/javascript" src="{$base_url}/js/jquery-1.3.2.min.js"></script>
{if $smarty.session.CSS ne "" && $smarty.session.CSS ne "default"}
<link href="{$img_css_url}/css/{$smarty.session.CSS}/{$smarty.session.CSS}.css" rel="stylesheet" type="text/css" />
{/if}
<link href="{$img_css_url}/css/rating.css" rel="stylesheet" type="text/css" />
{$html_head_extra}
</head>
<body>

<div id="wrapper">

    <div id="header" class="clearfix">
    
        <h1><a href="{$base_url}/index.php" title="{$site_name}">{$site_name}</a></h1>
    
        <div id="top-links">
            {if $smarty.session.USERNAME ne ""}
             
                 <span id="user-drop-down">
					Welcome,
					<a href="{$base_url}/{$smarty.session.USERNAME}">{$smarty.session.USERNAME}</a> <span class="arrow"><img src="{$img_css_url}/images/down-arrow.png" width="10" height="10" /></span>
					<ul id="user-menues" style="display: none;">
						<li><a href="{$base_url}/{$smarty.session.USERNAME}/account/">My Account</a></li>
						<li><a href="{$base_url}/{$smarty.session.USERNAME}/public/">Public Videos</a></li>
						<li><a href="{$base_url}/{$smarty.session.USERNAME}/private/">Private Videos</a></li>
						<li><a href="{$base_url}/{$smarty.session.USERNAME}/favorites/">Favorites</a></li>
						<li><a href="{$base_url}/{$smarty.session.USERNAME}/friends/">Friends</a></li>
						<li><a href="{$base_url}/{$smarty.session.USERNAME}/playlist/">Playlist</a></li>
						<li><a href="{$base_url}/{$smarty.session.USERNAME}/groups/">Groups</a></li>
					</ul>
				</span> |
                 <a href="{$base_url}/mail.php?folder=inbox"><img class="mail" height="12" {if $total_msg eq ""}src="{$img_css_url}/images/icon_mail_off.gif"{else}src="{$img_css_url}/images/newmail.gif"{/if} width="14" border="0" alt="mail" /></a>
                 (<a  href="{$base_url}/mail.php?folder=inbox">{insert name="msg_count" assign=total_msg}{$total_msg}</a>)
                 <a href="{$base_url}/logout/" class="bold">Log Out</a> |
            {else}
                 <a href="{$base_url}/signup/">Sign Up</a> |
                 <a href="{$base_url}/login/">Log In</a> |
            {/if}
            
            {if $family_filter eq '1'}
                Family Filter <a href="{$base_url}/family_filter/">{if $smarty.session.FAMILY_FILTER eq '1'}ON{else}OFF{/if}</a> |
            {/if}
            
            <a href="{$base_url}/pages/help.html">Help</a>
            <a href="{$base_url}/rss/new/"><img border="0" src="{$img_css_url}/images/rss.gif" alt="rss" /></a>
            
            {if $smarty.session.CSS eq "default"}
                <a href="{$base_url}/style/black/">
                    <img src="{$img_css_url}/images/style/black.png" alt="Black" />
                </a>
            {else}
                <a href="{$base_url}/style/default/">
                    <img src="{$img_css_url}/images/style/default.png" alt="Default" />
                </a>
            {/if}
        </div>
        
    </div>

    <div id="video-search">
       <form method="get" action="{$base_url}/search_videos.php">
         <input class="text" value="{$smarty.request.search_string}" name="search_string" />
		 <input type="hidden" name="type" value="video">
         <input type="submit" class="search-btn" value="Search" />
       </form>
    </div>

    <div id="menu" class="clearfix">
        <ul>
        <li><a href="{$base_url}/index.php">HOME</a></li>
        <li><a href="{$base_url}/upload/">UPLOAD</a></li>
        <li><a href="{$base_url}/recent/">WATCH</a></li>
        <li><a href="{$base_url}/tags/">TAGS</a></li>
        <li><a href="{$base_url}/channels/">CHANNELS</a></li>
        <li><a href="{$base_url}/groups/featured/1">GROUPS</a></li>
        <li><a href="{$base_url}/friends/">FRIENDS</a></li>
        <li><a href="{$base_url}/members/">PEOPLE</a></li>
        </ul>
    </div>

    {if $sub_menu ne ""}
        <div id="menu-sub">
            {include file=$sub_menu}
        </div>
    {/if}
    
    {insert name=advertise adv_name='banner_top'}
    
    {*{include file="search_box.tpl"}*}
    
    <div id="main" class="clearfix">
    
        {include file="error.tpl"}
