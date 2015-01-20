<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/libraries',
	app_path().'/models',
	app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path().'/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception);
    
    if(App::environment() != 'local' && strpos(get_class($exception), 'ModelNotFoundException ') !== false){
        $code = 404;
    }
    
    $httpErrors = [
        401 => [
            'page' => 'error-401',
            'title' => 'Unauthorized',
            'subtitle' => 'Hey there buddy,',
            'message' => "what're you trying to do here? You have no access to this area. Maybe try to log in, or maybe your account just doesn't have access to this page."
        ],
        403 => [
            'page' => 'error-403',
            'title' => 'Forbidden',
            'subtitle' => 'Whoa there!',
            'message' => "What you're trying to do here is <strong>forbidden</strong>. Strong word, we know. But that's just the name of the error really."
        ],
        404 => [
            'page' => 'error-404',
            'title' => 'Page Not Found',
            'subtitle' => 'Whoopsie-daisy.',
            'message' => "We couldn't find the page you were looking for. Maybe you made a typo in the url, or used an old link that doesn't exist anymore. Or who knows, maybe it's our bad."
        ],
        500 => [
            'page' => 'error-500',
            'title' => 'Internal Server Error',
            'subtitle' => 'Aw man,',
            'message' => "something went wrong on our side. Not great, but hey, it happens. If this keeps happening, you can send us an email at <a href=\"mailto:\"></a>."
        ]
    ];
    
    // show full laravel error locally
    if(App::environment() == 'local'){
        if(Request::ajax()){
            $httpErrors[500]['message'] = "<p class='error'>Refresh this page for a better overview of the error. Here's some error info already though:</p><pre>$exception</pre>";
        }else{
            unset($httpErrors[500]);
        }
    }
    
    if(array_key_exists($code, $httpErrors)){
        $httpErrors[$code]['errorPage'] = true;
        return Response::view('errors.http', $httpErrors[$code], $code);
    }
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require Files
|--------------------------------------------------------------------------
|
*/

require app_path().'/filters.php';
require app_path().'/config/constants.php';

/*
|--------------------------------------------------------------------------
| Extend stuff
|--------------------------------------------------------------------------
|
*/

Validator::resolver(function($translator, $data, $rules, $messages){
    return new WTValidator($translator, $data, $rules, $messages);
});

Blade::extend(function($value) {
    return preg_replace('/\@define(.+)/', '<?php ${1}; ?>', $value);
});

/*
|--------------------------------------------------------------------------
| Helper functions
|--------------------------------------------------------------------------
|
*/

function to_title_case($str, $fromCase = true){
    if(!$str)
        return false;
    
    $str = $fromCase ? preg_replace('/([A-Z])/', ' $1', str_replace(['-', '_'], ' ', $str)) : $str;
    $words = explode(' ', $str);
	
	foreach ($words as &$word){
		$word = ucfirst($word);
	}
	
	return implode(' ', $words);
}

function to_dash_case($str, $keepCapitals = false){
    if(!$str)
        return false;
    
    $str = $keepCapitals ? $str : strtolower($str);
    
    return trim(preg_replace('/-+/', '-', preg_replace('/[^A-Za-z0-9\-]/', '-', $str)), '-');
}

function to_db_case($str){
    if(!$str)
        return false;
    
    return '[^[:alnum:]]*' . str_replace('-', '[^[:alnum:]]+', $str) . '[^[:alnum:]]*';
}

function nl2p($str){
    return '<p>' . preg_replace('/(\r?\n)+/', '<br>', preg_replace('/(\r?\n){2,}/', '</p><p>', $str)) . '</p>';
}

function p2nl($str){
    return str_replace(['<p>', '</p>'], '', preg_replace('<br>', "\n", str_replace('</p><p>', "\n\n", $str)));
}


$env = $app->detectEnvironment(array(
    'local' => ['*.io', gethostname()],
    'production' => ['*.com', '*.net', '*.org']
));
