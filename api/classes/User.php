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
	 * Return the Google User ID based on a token passed from the client
	 *
	 * @param string $token The access token object stored on the site
	 * @return mixed int on success, false on failure
	 */
	function get_user_id_by_token($accessToken){

		try{
			$user_stmt = $this->pdo->prepare("SELECT `user_id` FROM users WHERE accessToken = :accessToken LIMIT 1");
			$user_stmt->execute(['accessToken' => $accessToken]);
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
	 * Run a prepared statment with a query and params to get an array of videos
	 *
	 * @param string $video_query
	 * @param array $params
	 * @return array
	 */
	public function get_videos_from_query(string $video_query, array $params){
		try{
			$video_stmt = $this->pdo->prepare($video_query);

			$video_stmt->execute($params);

			$videos = [];
			while ($video = $video_stmt->fetchObject())
			{
				$videos[] = jb_prepare_video($video);
			}

			return $videos;
		}catch (exception $e) {
			return [];
		}

		return [];
	}


	public function get_watch_later(int $user_id = 0, $search = [], $limit = 30){
		$params = jb_get_limit_and_offset_params($search, $limit);

		if(empty($user_id)){
			$user_id = $this->user_id;
		}

		$video_query = "SELECT V.video_id, V.youtube_id, V.channel_id, V.title, WL.created AS savedDate, WL.watch_id AS isSaved
						FROM videos AS V 
						LEFT JOIN watch_later AS WL USING(video_id) 
						WHERE `user_id` = :user_id ";

		$params[':user_id'] = $user_id;

		if(! empty($_GET['s'])){
			$video_query .= " AND ( title LIKE :title OR tags LIKE :tags) ";
			$params[':title'] = '%'.$_GET['s'].'%';
			$params[':tags'] = '%#'.$_GET['s'].',%';
		}

		return $this->get_videos_from_query($video_query, $params);
	}


	/**
	 * Get an array of videos this user has liked
	 *
	 * @param integer $user_id
	 * @param array $search
	 * @param integer $limit
	 * @return array
	 */
	public function get_liked(int $user_id = 0, $search = [], $limit = 30){
		$params = jb_get_limit_and_offset_params($search, $limit);

		if(empty($user_id)){
			$user_id = $this->user_id;
		}

		$video_query = "SELECT V.video_id, V.youtube_id, V.channel_id, V.title, L.created AS likedDate, L.liked_id AS isLiked
						FROM videos AS V 
						LEFT JOIN liked AS L USING(video_id) 
						WHERE `user_id` = :user_id ";

		$params[':user_id'] = $user_id;

		if(! empty($_GET['s'])){
			$video_query .= " AND ( title LIKE :title OR tags LIKE :tags) ";
			$params[':title'] = '%'.$_GET['s'].'%';
			$params[':tags'] = '%#'.$_GET['s'].',%';
		}

		$video_query .= " ORDER BY L.liked_id DESC LIMIT :offset, :limit";

		return $this->get_videos_from_query($video_query, $params);
	}


	/**
	 * Get a user's video history
	 *
	 * @param integer $user_id
	 * @param array $search
	 * @param integer $limit
	 * @return array
	 */
	public function get_history(int $user_id = 0, $search = [], $limit = 30){
		$params = jb_get_limit_and_offset_params($search, $limit);

		if(empty($user_id)){
			$user_id = $this->user_id;
		}


		$video_query = "SELECT V.video_id, V.youtube_id, V.channel_id, V.title, H.created AS watchedDate 
						FROM videos AS V 
						LEFT JOIN history AS H USING(video_id) 
						WHERE `user_id` = :user_id ";

		$params[':user_id'] = $user_id;

		if(! empty($_GET['s'])){
			$video_query .= " AND ( title LIKE :title OR tags LIKE :tags) ";
			$params[':title'] = '%'.$_GET['s'].'%';
			$params[':tags'] = '%#'.$_GET['s'].',%';
		}

		$video_query .= " ORDER BY H.last_watched DESC LIMIT :offset, :limit";

		return $this->get_videos_from_query($video_query, $params);
	}


	/**
	 * Save a video to a user's history
	 *
	 * @param integer $video_id
	 * @param integer $user_id
	 * @return void
	 */
	public function save_history(int $video_id, int $user_id = 0){
		if(empty($user_id)){
			$user_id = $this->user_id;
		}

		$params = ['user_id' => $user_id, 'video_id' => $video_id, 'last_watched' => date('Y-m-d H:i:s'), 'dlast_watched' => date('Y-m-d H:i:s')];

		try{
			$insert_stmt = $this->pdo->prepare("INSERT INTO history (`user_id`, `video_id`, `last_watched`) 
										VALUES (:user_id, :video_id, :last_watched)
										ON DUPLICATE KEY UPDATE `last_watched` = :dlast_watched");

			$insert_stmt->execute($params);

			return true;
		}catch (exception $e) {
			// try{
			// 	// 
			// 	$update_stmt = $this->pdo->prepare("UPDATE history SET last_watched = :last_watched WHERE `user_id` = :user_id AND `video_id` = :video_id");

			// 	$update_stmt->execute($params);

			// 	return true;
			// }catch (exception $e) {
				return false;
			//}
		}
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