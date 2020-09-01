<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h3>{{trans('post.label_newest')}}</h3>
        <a class="btn btn-outline-info" href="{{route('post.index')}}">{{trans('post.label_all')}}</a>
    </div>
    <div class="card-body">
        <form action="{{route('post.store')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="post_title">{{trans('post.label_title')}}</label>
                <input value="{{old('post_title')}}" type="text"
                       class="form-control{{$errors->has('post_title')?' is-invalid':''}}"
                       name="post_title">
                @if ($errors->has('post_title'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('post_title') }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="post_content">{{trans('post.label_content')}}</label>
                <textarea rows="7" class="form-control{{$errors->has('post_content')?' is-invalid':''}}
                    " name="post_content">{{old('post_content')}}</textarea>
                @if ($errors->has('post_content'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('post_content') }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="post_tags">Tag</label>
                <input type="text" class="form-control" name="post_tags" value="{{old('post_tags')}}"/>
                <p><small>Pisahkan tag dengan koma</small></p>
            </div>
            <div class="form-group">
                <input type="submit" value="{{trans('post.label_send')}}" class="btn btn-outline-success">
            </div>
        </form>
    </div>
</div>
