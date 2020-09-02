@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('layouts._message')
                @if(Route::is('post.index')||Route::is('root')||Route::is('home')||Route::is('post.tag'))
                    @if(Route::is('post.tag'))
                        <?php $page_title =trans('post.label_tag_title', ['tag'=>$title]) ?>
                        @include('post._item', ['title'=>$page_title])
                        @include('layouts._meta', ['meta_image'=>url('images/baner.png'), 'meta_title'=>$page_title, 'meta_description'=>$page_title])
                    @else
                        @include('post._item')
                        @include('layouts._meta', ['meta_image'=>url('images/baner.png'), 'meta_title'=>"Skutik | Cerdik & Unik", 'meta_description'=>"Tempat berbagi kisah menarik dan beragam tulisan lainnya"])
                    @endif
                        @section('title', isset($title)?$page_title." - Skutik":config('app.name')." - Cerdik & Unik")
                @endif
                @if(Route::is('post.create'))
                    @section('title', trans('general.label_create')." ".trans('post.label_post')." - ".config('app.name'))
                @include('post._form', ['label'=>trans('post.label_send'), 'route'=>route('post.store')])
                @endif
                @if(Route::is('post.edit'))
                    @section('title', trans('general.label_edit')." ".trans('post.label_post')." - ".config('app.name'))
                @include('post._form', ['label'=>trans('general.label_update'), 'route'=>route('post.update', $post->id), 'method'=> method_field('PUT')])
                @endif
                @if(Route::is('post.show'))
                    @section('title', $post->post_title." - ".config('app.name'))
                @include('layouts._meta', ['meta_image'=>$post->featured_image, 'meta_title'=>$post->post_title." - ".config('app.name'), 'meta_description'=>strip_tags(preg_replace( "/\r|\n/", "", $post->description ))])
                @include('post._show')
                @endif
            </div>
        </div>
    </div>
@endsection
