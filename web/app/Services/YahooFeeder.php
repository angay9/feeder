<?php namespace Feeder\Services;

use DOMDocument;
use Feeder\Api\FeedsDTO\YahooFeed;
use Illuminate\Support\Collection;

/**
* YahooFeeder
*/
class YahooFeeder extends AbstractFeeder {
	
	const FEED_TYPE_NEWS = 'news';
	const FEED_TYPE_NBA = 'nba';
	const FEED_TYPE_NHL = 'nhl';
	const FEED_TYPE_FOOTBALL = 'football';
	const FEED_TYPE_BOXING = 'boxing';
	const FEED_TYPE_FINANCE = 'finance';

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
			$feed = new YahooFeed([
				'title'	=>	$feed->getElementsByTagName('title')->item(0)->nodeValue,
				'link'	=>	$feed->getElementsByTagName('link')->item(0)->nodeValue,
				'pubDate'	=>	$feed->getElementsByTagName('pubDate')->item(0)->nodeValue,
				'description'	=>	$feed->getElementsByTagName('description')->item(0)->nodeValue,
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
			case static::FEED_TYPE_NEWS:
				$this->url = 'http://apps.shareholder.com/rss/rss.aspx?channels=632&companyid=YHOO&sh_auth=126968616%2E0%2E0%2E42133%2Efae64e245f674c42900f5ffd0a374339';
				break;

			case static::FEED_TYPE_FINANCE:
				$this->url = 'http://apps.shareholder.com/rss/rss.aspx?channels=633&companyid=YHOO&sh_auth=126968616%2E0%2E0%2E42133%2Efae64e245f674c42900f5ffd0a374339';
				break;

            case static::FEED_TYPE_BOXING:
                $this->url = 'https://sports.yahoo.com/box/rss.xml';
                break;
            
            case static::FEED_TYPE_NBA:
                $this->url = 'https://sports.yahoo.com/nba/rss.xml';
                break;
            
            case static::FEED_TYPE_NHL:
                $this->url = 'https://sports.yahoo.com/nhl/rss.xml';
                break;
            
            case static::FEED_TYPE_FOOTBALL:
                $this->url = 'http://sports.yahoo.com/soccer/rss.xml';
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
			static::FEED_TYPE_NEWS,
            static::FEED_TYPE_NBA,
            static::FEED_TYPE_NHL,
            static::FEED_TYPE_FOOTBALL,
			static::FEED_TYPE_BOXING,
			static::FEED_TYPE_FINANCE,
		];
	}
}
