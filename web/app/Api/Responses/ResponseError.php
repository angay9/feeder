<?php
namespace Feeder\Api\Responses;

class ResponseError extends ApiResponse {

	/**
	 * Response status
	 * @var string
	 */
	private $status;

	/**
	 * Data
	 * @var array
	 */
	private $messages;

	public function __construct($status, array $messages)
	{
		$this->status = $status;
		$this->messages = $messages;
	}

	/**
	 * Get status
	 * @return string
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * Set status
	 * @param string $status
	 * @return self
	 */
	public function setStatus($status)
	{
		$this->status = $status;
		
		return $this;
	}

	/**
	 * Get messages
	 * @return mixed
	 */
	public function getMessages()
	{
		return $this->messages;
	}

	/**
	 * Set messages
	 * @param array $messages
	 */
	public function setData(array $messages)
	{
		$this->messages = $messages;
	}

	public function toArray()
	{
		return [
			'status' => $this->status,
			'messages'	=>	$this->messages,
		];
	}
}