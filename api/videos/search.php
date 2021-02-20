<?php 
require_once('../api-setup.php');


$limit = ! empty($_GET['limit']) && is_numeric($_GET['limit'])?$_GET['limit']:$DEFAULT_VID_LIMIT;
$offset = ! empty($_GET['offset']) && is_numeric($_GET['offset'])?$_GET['offset']*$limit:0;


$search_query = "SELECT * FROM videos AS V ";

// if(! empty($_GET['style'])){
// 	$search_query .= " LEFT JOIN channel_styles AS CS ON CS.channel_id = C.channel_id ";
// }

// if(! empty($_GET['topic'])){
// 	$search_query .= " LEFT JOIN channel_topics AS CT ON CT.channel_id = C.channel_id ";
// }

$search_query .= " WHERE 1=1 ";

if(! empty($_GET['s'])){
	$search_query .= " AND ( title LIKE :title OR tags LIKE :tags) ";
	$params[':title'] = '%'.$_GET['s'].'%';
	$params[':tags'] = '%#'.$_GET['s'].',%';
}

if(! empty($_GET['channel_id'])){
	$search_query .= " AND channel_id = :channel_id ";
	$params[':channel_id'] = $_GET['channel_id'];
}

// if(! empty($_GET['style'])){
// 	$search_query .= " AND CS.style_id = %d ", $_GET['style'];
// }

// if(! empty($_GET['topic'])){
// 	$search_query .= " AND CT.topic_id = %d ", $_GET['topic'];
// }

if(! empty($_GET['rand'])){
	$search_query .= " ORDER BY RAND() ";
}else{
	$search_query .= " ORDER BY V.title ASC ";
}

$search_query .= " LIMIT :offset, :limit";

$params[':offset'] = $offset;
$params[':limit'] = $limit;

$video_stmt = $pdo->prepare($search_query);

$video_stmt->execute($params);

$videos = [];
while ($video = $video_stmt->fetchObject())
{
	$videos[] = $video;
}

echo json_encode($videos);
exit;