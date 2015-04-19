<?php namespace Feeder\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model {

	protected $fillable = ['guid'];
	
	public function user()
	{
		return $this->belongsTo('\Feeder\Models\User');
	}

}
