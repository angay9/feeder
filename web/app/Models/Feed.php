<?php namespace Feeder\Models;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model {

	protected $fillable = ['guid'];

	protected $table = 'feeds';
	
	public $timestamps = false;
	
	public function service()
	{
		return $this->belongsTo('\Feeder\Models\Service');
	}

}
