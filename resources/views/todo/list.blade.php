@extends('layouts.app')
@section('title', set_title('Daftar Tugas'))
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('layouts._message')
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="card-title">Daftar Tugas</h3>
                        <a class="btn btn-outline-primary"
                           href="{{route('challenge.create')}}">{{__('general.label_create')}}</a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <todo-list :todo="{{$todos}}"></todo-list>
            </div>
        </div>

    </div>
@endsection
