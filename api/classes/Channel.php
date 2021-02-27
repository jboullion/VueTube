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
	 * Return a list of channels 
	 *
	 * @return array
	 */
	public function get_channel_list($columns = '*'){
		try{
			$channel_stmt = $this->pdo->query("SELECT {$columns} FROM channels ORDER BY title ASC");

			$channels = [];
			while ($channel = $channel_stmt->fetchObject())
			{
				$channels[] = $channel;
			}

			return $channels;

		} catch (PDOException $e) {
			return false;
		}
	}


	/**
	 * Insert a channel into the database
	 * 
	 * @param array $channel An associative array of channel information
	 * 
	 * @var $channel[youtube_id] string, required The YouTube ID ex: UCHAK6CyegY22Zj2GWrcaIxg
	 * @var $channel[title] string, required The channel Title
	 * @var $channel[img_url] string, required The img url of this channel
	 * @var $channel[facebook] string, The facebook url
	 * @var $channel[instagram] string, The instagram url
	 * @var $channel[patreon] string, The patreon url
	 * @var $channel[tiktok] string, The tiktok url
	 * @var $channel[twitter] string, The twitter url
	 * @var $channel[twitch] string, The twitch url
	 * @var $channel[website] string, The website url
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

		$styles = $channel['styles'];
		$topics = $channel['topics'];
		//$focus = $channel['focus'];
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
			
			//print_r($channel);

			$insert_stmt->execute($channel);

			$new_channel = $this->get_channel_by_yt_id($channel['youtube_id'], 'channel_id');

			if($new_channel){
				if(! empty($styles)){
					$this->insert_channel_styles($styles, $new_channel->channel_id);
				}

				if(! empty($topics)){
					$this->insert_channel_topics($topics, $new_channel->channel_id);
				}

				return $new_channel->channel_id;
			}

		} catch (PDOException $e) {
			if(23000 == $e->getCode()){
				// Duplicate Key. For now if we get a duplicate key we are just ignoring it and calling it all good
				return true;
			}

			// print_r($e->getCode());
			print_r($e->getMessage());
			return false;
		}
	}


	/**
	 * Insert Channel Styles
	 *
	 * @param array $style_ids An array of style IDs to associate with this channel
	 * @param int $channel_id The channel id to associate with these styles
	 * @return void
	 */
	public function insert_channel_styles(array $style_ids, int $channel_id){
		if(empty($style_ids) || ! is_array($style_ids)) return;

		try{
			foreach($style_ids as $style_id){
				// We are using ON DUPLICATE KEY UPDATE to essentially ignore duplicates which would throw an exception and stop all other inserts
				$channel_stmt = $this->pdo->prepare("INSERT INTO channel_styles (`channel_id`, `style_id`) 
												VALUES (:channel_id, :style_id)
												ON DUPLICATE KEY UPDATE 
												`style_id` = :dstyle_id");

				$channel_stmt->execute(['channel_id' => $channel_id, 'style_id' => $style_id, 'dstyle_id' => $style_id]);
			}
		} catch (PDOException $e) {
			//return false;
		}
	}


	
	/**
	 * Insert Channel Topics
	 *
	 * @param array $topic_ids An array of topic IDs to associate with this channel
	 * @param int $channel_id The channel id to associate with these topics
	 * @return void
	 */
	public function insert_channel_topics(array $topic_ids, int $channel_id){
		if(empty($topic_ids) || ! is_array($topic_ids)) return;

		try{
			foreach($topic_ids as $topic_id){
				// We are using ON DUPLICATE KEY UPDATE to essentially ignore duplicates which would throw an exception and stop all other inserts
				$channel_stmt = $this->pdo->prepare("INSERT INTO channel_topics (`channel_id`, `topic_id`) 
												VALUES (:channel_id, :topic_id)
												ON DUPLICATE KEY UPDATE 
												`topic_id` = :dtopic_id");

				$channel_stmt->execute(['channel_id' => $channel_id, 'topic_id' => $topic_id, 'dtopic_id' => $topic_id]);
			}

		} catch (PDOException $e) {
			//return false;
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

	/**
	 * Search our channels based on search parameters
	 *
	 * @param array $search
	 * @var $search[style] int A style_id to search
	 * @var $search[topic] int A topic_id to search
	 * @var $search[s] string String to search channel titles
	 * @var $search[rand] bool shoudl this be a random order?
	 * 
	 * @param int $limit The numnber of videos to return 
	 * @return array
	 */
	public function search($search = [], $limit = 20, $columns = ''){

		if(empty($columns)){
			$columns = 'youtube_id, channel_id, title, img_url, facebook, instagram, patreon, tiktok, twitter, twitch, website';
		}

		$params = jb_get_limit_and_offset_params($search, $limit);

		$search_query = "SELECT {$columns} FROM channels AS C ";

		if(! empty($search['style'])){
			$search_query .= " LEFT JOIN channel_styles AS CS ON CS.channel_id = C.channel_id ";
		}

		if(! empty($search['topic'])){
			$search_query .= " LEFT JOIN channel_topics AS CT ON CT.channel_id = C.channel_id ";
		}

		$search_query .= " WHERE 1=1 ";

		if(! empty($search['s'])){
			// TODO: We may want to also do a search for videos with titles or tags which match this value and return DISTINCT(channel_id). 
			// 		That way it isn't just channel's being searched

			$search_query .= " AND title LIKE :title ";
			$params[':title'] = '%'.$search['s'].'%';
		}


		if(! empty($search['style'])){
			$search_query .= " AND CS.style_id = :style ";
			$params[':style'] = $search['style'];
		}

		if(! empty($search['topic'])){
			$search_query .= " AND CT.topic_id = :topic ";
			$params[':topic'] = $search['topic'];
		}


		if(! empty($search['rand'])){
			$search_query .= " ORDER BY RAND() ";
		}else{
			$search_query .= " ORDER BY title ASC ";
		}

		$search_query .= " LIMIT :offset, :limit";

		$channel_stmt = $this->pdo->prepare($search_query);

		$channel_stmt->execute($params);

		$channels = [];
		while ($channel = $channel_stmt->fetchObject())
		{
			//$channel->img_name = str_replace(' ', '-', $channel->title).'.png';

			$channel->videos = $this->get_channel_videos_by_channel_id($channel->channel_id);
			
			$channels[] = $channel;
		}
		
		return $channels;
	}

	/**
	 * Get a channels videos by the channel id
	 *
	 * @param integer $channel_id
	 * @param integer $limit
	 * @param string $columns Custom columns to retreive
	 * 
	 * @return array An array of videos prepared for display
	 */
	public function get_channel_videos_by_channel_id(int $channel_id, int $limit = 20, $columns = 'video_id, youtube_id, channel_id, title, `description`, `date`'){

		$videos = [];
		try{
			$video_stmt = $this->pdo->query("SELECT {$columns} FROM videos WHERE channel_id = {$channel_id} LIMIT {$limit}");

			while ($video = $video_stmt->fetchObject())
			{
				$videos[] = jb_prepare_video($video);
			}

			return $videos;
			
		} catch (PDOException $e) {
			return false;
		}

		return $videos;
	}


	

	
}