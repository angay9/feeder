<?php namespace Feeder\Services;

use DOMDocument;
use Feeder\Api\FeedsDTO\NYTFeed;
use Illuminate\Support\Collection;

/**
* NYTFeeder
*/
class NYTFeeder extends AbstractFeeder {
	
	const FEED_TYPE_SPORTS = 'sports';
	const FEED_TYPE_SCIENCE = 'science';
	const FEED_TYPE_BUSINESS = 'business';
	const FEED_TYPE_TECHNOLOGY = 'technology';
	
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
			$feed = new NYTFeed([
				'title'	=>	$feed->getElementsByTagName('title')->item(0)->nodeValue,
				'link'	=>	$feed->getElementsByTagName('guid')->item(0)->nodeValue,
				'pubDate'	=>	date('Y-m-d H:i:s', strtotime($feed->getElementsByTagName('pubDate')->item(0)->nodeValue)),
				'description'	=>	strip_tags($feed->getElementsByTagName('description')->item(0)->nodeValue),
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
			case static::FEED_TYPE_SPORTS:
				$this->url = 'http://rss.nytimes.com/services/xml/rss/nyt/Sports.xml';
				break;
			case static::FEED_TYPE_SCIENCE:
				$this->url = 'http://rss.nytimes.com/services/xml/rss/nyt/Science.xml';
				break;
			case static::FEED_TYPE_BUSINESS:
				$this->url = 'http://rss.nytimes.com/services/xml/rss/nyt/Business.xml';
				break;
			case static::FEED_TYPE_TECHNOLOGY:
				$this->url = 'http://rss.nytimes.com/services/xml/rss/nyt/Technology.xml';
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
			static::FEED_TYPE_SPORTS,
			static::FEED_TYPE_SCIENCE,
			static::FEED_TYPE_BUSINESS,
			static::FEED_TYPE_TECHNOLOGY,
		];
	}
	
}
