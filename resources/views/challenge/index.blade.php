@extends('layouts.app')
@section('title', set_title('Daftar Tantangan'))
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('layouts._message')
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="card-title">Daftar Tantangan</h3>
                        <a class="btn btn-outline-primary"
                           href="{{route('challenge.create')}}">{{__('general.label_create')}}</a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                @foreach($data as $item)
                    <div class="w-100 card shadow mt-1">
                        <div class="card-body">
                            <div class="media post-content-inner">
                                <div class="media-body post-content">
                                    <div class="lead d-flex justify-content-between">
                                        <div class="d-block d-flex justify-content-between">
                                            <img alt="User Avatar" height="40" width="40"
                                                 src="{{$item->user->avatar}}"
                                                 class="img rounded-circle">
                                            <div class="ml-2"><a
                                                    href="{{$item->user->url}}">{{$item->user->name}}</a> <small
                                                    class="text-muted d-block">{{$item->created_date}}</small>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-muted d-block"><i
                                                    class="fa fa-eye"></i> {{$item->challenge_view}}
                                            </div>
                                        </div>
                                    </div>
                                    <h2 class="title h1-sm h3-lg"><a href="{{$item->url}}">{{$item->challenge_title}}</a></h2>
                                    <div class="float-left mr-2">
                                    </div>
                                    <div>{!! $item->challenge_content !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection
