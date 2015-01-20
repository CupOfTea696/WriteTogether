<?php

class Group extends Eloquent{
    public $timestamps = false;
    
    protected $primaryKey = 'groupID';
	protected $table = 'Groups';
    protected $fillable = ['group', 'level'];
    
    public function users(){
        return $this->hasMany('User', 'userID', 'userID');
    }
}
