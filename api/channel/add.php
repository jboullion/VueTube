<?php 

require_once('../api-setup.php');

$content = json_decode(trim(file_get_contents("php://input")), true);

if(empty($content['channel']['title']) || empty($content['channel']['youtube_id']) ) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

$new_channel = $Channel->get_channel_by_yt_id($content['channel']['youtube_id'], 'channel_id');
// If this channel already exists let's just return that channel_id and call it done
if($new_channel){
	//$channel_id = $new_channel->channel_id;// for now we are just assuming things went as expected.
	echo json_encode(array('success' => 'Channel Already Exists'));
	exit;
}

$channel_id = $Channel->insert_channel($content['channel']);

if($channel_id && is_numeric($channel_id)){

	$items = $Channel->get_channel_videos($content['channel']['youtube_id'], 120);
	$videos = $Video->channel_items_to_videos($items, $channel_id);
	if(! empty($videos)){

		foreach($videos as $video){

			// The video information returned from the channel is only a brief description.
			$video_info = $Video->get_video_info_from_yt($video['youtube_id']);
			if(! empty($video_info)){
				$video['description'] = $video_info->description?$video_info->description:'';

				if(! empty($video_info->tags)){
					$video['tags'] = '#'.implode(',#',$video_info->tags).',';
				}

			}

			if($video){
				$result = $Video->insert_video($video);
			}
		}

		// for now we are just assuming things went as expected.
		echo json_encode(array('success' => 'Channel and Videos Inserted!'));
		exit;
	}
}


echo json_encode(array('error' => 'Unable to add channel!'));
exit;