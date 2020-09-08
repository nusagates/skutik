@extends('layouts.app')
@section('title', set_title('Buat Tantangan'))
@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="card-title">Buat Tantangan</h3>
                        <a class="btn btn-outline-primary"
                           href="{{route('challenge.index')}}">{{__('general.label_all')}}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{route('challenge.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="title">Judul Tantangan</label>
                                <input value="{{old('title')}}" type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                       id="title"/>
                            </div>
                            <div class="form-group">
                                <label for="description">Keterangan Tantangan</label>
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
