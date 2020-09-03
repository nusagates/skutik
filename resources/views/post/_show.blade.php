<div class="card">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">{{trans('general.label_home')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('post.index')}}">{{trans('post.label_post')}}</a></li>
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
                        <ul class="fa-ul">
                            <li><span class="fa-li"></span>
                                <span class="text-muted d-block"><i
                                        class="fa fa-eye"></i> {{$post->post_view}}
                                </span>
                            </li>
                            <li><span class="fa-li"></span>
                                <span>
                                    @if($post->tags->count()>0)
                                        <i class="fa fa-tags"></i>
                                        @foreach($post->tags as $tag)
                                            <a class="badge badge-success"
                                               href="{{$tag->url}}">{{$tag->name}}</a>
                                        @endforeach
                                    @endif
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="post-content">{!! $post->post_content !!}</div>
                <div class="d-flex justify-content-between">
                    <div></div>
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
            </div>
        </div>
    </div>
</div>
<script type="application/ld+json">
    [{
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement": [{
        "@type": "ListItem",
        "position": 1,
        "name": "{{trans('general.label_home')}}",
        "item": "{{route('home')}}"
      },{
        "@type": "ListItem",
        "position": 2,
        "name": "{{trans('post.label_post')}}",
        "item": "{{route('post.index')}}"
      },{
        "@type": "ListItem",
        "position": 3,
        "name": "{{$post->post_title}}"
      }]
    },
    {
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
