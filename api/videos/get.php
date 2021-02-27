<?php 

require_once('../api-setup.php');

if(empty($_GET['youtube_id']) ) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

if($_GET['token']){
	$video = $Video->get_video_with_user_info($_GET['youtube_id'], $_GET['token']);
}

if(empty($video)){
	$video = $Video->get_video_by_yt_id($_GET['youtube_id']);
}

echo json_encode($video);
exit;