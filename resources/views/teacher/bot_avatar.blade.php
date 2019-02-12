@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <p>
                        <a href="{{ route('teacher_bot_avatar_regist') }}" class="btn btn-primary">アバター追加</a>
                    </p>
                    @if ($BotAvatars->isNotEmpty())
                            <div class="row border-bottom border-top">
                                <div class="col">ID</div>
                                <div class="col">感情</div>
                                <div class="col">表情</div>
                                <div class="col"></div>
                            </div>
                        @foreach ($BotAvatars as $BotAvatar)
                            <div class="row border-bottom">
                                <div class="col">{{ $BotAvatar->protcol }}</div>
                                <div class="col">{{ $BotAvatar->protcol_name }}</div>
                                <div class="col"> <img src="{{ route('root') }}/storage/bot/{{ $BotAvatar->filename }}"></div>
                                <div class="col"><a href="{{ route('teacher_bot_avatar_delete', $BotAvatar->id) }}">削除</a></div>
                            </div>
                        @endforeach
                    @endif
                    <p>
                        <a href="{{ route('teacher_bot') }}">戻る</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
