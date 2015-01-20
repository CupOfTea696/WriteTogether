@extends('layouts.pdf')
@section('pdf')
    {{-- A4 - 1200 PPI - Width: 9921px - Height: 14031px --}}
    <div class="cover" style="height: 12000px">
        <div class="top">
            <h1>{{ $story->title }}</h1>
        </div>
        <div class="bottom">
        
        </div>
    </div>
    <div class="story">
        {{ nl2p($story->intro) }}
        @foreach($story->paragraphs as $p)
            {{ nl2p($p->paragraph) }}
        @endforeach
    </div>
    <div class="contributors">
        <h1>Contributors</h1>
        <ul>
        @foreach($story->paragraphs as $p)
            <li>{{ $p->user->user }}</li>
        @endforeach
        </ul>
    </div>
@stop
