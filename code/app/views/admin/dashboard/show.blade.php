@extends('layouts.master')
@section('body')
    <div class="page middle">
        {{ Session::pull('message') }} {{-- Message can be success for registration complete or saved for profile updated --}}
        <h4 class="no-border-header">Your Profile</h4>

        <div id="profile-container">
            <div id="profile-welcome">
                <p><b>Welcome..</b> {{$user->user}}.</p>
            </div>
            <div class="nofloat"></div>
            <div id="profile-functions">
                <a class="button" href="{{ URL::route('read') }}">Read</a>
                <a class="button" href="{{ URL::route('write') }}">Write</a>
            </div>



            <div class="nofloat"></div>
        </div>


    </div>

@stop