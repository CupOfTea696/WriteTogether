<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {
	use UserTrait, RemindableTrait;
    
    public static function boot(){
        User::creating(function($user){
            if(!$user->isValid())
                return false;
        });
    }
    
    public $timestamps = false;
    
    protected $primaryKey = 'userID';
	protected $table = 'Users';
    protected $appends = ['fake_pass'];
	protected $hidden = ['pass', 'remember_token'];
    protected $fillable = ['user', 'pass', 'email', 'passLength', 'status', 'groupID'];
    
    public $errors;
    public static $rules = [
        'user' => 'sometimes|required|min:5|max:24|alpha_dash|unique:Users',
        'pass' => 'sometimes|required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\\d!@#$%^&\'])[^\\s\\n]*$/',
        'email' => 'sometimes|required|email'
    ];
    public static $messages = [
        'user.required' => 'Please pick a username.',
        'user.min' => 'Your username must be at least :min characters.',
        'user.max' => 'Your username can\'t contain more than :max characters.',
        'user.unique' => 'Sorry, but some one already stole this username from you. What a douche.',
        
        'pass.required' => 'Hey buddy, you need a password or everyone will be able to access your account!',
        'pass.min' => 'Your password must be at least :min characters.',
        'pass.regex' => 'To ensure a safe password it must container at least one lowercase cahracter, one uppercase cahracter, and a digit or a special character.',
        
        'email.required' => 'We really <em>do</em> need that email...',
        'email.email' => 'Please give us a valid email address.'
    ];
    
    public function isValid(){
        $validation = Validator::make($this->attributes, static::$rules, static::$messages);
        
        if($validation->passes())
            return true;
        
        $this->errors = $validation->messages();
        return false;
    }
    
    public function subscriptions(){
        return $this->hasMany('Subscription', 'subscriptionID', 'subscriptionID');
    }
    
    public function paragraphs(){
        return $this->hasMany('Paragraph', 'userID', 'userID');
    }
    
    public function group(){
        return $this->belongsTo('Group', 'groupID', 'groupID');
    }
    
    public function is($type){
        $group = Group::where('group', $type)->first();
        
        if(count($group))
            return $this->group->group == $group->group;
        
        throw new Exception('Group "' . $type . '" does not exist.');
    }
    
    public function isOrHigher($type){
        $group = Group::where('group', $type)->first();
        
        if(count($group))
            return $this->group->group == $group->group || $this->group->level <= $group->level;
        
        throw new Exception('Group "' . $type . '" does not exist.');
    }
    
    public function getAuthPassword(){
        return $this->pass;
    }
    
    public function getFakePassAttribute(){
        return str_repeat('x', $this->passLength);
    }
    
    public function getGravatar($size){
        /* GRAA-VAAA-TAAAAR! RAWR!
            
            ,,,,,,,,,,,,__
            ,,,,,,,,,,/ *_) . -♥-♥-♥-♥-♥-♥-
            ,, _,—-,_/,,/ , RAWR Means .
            ,,/,,,,,,,,/ , I Love You .
            _/…(…|.(…|) , In Dinosaur .
            /_-|_|–|_|
            
        */
        
        return "http://www.gravatar.com/avatar/" . md5($this->email) . "?s=$size&r=pg&d=identicon";
    }
}
