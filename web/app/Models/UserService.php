<?php namespace Feeder\Models;

use Illuminate\Database\Eloquent\Model;

class UserService extends Model {

	protected $table = 'users_services';

	public $timestamps = false;

	protected $fillable = ['user_id', 'service_id', 'is_active', 'active_until'];
	
	public function user()
	{
		return $this->belongsTo('\Feeder\Models\User');
	}

	public function service()
	{
		return $this->belongsTo('\Feeder\Models\Service');
	}
}
