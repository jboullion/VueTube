<?php 

require_once('../api-setup.php');

if(empty($_GET['channel_id']) 
&& empty($_GET['youtube_id'])) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

if(! empty($_GET['channel_id']) ) {
	$channel_stmt = $pdo->prepare("SELECT * FROM channels WHERE channel_id = :channel_id");

	$channel_stmt->execute(['channel_id' => $_GET['channel_id']]);
}else if(! empty($_GET['youtube_id'])){
	$channel_stmt = $pdo->prepare("SELECT * FROM channels WHERE youtube_id = :youtube_id");

	$channel_stmt->execute(['youtube_id' => $_GET['youtube_id']]);
}

$channel = $channel_stmt->fetchObject();

if($channel){
	$channel->img_name = str_replace(' ', '-', $channel->title).'.png';
}

// if(! empty($channel)){
// 	$channel->videos = $wpdb->get_results("SELECT * FROM {$wpdb->channels} WHERE channel_id = {$channel->channel_id}");
// }

echo json_encode($channel);
exit;