<?php namespace Feeder\Api\FeedsDTO;

class BBCFeed extends AbstractFeed {

	public $title;

	public $link;

	public $description;

	public $pubDate;

	public function __construct(array $data = array()) 
	{
		$this->init($data);
	}

}