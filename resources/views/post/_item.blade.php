<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h3>{{trans('post.label_newest')}}</h3>
        <a class="btn btn-outline-info" href="{{route('post.create')}}">{{trans('post.label_create')}}</a>
    </div>
    <div class="card-body">
        <div class="media">
            <div class="media-body">

                @foreach($post as $item)
                    <h3><a href="{{$item->url}}"> {{$item->post_title}}</a></h3>
                    <p class="lead">
                        {{trans('post.label_by')}}
                        <a href="{{$item->user->url}}"><i class="fa fa-user"></i> {{ $item->user->name }}</a>
                        <small class="text-muted"><i class="fa fa-clock-o"></i> {{ $item->created_date }}</small>
                        <small class="text-muted">
                            @if($item->tags->count()>0)
                                <i class="fa fa-tags"></i>
                                @foreach($item->tags as $tag)
                                    <a href="{{$tag->url}}">{{$tag->name}}</a> @if(!$loop->last),@endif
                                @endforeach
                            @endif
                        </small>
                    </p>
                    <p>{{$item->post_content}}</p>
                    <hr>
                @endforeach
            </div>
        </div>
        <div class="mx-auto">
            {{$post->links()}}
        </div>
    </div>
</div>
