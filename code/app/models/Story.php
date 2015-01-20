<?php

class Story extends Eloquent{
    public $timestamps = false;
    
    protected $primaryKey = 'storyID';
	protected $table = 'Stories';
    protected $fillable = ['title', 'intro', 'facts', 'status'];
    
    public static $parts = [
        ['from' => 0, 'to' => 1, 'name' => 'Introduction'],
        ['from' => 2, 'to' => 4, 'name' => 'Crisis I'],
        ['from' => 5, 'to' => 7, 'name' => 'Crisis II'],
        ['from' => 8, 'to' => 10, 'name' => 'Climax'],
        ['from' => 11, 'to' => 12, 'name' => 'Denouement']
    ];
    
    public $errors;
    public static $rules = [
        'title' => 'required|min:2|max:128',
        'intro' => 'required|wordcount:500,1500',
        'facts' => 'required'
    ];
    public static $messages = [
        'title.required' => 'Please enter a title',
        'title.min' => 'The title must be at least :min characters.',
        'title.max' => 'The title can\'t contain more than :max characters.',
        
        'intro.required' => 'You need to write an introduction to create a story.',
        'intro.wordcount' => 'Your part must have a word count between :min and :max words.',
        
        'facts.required' => 'We need at least some facts.'
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
        return $this->hasMany('Paragraph', 'storyID', 'storyID');
    }
}
