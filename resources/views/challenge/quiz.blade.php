@extends('layouts.app')
@section('title', set_title($challenge->challenge_title))
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('layouts._message')
            <div class="col-md-12">
                <div class="w-100 card shadow mt-1">
                    <div class="card-body">
                        <div class="media post-content-inner">
                            <div class="media-body post-content">
                                <div class="lead d-flex justify-content-between">
                                    <div class="d-block d-flex justify-content-between">
                                        <img alt="User Avatar" height="40" width="40"
                                             src="{{$challenge->user->avatar}}"
                                             class="img rounded-circle">
                                        <div class="ml-2"><a
                                                href="{{$challenge->user->url}}">{{$challenge->user->name}}</a> <small
                                                class="text-muted d-block">{{$challenge->created_date}}</small>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-muted d-block"><i
                                                class="fa fa-eye"></i> {{$challenge->challenge_view}}
                                        </div>
                                    </div>
                                </div>
                                <h2 class="title">{{$challenge->challenge_title}}</h2>
                                <hr/>
                                <div>
                                    <div class="card">
                                        <div class="card-header text-center">
                                            <h4 class="card-title">Pertanyaan {{$quiz->currentPage()}}
                                                dari {{$quiz->lastPage()}}</h4>
                                        </div>
                                        <div class="card-body">
                                            @foreach($quiz as $item)
                                                <h4>
                                                    {!! $item->question !!}
                                                </h4>
                                                <quiz-item :quiz="{{$item}}" prev="{{$quiz->previousPageUrl()}}"
                                                           next="{{$quiz->nextPageUrl()}}"></quiz-item>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
