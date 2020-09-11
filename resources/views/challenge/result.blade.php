@extends('layouts.app')
@section('title', set_title('Hasil Tantangan '.$answer->user->name))
@section('content')
    @include('layouts._meta', ['meta_image'=>route('challenge.result.image', $answer->slug), 'meta_title'=>set_title('Hasil Tantangan '.$answer->user->name), 'meta_description'=>set_title('Hasil Tantangan '.$answer->user->name)])
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="text-center">
                            <p>
                                Hai, {{$answer->user->name}}. Kamu telah menyelesaikan tantangan
                                <b>{{$answer->challenge->challenge_title}}.</b>
                                Berikut ini adalah hasilnya.
                            </p>
                            <img src="{{route('challenge.result.image', $answer->slug)}}"/>
                        </div>
                        <table class="mt-2 ">
                            <tr>
                                <td width="150">Jumlah Soal</td>
                                <td>{{$quiz_count}}</td>
                            </tr>
                            <tr>
                                <td>Jumlah Soal Dijawab</td>
                                <td>{{$answer_count}}</td>
                            </tr>
                            <tr>
                                <td>Presentase Jawaban</td>
                                <td>{{number_format($complete_percentage, 2)}}% soal terjawab</td>
                            </tr>
                            <tr>
                                <td>Jawaban Benar</td>
                                <td>{{$correct}}</td>
                            </tr>
                            <tr>
                                <td>Predikat</td>
                                <td>{!! $label !!}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-body text-center">
                        <a target="_blank" class="btn btn-outline-success mt-1" href="{{route('challenge.create')}}">Buat Tantangan Sendiri</a> <br/>atau bagikan hasilmu melalui<br/>
                        <a target="_blank" class="btn btn-facebook btn-primary mt-1" href="https://www.facebook.com/sharer.php?u={{Request::url()}}&app_id=3223075517741573">Facebook</a>
                        <a target="_blank" class="btn btn-facebook btn-success mt-1" href="https://api.whatsapp.com/send?text={{Request::url()}}">Whatsapp</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
