<?php 
/**
 * User paramaters and functionality
 * 
 */

class User {
	protected $pdo;
	protected $table = 'users';

	public int $user_id;
	public string $google_id;
	public string $email;
	public string $photoURL;
	public string $idToken;
	public string $accessToken;
	public string $refreshToken;
	public int $admin;
	public string $last_visit;


	/**
	 * Construct our Video class
	 *
	 * @param dbconn $pdo
	 * @param string $video_id
	 */
	public function __construct($pdo){
		$this->pdo = $pdo;
	}


	/**
	 * Return the Google User ID based on a token passed from the client
	 *
	 * @param string $uid The uid object used in our state
	 * @return mixed int on success, false on failure
	 */
	function get_user_id_by_uid($uid){

		try{
			$user_stmt = $this->pdo->prepare("SELECT `user_id` FROM users WHERE google_id = :google_id LIMIT 1");
			$user_stmt->execute(['google_id' => $uid]);
			$user = $user_stmt->fetchObject();

			if( $user ){
				$this->user_id = $user->user_id;
				return $user->user_id;
			}

			return false;

		}catch (exception $e) {
			return false;
		}

		return false;
	}

	/**
	 * Toggle this user's "like" of a video
	 *
	 * @param integer $video_id
	 * @param integer $user_id
	 * @return bool
	 */
	public function toggle_like_video(int $video_id, int $user_id = 0){
		if(empty($user_id)){
			$user_id = $this->user_id;
		}

		$params = ['user_id' => $user_id, 'video_id' => $video_id];

		try{
			$insert_stmt = $this->pdo->prepare("INSERT INTO liked (`user_id`, `video_id`) VALUES (:user_id, :video_id)");
			$insert_stmt->execute($params);

			return true;
		}catch (exception $e) {
			try{
				$delete_stmt = $this->pdo->prepare("DELETE FROM liked WHERE `user_id` = :user_id AND `video_id` = :video_id");
				$delete_stmt->execute($params);

				return true;
			}catch (exception $e) {
				return false;
			}
		}

		return false;
	}

	/**
	 * Remove this video from a user's history
	 *
	 * @param integer $video_id
	 * @param integer $user_id
	 * @return bool
	 */
	public function remove_history(int $video_id, int $user_id = 0){
		if(empty($user_id)){
			$user_id = $this->user_id;
		}

		$params = ['user_id' => $user_id, 'video_id' => $video_id];

		try{
			$delete_stmt = $this->pdo->prepare("DELETE FROM history WHERE `user_id` = :user_id AND `video_id` = :video_id");
			$delete_stmt->execute($params);
	
			return true;
		}catch (exception $e) {
			return false;
		}
	}

	/**
	 * Toggle watch later for a user
	 *
	 * @param integer $video_id
	 * @param integer $user_id
	 * @return bool
	 */
	public function toggle_watch_later(int $video_id, int $user_id = 0){
		if(empty($user_id)){
			$user_id = $this->user_id;
		}

		$params = ['user_id' => $user_id, 'video_id' => $video_id];

		try{
			$insert_stmt = $this->pdo->prepare("INSERT INTO watch_later (`user_id`, `video_id`) VALUES (:user_id, :video_id)");
			$insert_stmt->execute($params);
	
			return true;
		}catch (exception $e) {
			try{
				$delete_stmt = $this->pdo->prepare("DELETE FROM watch_later WHERE `user_id` = :user_id AND `video_id` = :video_id");
				$delete_stmt->execute($params);
	
				return true;
			}catch (exception $e) {
				return false;
			}
		}
	}

}