<?php

class UnsubLink extends Eloquent{
    public $timestamps = true;
    
    protected $primaryKey = 'unsubLinkID';
	protected $table = 'UnsubLinks';
    protected $fillable = ['hash', 'string'];
    
    public function getDates(){
        return ['created_at'];
    }
    
    public function setUpdatedAtAttribute($value){
        // Do nothing.
    }
}
