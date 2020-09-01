@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('layouts._message')
                @if(Route::is('post.index'))
                    @include('post._item')
                @endif
                @if(Route::is('post.create'))
                    @include('post._create')
                @endif
            </div>
        </div>
    </div>
@endsection
