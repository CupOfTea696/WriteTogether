<?php

class Paragraph extends Eloquent{
    public $timestamps = false;
    
    protected $primaryKey = 'paragraphID';
	protected $table = 'Paragraphs';
    protected $fillable = ['paragraph', 'userID', 'storyID'];
    protected $appends = ['wordcount'];
    
    public $errors;
    public static $rules = [
        'paragraph' => 'wordcount:500,1500',
        'user' => 'sometimes|required|min:5|max:24|alpha_dash|unique:Users',
        'pass' => 'sometimes|required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\\d!@#$%^&\'])[^\\s\\n]*$/',
        'email' => 'sometimes|required|email'
    ];
    public static $messages = [
        'paragraph.wordcount' => 'Your part must have a word count between :min and :max words.',
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
    
    public function user(){
        return $this->belongsTo('User', 'userID', 'userID');
    }
    
    public function story(){
        return $this->belongsTo('Story', 'storyID', 'storyID');
    }
    
    public function getWordcountAttribute(){
        return count(preg_split('/\s+/', $this->attributes['paragraph']));
    }
}
