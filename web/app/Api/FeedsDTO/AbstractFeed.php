<?php namespace Feeder\Api\FeedsDTO;

abstract class AbstractFeed {
	
	/**
	 * Create new object and init it with params
	 * 
	 * @param  array  $data
	 * @return this
	 */
	public function init(array $data = array())
	{
		foreach ($data as $prop => $value) 
		{
			if (property_exists($this, $prop)) 
			{
				$this->{$prop} = $value;
			}
		}

		return $this;
	}

}