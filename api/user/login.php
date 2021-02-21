<?php 
/**
 * Login in our user using credentials from firebase.
 * 
 * Our sessions are permanent so accessToken should be good until the user signs out through firebase. When they log in again we should have a new access token
 */

require_once('../api-setup.php');

$content = json_decode(trim(file_get_contents("php://input")));

if(empty($content->googleUser) || ! $content->googleUser->uid
|| ! $content->googleUser->email || ! $content->googleUser->refreshToken
|| ! $content->googleUser->accessToken || ! $content->googleUser->idToken ) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

try{

	// Track our user visit
	$update_stmt = $pdo->prepare("UPDATE users 
		SET photoURL = :photoURL,
			idToken = :idToken, 
			accessToken = :accessToken, 
			refreshToken = :refreshToken,
			last_visit = :last_visit 
		WHERE `google_id` = :google_id");

	$update_stmt->execute([
		'photoURL' => $content->googleUser->photoURL, 
		'idToken' => $content->googleUser->idToken, 
		'accessToken' => $content->googleUser->accessToken, 
		'refreshToken' => $content->googleUser->refreshToken, 
		'last_visit' => date('Y-m-d H:i:s'),
		'google_id' => $content->googleUser->uid]
	);

	if($update_stmt->rowCount() < 1){

		try{
			$insert_stmt = $pdo->prepare("INSERT INTO users (google_id, email, photoURL, idToken, accessToken, refreshToken, last_visit) 
											VALUES (:google_id, :email, :photoURL, :idToken, :accessToken, :refreshToken, :last_visit)");

			$insert_stmt->execute([
				'google_id' => $content->googleUser->uid, 
				'email' => $content->googleUser->email, 
				'photoURL' => $content->googleUser->photoURL, 
				'idToken' => $content->googleUser->idToken, 
				'accessToken' => $content->googleUser->accessToken, 
				'refreshToken' => $content->googleUser->refreshToken, 
				'last_visit' => date('Y-m-d H:i:s')]);
			
		}catch (exception $e) {
			echo json_encode(array('error' => $e->getMessage(), 'query' => 'insert'));
			exit;
		}
	}

	$user_id = jb_get_user_id($content->googleUser->uid, $content->googleUser->accessToken);

	if ($user_id && is_numeric($user_id)) {
		echo json_encode(['success' => 'User Logged In']);
		exit;
	}

}catch (exception $e) {
	echo json_encode(array('error' => $e->getMessage(), 'query' => 'update'));
	exit;
}

echo json_encode(array('error' => 'Unable to login'));
exit;