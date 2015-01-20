<?php

namespace Admin;

use \App;
use \DB;
use \Input;
use \Paragraph;
use \PDF;
use \Redirect;
use \Story;
use \View;

class StoryController extends \BaseController{
    protected $story;
    
    public function __construct(Story $story){
        $this->story = $story;
    }
    
    public function index(){
        return View::make('admin.story.index', [
            'stories' => [
                'finished' => Story::where('status', STORY_END_STATUS)->get(),
                'publish' => Story::where('status', end(Story::$parts)['to'])->get(),
                'wip' => Story::where('status', '<', end(Story::$parts)['to'])->get()
            ],
            'page' => 'admin_story-index'
        ]);
    }
    
    public function show($title){
        return View::make('admin.story.show', [
            'story' => Story::where('title', 'REGEXP', to_db_case($title))->firstOrFail(),
            'page' => 'admin_story-show'
        ]);
    }
    
    public function create(){
        return View::make('admin.story.create', [
            'page' => 'admin_story-create'
        ]);
    }
    
    public function store(){
        $story = $this->story;
        $facts = json_encode(Input::get('facts'));
        
        $data = [
            'title' => Input::get('title'),
            'intro' => Input::get('intro'),
            'facts' => $facts,
            'status' => 0
        ];
        
        if(!$story->fill($data)->isValid())
            return Redirect::back()->withInput()->withErrors($story->errors);
        
        $story->save();
        return Redirect::route('admin.story.index')->with('message', 'story.created');
    }
    
    public function edit($title){
        return View::make('admin.story.edit', [
            'story' => Story::where('title', 'REGEXP', to_db_case($title))->firstOrFail(),
            'page' => 'admin_story-edit'
        ]);
    }
    
    public function update($title){
        $story = Story::where('title', 'REGEXP', to_db_case($title))->firstOrFail();
        $facts = json_encode(Input::get('facts'));
        
        $data = [
            'title' => Input::get('title'),
            'intro' => Input::get('intro'),
            'facts' => $facts
        ];
        
        if(!$story->fill($data)->isValid())
            return Redirect::back()->withInput()->withErrors($story->errors);
        
        $paragraphs = Input::get('paragraphs');
        $paragraphIDs = Input::get('paragraphIDs');
        $hasChanges = Input::get('hasChanges');
        for($i = 0; $i < count($paragraphs); $i++){
            if($hasChanges[$i])
                Paragraph::where('paragraphID', $paragraphIDs[$i])->update(['paragraph' => $paragraphs[$i]]);
        }
        
        $story->save();
        return Redirect::route('admin.story.index')->with('message', 'story.saved');
    }
    
    public function check($title){
        return View::make('admin.story.edit', [
            'story' => Story::where('title', 'REGEXP', to_db_case($title))->firstOrFail(),
            'page' => 'admin_story-check'
            // use the above var to switch between edit and check. the titles need to be different.
            // the button at the bottom needs to say save or publish, and the post needs to be to admin.story.update or admin.story.publish
        ]);
    }
    
    public function publish($title){
        $story = Story::where('title', 'REGEXP', to_db_case($title))->firstOrFail();
        $facts = json_encode(Input::get('facts'));
        
        $data = [
            'title' => Input::get('title'),
            'intro' => Input::get('intro'),
            'facts' => $facts,
            'status' => STORY_END_STATUS
        ];
        
        if(!$story->fill($data)->isValid())
            return Redirect::back()->withInput()->withErrors($story->errors);
        
        $paragraphs = Input::get('paragraphs');
        $paragraphIDs = Input::get('paragraphIDs');
        $hasChanges = Input::get('hasChanges');
        for($i = 0; $i < count($paragraphs); $i++){
            if($hasChanges[$i])
                Paragraph::where('paragraphID', $paragraphIDs[$i])->update(['paragraph' => $paragraphs[$i]]);
        }
        
        $file = app_path() . "/storage/downloads/stories/" . md5($story->title) . ".pdf";
        $pdf = PDF::loadView('pdf.story', [
            'story' => $story
        ])->save($file);
        
        $story->save();
        return Redirect::route('admin.story.index')->with('message', 'story.saved');
    }
    
    public function pdf($title){
        $story = Story::where('title', 'REGEXP', to_db_case($title))->firstOrFail();
        
        $file = app_path() . "/storage/downloads/stories/" . md5($story->title) . ".pdf";
        PDF::loadView('pdf.story', [
            'story' => $story
        ])->save($file);
        
        return 'pdf created';
    }
    
    public function delete(){
        $story = Story::find(Input::get('storyID'));
        $story->delete();
        
        return Redirect::route('admin.story.index')->with('message', 'story.deleted');
    }
    
	public function __call($m, $p = []){
        App::abort(404);
    }
}
