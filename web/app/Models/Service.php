<?php namespace Feeder\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model {

	protected $table = 'services';

	protected $fillable = ['name', 'feed', 'price'];
	
	public function users()
	{
		return $this->belongsToMany('\Feeder\Models\User', 'users_services', 'service_id', 'user_id');
	}

}
