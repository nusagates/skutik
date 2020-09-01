@section('meta')
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{$post->url}}"/>
    <meta property="og:site_name" content="Skutik"/>
    <meta property="og:image" itemprop="image primaryImageOfPage" content="{{$post->featured_image}}"/>
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:domain" content="skutik.comcom"/>
    <meta name="twitter:title" property="og:title" itemprop="name" content="{{$post->post_title." - ".config('app.name')}}"/>
    <meta name="twitter:description" property="og:description" itemprop="description" content="{{$post->description}}"/>
@endsection
<div class="card">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">{{trans('general.label_home')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('post.index')}}">{{trans('post.label_post')}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$post->post_title}}</li>
        </ol>
    </nav>
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
                <h3>{{$post->post_title}}</h3>
                <p>{{$post->post_content}}</p>
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="d-block">
                            <i class="fa fa-"></i>
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
      "datePublished": "2015-02-05T08:00:00+08:00",
      "dateModified": "2015-02-05T09:20:00+08:00",
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
