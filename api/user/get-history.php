<?php 
/**
 * Get all the videos this user has watched
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

	$video_query = "SELECT V.video_id, V.youtube_id, V.channel_id, V.title, H.created AS watchedDate 
					FROM videos AS V 
					LEFT JOIN history AS H USING(video_id) 
					WHERE `user_id` = :user_id ";

	$params[':user_id'] = $user_id;

	if(! empty($_GET['s'])){
		$video_query .= " AND ( title LIKE :title OR tags LIKE :tags) ";
		$params[':title'] = '%'.$_GET['s'].'%';
		$params[':tags'] = '%#'.$_GET['s'].',%';
	}

	$video_query .= " ORDER BY H.last_watched DESC LIMIT :offset, :limit";

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

	// $video_query = $wpdb->prepare("SELECT V.*, H.created AS watchedDate FROM {$wpdb->videos} AS V 
	// 				LEFT JOIN {$wpdb->history} AS H USING(video_id) 
	// 				WHERE `user_id` = %s ", $user_id);
		
	// if(! empty($_GET['s'])){
	// 	$video_query .= $wpdb->prepare(" AND ( title LIKE %s OR tags LIKE %s) ", '%'.$_GET['s'].'%', '%#'.$_GET['s'].',%');
	// }


	// $video_query .= $wpdb->prepare(" ORDER BY H.last_watched DESC
	// 				LIMIT %d, %d", $offset, $limit);


	// $videos = $wpdb->get_results($video_query);

	// echo json_encode($videos);
	// exit;
}else{
	echo json_encode(array('error' => 'Invalid Token'));
	exit;
}