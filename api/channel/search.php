<?php 

require_once('../api-setup.php');


$limit = ! empty($_GET['limit']) && is_numeric($_GET['limit'])?$_GET['limit']:$DEFAULT_VID_LIMIT;
$offset = ! empty($_GET['offset']) && is_numeric($_GET['offset'])?$_GET['offset']*$limit:0;

$search_query = "SELECT * FROM channels AS C ";

if(! empty($_GET['style'])){
	$search_query .= " LEFT JOIN channel_styles AS CS ON CS.channel_id = C.channel_id ";
}

if(! empty($_GET['topic'])){
	$search_query .= " LEFT JOIN channel_topics AS CT ON CT.channel_id = C.channel_id ";
}

$search_query .= " WHERE 1=1 ";

// if(! empty($_GET['s'])){
// 	$search_query .= $pdo->prepare("AND title LIKE %s ", '%'.$_GET['s'].'%');
// }

// if(! empty($_GET['style'])){
// 	$search_query .= $pdo->prepare(" AND CS.style_id = %d ", $_GET['style']);
// }

// if(! empty($_GET['topic'])){
// 	$search_query .= $pdo->prepare(" AND CT.topic_id = %d ", $_GET['topic']);
// }

// if(! empty($_GET['rand'])){
// 	$search_query .= " ORDER BY RAND()";
// }

//$search_query .= $pdo->prepare("LIMIT %d, %d", $offset, $limit);

$channel_stmt = $pdo->query($search_query);
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


// if(! empty($channels)){
// 	foreach($channels as $key => &$channel){
// 		//$channels[$key]->img_url = str_replace('http:', 'https:', $channels[$key]->img_url);
// 		$channels[$key]->img_name = str_replace(' ', '-', $channel->title).'.png';
// 		$video_stmt = $pdo->query("SELECT video_id, youtube_id, channel_id, title, `date` FROM videos WHERE channel_id = {$channel->channel_id} LIMIT {$DEFAULT_VID_LIMIT}");
		
// 		$videos = [];
// 		while ($row = $video_stmt->fetchObject())
// 		{
// 			$videos[] = $row;
// 		}

// 		$channels[$key]->videos = $videos;
// 	}
// }

echo json_encode($channels);
exit;