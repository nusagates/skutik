<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h3>{{$title??trans('post.label_newest')}}</h3>
        <a class="btn btn-outline-info" href="{{route('post.create')}}">{{trans('post.label_create')}}</a>
    </div>
    <div class="card-body post-content-outer">
        @foreach($post as $item)
            <div class="media post-content-inner">
                <div class="media-body">
                    <h2><small><a href="{{$item->url}}"> {{$item->post_title}}</a></small></h2>
                    <div class='lead d-flex justify-content-between'>
                        <small class="text-muted d-block"><i class="fa fa-user-circle"></i> <a
                                href="{{$item->user->url}}">{{ $item->user->name }}</a></small>
                        <div>
                            <small class="text-muted"><i class="fa fa-clock"></i> {{ $item->created_date }}</small>
                            <small class="text-muted"><i class="fa fa-eye"></i> {{ $item->post_view }}</small>
                        </div>
                    </div>
                    <p>{!!Str::limit(strip_tags($item->post_content), 200, '...')!!}</p>
                    <small class="text-muted d-block">
                        @if($item->tags->count()>0)
                            <i class="fa fa-tags"></i>
                            @foreach($item->tags as $tag)
                                <a class="badge badge-success" href="{{$tag->url}}">{{$tag->name}}</a>
                            @endforeach
                        @endif
                    </small>
                    <div class="d-block">
                        @can('update', $item)
                            <a class="btn btn-sm btn-outline-primary mt-2"
                               href="{{route('post.edit', $item->id)}}">Edit</a>
                        @endcan
                        @can('delete', $item)
                            <form class="d-inline" action="{{route('post.destroy', $item->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <input onclick="return confirm('{{trans('post.msg_delete_confirmation')}}')"
                                       type="submit" class="btn btn-sm btn-outline-danger mt-2"
                                       value="{{trans('general.label_delete')}}">
                            </form>
                        @endcan
                    </div>
                    <hr>
                </div>
            </div>
        @endforeach
        <div class="mx-auto">
            {{$post->links()}}
        </div>
    </div>
</div>
