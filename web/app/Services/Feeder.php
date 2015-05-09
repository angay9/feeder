<?php namespace Feeder\Services;

use Feeder\Exceptions\UnknownChannelException;
use Feeder\Exceptions\UnknownFeedTypeException;
/**
* Feeder 
*/
class Feeder {
	
	// Available feed channels
	const CHANNEL_YAHOO =	'yahoo'; // Yahoo
	const CHANNEL_ESPN	=	'espn';	 // ESPN
	const CHANNEL_NYT	=	'nyt';	 // New York Times
	const CHANNEL_BBC	=	'bbc';	 // BBC

	/**
	 * Make an appropriate feeder
	 * @param  string $channel Requested feeds channel
	 * @param  string $feedType Requested feed type
	 * @return FeederInterface
	 */
	public function make($channel, $feedType)
	{
		if (!$this->validate($channel)) 
		{
			throw new UnknownChannelException("Invalid channel $channel");
		}
		$feeder = $this->create($channel, $feedType);

		return $feeder !== null ? $feeder->setFeedType($feedType) : null;
	}

	/**
	 * Validate channel type
	 * @param  string $channnel Feeds channel type
	 * @return bool
	 */
	public function validate($channel) 
	{
		return in_array($channel, $this->channels());
	}

	/**
	 * Get all channels
	 * @return array
	 */
	public function channels()
	{
		return [
			static::CHANNEL_YAHOO,
			static::CHANNEL_ESPN,
			static::CHANNEL_NYT,
			static::CHANNEL_BBC,
		];
	}

	/**
	 * Create feeder
	 * @param  	string $channel News channel
	 * @param 	string $feedType Feed type
	 * @return 	AbstractFeeder
	 */
	public function create($channel, $feedType)
	{
		$feeder = !is_null($feederType = $this->detect($channel)) ? new $feederType : null;
		if ($feeder !== null) 
		{
			if (!$feeder->validate($feedType))
				throw new UnknownFeedTypeException("Invalid feed type $feedType");
			
			return $feeder;
		}
	}

	/**
	 * Detect appropriate feeder
	 * @param  string $channel Requested channel
	 * @return string|null
	 */
	public function detect($channel)
	{
		$feeder = null;
		switch ($channel) {
			case self::CHANNEL_YAHOO:
				return '\Feeder\Services\YahooFeeder';			

			case self::CHANNEL_NYT:
				return 'Feeder\Services\NYTFeeder';

			case self::CHANNEL_ESPN:
				return 'Feeder\Services\ESPNFeeder';

			case self::CHANNEL_BBC:
				return 'Feeder\Services\BBCFeeder';
		}
	}
}