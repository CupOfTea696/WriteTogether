<?php

class UserController extends BaseController{
    protected $user;
    
    public function __construct(User $user){
        $this->beforeFilter('auth', ['except' => ['login', 'create', 'store']]);
        $this->beforeFilter('guest', ['only' => ['login', 'create', 'store']]);
        
        $this->user = $user;
    }
    
    public function login($fromWrite = false){
        if(Auth::attempt(['user' => Input::get('user'), 'password' => Input::get('pass')], Input::get('rememberme') ? true : false)){
            return $fromWrite ? Auth::user() : (Auth::user()->isOrHigher(LOWEST_GROUP_WITH_ADMIN_ACCESS) ? Redirect::route('admin.show') : Redirect::route('user.show'));
        }
        
        $err = User::where('user', Input::get('user'))->first() ? 'The password you entered did not match.' : 'There is no user with this username.';
        $action = $fromWrite ? 'write.login' : 'login';
        
        return Redirect::back()->withInput()->with('loginError', $err)->with('action', $action);
    }
    
    public function logout(){
        Auth::logout();
        return Redirect::to('/');
    }
    
    public function show(){
        return View::make('user.show', [
            'user' => Auth::user(),
            'page' => 'dashboard'
        ]);
    }
    
    public function store($fromWrite = false){
        $user = $this->user;
        $pass = Input::get('pass');
        
        $data = [
            'user' => Input::get('user'),
            'pass' => $pass,
            'email' => Input::get('email'),
            'passLength' => strlen($pass),
            'status' => DEFAULT_USER_STATUS,
            'groupID' => Group::where('group', DEFAULT_USER_GROUP)->first()->groupID
        ];
        
        $action = $fromWrite ? 'write.register' : 'register';
        if(!$user->fill($data)->isValid())
            return Redirect::back()->withInput()->withErrors($user->errors)->with('action', $action);
        
        $user->pass = Hash::make($pass);
        $user->save();
        Auth::login($user, Input::get('rememberme') ? true : false);
        
        if($fromWrite)
            return Auth::user();
        
        return Redirect::route('user.show')->with('message', 'success');
    }
    
    public function edit(){
        return View::make('user.edit', [
            'user' => Auth::user(),
            'page' => 'account-edit'
        ]);
    }
    
    public function update(){
        $user = Auth::user();
        $pass = Input::get('pass');
        
        $data = [
            'user' => Input::get('user'),
            'email' => Input::get('email')
        ];
        
        if(!preg_match('/x+/', $pass)){
            $data['pass'] = $pass;
            $data['passLength'] = strlen($pass);
        }
        
        if(!$user->fill($data)->isValid())
            return Redirect::back()->withInput()->withErrors($user->errors);
        
        $user->save();
        return Redirect::route('user.show')->with('message', 'saved');
    }
    
    public function delete(){
        $this->user->delete();
        Auth::logout();
        
        return Redirect::route('home');
    }
    
	public function __call($m, $p = []){
        App::abort(404);
    }
}
