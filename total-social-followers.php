<?php
/*
 * Plugin Name: Total Social Followers
 * Plugin URI: http://element-80.com/portfolio/plugins/total-social-followers/
 * Description: Displays a total count of all Facebook, Feedburner, and Twitter followers in text format.
 * Version: 1.0
 * Author: Melody Fassino
 * Author URI: http://element-80.com/
 */

class TotalSocialFollowersStats{
	public	$twitter,$rss,$facebook;
	public	$services = array();

	public function __construct($arr) {
		$this->services = $arr;
		$BASE_URL = "https://query.yahooapis.com/v1/public/yql?q=";

		// Forming the Feedburner Awareness API URL from the passed feed URL:
		$feedBurnerAwarenessAPI = 'http://feedburner.google.com/api/awareness/1.0/GetFeedData?uri='.end(split('/',trim($arr['feedBurnerURL'],'/')));

		// Building an array with queries:
		if($arr['feedBurnerURL'])
			$feed_query = 'select * from xml where url=\''.$feedBurnerAwarenessAPI.'\'';
			$feed_query_url = $BASE_URL . urlencode($feed_query) . "&format=json&callback=";
			// Make call with cURL
			$feed_session = curl_init($feed_query_url);
			curl_setopt($feed_session, CURLOPT_RETURNTRANSFER,true);
			$feed_json = curl_exec($feed_session);
			// Convert JSON to PHP object
			$feed_result =  json_decode($feed_json);

		if($arr['twitterName'])
			$twit_query = 'select * from xml where url=\'http://twitter.com/users/show/'.$arr['twitterName'].'.xml\'';
			$twit_query_url = $BASE_URL . urlencode($twit_query) . "&format=json&callback=";
			// Make call with cURL
			$twit_session = curl_init($twit_query_url);
			curl_setopt($twit_session, CURLOPT_RETURNTRANSFER,true);
			$twit_json = curl_exec($twit_session);
			// Convert JSON to PHP object
			$twit_result =  json_decode($twit_json);

		if($arr['facebookFanPageURL'])
			$face_query = 'select * from facebook.graph where id=\''.end(split('/',trim($arr['facebookFanPageURL'],'/'))).'\'';
			$face_query_url = $BASE_URL . urlencode($face_query) . "&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=";
			// Make call with cURL
			$face_session = curl_init($face_query_url);
			curl_setopt($face_session, CURLOPT_RETURNTRANSFER,true);
			$face_json = curl_exec($face_session);
			// Convert JSON to PHP object
			$face_result =  json_decode($face_json);

		// The results from the queries are accessible in the $results array:
		$this->feed = $feed_result->query->results->rsp->feed->entry->circulation;
		$this->twitter = $twit_result->query->results->user->followers_count;
		$this->facebook = $face_result->query->results->json->fan_count;
	}

	public function generate() {
		$total = number_format($this->feed+$this->twitter+$this->facebook);
		echo $total;
	}
}

function total_social_followers($array) {
	$cacheFileName = "cache.txt";

	extract(shortcode_atts(array('facebook' => '', 'feedburner' => '', 'twitter' => ''), $array));
	$faceurl = "http://www.facebook.com/".$facebook;
	$feedurl = "http://feeds.feedburner.com/".$feedburner;
	$twiturl = $twitter;

	// If a cache file exists and it is less than 6*60*60 seconds (6 hours) old, use it:
	if(file_exists($cacheFileName) && time() - filemtime($cacheFileName) > 6*60*60) {
		$stats = unserialize(file_get_contents($cacheFileName));
	}

	if(!$stats) {
		// If no cache was found, fetch the subscriber stats and create a new cache:
		$stats = new TotalSocialFollowersStats(array(
			'facebookFanPageURL'	=> $faceurl,
			'feedBurnerURL'			=> $feedurl,
			'twitterName'			=> $twiturl
		));

		file_put_contents($cacheFileName,serialize($stats));
	}

	$stats->generate();
}

add_shortcode('total-social-followers', 'total_social_followers');