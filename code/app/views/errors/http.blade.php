@extends('layouts.master')

@section('body')
            {{-- you can edit the title, subtitle and messages for the error pages in start/global.php --}}
            <section class="error {{ $page }}">
                <h1>{{ $title }}</h1>
                <h2>{{ $subtitle }}</h2>
                <p>
                    {{ $message }}
                </p>
            </section>
@stop
