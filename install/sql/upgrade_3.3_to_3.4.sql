-- Migration: Upgrade password storage from MD5 to bcrypt
-- Run this before deploying the new code

ALTER TABLE `users` MODIFY COLUMN `user_password` VARCHAR(255) NOT NULL;
ALTER TABLE `users` ADD COLUMN `user_auto_login_token` VARCHAR(64) NOT NULL DEFAULT '' AFTER `user_salt`;
