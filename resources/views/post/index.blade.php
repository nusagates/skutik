@extends('layouts.app')
@if($post)
@section('meta')
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{$post->url}}"/>
    <meta property="og:site_name" content="Skutik"/>
    <meta property="og:image" itemprop="image primaryImageOfPage" content="{{$post->featured_image}}"/>
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:domain" content="skutik.comcom"/>
    <meta name="twitter:title" property="og:title" itemprop="name" content="{{$post->post_title." - ".config('app.name')}}"/>
    <meta name="twitter:description" property="og:description" itemprop="description" content="{{$post->description}}"/>
@endsection
@endif
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
                @if(Route::is('post.show'))
                    @include('post._show')
                @endif
            </div>
        </div>
    </div>
@endsection
