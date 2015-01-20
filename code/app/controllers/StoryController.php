<?php

class StoryController extends BaseController{
    protected $paragraph;
    
    public function __construct(Paragraph $paragraph){
        $this->paragraph = $paragraph;
    }
    
    public function read(){
        return View::make('story.read', [
            'stories' => Story::where('status', STORY_END_STATUS)->get(),
            'page' => 'read'
        ]);
    }
    
    public function write(){
        $stories = Story::where('status', '<', end(Story::$parts)['to'])->take(WRITE_STORY_AMOUNT)->get();
        
        return View::make('story.write', [
            'stories' => $stories,
            'page' => 'write'
        ]);
    }
    
    public function show($title){
        return View::make('story.show', [
            'story' => Story::where('title', 'REGEXP', to_db_case($title))->where('status', STORY_END_STATUS)->firstOrFail(),
            'page' => 'story-read'
        ]);
    }
    
    public function create($title){
        $story = Story::where('title', 'REGEXP', to_db_case($title))->with('paragraphs')->firstOrFail();
        Session::put('createStory', $story);
        
        return View::make('story.create', [
            'story' => $story,
            'page' => 'story-write'
        ]);
    }
    
    public function review(){
        $this->paragraph->paragraph = Input::get('paragraph');
        
        return View::make('story.review', [
            'story' => Session::get('createStory'), 'paragraph' => $this->paragraph,
            'page' => 'write-review'
        ]);
    }
    
    public function store(){
        $story = Session::pull('createStory');
        $paragraph = $this->paragraph;
        $user;
        
        if(Auth::check()){
            $user = Auth::user();
        }else{
            $u = Input::get('user');
            if($u){
                if(Input::get('email')){
                    $user = App::make('UserController')->store(true);
                }else{
                    $user = App::make('UserController')->login(true);
                }
            }
        }
        
        // validate + store
        $data = [
            'paragraph' => Input::get('paragraph'),
            'userID' => Auth::id(),
            'storyID' => $story->storyID
        ];
        
        if(!$paragraph->fill($data)->isValid())
            return Redirect::back()->withInput()->withErrors($paragraph->errors);
        
        $story->increment('status');
        $story->paragraphs()->save($paragraph);
        
        if($story->status == end(Story::$parts)['to']){
            // notify admins story is complete. ask to verify.
            
            if(count(Story::where('status', '<', end(Story::$parts)['to'])->take(WRITE_STORY_AMOUNT)->get()->toArray()) <= WRITE_STORY_AMOUNT + 1){
                // notify admins they need to add more stories to the DB.
            }
        }
        
        return View::make('story.store', [
            'story' => $story,
            'page' => 'write-done'
        ]);
    }
    
    public function buy($title){
        return View::make('story.buy', [
            'story' => Story::where('title', 'REGEXP', to_db_case($title))->firstOrFail(),
            'page' => 'story-buy'
        ]);
    }
    
    public function download($title){
        $story = Story::where('title', 'REGEXP', to_db_case($title))->firstOrFail();
        
        $file = app_path() . "/storage/downloads/stories/" . md5($story->title) . ".pdf";
        $name = "WriteTogether-" . preg_replace('/[^A-Za-z0-9\-]/', '', to_title_case($story->title)) . ".pdf";
        
        return Response::download($file, $name);
    }
    
	public function __call($m, $p = []){
        App::abort(404);
    }
}
