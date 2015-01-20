@extends('layouts.email')
@section('email')
    {{-- guide to html emails: http://is.gd/C5jChC --}}
    {{-- also this tool to convert css style to inline style: http://inlinestyler.torchboxapps.com/styler/convert/ --}}
    {Logo}<br><br>
    
    Thanks for signing up with Write Together.... blah blah blah.<br><br>
    
    All the best,<br>
    Write Together<br><br>
    
    If you didn't register at {website link}, <a href="{route:user.report}">click here</a> to report it.
@stop
