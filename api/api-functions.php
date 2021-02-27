<?php 
/**
 * Various helper functions used throughout the API
 */

 /**
  * Get the current subdomain string
  *
  * @return string
  */
function get_current_subdomain(){
	$host = explode('.', $_SERVER['HTTP_HOST']);
	//$subdomain = $host[0];
	return $host[0];
}


/**
 * Seach a text string and convert all urls with links
 *
 * @param string $s
 * @return string
 */
function displayTextWithLinks($s) {
	return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank" rel="nofollow">$1</a>', $s);
}

/**
 * Return the Google User ID based on a token passed from the client
 *
 * @param string $accessToken The accessToken from Firebase. Updated on login
 * @return mixed int on success, false on failure
 */
function jb_get_user_id_by_token($accessToken){
	global $pdo;

	try{
		$user_stmt = $pdo->prepare("SELECT `user_id` FROM users WHERE accessToken = :accessToken LIMIT 1");
		$user_stmt->execute(['accessToken' => $accessToken]);
		$user = $user_stmt->fetchObject();

		if( $user ){
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
 * @param string $uid The uid object used in our state
 * @param string $accessToken The accessToken from Firebase. Updated on login
 * @return mixed int on success, false on failure
 */
function jb_get_user_id_by_uid($uid){
	global $pdo;

	try{
		$user_stmt = $pdo->prepare("SELECT `user_id` FROM users WHERE google_id = :google_id LIMIT 1");
		$user_stmt->execute(['google_id' => $uid]);
		$user = $user_stmt->fetchObject();

		if( $user ){
			return $user->user_id;
		}

		return false;

	}catch (exception $e) {
		return false;
	}

	return false;
}

// OLD: Custom Google user tracking. Depricated in favor of Firebase tracking.
// function jb_get_user_id($token){
// 	global $pdo;

// 	$LOGIN_CLIENT_ID = '310021421846-4atakhdcfm62jj95u4193fu2ri8h9q40.apps.googleusercontent.com';

// 	try{
// 		$client = new Google_Client(['client_id' => $LOGIN_CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
// 		//$client->addScope(Google_Service_Plus::USERINFO_EMAIL);
// 		//$client->addScope(Google_Service_Plus::USERINFO_PROFILE);
// 		//$client->isAccessTokenExpired()

// 		// TODO: each token is only good for 1 hour and then it needs to be refreshed. We should be able to either get a refresh token and store it in the DB which we can use to refresh the client OR ....something else.
// 		$payload = $client->verifyIdToken($token);

// 		if ($payload && $payload['sub']) {

// 			$user_stmt = $pdo->prepare("SELECT `user_id` FROM users WHERE google_id = :google_id LIMIT 1");
// 			$user_stmt->execute(['google_id' => $payload['sub']]);

// 			if( $user_stmt->rowCount() < 1){
// 				$insert_stmt = $pdo->prepare("INSERT INTO users (google_id, email, last_vist) VALUES (:google_id, :email, :last_visit)");
// 				$insert_stmt->execute(['google_id' => $payload['sub'], 'email' => $payload['email'], 'last_visit' => date('Y-m-d H:i:s')]);
// 				$user = $user_stmt->fetchObject();
// 			}else{
// 				$user = $user_stmt->fetchObject();
// 			}

// 			return $user->user_id;
// 		}

// 		return false;
// 	}catch (exception $e) {
// 		return false;
// 	}

// 	return false;
// }


/**
 * Get a single video row
 * 
 * @param int $video_id The ID of the video in question
 * @param string $columns The columns in question
 * 
 * @return object Video row
 */
function jb_get_video_info($video_id, $columns = '*'){
	global $pdo;

	$video_stmt = $pdo->prepare("SELECT {$columns} FROM videos WHERE video_id = :video_id");
	$video_stmt->execute(['video_id' => $video_id]);
	$video = $video_stmt->fetchObject();

	return $video;
}

/**
 * Get this Channels thumbnail and set it
 * 
 * @param int $post_id The ID of the post to get the featured image for
 * @return string the URL of the post thumbnail
 */
function jb_get_channel_thumbnail($youtube_id){
	global $yt_key;

	if(empty($youtube_id )) return;

	$url = 'https://www.googleapis.com/youtube/v3/channels?part=snippet&fields=items%2Fsnippet%2Fthumbnails%2Fdefault&id='.$youtube_id.'&key='.$yt_key;

	$result = @file_get_contents($url);

	// If we have a result, cache the info for 1 month.
	if(! empty($result)){
		$channel_obj = json_decode( $result );
		return $channel_obj->items[0]->snippet->thumbnails->default->url;
	}

	return '';
}

/**
 * Get the img url of video
 *
 * @param int $video_id The id of the video
 */
function jb_get_video_img_url($video_id, $size = 'mqdefault'){
	//0,1,2,3,default,hqdefault,mqdefault,sddefault,maxresdefault
	$img_url = 'https://img.youtube.com/vi/'.$video_id.'/'.$size.'.jpg';

	@getimagesize($img_url, $img_size);

	// Sometimes we do not have access to the video thumbnail and a "missing" img is returned that is 90 px high
	if(empty($img_size) || $img_size[1] === 90){
		$img_url = 'https://img.youtube.com/vi/'.$video_id.'/0.jpg';
	}

	return $img_url;
}


/**
 * Get the limit and offset from GET
 *
 * @return array A $params array with :limit and :offset set
 */
function jb_get_limit_and_offset_params($default_limit = 30){
	$params = [];
	$params[':limit'] = ! empty($_GET['limit']) && is_numeric($_GET['limit'])?$_GET['limit']:$default_limit;
	$params[':offset'] = ! empty($_GET['offset']) && is_numeric($_GET['offset'])?$_GET['offset']*$params[':limit']:0;

	return $params;
}



/**
 * Get the last X videos from a channel and store them for later
 *
 * @param int $channel_id The YouTube channel ID
 * @param int $max_videos The maximum number of videos 
 * @return array
 */
function jb_get_channel_videos($channel_id, $max_videos = 120){
	global $YT_KEY;

	$videos = [];

	if(! empty($channel_id)){
		$done = false;
		$safety = 20;
		$channel_obj = null;

		$count = 0;
		while(! $done){
			$count++;

			$url = 'https://www.googleapis.com/youtube/v3/search?key='.$YT_KEY.'&channelId='.$channel_id.'&part=snippet&order=date&maxResults=20';

			if($channel_obj && ! empty($channel_obj->nextPageToken)){
				$url .= '&pageToken='.$channel_obj->nextPageToken;
			}

			$result = file_get_contents($url);

			if($result){

				$channel_obj = json_decode( $result );

				$videos = array_merge($videos, $channel_obj->items);

				if(count($videos) >= $max_videos
				|| $count > $safety){
					$done = true;
					break;
				}
			}else{
				$done = true;
				break;
			}
		}

	}

	return $videos;
}


/**
 * Get YouTube information for a single video
 *
 * @param string $video_id AKA This Video's youtube ID
 * @return object Returns object if successfull or false on failure
 */
function jb_get_detailed_video_info($video_id){
	global $YT_KEY;

	$url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&id='.$video_id.'&key='.$YT_KEY;

	$result = file_get_contents($url);

	if($result){
		$result_obj = json_decode( $result );
		// TODO: setup check on what we return?
		return $result_obj->items[0]->snippet;
	}else{
		return false;
	}
}


/**
 * This wraps blocks of text (delimited by \n) in p tags (similar to nl2br)
 * 
 * @author Scott Dover <sdover102@gmail.com>
 * @param str
 * @return str
 */
function nl2p($string) {
	/* Explode based on new-line */
	$string_parts = explode("\n", $string);

	/* Wrap each block in a p tag */
	$string = '<p>' . implode('</p><p>', $string_parts) . '</p>';	

	/* Return the string with empty paragraphs removed */
	return str_replace("<p></p>", '', $string);	
}


/**
 * Format the text returned from youtube for display
 *
 * @param string $string
 * @return string
 */
function formatDescription($string){
	$string = displayTextWithLinks($string);
	$string = nl2p($string);
	return $string;
}


/**
 * Add a video to our normalized tables for easier searching from front end
 *
 * @param object $video The video object from the cached_video_list meta_data
 * @param int $channel_id The channel_id of the normalized channel related to this video
 * @return void
 */
function jb_add_video($video, $channel_id){
	global $wpdb;

	if(empty($video->id) || empty($video->id->videoId)) return;

	$tag_string = '';
	if($video->tags){
		$tag_string = '#'.implode(',#',$video->tags).',';
	}
	
	$video_info->title = html_entity_decode($video_info->title, ENT_QUOTES);
	$video_info->description = displayTextWithLinks( html_entity_decode($video_info->description, ENT_QUOTES));

	$prepared_description = apply_filters('the_content', $video_info->description); //sanitize_text_field(addslashes($video_info->description));


	// This query works but the insert above does not. Weird
	$wpdb->query(
		$wpdb->prepare("INSERT INTO {$wpdb->videos} (`youtube_id`, `channel_id`, `title`, `tags`, `description`, `date`) 
						VALUES (%s, %d, %s, %s, %s, %s)
						ON DUPLICATE KEY UPDATE
						`youtube_id` = %s, 
						`channel_id` = %d,
						`title` = %s,
						`tags` = %s,
						`description` = %s,
						`date` = %s", 
						$video->id->videoId, 
						$channel_id, 
						$video_info->title, 
						$tag_string,
						$prepared_description, 
						date('Y-m-d', strtotime($video_info->publishedAt)), 
						$video->id->videoId, 
						$channel_id,
						$video_info->title, 
						$tag_string, 
						$prepared_description, 
						date('Y-m-d', strtotime($video_info->publishedAt))
			
		)
	);

}
