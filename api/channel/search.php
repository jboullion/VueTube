<?php 
require_once('../api-setup.php');

$params = jb_get_limit_and_offset_params($DEFAULT_VID_LIMIT);

$search_query = "SELECT * FROM channels AS C ";

if(! empty($_GET['style'])){
	$search_query .= " LEFT JOIN channel_styles AS CS ON CS.channel_id = C.channel_id ";
}

if(! empty($_GET['topic'])){
	$search_query .= " LEFT JOIN channel_topics AS CT ON CT.channel_id = C.channel_id ";
}

$search_query .= " WHERE 1=1 ";

if(! empty($_GET['s'])){
	$search_query .= " AND title LIKE :title ";
	$params[':title'] = '%'.$_GET['s'].'%';
}


// if(! empty($_GET['style'])){
// 	$search_query .= $pdo->prepare(" AND CS.style_id = %d ", $_GET['style']);
// }

// if(! empty($_GET['topic'])){
// 	$search_query .= $pdo->prepare(" AND CT.topic_id = %d ", $_GET['topic']);
// }


if(! empty($_GET['rand'])){
	$search_query .= " ORDER BY RAND() ";
}else{
	$search_query .= " ORDER BY V.title ASC ";
}

$search_query .= " LIMIT :offset, :limit";

$channel_stmt = $pdo->prepare($search_query);

$channel_stmt->execute($params);

$channels = [];
while ($channel = $channel_stmt->fetchObject())
{
	$channel->img_name = str_replace(' ', '-', $channel->title).'.png';
	$video_stmt = $pdo->query("SELECT video_id, youtube_id, channel_id, title, `date` FROM videos WHERE channel_id = {$channel->channel_id} LIMIT {$DEFAULT_VID_LIMIT}");
	
	$videos = [];
	while ($video = $video_stmt->fetchObject())
	{
		$videos[] = $video;
	}

	$channel->videos = $videos;
	
	$channels[] = $channel;
}

echo json_encode($channels);
exit;