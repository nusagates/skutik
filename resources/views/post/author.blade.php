@extends('layouts.app')
@section('title', set_title($title))
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('layouts._message')
                @include('post._item')
                @include('layouts._meta', ['meta_image'=>url('images/baner.png'), 'meta_title'=>set_title($title), 'meta_description'=>"Tempat berbagi kisah menarik dan beragam tulisan lainnya"])
            </div>
        </div>
    </div>
@endsection
