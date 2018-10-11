@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div id="talkerea">
                        <div class="row no-gutters">
                            @foreach ($Logs as $Log)
                                <span @if ($loop->last) id="last" @endif></span>
                                @if ($Log->sender_flg == 1)
                                    <div class="col-9 justify-content-start">
                                        <div class="row no-gutters">
                                            <div class="col-auto avatar">
                                                <img class="avater_image" src="
                                                @if ($Log->avater_image) {{ $Log->avater_image }}
                                                @else {{ route('root') }}/storage/default_avatar.png
                                                @endif
                                                ">
                                            </div>
                                            <div class="col talkbox bottalk rounded">
                                                {{ $Log->contents }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3"></div>
                                @else
                                    <div class="col-3"></div>
                                    <div class="col-9 align-self-end">
                                        <div class="row no-gutters">
                                            <div class="col talkbox usertalk rounded">
                                                {{ $Log->contents }}
                                            </div>
                                            <div class="col-auto avatar">
                                                <img class="avater_image" src="
                                                @if ($Log->avater_image) {{ $Log->avater_image }}
                                                @else {{ route('root') }}/storage/default_avatar.png
                                                @endif
                                                ">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <p>
                            <a href="{{ route('home') }}">戻る</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
