@extends('layouts.master')
@section('body')
    @if (Auth::guest())
        <!--<a href="#"  id="registered">Login</a>-->
    @endif

        <div class="page middle" id="section1">
            <h3>Take part in a Social Experiment,<br>write books <b>Together</b></h3>
        </div>

        <div class="page right" id="section2">
            <h4>The Concept&nbsp;&nbsp;</h4>
            <h2>Legend-based<br/>Storytelling</h2>
            <p>We use this term to define the Social Experiment. Short stories are written by the people, for the people. We'll give you a couple of story facts you have to stick to, the previously written <b>paragraph</b>, and a
                position in the story. Let's see what <b>you</b> can write! </p>
        </div>
        <div class="page left" id="section3">
            <h4>Take Part&nbsp;&nbsp;</h4>
            <p>You'll need to register so that we can send you a PDF version of the book once it's finished!
                Downloads will be <b>free</b> and hard-copy's will be sold at the price they cost to be made.</p>
            <a class="button" href="{{ URL::route('read') }}" data-modal="modal-1">Read</a>
            <a class="button" href="{{ URL::route('write') }}" data-modal="modal-1">Write</a>
        </div>
@stop
