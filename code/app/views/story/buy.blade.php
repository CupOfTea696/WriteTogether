@extends('layouts.master')
@section('body')

    <div class="page middle write_story">
        {{-- create page, vars: title, intro, facts, status, paragraphs --}}
        <h1>Buy: {{ $story->title }}</h1>
        <div id="read_container" class="buy_reader">
            <div class="read-panel">
                <h4>Intro</h4>
                <textarea disabled class="textarea_write">{{$story->intro}}</textarea>
                <div class="nofloat"></div>
            </div>

        </div>
        <form action="{{ URL::route('story.storebuy') }}" method="post">
            <div class="buy_form">
                <div class="form-group">
                    <input type="text" placeholder="User" name="user">
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Shipping adres" name="adres">
                </div>
                <div class="form-group">
                    <input type="email" placeholder="Email" name="adres">
                </div>
                <h3 class="buy_h3">35 Euro</h3>
                <div class="nofloat"></div>

            </div>

            <input type="submit" value="Place order"/>
        </form>

    </div>

@stop