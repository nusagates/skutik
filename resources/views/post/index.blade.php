@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('layouts._message')
                @if(Route::is('post.index'))
                    @include('layouts._meta', ['meta_image'=>url('images/baner.png'), 'meta_title'=>"Skutik | Cerdik & Unik", 'meta_description'=>"Tempat berbagi kisah menarik dan beragam tulisan lainnya"])
                    @include('post._item')
                @endif
                @if(Route::is('post.create'))
                    @include('post._form', ['label'=>trans('post.label_send'), 'route'=>route('post.store')])
                @endif
                @if(Route::is('post.edit'))
                    @include('post._form', ['label'=>trans('general.label_update'), 'route'=>route('post.update', $post->id), 'method'=> method_field('PUT')])
                @endif
                @if(Route::is('post.show'))
                    @include('layouts._meta', ['meta_image'=>$post->featured_image, 'meta_title'=>$post->content_title, 'meta_description'=>$post->description])
                    @include('post._show')
                @endif
            </div>
        </div>
    </div>
@endsection
