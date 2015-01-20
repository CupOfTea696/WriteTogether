<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Write | Together</title>
    <base href={{ URL::to('/') }}>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
    
    @include('resources.styles')
    @include('resources.favicons')
</head>
<body class="cbp-spmenu-push">
    @include('modals')
    <div id="container" class="container-{{ $page or 'home' }}">
        @include('header')
        @if(Auth::check() && Auth::user()->isOrHigher('Moderator'))
            @include('admin.menu')
        @endif
        <main id="{{ $page or 'home' }}">
            @yield('body')
        </main>
    </div>
    <div class="md-overlay"></div>
    @include('resources.scripts')
</body>
</html>
