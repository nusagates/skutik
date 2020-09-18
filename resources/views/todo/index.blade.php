@extends('layouts.app')
@section('title', set_title('Daftar Tantangan'))
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('layouts._message')
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="card-title">Daftar Proyek</h3>
                        <a class="btn btn-outline-primary"
                           href="{{route('todo.create')}}">{{__('general.label_create')}}</a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="fa-ul">
                            @foreach($data as $item)
                                <li><i class="fa-li"></i>
                                    <a href="{{route('todo.show', $item->slug)}}">{{$item->title}}</a>
                                    <p>{{$item->description}}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
