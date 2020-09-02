@section('meta')
    <meta property="fb:app_id" content="3223075517741573"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{Request::url()}}"/>
    <meta property="og:site_name" content="Skutik"/>
    <meta property="og:title" content="{{$meta_title??''}}"/>
    <meta property="og:description" content="{{$meta_description??''}}"/>
    <meta property="og:image" itemprop="image primaryImageOfPage"
          content="{{$meta_image??''}}"/>
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:domain" content="skutik.com"/>
    <meta name="twitter:title" property="og:title" itemprop="name"
          content="{{$meta_title??''}}"/>
    <meta name="twitter:description" property="og:description" itemprop="description"
          content="{{$meta_description??''}}"/>
@endsection
