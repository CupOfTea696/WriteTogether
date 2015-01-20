<?php

class HomeController extends BaseController{
	public function index(){
        if(Auth::check()){
            if(Auth::user()->isOrHigher('Moderator'))
                return Redirect::route('admin.show');
            
            return Redirect::route('user.show');
        }
        
        return View::make('index');
	}
    
    public function __call($m, $p = []){
        App::abort(404);
    }
}
