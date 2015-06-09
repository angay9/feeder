<?php namespace Feeder\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password', 'role'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	const ROLE_ADMIN = 1;
	const ROLE_USER = 2;

	/**
	 * Check if user is admin
	 * @return boolean
	 */
	public function isAdmin()
	{
		return (int)$this->role === static::ROLE_ADMIN;
	}

	public function devices()
	{
		return $this->hasMany('\Feeder\Models\Device');
	}

	public function logs()
	{
		return $this->hasMany('\Feeder\Models\UserLog');
	}
	
	public function services()
	{
		return $this->belongsToMany('\Feeder\Models\Service', 'users_services', 'user_id', 'service_id')->withPivot('is_active', 'active_until');
	}

	public function isServiceActive($serviceId)
	{
		$service = $this->services->where('id', $serviceId)->first();
		
		if (is_null($service)) return false;
		
		return !!$service->pivot->is_active;
	}
}
