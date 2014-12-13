<?php

class Gathering extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'gatherings';

	public function users() {
		return $this->belongsToMany('User', 'user_gathering', 'gathering_id', 'user_id');
	}

	public static function user_gathering($gatheringID)
    {

    	$result = User::find(Auth::user()->id)->gatherings()->where('gathering_id', '=', $gatheringID)->exists();

    	return $result;
    }
}
