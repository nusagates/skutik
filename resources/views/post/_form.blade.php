<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h3>{{trans('post.label_newest')}}</h3>
        <a class="btn btn-outline-info" href="{{route('post.index')}}">{{trans('post.label_all')}}</a>
    </div>
    <div class="card-body">
        <form action="{{$route}}" method="post">
            @csrf
            {{$method??''}}
            <div class="form-group">
                <label for="post_title">{{trans('post.label_title')}}</label>
                <input autocomplete="off" value="{{old('post_title', isset($post)?$post->post_title:'')}}" type="text"
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
                <post-comment content="{{old('post_content', isset($post)?$post->post_content:'')}}"></post-comment>
            </div>
            <div class="form-group">
                <label for="post_tags">Tag</label>
                <input type="text" class="form-control" name="post_tags"
                       value="{{old('post_tags', isset($post)?$post->all_tags:'')}}"/>
                <p><small>Pisahkan tag dengan koma</small></p>
            </div>
            <div class="form-group">
                <input type="submit" value="{{$label??''}}" class="btn btn-outline-success">
            </div>
        </form>
    </div>
</div>
