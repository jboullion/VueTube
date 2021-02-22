<?php 
/**
 * Logout of our user using credentials from firebase.
 * 
 * For now we are just removing out accessToken from the DB. Without access token we are assuming the user is logged out
 */

require_once('../api-setup.php');

$content = json_decode(trim(file_get_contents("php://input")));

if(empty($content->googleUser) || ! $content->googleUser->uid || ! $content->googleUser->accessToken ) {
	echo json_encode(array('error'=> 'Missing Information'));
	exit;
}

try{

	// Track our user visit
	$update_stmt = $pdo->prepare("UPDATE users 
		SET accessToken = :accessToken
		WHERE `google_id` = :google_id");

	$update_stmt->execute([
		'accessToken' => uniqid('logout'), // enter gibberish so no one can log in
		'google_id' => $content->googleUser->uid]
	);

	if($update_stmt->rowCount()){

		echo json_encode(array('success' => 'User Logged Out'));
		exit;
	}

}catch (exception $e) {
	echo json_encode(array('error' => $e->getMessage()));
	exit;
}

echo json_encode(array('error' => 'Unable to logout'));
exit;