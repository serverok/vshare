<?php
/******************************************************************************
 *
 * COMPANY: BuyScripts.in
 * PROJECT: vShare Youtube Clone
 * VERSION: [VSHARE_VERSION]
 * LISENSE: http://buyscripts.in/vshare-license.html
 * WEBSITE: http://buyscripts.in/youtube_clone.html
 *
 * This program is a commercial software and any kind of using it must agree
 * to vShare license.
 *
 ******************************************************************************/

require 'include/config.php';
require 'include/class.cache.php';
require 'HTML/TagCloud.php';

Cache::init();

$latest_tags = Cache::load('latest_tags');

if (! $latest_tags) {
    $sql = "SELECT * FROM `tags` WHERE
	       `active`='1' AND
	       `tag_count` > 0
	        ORDER BY `used_on` DESC
	        LIMIT 100";
    $tags = DB::fetch($sql);

    if ($tags) {
        $tags = new HTML_TagCloud();
        foreach ($tags as $tag) {
            $tag_url = VSHARE_URL . '/tag/' . strtolower($tag['tag']) . '/';
            $tags->addElement($tag['tag'], $tag_url, $tag['tag_count'], $tag['used_on']);
        }
        $latest_tags = $tags->buildHTML();
        unset($tags);
    }

    Cache::save('latest_tags', $latest_tags);
}

$smarty->assign('latest_tags', $latest_tags);

$popular_tags = Cache::load('popular_tags');

if (! $popular_tags) {
    $sql = "SELECT * FROM `tags` WHERE
           `active`='1' AND
           `tag_count` > 0
            ORDER BY `tag_count` DESC
            LIMIT 100";
    $polular_tags = DB::fetch($sql);

    if ($polular_tags) {
        $tags = new HTML_TagCloud();
        foreach ($polular_tags as $tag) {
            $tag_url = VSHARE_URL . '/tag/' . strtolower($tag['tag']) . '/';
            $tags->addElement($tag['tag'], $tag_url, $tag['tag_count'], $tag['used_on']);
        }
        $popular_tags = $tags->buildHTML();
        unset($tags);
    }
    Cache::save('popular_tags', $popular_tags);
}

$smarty->assign(array(
    'popular_tags' => $popular_tags,
    'html_title' => 'Tags',
    'html_description' => 'Tags'
));

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('sub_menu', 'menu_home.tpl');
$smarty->display('header.tpl');
$smarty->display('tags.tpl');
$smarty->display('footer.tpl');
db_close();
