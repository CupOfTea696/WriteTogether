<header>
    <div class="header_wrapper">
        <nav>
            <div class="logo">
                <a href="{{ URL::route('home') }}"></a>
            </div>
        </nav>
        <nav class="right">
            @if (Auth::check())
                <a href="{{URL::route('read')}}">Read</a>
                <a href="{{URL::route('write')}}">Write</a>
                <a href="{{ URL::route('user.show') }}">{{ Auth::user()->user }}</a>
                <a href="{{URL::route('logout')}}">Sign Out</a>
                @if(Auth::user()->isOrHigher('Moderator'))
                    <a class="icn admin-menu-button"><i class="icon-menu"></i></a>
                @endif
            @else
                <a href="{{URL::route('read')}}">Read</a>
                <a href="{{URL::route('write')}}">Write</a>
                <a class="md-trigger login_button" data-modal="modal-1">Sign In</a>
            @endif
        </nav>
    </div>
</header>
