<?php 
/**
 * Get videos related to a partcular channel.
 * 
 * TODO: We may want a more sophisticated related functionality, but for now we just find similar channels and get random videos from them
 */
require_once('../api-setup.php');

if(empty($_GET['channel_id']) ) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}


$user_id = ! empty($_GET['user_id'])?:0;

$limit = ! empty($_GET['limit']) && is_numeric($_GET['limit'])?$_GET['limit']:$DEFAULT_VID_LIMIT;
$offset = ! empty($_GET['offset']) && is_numeric($_GET['offset'])?$_GET['offset']*$limit:0;


$style_stmt = $pdo->prepare("SELECT style_id FROM channel_styles 
								WHERE `channel_id` = :channel_id");

$style_stmt->execute(['channel_id' => $_GET['channel_id']]);

$style_ids = [];
while ($style = $style_stmt->fetchObject())
{
	$style_ids[] = $style->style_id;
}


// $topic_stmt = $pdo->prepare("SELECT topic_id FROM channel_topics 
// 								WHERE `channel_id` = :channel_id");

// $topic_stmt->execute(['channel_id' => $_GET['channel_id']]);

// $topic_ids = [];
// while ($topic = $topic_stmt->fetchObject())
// {
// 	$topic_ids[] = $topic->topic_id;
// }

$channel_ids = [];
if(! empty($style_ids)){
	// What channels share these styles
	$related_stmt = $pdo->query("SELECT channel_id FROM channel_styles WHERE `style_id` IN (".implode(',',$style_ids).")");

	while ($channel = $related_stmt->fetchObject())
	{
		$channel_ids[] = $channel->channel_id;
	}
}else{
	$channel_ids[] = $_GET['channel_id'];

}


if(! empty($channel_ids)){

	$video_stmt = $pdo->prepare("SELECT V.video_id, V.youtube_id, V.channel_id, V.title, V.`date`, C.youtube_id AS channel_youtube, C.title AS channel_title FROM videos AS V 
								LEFT JOIN channels AS C ON V.channel_id = C.channel_id
								WHERE V.`channel_id` IN (".implode(',',$channel_ids).")
								ORDER BY RAND()
								LIMIT :limit");

	$video_stmt->execute(['limit' => $limit]);

	$videos = [];
	while ($video = $video_stmt->fetchObject())
	{
		$video->title = html_entity_decode($video->title, ENT_QUOTES);
		//$video->description = displayTextWithLinks($video->description);
		//$video->content = apply_filters('the_content', $video->content);

		$videos[] = $video;
	}

	// L.liked_id AS isLiked 
	//LEFT JOIN {$wpdb->liked} AS L ON V.video_id = L.video_id AND L.user_id = %d

	echo json_encode($videos);
	exit;
}


echo json_encode([]);
exit;