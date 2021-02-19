<?php 
/**
 * Return the liked videos of a particular user
 */

require_once('../api-setup.php');

if(empty($_GET['token'])){
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

$user_id = jb_get_user_id($_GET['token']);

if ($user_id) {

	$limit = ! empty($_GET['limit']) && is_numeric($_GET['limit'])?$_GET['limit']:$DEFAULT_VID_LIMIT;
	$offset = ! empty($_GET['offset']) && is_numeric($_GET['offset'])?$_GET['offset']*$limit:0;

	$params = [];

	$video_query = "SELECT V.video_id, V.youtube_id, V.channel_id, V.title, L.created AS likedDate 
					FROM videos AS V 
					LEFT JOIN liked AS L USING(video_id) 
					WHERE `user_id` = :user_id ";

	$params[':user_id'] = $user_id;

	if(! empty($_GET['s'])){
		$video_query .= " AND ( title LIKE :title OR tags LIKE :tags) ";
		$params[':title'] = '%'.$_GET['s'].'%';
		$params[':tags'] = '%#'.$_GET['s'].',%';
	}

	$video_query .= " ORDER BY L.liked_id DESC LIMIT :offset, :limit";
	$params[':offset'] = $offset;
	$params[':limit'] = $limit;

	$video_stmt = $pdo->prepare($video_query);

	$video_stmt->execute($params);

	$videos = [];
	while ($video = $video_stmt->fetchObject())
	{
		$videos[] = $video;
	}

	echo json_encode($videos);
	exit;

} else {
	echo json_encode(array('error' => 'Invalid Token'));
	exit;
}