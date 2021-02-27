<?php 
/**
 * Video paramaters and functionality
 * 
 */

class Channel {
	protected $pdo;
	protected $YT_KEY;
	protected $table = 'channels';

	public int $video_id;
	public string $youtube_id;
	public int $channel_id;
	public string $title;
	public string $description;
	public string $short_description;
	public string $tags;
	public string $date;
	public string $last_updated;
	public string $created;

	/**
	 * Construct our Video class
	 *
	 * @param dbconn $pdo
	 * @param string $video_id
	 */
	public function __construct($pdo, $YT_KEY){
		$this->pdo = $pdo;
		$this->YT_KEY = $YT_KEY;
	}

	
	/**
	 * Insert a channel into the database
	 * 
	 * @param array $channel An associative array of channel information
	 * 
	 * @var $video[youtube_id] string, required The YouTube ID ex: UCHAK6CyegY22Zj2GWrcaIxg
	 * @var $video[title] string, required The channel Title
	 * @var $video[img_url] string, required The img url of this channel
	 * @var $video[facebook] string, The facebook url
	 * @var $video[instagram] string, The instagram url
	 * @var $video[patreon] string, The patreon url
	 * @var $video[tiktok] string, The tiktok url
	 * @var $video[twitter] string, The twitter url
	 * @var $video[twitch] string, The twitch url
	 * @var $video[website] string, The website url
	 */
	public function insert_channel($channel){

		$default_channel = [
			'description' => '',
			'facebook' => '', 
			'instagram' => '', 
			'patreon' => '', 
			'tiktok' => '', 
			'twitter' => '', 
			'twitch' => '', 
			'website' => ''
		];
		
		// Need to return some info about what is missing
		if(empty($channel['youtube_id'])) return false;
		if(empty($channel['title'])) return false;

		// Get the channel thumbnail url from YouTube
		$channel_info = $this->get_channel_info($channel['youtube_id']);
		
		if(! empty($channel_info)){
			$channel['description'] = $channel_info['description'];
			$channel['img_url'] = $channel_info['thumbnail'];
		}

		if(empty($channel['img_url'])) return false;
		
		// Merge our defaults so we know we have the params we need
		$channel = array_merge( $default_channel, $channel );

		unset($channel['styles']);
		unset($channel['topics']);
		unset($channel['focus']);

		// $channel['dtitle'] = $channel['title'];
		// $channel['ddescription'] = $channel['description'];
		// $channel['dimg_url'] = $channel['img_url'];
		// $channel['dfacebook'] = $channel['facebook'];
		// $channel['dinstagram'] = $channel['instagram'];
		// $channel['dpatreon'] = $channel['patreon'];
		// $channel['dtiktok'] = $channel['tiktok'];
		// $channel['dtwitter'] = $channel['twitter'];
		// $channel['dtwitch'] = $channel['twitch'];
		// $channel['dwebsite'] = $channel['website'];

		//print_r($channel);

		// TODO: Setup validation here to ensure all the URLs are actually the urls they claim to be. ie: facebook points to facebook.
		try{
			$insert_stmt = $this->pdo->prepare("INSERT INTO channels (`youtube_id`,
																`title`, 
																`description`, 
																`img_url`,
																`facebook`,
																`instagram`,
																`patreon`,
																`tiktok`,
																`twitter`,
																`twitch`,
																`website`)
											VALUES (:youtube_id,
													:title, 
													:description, 
													:img_url,
													:facebook,
													:instagram,
													:patreon,
													:tiktok,
													:twitter,
													:twitch,
													:website)");

			// ON DUPLICATE KEY UPDATE
			// `title` = :dtitle, 
			// `description` = :ddescription, 
			// `img_url` = :dimg_url, 
			// `facebook` = :dfacebook, 
			// `instagram` = :dinstagram, 
			// `patreon` = :dpatreon, 
			// `tiktok` = :dtiktok, 
			// `twitter` = :dtwitter, 
			// `twitch` = :dtwitch, 
			// `website` = :dwebsite

			$insert_stmt->execute($channel);

			$new_channel = $this->get_channel_by_yt_id($channel['youtube_id'], 'channel_id');

			if($new_channel){
				return $new_channel->channel_id;
			}

		} catch (PDOException $e) {
			if(23000 == $e->getCode()){
				// Duplicate Key. For now if we get a duplicate key we are just ignoring it and calling it all good
				return true;
			}

			// print_r($e->getCode());
			// print_r($e->getMessage());
			return false;
		}
	}


	/**
	 * Get channel information from the database by YouTube ID
	 *
	 * @param string $youtube_id YouTube channel ID
	 * @param string $columns The columns to retreive
	 * @return object
	 */
	public function get_channel_by_yt_id(string $youtube_id, $columns = '*'){
		try{
			$channel_stmt = $this->pdo->prepare("SELECT {$columns} FROM channels WHERE youtube_id = :youtube_id");

			$channel_stmt->execute(['youtube_id' => $youtube_id]);

			return $channel_stmt->fetchObject();

		} catch (PDOException $e) {
			return false;
		}
	}


	/**
	 * Get channel information from the database by YouTube ID
	 *
	 * @param int $channel_id Channel ID
	 * @param string $columns The columns to retreive
	 * @return object
	 */
	public function get_channel_by_channel_id(int $channel_id, $columns = '*'){
		try{
			$channel_stmt = $this->pdo->prepare("SELECT {$columns} FROM channels WHERE channel_id = :channel_id");

			$channel_stmt->execute(['channel_id' => $channel_id]);

			return $channel_stmt->fetchObject();

		} catch (PDOException $e) {
			return false;
		}
	}


	/**
	 * Get this Channels thumbnail and set it
	 * 
	 * @param int $post_id The ID of the post to get the featured image for
	 * @return string the URL of the post thumbnail
	 */
	public function get_channel_info($youtube_id){

		if(empty($youtube_id )) return;

		$url = 'https://www.googleapis.com/youtube/v3/channels?part=snippet&id='.$youtube_id.'&key='.$this->YT_KEY;

		$result = @file_get_contents($url);

		// If we have a result, cache the info for 1 month.
		if(! empty($result)){
			$channel_obj = json_decode( $result );

			$info = [];

			// print_r($channel_obj->items[0]->snippet);
			if(! empty($channel_obj->items[0]->snippet->description)){
				$info['description'] = $channel_obj->items[0]->snippet->description;
			}else{
				$info['description'] = '';
			}

			$info['thumbnail'] = $channel_obj->items[0]->snippet->thumbnails->default->url;

			return $info;
		}

		return [];
	}


	
	/**
	 * Get the last X videos from a channel and store them for later
	 *
	 * @param int $channel_id The YouTube channel ID
	 * @param int $max_videos The maximum number of videos 
	 * @return array
	 */
	public function get_channel_videos($channel_id, $max_videos = 120){

		$videos = [];

		if(! empty($channel_id)){
			$done = false;
			$safety = 20;
			$channel_obj = null;
			$max_results = min($max_videos, 20);

			$count = 0;
			while(! $done){
				$count++;

				$url = 'https://www.googleapis.com/youtube/v3/search?key='.$this->YT_KEY.'&channelId='.$channel_id.'&part=snippet&order=date&maxResults='.$max_results;

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


}