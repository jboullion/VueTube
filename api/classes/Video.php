<?php 
/**
 * Video paramaters and functionality
 * 
 */

class Video {
	protected $pdo;
	protected $table = 'videos';

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
	 * Insert a video into the database
	 * 
	 * @param array $video An associative array of video information
	 * 
	 * @var $video[youtube_id] string, required The YouTube ID ex: QMpkFde3euA
	 * @var $video[channel_id] int, required The ID of the related channel
	 * @var $video[title] string, required The video Title
	 * @var $video[tags] string, The video's tags in a single comma delimited string. ex: #example, #example2
	 * @var $video[description] string, The video description directly from youtube without HTML or formatting
	 * @var $video[date] required string, The date this video was posted to YouTube
	 */
	public function insert_video($video){

		$default_video = [
			'tags' => '', 
			'description' => '', 
			'short_description' => ''
		];

		// Need to return some info about what is missing
		if(empty($video['youtube_id'])) return false;
		if(empty($video['channel_id'])) return false;
		if(empty($video['title'])) return false;
		if(empty($video['date'])) return false;

		// Merge our defaults so we know we have the params we need
		$video = array_merge( $default_video, $video );

		try{
			$insert_stmt = $this->pdo->prepare("INSERT INTO {$this->table} (`youtube_id`, `channel_id`, `title`, `tags`, `description`, `short_description`, `date`) 
								VALUES (:youtube_id,  :channel_id, :title, :tags, :description, :short_description, :date)");

// ON DUPLICATE KEY UPDATE
// `youtube_id` = :youtube_id, 
// `channel_id` = :channel_id,
// `title` = :title,
// `tags` = :tags,
// `description` = :description,
// `short_description` = :short_description,
// `date` = :date

			$insert_stmt->execute($video);

			return true;
		} catch (PDOException $e) {
			if(23000 == $e->getCode()){
				// Duplicate Key. For now if we get a duplicate key we are just ignoring it and calling it all good
				return true;
			}

			//print_r($e->getCode());
			print_r($e->getMessage());
			return false;
		}
	}


	/**
	 * Convert the returned channel items into video arrays for saving
	 *
	 * @param array $items An array of channel_obj->items returned from youtube API
	 * @param int $channel_id The id of this channel in our database
	 * @return array An array of videos
	 */
	function channel_items_to_videos($items, $channel_id){
		
		$videos = array();

		if($items){
			foreach($items as $item){
				$videos[] = array(
					'youtube_id' => $item->id->videoId,
					'channel_id' => $channel_id,
					'title' => $item->snippet->title,
					//$short_description = $video->snippet->description;
					'short_description' => $item->snippet->description,//sanitize_text_field(addslashes($item->snippet->description)),
					//'tags' => '#'.implode(',#',$item->snippet->tags).',',
					'date' => date('Y-m-d', strtotime($item->snippet->publishTime)),
				);
			}
		}

		return $videos;
	}


	/**
	 * Get a single video row
	 * 
	 * @param int $video_id The ID of the video in question
	 * @param string $columns The columns in question
	 * 
	 * @return object Video row
	 */
	public function get_video_info($video_id, $columns = '*'){
		global $pdo;

		$video_stmt = $pdo->prepare("SELECT {$columns} FROM videos WHERE video_id = :video_id");
		$video_stmt->execute(['video_id' => $video_id]);
		$video = $video_stmt->fetchObject();

		return $video;
	}


	/**
	 * Get YouTube information for a single video
	 *
	 * @param string $youtube_id AKA This Video's youtube ID
	 * @return object Returns object if successfull or false on failure
	 */
	public function get_video_info_from_yt($youtube_id){
		global $YT_KEY;

		$url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&id='.$youtube_id.'&key='.$YT_KEY;

		$result = file_get_contents($url);

		if($result){
			$result_obj = json_decode( $result );
			// TODO: setup check on what we return?
			
			return $result_obj->items[0]->snippet;
		}else{
			return false;
		}
	}


}