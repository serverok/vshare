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

require '../include/config.php';
require '../include/functions_seo_name.php';
require '../include/class.tags.php';
require '../include/class.video_thumb.php';
require '../include/language/' . LANG . '/lang_admin_video_add_flv_2.php';

check_admin_login();

$success = 0;

if (isset($_SESSION['keywords']))
{
    $upload_video_keywords = $_SESSION['keywords'];
}
else
{
    $err = $lang['keywords_empty'];
}

if (isset($_SESSION['title']))
{
    $video_title = $_SESSION['title'];
}
else
{
    $err = $lang['title_empty'];
}

if (isset($_SESSION['description']))
{
    $video_description = $_SESSION['description'];
}
else
{
    $err = $lang['description_empty'];
}

if (isset($_SESSION['channels']))
{
    $video_channels = $_SESSION['channels'];
}
else
{
    $err = $lang['channels_empty'];
}

if (isset($_SESSION['video_privacy']))
{
    $video_type = $_SESSION['video_privacy'];
}
else
{
    $err = $lang['type_empty'];
}

if (isset($_SESSION['user_id']))
{
    $video_user_id = $_SESSION['user_id'];
}
else
{
    $err = $lang['userid_not_set'];
}

if ($err != '')
{
    set_message($err, 'error');
    $redirect_url = VSHARE_URL . '/admin/video_add_flv.php';
    redirect($redirect_url);
}

if (isset($_POST['submit']))
{
    $video_adult = isset($_SESSION['adult']) ? $_SESSION['adult'] : 0;
    $embed_code = isset($_POST['embed_code']) ? $_POST['embed_code'] : '';
    $flv_url = isset($_POST['flv_url']) ? $_POST['flv_url'] : '';
    
    if ($embed_code == '' && $flv_url == '')
    {
        $err = $lang['url_embed_empty'];
    }
    else if (! isset($_POST['embedded_code_image']) && ! isset($_POST['embedded_code_image_local']))
    {
        $err = $lang['specify_image'];
    }
    
    if ($err == '')
    {
        
        if (strlen($flv_url) > 30)
        {
            $vtype = 2;
            $embed_code = $flv_url;
        }
        else
        {
            $vtype = 6;
        }
        
        $video_duration = '1';
        $video_length = '01:00';
        
        if (preg_match("/youtube/i", $embed_code))
        {
            require '../include/class.bulk_import.php';
            
            $youtube_video_id = BulkImport::getYoutubeVideoId($embed_code);
            
            if (! empty($youtube_video_id))
            {
                require 'Zend/Loader.php';
                Zend_Loader::loadClass('Zend_Gdata_YouTube');
                
                $youtube_video_info = BulkImport::getYoutubeVideoInfo($youtube_video_id);
                $video_duration = $youtube_video_info['video_duration'];
                $video_length = sec2hms($youtube_video_info['video_duration']);
            }
        }
        
        $sql = "INSERT INTO `videos` SET
               `video_user_id`=" . (int) $video_user_id . ",
               `video_title`='" . mysql_clean($video_title) . "',
               `video_description`='" . mysql_clean($video_description) . "',
               `video_keywords`='" . mysql_clean($upload_video_keywords) . "',
               `video_seo_name`='" . seo_name($video_title) . "',
               `video_embed_code`='" . mysql_clean($embed_code) . "',
               `video_channels`='0|$video_channels|0',
               `video_type`='$video_type',
               `video_vtype`=$vtype,
               `video_adult`='$video_adult',
               `video_duration`='" . (int) $video_duration . "',
               `video_length`='" . mysql_clean($video_length) . "',
               `video_add_time`='" . time() . "',
               `video_add_date`='" . date("Y-m-d") . "',
               `video_active`='1',
               `video_approve`='$config[approve]'";
        
        $result = mysql_query($sql) or mysql_die($sql);
        $video_id = mysql_insert_id();
        
        if ($video_type == 'public' && $config['approve'] == 1)
        {
            $current_keyword = mysql_clean($upload_video_keywords);
            $tags = new Tags($current_keyword, $video_id, $video_user_id, $video_channels);
            $tags->add();
        }
        
        if (! empty($_POST['embedded_code_image'][0]))
        {
            $embedded_image = $_POST['embedded_code_image'];
            $destination = VSHARE_DIR . '/thumb/' . $video_id . '.jpg';
            $source = $embedded_image[0];
            download($source, $destination);
            
            //$limit = count($embedded_image);
            $j = 0;
            for ($i = 0; $i < 3; $i ++)
            {
                $j ++;
                if (! empty($embedded_image[$i]) && strstr($embedded_image[$i], '.jpg'))
                {
                    $destination = VSHARE_DIR . '/thumb/' . $j . '_' . $video_id . '.jpg';
                    echo '<br />';
                    $source = $embedded_image[$i];
                    download($source, $destination);
                }
                else
                {
                    $destination = VSHARE_DIR . '/thumb/' . $j . '_' . $video_id . '.jpg';
                    copy(VSHARE_DIR . '/templates/images/no_thumbnail.gif', $destination);
                }
            }
        }
        else if (! empty($_FILES['embedded_code_image_local']['tmp_name'][0]))
        {
            $fd = VSHARE_DIR . '/thumb/' . $video_id . '.jpg';
            $maxwidth = $config['img_max_width'];
            $maxheight = $config['img_max_height'];
            video_thumb::create_thumb($_FILES['embedded_code_image_local']['tmp_name'][0], $fd, $maxwidth, $maxheight);
            
            //$limit = count($_FILES['embedded_code_image_local']['name']);
            $j = 0;
            for ($i = 0; $i < 3; $i ++)
            {
                $j ++;
                if (! empty($_FILES['embedded_code_image_local']['name'][$i]) && ($_FILES['embedded_code_image_local']['type'][$i] == "image/jpeg"))
                {
                    $fd = VSHARE_DIR . '/thumb/' . $j . '_' . $video_id . '.jpg';
                    video_thumb::create_thumb($_FILES['embedded_code_image_local']['tmp_name'][$i], $fd, $maxwidth, $maxheight);
                }
                else
                {
                    copy(VSHARE_DIR . '/templates/images/no_thumbnail.gif', VSHARE_DIR . '/thumb/' . $j . '_' . $video_id . '.jpg');
                }
            }
        }
        
        $msg = $lang['video_added'];
        $success = 1;
    }
}

$smarty->assign('success', $success);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/video_add_flv_2.tpl');
$smarty->display('admin/footer.tpl');
db_close();
