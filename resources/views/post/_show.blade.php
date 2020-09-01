<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h3>{{$post->post_title}}</h3>
    </div>
    <div class="card-body">
        <div class="media">
            <div class="d-flex flex-column vote-controls">
                <a href="#" title="This question is useful" class="vote-up">
                    <i class="fa fa-caret-up fa-3x"></i>
                </a>
                <span class="votes-count">1230</span>
                <a href="#" title="This question is not useful" class="vote-down off">
                    <i class="fa fa-caret-down fa-3x"></i>
                </a>
                <a href="#" title="Click to mark as favorite question (Click again to undo)" class="favorite favorited">
                    <i class="fa fa-star fa-1x"></i>
                </a>
                <span class="favorites-count">123</span>
            </div>
            <div class="media-body">
                <p>{{$post->post_content}}</p>
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="d-block">
                            <small class="text-muted">
                                @if($post->tags->count()>0)
                                    @foreach($post->tags as $tag)
                                        <a class="badge badge-success"
                                           href="{{$tag->url}}">{{$tag->name}}</a>
                                    @endforeach
                                @endif
                            </small>
                        </div>
                    </div>
                    <div>
                        <div class="d-block d-flex justify-content-between">
                            <img height="40" width="40" class="img rounded-circle" src="{{$post->user->avatar}}"/>
                            <div class="ml-2">
                                <a href="{{$post->user->url}}">{{ $post->user->name }}</a>
                                <small class="text-muted d-block">{{ $post->created_date }}</small>
                            </div>
                        </div>
                        <div class="d-block mt-2">
                            <a class="btn btn-sm btn-outline-primary" href="">Edit</a>
                            <a class="btn btn-sm btn-outline-danger" href="">Hapus</a>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>
</div>
