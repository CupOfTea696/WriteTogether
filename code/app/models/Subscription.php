<?php

class Subscription extends Eloquent{
    public $timestamps = false;
    
    protected $primaryKey = 'subscriptionID';
	protected $table = 'Subscriptions';
    protected $fillable = ['userID', 'storyID'];
    
    public function user(){
        return $this->belongsTo('User', 'userID', 'userID');
    }
    
    public function story(){
        return $this->belongsTo('Story', 'storyID', 'storyID');
    }
}
