@extends('layouts.app')
@section('title', set_title('Daftar Tugas'))
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('layouts._message')

            <chat-message :room="{{$room}}" auth="{{Auth::check()}}"></chat-message>

        </div>

    </div>
@endsection
