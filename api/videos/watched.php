<?php 
/**
 * Save a video as liked by the user
 */

require_once('../api-setup.php');

$content = json_decode(trim(file_get_contents("php://input")));

if(empty($content->video_id) || ! is_numeric($content->video_id)
|| empty($content->channel_id) || ! is_numeric($content->channel_id) ) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

if(! empty($content->googleUser->uid)){
	$user_id = jb_get_user_id_by_token($content->googleUser->accessToken);

	if ($user_id) {

		$params = ['user_id' => $user_id, 'video_id' => $content->video_id, 'last_watched' => date('Y-m-d H:i:s')];

		try{
			$insert_stmt = $pdo->prepare("INSERT INTO history (`user_id`, `video_id`, `last_watched`) 
										VALUES (:user_id, :video_id, :last_watched)");
										// ON DUPLICATE KEY UPDATE `last_watched` = :last_watched

			$insert_stmt->execute($params);
		}catch (exception $e) {
			$update_stmt = $pdo->prepare("UPDATE history SET last_watched = :last_watched WHERE `user_id` = :user_id AND `video_id` = :video_id");
			$update_stmt->execute($params);
		}

	}
}

// Record this video's view
$insert_stmt = $pdo->prepare("INSERT INTO video_views (`video_id`, `view_count`) VALUES (:video_id, 1)
								ON DUPLICATE KEY UPDATE `view_count` = view_count+1");
$insert_stmt->execute(['video_id' => $content->video_id]);


// Record this channel's view
// TODO: Technically this probably isn't needed as we can get a channels view by querying all of it's videos...but whatever
$channel_obj = jb_get_video_info($content->video_id, 'channel_id');

if(! empty($channel_obj)){
	$insert_stmt = $pdo->prepare("INSERT INTO channel_views (`channel_id`, `view_count`) VALUES (:channel_id, 1)
								ON DUPLICATE KEY UPDATE `view_count` = view_count+1");
	$insert_stmt->execute(['channel_id' => $channel_obj->channel_id]);
}


// echo json_encode(['success' => 1]);
// exit;