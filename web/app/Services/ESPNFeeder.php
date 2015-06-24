<?php namespace Feeder\Services;

use DOMDocument;
use Feeder\Api\FeedsDTO\ESPNFeed;
use Illuminate\Support\Collection;

/**
* ESPNFeeder
*/
class ESPNFeeder extends AbstractFeeder {
	
	const FEED_TYPE_NBA = 'nba';
	const FEED_TYPE_NHL = 'nhl';
	const FEED_TYPE_POKER = 'poker';
	const FEED_TYPE_FOOTBALL = 'football';

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->feeds = new Collection;
	}

	/**
	 * Fetch all news feeds
	 * @return Collection
	 */
	public function fetch()
	{
		$content = file_get_contents($this->url);
		$document = new DOMDocument;
		$document->loadXML($content);
		$this->parseRss($document);

		return $this->feeds->all();
	}

	/**
	 * Parse DOMDocument to a list of feeds
	 * @param  DOMDocument $document XML DOM Document
	 * @return void
	 */
	public function parseRss(DOMDocument $document)
	{
		$feeds = $document->getElementsByTagName('item');

		foreach ($feeds as $feed) 
		{
			$feed = new ESPNFeed([
				'title'	=>	$feed->getElementsByTagName('title')->item(0)->nodeValue,
				'link'	=>	$feed->getElementsByTagName('link')->item(0)->nodeValue,
				'description' => strip_tags($feed->getElementsByTagName('description')->item(0) ? $feed->getElementsByTagName('description')->item(0)->nodeValue : ''),
				'pubDate'	=>	date('Y-m-d H:i:s', strtotime($feed->getElementsByTagName('pubDate')->item(0)->nodeValue)),
			]);

			$this->feeds->push($feed);
		}
	}

	/**
	 * Set feeds type
	 * @param self::FEED_TYPE_{TYPE} $feedType
	 * @return $this
	 */
	public function setFeedType($feedType)
	{
		switch($feedType) {
			case static::FEED_TYPE_NBA:
				$this->url = 'http://sports.espn.go.com/espn/rss/nba/news';
				break;

			case static::FEED_TYPE_NHL:
				$this->url = 'http://sports.espn.go.com/espn/rss/nhl/news';
				break;

			case static::FEED_TYPE_POKER:
				$this->url = 'http://sports.espn.go.com/espn/rss/poker/master';
				break;

			case static::FEED_TYPE_FOOTBALL:
				$this->url = 'http://www.espnfc.com/rss';
				break;
		}

		return $this;
	}

	/**
	 * Validate requested feed type
	 * @return bool
	 */
	public function validate($feedType) 
	{
		return in_array($feedType, static::feedTypes());
	}

	/**
	 * Get all feed types
	 * @return array
	 */
	public static function feedTypes() 
	{
		return [
			static::FEED_TYPE_NBA,
			static::FEED_TYPE_NHL,
			static::FEED_TYPE_POKER,
			static::FEED_TYPE_FOOTBALL,
		];
	}
}
