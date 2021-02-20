<?php 

/**
 * Setup all the tables we need for a site.
 *
 * @param string $prefix How to prefix the tables. Should match the subdomain.
 * @return void
 */
function jb_create_tables($prefix = '_'){
	global $pdo;

	$channel_table = "CREATE TABLE `channels` (
						`channel_id` INT(11) NOT NULL AUTO_INCREMENT,
						`youtube_id` VARCHAR(50) NULL DEFAULT NULL,
						`title` VARCHAR(255) NULL DEFAULT NULL,
						`description` TEXT NULL,
						`img_url` TEXT NULL,
						`facebook` VARCHAR(255) NULL DEFAULT NULL,
						`instagram` VARCHAR(255) NULL DEFAULT NULL,
						`patreon` VARCHAR(255) NULL DEFAULT NULL,
						`tiktok` VARCHAR(255) NULL DEFAULT NULL,
						`twitter` VARCHAR(255) NULL DEFAULT NULL,
						`twitch` VARCHAR(255) NULL DEFAULT NULL,
						`website` VARCHAR(255) NULL DEFAULT NULL,
						`tags` TEXT NULL,
						`active` TINYINT(4) NULL DEFAULT NULL,
						`last_updated` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						`created` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
						PRIMARY KEY (`channel_id`),
						UNIQUE INDEX `youtube_id` (`youtube_id`)
					)
					COLLATE='latin1_swedish_ci'
					ENGINE=InnoDB
					AUTO_INCREMENT=1;";

	$pdo->query($channel_table);


	$channel_styles = "CREATE TABLE `channel_styles` (
						`channel_id` INT(11) NULL DEFAULT NULL,
						`style_id` INT(11) NULL DEFAULT NULL,
						UNIQUE INDEX `channel_id_style_id` (`channel_id`, `style_id`)
					)
					COLLATE='latin1_swedish_ci'
					ENGINE=InnoDB;";

	$pdo->query($channel_styles);


	$channel_topics = "CREATE TABLE `channel_topics` (
						`channel_id` INT(11) NULL DEFAULT NULL,
						`topic_id` INT(11) NULL DEFAULT NULL,
						UNIQUE INDEX `channel_id_topic_id` (`channel_id`, `topic_id`)
					)
					COLLATE='latin1_swedish_ci'
					ENGINE=InnoDB;";

	$pdo->query($channel_topics);


	$channel_views = "CREATE TABLE `channel_views` (
						`channel_id` INT(11) NOT NULL,
						`view_count` INT(11) NOT NULL,
						`last_view` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						`first_view` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
						PRIMARY KEY (`channel_id`)
					)
					COLLATE='latin1_swedish_ci'
					ENGINE=InnoDB;";

	$pdo->query($channel_views);


	$user_history = "CREATE TABLE `history` (
						`history_id` INT(11) NOT NULL AUTO_INCREMENT,
						`user_id` VARCHAR(50) NOT NULL DEFAULT '0',
						`video_id` INT(11) NULL DEFAULT NULL,
						`last_watched` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						`created` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
						PRIMARY KEY (`history_id`),
						UNIQUE INDEX `user_id_video_id` (`user_id`, `video_id`)
					)
					COLLATE='latin1_swedish_ci'
					ENGINE=InnoDB
					AUTO_INCREMENT=1;";
	
	$pdo->query($user_history);


	$user_liked = "CREATE TABLE `liked` (
					`liked_id` INT(11) NOT NULL AUTO_INCREMENT,
					`user_id` VARCHAR(50) NOT NULL DEFAULT '0',
					`video_id` INT(11) NOT NULL DEFAULT '0',
					`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
					PRIMARY KEY (`liked_id`),
					UNIQUE INDEX `user_id_video_id` (`user_id`, `video_id`)
				)
				COLLATE='latin1_swedish_ci'
				ENGINE=InnoDB
				AUTO_INCREMENT=1;";
	
	$pdo->query($user_liked);


	$styles = "CREATE TABLE `styles` (
				`style_id` INT(11) NOT NULL AUTO_INCREMENT,
				`style_name` VARCHAR(50) NOT NULL,
				PRIMARY KEY (`style_id`)
			)
			COLLATE='latin1_swedish_ci'
			ENGINE=InnoDB
			AUTO_INCREMENT=1;";

	$pdo->query($styles);


	$topics = "CREATE TABLE `topics` (
					`topic_id` INT(11) NOT NULL AUTO_INCREMENT,
					`topic_name` VARCHAR(255) NULL DEFAULT NULL,
					PRIMARY KEY (`topic_id`)
				)
				COLLATE='latin1_swedish_ci'
				ENGINE=InnoDB
				AUTO_INCREMENT=1;";

	$pdo->query($topics);


	$videos_table = "CREATE TABLE `videos` (
						`video_id` INT(11) NOT NULL AUTO_INCREMENT,
						`youtube_id` VARCHAR(50) NULL,
						`channel_id` INT(11) NULL DEFAULT NULL,
						`title` VARCHAR(50) NOT NULL,
						`description` TEXT NOT NULL,
						`tags` MEDIUMTEXT NOT NULL,
						`date` DATE NOT NULL,
						`last_updated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
						PRIMARY KEY (`video_id`),
						UNIQUE INDEX `youtube_id` (`youtube_id`)
					)
					COLLATE='latin1_swedish_ci'
					ENGINE=InnoDB
					AUTO_INCREMENT=1;";

	$pdo->query($videos_table);


	$video_views = "CREATE TABLE `video_views` (
						`video_id` INT(11) NOT NULL,
						`view_count` INT(11) NOT NULL,
						`last_view` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						`first_view` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
						PRIMARY KEY (`video_id`)
					)
					COLLATE='latin1_swedish_ci'
					ENGINE=InnoDB;";

	$pdo->query($video_views);


	$watch_later = "CREATE TABLE `watch_later` (
						`watch_id` INT(11) NOT NULL AUTO_INCREMENT,
						`user_id` VARCHAR(50) NOT NULL,
						`video_id` INT(11) NOT NULL,
						`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						PRIMARY KEY (`watch_id`),
						UNIQUE INDEX `user_id_video_id` (`user_id`, `video_id`)
					)
					COLLATE='latin1_swedish_ci'
					ENGINE=InnoDB
					AUTO_INCREMENT=1;";
	
	$pdo->query($watch_later);

	// We will be using the Google user ID for our base user table
	$users = "CREATE TABLE `users` (
				`user_id` INT(11) NOT NULL AUTO_INCREMENT,
				`google_id` VARCHAR(50) NOT NULL,
				`email` VARCHAR(100) NULL DEFAULT NULL,
				`admin` TINYINT(4) NOT NULL DEFAULT '0',
				`last_vist` DATETIME NOT NULL,
				`created` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`user_id`),
				UNIQUE INDEX `email` (`email`)
			)
			COLLATE='latin1_swedish_ci'
			ENGINE=InnoDB
			AUTO_INCREMENT=1;";

	$pdo->query($users);

}