<?php

namespace Admin;

use \App;
use \Auth;
use \Group;
use \Groups;
use \Redirect;
use \View;

class DashboardController extends \BaseController{
    public function index(){
        if(Auth::check() && Auth::user()->isOrHigher('Moderator'))
            return Redirect::route('admin.show');
        
        return Redirect::route('home');
    }
    
    public function show(){
        return View::make('admin.dashboard.show', [
            'user' => Auth::user(),
            'page' => 'admin_dashboard'
        ]);
    }
    
    // does this need anything else? not sure.
    
	public function __call($m, $p = []){
        App::abort(404);
    }
}
