<?php namespace Feeder\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model {

	protected $table = 'services';

	protected $fillable = ['name', 'feed', 'price'];
	
	public function users()
	{
		return $this->hasManyThrough('\Feeder\Models\User', '\Feeder\Models\UserService', 'service_id', 'id');
	}

}
