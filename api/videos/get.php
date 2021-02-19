<?php 

require_once('../api-setup.php');

if(empty($_GET['youtube_id']) ) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

if($_GET['token']){
	$user_id = jb_get_user_id($_GET['token']);

	if($user_id){
		$video_stmt = $pdo->prepare("SELECT V.*, C.youtube_id AS channel_youtube, L.liked_id AS isLiked, WL.watch_id AS isSaved FROM videos AS V 
				LEFT JOIN channels AS C ON V.channel_id = C.channel_id
				LEFT JOIN liked AS L ON V.video_id = L.video_id AND L.user_id = :user_id_1
				LEFT JOIN watch_later AS WL ON V.video_id = WL.video_id AND WL.user_id = :user_id_2
				WHERE V.`youtube_id` = :youtube_id");
		
		$video_stmt->execute(['user_id_1' => $user_id, 'user_id_2' => $user_id, 'youtube_id' => $_GET['youtube_id']]);

		$video = $video_stmt->fetchObject();
	}
}

if(empty($video)){
	
	$video_stmt = $pdo->prepare("SELECT V.*, C.youtube_id AS channel_youtube FROM videos AS V 
			LEFT JOIN channels AS C ON V.channel_id = C.channel_id
			WHERE V.`youtube_id` = :youtube_id");

	$video_stmt->execute(['youtube_id' => $_GET['youtube_id']]);

	$video = $video_stmt->fetchObject();
}


if($video){
	$video->title = html_entity_decode($video->title, ENT_QUOTES);
	$video->description = displayTextWithLinks($video->description);
	//$video->content = apply_filters('the_content', $video->content);
}


echo json_encode($video);
exit;