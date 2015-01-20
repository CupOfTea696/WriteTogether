@extends('layouts.master')
@section('body')
    <div class="page write_story">
        {{-- create page, vars: title, intro, facts, status, paragraphs --}}
        <h1>{{$story->title}}</h1>
        <div id="write_container">
            @if(count($story->paragraphs))
                <h4>Previous Paragraph</h4>
                <textarea class="textarea_write" disabled>{{$story->paragraphs->last()->paragraph}}</textarea>
            @else
                <h4>Introduction to the story</h4>
                <textarea class="textarea_write" disabled>{{$story->intro}}</textarea>
            @endif
            <h4>Write your own part of the story</h4>
            <form action="{{ URL::route('story.review') }}" method="post">
                <textarea name="paragraph" class="textarea_write" autofocus></textarea>
                <p class="word-counter"><span>0</span> / 1500</p>
                <p><input disabled class='text_submit' type="submit"></p>
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
@stop
