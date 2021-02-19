<?php 
/**
 * Get a list of videos from a single channel based off of that channel's id
 */
require_once('../api-setup.php');

if(empty($_GET['channel_id']) ) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}


$limit = ! empty($_GET['limit']) && is_numeric($_GET['limit'])?$_GET['limit']:$DEFAULT_VID_LIMIT;
$offset = ! empty($_GET['offset']) && is_numeric($_GET['offset'])?$_GET['offset']*$limit:0;

$params = [];

$video_query = "SELECT  V.video_id, V.youtube_id, V.channel_id, V.title, V.`date`, C.youtube_id AS channel_youtube, C.title AS channel_title FROM videos AS V 
				LEFT JOIN channels AS C ON V.channel_id = C.channel_id
				WHERE V.channel_id = :channel_id ";

if(! empty($_GET['s'])){
	$video_query .= " AND title LIKE :search "; //, $_GET['s'].'%';
	$params[':search'] = $_GET['s'];
}

$video_query .= " LIMIT :offset, :limit";

$video_stmt = $pdo->prepare($video_query);

$params[':channel_id'] = $_GET['channel_id'];
$params[':offset'] = $offset;
$params[':limit'] = $limit;

$video_stmt->execute($params);

$videos = [];
while ($video = $video_stmt->fetchObject())
{
	$videos[] = $video;
}

echo json_encode($videos);
exit;