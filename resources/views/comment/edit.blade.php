@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('layouts._message')
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>{!! trans('post.comment_editing_title', ['title'=>$postComment->post->post_title]) !!}</h2>
                        </div>
                    </div>

                    <div class="card-body">
                        @if(Auth::check())
                            <form action="{{route('post.comment.update',[$postComment->post->id, $postComment->id])}}"
                                  method="post">
                                @csrf
                                @method('PUT')
                                <div class="mt-2"></div>
                                <div class="form-group">
                                    <textarea name="comment_content"
                                              class="form-control{{$errors->has('comment_content')?' is-invalid':''}}"
                                              placeholder=""
                                              rows="4">{{old('post_content', $postComment->comment_content)}}</textarea>
                                    @if ($errors->has('comment_content'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('comment_content') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <button type="submit"
                                            class="btn btn-primary">{{trans('post.comment_update_button')}}</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
