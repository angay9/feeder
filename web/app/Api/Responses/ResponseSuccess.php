<?php
namespace Feeder\Api\Responses;

class ResponseSuccess extends ApiResponse {

	/**
	 * Response status
	 * @var string
	 */
	private $status;

	/**
	 * Data
	 * @var Mixed
	 */
	private $data;

	public function __construct($status, $data)
	{
		$this->status = $status;
		$this->data = $data;
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
	 * Get data
	 * @return mixed
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * Set data
	 * @param mixed $data
	 */
	public function setData($data)
	{
		$this->data = $data;
	}

	public function toArray()
	{
		return [
			'status' => $this->status,
			'data'	=>	$this->data,
		];
	}
}