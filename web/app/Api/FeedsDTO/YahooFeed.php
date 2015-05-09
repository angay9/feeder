<?php namespace Feeder\Api\FeedsDTO;

class YahooFeed extends AbstractFeed {
	
	public $title;

	public $link;

	public $pubDate;

	public $description;

	public function __construct(array $data = array())
	{
		$this->init($data);
	}

}
