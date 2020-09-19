@extends('layouts.app')
@section('title', set_title('New Room'))
@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="card-title">New Room</h3>
                        <a class="btn btn-outline-primary"
                           href="{{route('todo.index')}}">{{__('general.label_all')}}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{route('room.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="title">Name</label>
                                <input value="{{old('title')}}" type="text"
                                       class="form-control @error('title') is-invalid @enderror" name="title"
                                       id="title"/>
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          name="description" id="description">{{old('description')}}</textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-outline-success">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
