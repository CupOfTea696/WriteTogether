<?php

class SubscriptionController extends BaseController {
    public function delete($hash){
        $unsubLink = UnsubLink::where('hash', $hash)->firstOrFail();
        
        $strings = explode(';', $unsubLink->string);
        $story = Story::find($strings[0]);
        $user = User::find($strings[1]);
        $hash = $strings[2];
        
        if(Hash::check($user->email, $hash) != Hash::check($user->email, Hash::make($user->email)))
            return Redirect::route('home');
        
        $unsubLink->delete();
        Subscription::where('userID', $strings[1])->where('storyID', $strings[0])->delete();
        
        return View::make('subscription.delete', [
            'page' => 'unsubscribe'
        ]);
    }
    
    // this is only for testing since i can't send emails yet.
    public function generateLink(){
        $sub = Subscription::find(3);
        $story = $sub->story;
        $user = $sub->user;
        
        $string = $story->storyID . ";" . $user->userID . ";" . Hash::make($user->email);
        $hash = md5($string);
        
        UnsubLink::create(['hash' => $hash, 'string' => $string]);
        
        return link_to_route('subscription.delete', 'CLICK ME BRUH', [$hash]);
    }
    
	public function __call($m, $p = []){
        App::abort(404);
    }
}
