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
	// TODO: We may want to also do a search for videos with titles or tags which match this value and return DISTINCT(channel_id). 
	// 		That way it isn't just channel's being searched

	$search_query .= " AND title LIKE :title ";
	$params[':title'] = '%'.$_GET['s'].'%';
}


if(! empty($_GET['style'])){
	$search_query .= " AND CS.style_id = :style ";
	$params[':style'] = $_GET['style'];
}

if(! empty($_GET['topic'])){
	$search_query .= " AND CT.topic_id = :topic ";
	$params[':topic'] = $_GET['topic'];
}


if(! empty($_GET['rand'])){
	$search_query .= " ORDER BY RAND() ";
}else{
	$search_query .= " ORDER BY title ASC ";
}

$search_query .= " LIMIT :offset, :limit";

$channel_stmt = $pdo->prepare($search_query);

$channel_stmt->execute($params);

$channels = [];
while ($channel = $channel_stmt->fetchObject())
{
	$channel->img_name = str_replace(' ', '-', $channel->title).'.png';
	$video_stmt = $pdo->query("SELECT video_id, youtube_id, channel_id, title, `description`, `date` FROM videos WHERE channel_id = {$channel->channel_id} LIMIT {$DEFAULT_VID_LIMIT}");
	
	$videos = [];
	while ($video = $video_stmt->fetchObject())
	{
		$video->title = html_entity_decode($video->title, ENT_QUOTES);
		$video->description = formatDescription($video->description);
		$videos[] = $video;
	}

	$channel->videos = $videos;
	
	$channels[] = $channel;
}

echo json_encode($channels);
exit;