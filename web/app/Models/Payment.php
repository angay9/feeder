<?php namespace Feeder\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model {

	protected $fillable = ['service_id', 'user_id', 'created_at'];

	protected $table = 'payments';
	
	public $timestamps = false;

	public function user()
	{
		return $this->belongsTo('\Feeder\Models\User');
	}

	public function service()
	{
		return $this->belongsTo('\Feeder\Models\Service');
	}

}
