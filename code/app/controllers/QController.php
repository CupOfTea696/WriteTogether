<?php

class QController extends BaseController{
	
    
    public function __call($m, $p = []){
        App::abort(404);
    }
}
