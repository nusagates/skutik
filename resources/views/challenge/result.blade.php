@extends('layouts.app')
@section('title', set_title('Buat Tantangan'))
@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <p>
                            Hai, {{$answer->user->name}}. Kamu telah menyelesaikan tantangan
                            <b>{{$answer->challenge->challenge_title}}</b>
                            Berikut ini adalah hasilnya.
                        </p>
                        <table>
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
                </div>
            </div>
        </div>

    </div>
@endsection
