@extends('layouts.master')
@section('body')

    <div class="page middle write_story">
        {{-- create page, vars: title, intro, facts, status, paragraphs --}}
        <h1>{{$story->title}}</h1>
        <div id="read_container">
            @foreach($story->paragraphs as $p)
                <div class="read-panel">
                    <textarea disabled class="textarea_write">{{$p->paragraph}}</textarea>
                    <p class="author-text"><b>Author: </b>{{User::find($p->userID)->user}}</p>
                    <div class="nofloat"></div>
                </div>
            @endforeach

        </div>
        <a class="button" href="{{URL::route('story.buy', to_dash_case($story->title))}}">Buy the book!</a>
        <a class="button" href="{{URL::route('story.download', to_dash_case($story->title))}}">Download the book!</a>
    </div>

@stop