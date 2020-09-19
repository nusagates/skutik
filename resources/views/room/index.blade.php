@extends('layouts.app')
@section('title', set_title('Room List'))
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('layouts._message')
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="card-title">Room List</h3>
                        <a class="btn btn-outline-primary"
                           href="{{route('room.create')}}">Create Room</a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="fa-ul">
                            @foreach($rooms as $item)
                                <li><i class="fa-li"></i>
                                    <a href="{{route('room.show', $item->slug)}}">{{$item->title}}</a>
                                    <p>{{$item->description}}</p>
                                </li>
                            @endforeach
                        </ul>
                        {{$rooms->links()}}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
