@extends('layouts.master')
@section('body')
    <div class="page middle">
        <h4>Read The Stories</h4>
        <div id="bookcontainer">
            @define $i = 1
            @foreach($stories as $item)
                <a href="{{URL::route('story.show', to_dash_case($item->title))}}" class="book">
                    <div class="wrapper">
                        <div class="inner">
                            <img src="img/book{{ $i }}.svg">
                            <p>{{ $item->title }}</p>
                        </div>
                    </div>
                </a>
                @define $i++ >= 4 ? 1 : $i
            @endforeach
        </div>
    </div>
@stop
