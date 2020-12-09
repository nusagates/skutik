@extends('layouts.app')
@section('title', set_title('Daftar Tugas'))
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('layouts._message')
            <div class="col-md-12">
                <todo-list slug="{{$slug}}"></todo-list>
            </div>
        </div>

    </div>
@endsection
