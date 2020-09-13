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
                                {!! $challenge->challenge_content !!}
                                <div class="text-center">
                                    <a class="btn btn-outline-success" href="{{route('challenge.quiz.index', $challenge->challenge_slug)}}">Mulai Tantangan</a>
                                </div>
                                <hr/>
                                @can('update', $challenge)
                                    <div style="max-width: 100%">
                                        <challenge-item :challenge="{{$challenge}}"></challenge-item>
                                    </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
