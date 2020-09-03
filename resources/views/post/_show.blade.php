<div class="card shadow">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('root')}}">{{trans('general.label_home')}}</a></li>
        </ol>
    </nav>
    <div class="card-body">
        <div class="media post-content-inner w-100">
            <div class="media-body">
                <h3>{{$post->post_title}}</h3>
                <div class='lead d-flex justify-content-between'>
                    <div class="d-block d-flex justify-content-between">
                        <img alt="User Avatar" height="40" width="40" class="img rounded-circle"
                             src="{{$post->user->avatar}}"/>
                        <div class="ml-2">
                            <a href="{{$post->user->url}}">{{ $post->user->name }}</a>
                            <small class="text-muted d-block">{{ $post->created_date }}</small>
                        </div>
                    </div>
                    <div>
                      <span class="text-muted d-block"><i
                              class="fa fa-eye"></i> {{$post->post_view}}
                      </span>
                    </div>
                </div>
                <div class="post-content mt-2 mb-2">{!! $post->post_content !!}</div>
                <div class="text-center mt-4">
                    @foreach($post->tags as $tag)
                        <a class="btn btn-sm btn-outline-success mt-1"
                           href="{{$tag->url}}">{{$tag->name}}</a>
                    @endforeach
                </div>
                <hr>
                <div class="text-right mt-4">

                    <div class="d-block">
                        @can('update', $post)
                            <a class="btn btn-sm btn-outline-primary mt-2"
                               href="{{route('post.edit', $post->id)}}">Edit</a>
                        @endcan
                        @can('delete', $post)
                            <form class="d-inline" action="{{route('post.destroy', $post->id)}}" method="post">
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
                <div id="comments">
                    <!--title-->
                    <div class="block-title-6 mb-4">
                        <h4 class="h5 border-success border-2 comment-title">
                            <span
                                class="bg-success py-1 px-2 text-white">{{$post->comments->count()." ".trans('post.comment')}}</span>
                        </h4>
                    </div>
                    <!--comment list-->

                    @foreach($post->comments as $item)
                        <div class="media">
                            <div class="media-left mr-2">
                                <img src="{{$item->user->avatar}}" alt="Avatar">
                            </div>
                            <div class="media-body">
                                <div class="d-flex justify-content-between">
                                    <a class="authors" href="{{$item->user->url}}"
                                       target="_blank">{{$item->user->name}}</a>
                                    <div class="text-muted dates small">
                                        <time datetime="{{$item->created_at}}">{{$item->created_date}}</time>
                                    </div>
                                </div>
                                <p>{!! $item->comment_content !!}</p>
                                <div class="text-right">
                                    @can('update', $item)
                                        <a class="btn btn-sm btn-outline-primary mt-2"
                                           href="{{route('post.comment.edit', [$post->id, $item->id])}}">Edit</a>
                                    @endcan
                                    @can('delete', $item)
                                        <form class="d-inline"
                                              action="{{route('post.comment.destroy', [$post->id, $item->id])}}"
                                              method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input
                                                onclick="return confirm('{{trans('post.comment_delete_confirmation')}}')"
                                                type="submit" class="btn btn-sm btn-outline-danger mt-2"
                                                value="{{trans('general.label_delete')}}">
                                        </form>
                                    @endcan
                                </div>
                                <hr/>
                            </div>
                        </div>
                    @endforeach
                    @if(Auth::check())
                    <!--comment form-->
                        <div id="comment-form" class="my-5">
                            <h3 class="h6 h4-md">{{trans('post.comment_message')}}</h3>
                            <div class="comment-form">
                                <form method="post" action="{{route('post.comment.store', $post)}}">
                                    @csrf
                                    <div class="mt-2"></div>
                                    <div class="form-group">
                                    <textarea name="comment_content"
                                              class="form-control{{$errors->has('comment_content')?' is-invalid':''}}"
                                              placeholder="" rows="4">{{old('post_content')}}</textarea>
                                        @if ($errors->has('comment_content'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('comment_content') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <button type="submit"
                                                class="btn btn-primary">{{trans('post.comment_send_button')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <p class="text-center">Anda harus <a class="btn btn-sm btn-outline-success"
                                                             href="{{route('login')}}">login</a> untuk memberikan
                            komentar. Belum punya akun? Silahkan <a class="btn btn-sm btn-outline-danger"
                                                                    href="{{route('register')}}">Mendaftar</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/ld+json">
    [{
      "@context": "https://schema.org",
      "@type": "NewsArticle",
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{$post->url}}"
      },
      "headline": "{{$post->post_title}}",
      "image":"{{$post->featured_image}}",
      "datePublished": "{{$post->created_at_iso}}",
      "dateModified": "{{$post->updated_at_iso}}",
      "author": {
        "@type": "Person",
        "name": "{{$post->user->name}}"
      },
       "publisher": {
        "@type": "Organization",
        "name": "Skutik",
        "logo": {
          "@type": "ImageObject",
          "url": "{{url('images/logo.png')}}"
        }
      }
    }
    ]












</script>
