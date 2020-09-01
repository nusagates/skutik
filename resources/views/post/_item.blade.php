<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h3>{{trans('post.label_newest')}}</h3>
        <a class="btn btn-outline-info" href="{{route('post.create')}}">{{trans('post.label_create')}}</a>
    </div>
    <div class="card-body">
        @foreach($post as $item)
            <div class="media">
                <div class="media-body">
                    <h3><a href="{{$item->url}}"> {{$item->post_title}}</a></h3>
                    <p class="lead">
                        <i class="fa fa-user"></i> <a href="{{$item->user->url}}">{{ $item->user->name }}</a>
                        <small class="text-muted"><i class="fa fa-clock-o"></i> {{ $item->created_date }}</small>
                        <small class="text-muted">
                            @if($item->tags->count()>0)
                                <i class="fa fa-tags"></i>
                                @foreach($item->tags as $tag)
                                    <a class="badge btn-outline-success" href="{{$tag->url}}">{{$tag->name}}</a> @if(!$loop->last),@endif
                                @endforeach
                            @endif
                        </small>
                    </p>
                    <p>{!!Str::limit(strip_tags($item->post_content), 200, '...')!!}</p>
                    <hr>
                </div>
            </div>
        @endforeach
        <div class="mx-auto">
            {{$post->links()}}
        </div>
    </div>
</div>
