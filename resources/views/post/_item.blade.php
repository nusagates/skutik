<div class="card shadow">
    <div class="card-header d-flex justify-content-between">
        <h3>{{$title??trans('post.label_newest')}}</h3>
        <a class="btn btn-outline-info" href="{{route('post.create')}}">{{trans('post.label_create')}}</a>
    </div>
    <div class="card-body post-content-outer">
        @foreach($post as $item)
            <div class="media post-content-inner">
                <div class="media-body">
                    <h2 class="title h1-sm h3-lg"><a href="{{$item->url}}"> {{$item->post_title}}</a></h2>
                    <user-info :model="{{$item}}" :userdata="{{$item->user}}"></user-info>
                    <p>{!!Str::limit(strip_tags($item->post_content), 200, '...')!!}</p>
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
                    <hr>
                </div>
            </div>
        @endforeach
        <div class="mx-auto">
            {{$post->links()}}
        </div>
    </div>
</div>
