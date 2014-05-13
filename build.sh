#!/bin/bash

# RUN THIS IN LINUX AS REPLACE COMMAND IN WINDOWS WILL NOT WORK
# mkdir -p /home/buyscrip/downloads/
# mkdir -p /home/buyscrip/vshare_build/relese/
# mkdir -p /home/buyscrip/vshare_build/
# cd /home/buyscrip/vshare_build/
# git clone git://git.bizhat.com/vshare.git
# cd /home/buyscrip/vshare_build/vshare
# git pull origin master
# sh ./build.sh 2.9
# ls -l /home/buyscrip/downloads

VERSION=$1

if [ ! $VERSION ]
then
   echo "Usage: ./build.sh <version>";
   exit 1
fi

rm -rf ../relese/
mkdir ../relese/
mkdir ../relese/vshare_$VERSION
git archive master --format=tar | gzip > ../relese/vshare_$VERSION/vshare.tar.gz
cd ../relese/vshare_$VERSION/
tar zxf vshare.tar.gz
rm -f vshare.tar.gz
rm -f .gitignore
rm -f build.sh
rm -rf tools

read -p "Press Enter key to start replace..."

replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./404.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/admin_log.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/admin_log_delete.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/advertisements.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/advertisement_edit.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/advertisement_status.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/bad_words.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/change_password.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/channels.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/channel_add.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/channel_edit.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/channel_groups.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/channel_search.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/channel_sort.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/channel_videos.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/comment.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/comment_edit.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/convert.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/email_edit.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/email_templates.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/groups.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/group_edit.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/group_members.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/group_posts.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/group_search.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/group_topics.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/group_videos.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/group_view.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/home.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/import_auto.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/import_auto_delete.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/import_auto_edit.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/import_bulk.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/import_bulk_process.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/import_folder.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/import_folder_all.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/import_folder_form.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/import_video.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/index.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/logout.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/lost_password.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/mail_users.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/packages.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/package_add.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/package_edit.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/package_view.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/page.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/page_add.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/page_edit.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/payments.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/phpinfo.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/poll_add.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/poll_edit.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/poll_list.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/process_queue.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/process_status_edit.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/reserve_user_name.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/reset_password.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/server_add.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/server_manage.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/server_manage_delete.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/server_manage_edit.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/server_manage_status.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/settings.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/settings_home.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/settings_player.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/settings_signup.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/subscription_edit.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/subscription_extend.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/tags.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/tags_disabled.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/tags_search.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/update_counters.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/upload_logo.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/upload_watermark.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/users.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/user_delete.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/user_edit.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/user_login.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/user_search.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/user_videos.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/user_view.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/videos.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/video_add_flv.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/video_add_flv_2.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/video_approve.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/video_delete.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/video_details.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/video_edit.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/video_featured.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/video_feature_requests.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/video_inactive.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/video_local.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/video_local_move.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/video_rename_flv.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/video_search.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/video_thumb.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/video_user_deleted.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/video_user_deleted_activate.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/video_user_deleted_all.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./ajax/username_check.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./captcha.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./channels.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./channel_details.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./confirm_email.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./convert.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./cron.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./cron_daily.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./download.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./email_unsubscribe.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./family_filter.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./friends.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./friend_accept.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./groups.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./group_add_fav_videos.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./group_add_videos.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./group_edit.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./group_home.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./group_invite_confirm.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./group_join.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./group_members.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./group_new.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./group_posts.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./index.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./invite_friends.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./invite_members.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./language.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./login.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./logout.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./mail.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./members.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./myaccount.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./package_options.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./payment.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./playlist_delete.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./recent_viewed_xml.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./recommend_friends.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./recoverpass.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./renew_account.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./resend_activation_mail.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./reset_password.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./rss.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./search.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./search_group.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./search_videos.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./show.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./show_page.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./signup.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./style.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./tag.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./tags.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./upload.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./upload_file.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./upload_remote.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./upload_success.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./upload_video_response.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./user.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./user_delete.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./user_delete_done.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./user_favorites.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./user_friends.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./user_friends_favourites.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./user_friends_videos.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./user_groups.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./user_photo_upload.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./user_playlist.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./user_privacy.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./user_profile_edit.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./user_signup_verify.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./user_videos.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./video.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./video_edit.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./video_embed.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./video_redirect.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./video_responses.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./video_response_verify.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./view_video.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./xml_playlist.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./install/install.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./install/upgrade.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./install/index.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./install/upgrade_start.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./install/upgrade_finished.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./install/upgrade_2.8_to_2.8.1.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./install/install_finished.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./install/install_collect_info.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./install/install_create_tables.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./install/upgrade_2.7_to_2.8.1.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./upload_embed.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/sitemap.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./install/install_collect_info.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/user_add.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/settings_miscellaneous.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/settings_video.php
replace '* VERSION: [VSHARE_VERSION]' "* VERSION: $VERSION" -- ./admin/sitemap_generate.php

echo '' > /home/buyscrip/vshare_build/relese/vshare_$VERSION/include/config.php
mv /home/buyscrip/vshare_build/relese/vshare_$VERSION/cgi-bin/ubr_upload_sample.pl /home/buyscrip/vshare_build/relese/vshare_$VERSION/cgi-bin/ubr_upload.pl

chmod -R 755 /home/buyscrip/vshare_build/relese/vshare_$VERSION/

# chown -R buyscrip:buyscrip /home/buyscrip/vshare_build/relese/

read -p "Press Enter key to create ZIP file..."

cd /home/buyscrip/vshare_build/relese/

/usr/bin/zip -r vshare_$VERSION.zip vshare_$VERSION
# chown buyscrip:buyscrip vshare_$VERSION.zip

cd /home/buyscrip/vshare_build/relese/

if [ -f /home/buyscrip/downloads/vshare_$VERSION.zip ]
then
    mv /home/buyscrip/downloads/vshare_$VERSION.zip /home/buyscrip/downloads/vshare_$VERSION.zip.$(date +%m%d%Y%H%i%s).backup
    echo "Renaming existing ZIP file"
fi

cp vshare_$VERSION.zip /home/buyscrip/downloads

# chown buyscrip:buyscrip /home/buyscrip/downloads/vshare_$VERSION.zip
chmod 755 /home/buyscrip/downloads/vshare_$VERSION.zip

echo "VERIFY ZIP CREATE TIME"

ls -lh /home/buyscrip/downloads | grep vshare_$VERSION.zip
date

read -p "Press Enter key to check for VSHARE_VERSION ..."

cd /home/buyscrip/vshare_build/relese/vshare_$VERSION
find ./ -name '*.php' -exec grep 'VSHARE_VERSION' {} \; -print

echo "Finished"
