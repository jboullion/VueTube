<?php 
/**
 * Save a video for watch later list
 */
require_once('../api-setup.php');

$content = json_decode(trim(file_get_contents("php://input")));

if(empty($content->googleUser->accessToken)
|| empty($content->video_id) ) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}


$user_id = jb_get_user_id_by_uid($content->googleUser->uid);

if ($user_id) {

	$params = ['user_id' => $user_id, 'video_id' => $content->video_id];

	try{
		$insert_stmt = $pdo->prepare("INSERT INTO watch_later (`user_id`, `video_id`) VALUES (:user_id, :video_id)");
		$insert_stmt->execute($params);

		echo json_encode(array('success' => 1));
	}catch (exception $e) {
		try{
			$delete_stmt = $pdo->prepare("DELETE FROM watch_later WHERE `user_id` = :user_id AND `video_id` = :video_id");
			$delete_stmt->execute($params);

			echo json_encode(array('success' => 2));
		}catch (exception $e) {
			echo json_encode(array('error' => 'Unable to update watch later'));
		}
	}

	exit;

}else{
	echo json_encode(array('error' => 'Invalid Token'));
	exit;
}