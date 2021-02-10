<div class="card-header d-flex justify-content-between">
    <h3>{{$title??trans('post.label_newest')}}</h3>
    <a class="btn btn-outline-info" href="{{route('post.create')}}">{{trans('post.label_create')}}</a>
</div>
@foreach($post as $item)
    <div class="card shadow mt-2">
        <div class="card-body">
            <div class="media post-content-inner">
                <div class="media-body post-content">
                    <user-info :model="{{$item}}" :userdata="{{$item->user}}"></user-info>
                    <h2 class="title h1-sm h3-lg"><a href="{{$item->url}}"> {{$item->post_title}}</a></h2>
                    <div class="float-left mr-2">
                        <a href="{{$item->url}}">
                            <img width="150px" src="{{$item->featured_image}}" alt="{{$item->post_title}}" title="{{$item->post_title}}"/>
                        </a>
                    </div>
                    <div>{!!Str::limit(strip_tags($item->post_content), 200, '...')!!}</div>
                    <div class="d-flex justify-content-between">
                        <div>
                            @can('update', $item)
                                <span class="badge {{$item->post_status=="published"?"badge-success":'badge-danger'}}">{{$item->post_status}}</span>
                            @endcan
                        </div>
                        <div>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
<div class="mx-auto mt-2 d-flex justify-content-center">
    {{$post->onEachSide(1)->links()}}
</div>
