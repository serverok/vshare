<a href="http://buyscripts.in" target="_blank"><img src="{$img_css_url}/images/logo_small.jpg" width="150" alt="logo" /></a>

<div id="main-menu">
    {section name=i loop=$menu_heading}
    <h1>{$menu_heading[i].0}</h1>
    <ul>
    {section name=j loop=$menu_items}
    {if $menu_items[j].2 eq $smarty.section.i.index}
        <li><a href="{$menu_items[j].1}" target="body">{$menu_items[j].0}</a></li>
    {/if}
    {/section}
    </ul>
    {/section}
</div>

<hr />

<div style="margin:8px auto 10px 50px;">
<a href="./logout.php" target="_top">Logout</a>
</div>

<div style="padding-left:8px;">
Powered by: <a href="http://buyscripts.in/youtube_clone.html" target="_blank">vShare</a>
</div>
