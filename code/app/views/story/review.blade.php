@extends('layouts.master')
@section('body')
    <div class="page write_story">
        {{-- create page, vars: title, intro, facts, status, paragraphs --}}
        <h1>{{$story->title}}</h1>
        <div id="write_container" class="review_container">
            <h4>Are you sure ?</h4>
            <form action="{{ URL::route('story.store') }}" method="post">
                <textarea disabled class="textarea_write review-field" name="paragraph">{{ $paragraph->paragraph }}</textarea>
                <p class="word-counter"><span>{{$paragraph->wordcount}}</span> / 1500</p>
                <p><input type="checkbox" name="subscribe" checked> Subscribe</p>
                @if(!Auth::check())
                    <div class="review_login_form">

                        <div class="form-group">
                            <input type="text" name="user" placeholder="user">
                        </div>

                        <div class="form-group">
                            <input type="password" name="pass" placeholder="password">
                        </div>

                        <div class="form-group">
                            <input type="email" name="email" placeholder="email">
                        </div>

                        <div class="form-group">
                            <input type="checkbox" name="rememberme" checked> Keep me logged in.
                        </div>

                        <div class="nofloat"></div>


                    </div>
                @endif
                <p><input class="text_submit review_submit" type="submit"></p>
            </form>
        </div>
        <div class="facts_container">
            <p><b>Facts</b> to follow</p>
            <ul>
                @foreach(json_decode($story->facts) as $fact)
                    <li>{{$fact}}</li>
                @endforeach
            </ul>

        </div>

    </div>
@stop()
