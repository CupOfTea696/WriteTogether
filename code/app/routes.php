<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
//error_reporting(1);
//Route::get('/init', function(){
//    set_time_limit(180);
//    define('STDIN',fopen("php://stdin","r"));
////    Artisan::call('migrate', ['--force' => true]);
//    Artisan::call('db:seed', ['--class' => 'GroupsTableSeeder']);
//});

Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home']);

// Login & User
Route::post('/login', ['uses' => 'UserController@login', 'as' => 'login']);
Route::get('/logout', ['uses' => 'UserController@logout', 'as' => 'logout']);
Route::get('/dashboard', ['uses' => 'UserController@show', 'as' => 'user.show']);
Route::post('/sign/up', ['uses' => 'UserController@store', 'as' => 'user.store']);
Route::get('/account/edit', ['uses' => 'UserController@edit', 'as' => 'user.edit']);
Route::post('/dashboard', ['uses' => 'UserController@update', 'as' => 'user.update']);
Route::post('/account/delete', ['uses' => 'UserController@delete', 'as' => 'user.delete']); // confirm can happen via modal.
Route::get('account/report/{hash}', ['uses' => 'UserController@report', 'as' => 'user.report']);

// Read & Write
Route::get('/read', ['uses' => 'StoryController@read', 'as' => 'read']);
Route::get('/write', ['uses' => 'StoryController@write', 'as' => 'write']);

// Story
Route::get('/read/{story}', ['uses' => 'StoryController@show', 'as' => 'story.show']);
Route::get('/write/{story}', ['uses' => 'StoryController@create', 'as' => 'story.create'])->where('story', '^(?:(?!review$|done$)[a-zA-Z0-9\-]+)$');
Route::match(['GET', 'POST'], '/write/review', ['uses' => 'StoryController@review', 'as' => 'story.review']); // allow user to make small edits / sign up.
Route::post('/write/done', ['uses' => 'StoryController@store', 'as' => 'story.store']); // store story / store user
Route::get('/buy/{story}', ['uses' => 'StoryController@buy', 'as' => 'story.buy']);
Route::post('/buy/{story}', ['uses' => 'StoryController@storebuy', 'as' => 'story.storebuy']);
Route::get('/download/{story}', ['uses' => 'StoryController@download', 'as' => 'story.download']);

// Unsubscribe. Link attatched to emails.
Route::get('/sub', ['uses' => 'SubscriptionController@generateLink']); // this is only for testing since i can't send emails yet.
Route::get('/unsubscribe/{hash}/', ['uses' => 'SubscriptionController@delete', 'as' => 'subscription.delete']);

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'before' => 'auth.adminaccess'], function(){
    // Admin dashboard
    Route::get('/', ['uses' => 'DashboardController@index', 'as' => 'admin.index']);
    Route::get('/dashboard', ['uses' => 'DashboardController@show', 'as' => 'admin.show']);
    Route::get('/pdf/{title}', ['uses' => 'StoryController@pdf', 'as' => 'pdf']);
    
    // Admin story
    Route::get('/story', ['uses' => 'StoryController@index', 'as' => 'admin.story.index']);
    Route::get('/story/{story}', ['uses' => 'StoryController@show', 'as' => 'admin.story.show'])->where('story', '^(?:(?!new|delete)[a-zA-Z0-9\-]+)$');
    Route::get('/story/new', ['uses' => 'StoryController@create', 'as' => 'admin.story.create']);
    Route::post('/story/new', ['uses' => 'StoryController@store', 'as' => 'admin.story.store']);
    Route::get('/story/{story}/edit', ['uses' => 'StoryController@edit', 'as' => 'admin.story.edit']);
    Route::post('/story/{story}/edit', ['uses' => 'StoryController@update', 'as' => 'admin.story.update']);
    Route::get('/story/{story}/publish', ['uses' => 'StoryController@check', 'as' => 'admin.story.check']);
    Route::post('/story/{story}/publish', ['uses' => 'StoryController@publish', 'as' => 'admin.story.publish']);
    Route::post('/story/delete', ['uses' => 'StoryController@delete', 'as' => 'admin.story.delete']);
});
