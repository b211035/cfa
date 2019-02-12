@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <p>
                        <a href="{{ route('teacher_bot_regist') }}" class="btn btn-primary">ボット追加</a>
                        <a href="{{ route('teacher_bot_avatar') }}" class="btn btn-primary">アバター設定</a>
                    </p>
                    @if ($Bots->isNotEmpty())
                            <div class="row border-bottom border-top">
                                <div class="col">ID</div>
                                <div class="col">{{ __('Bot ID') }}</div>
                                <div class="col">{{ __('Botname') }}</div>
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>
                        @foreach ($Bots as $Bot)
                            <div class="row border-bottom">
                                <div class="col">{{ $Bot->id }}</div>
                                <div class="col">{{ $Bot->bot_id }}</div>
                                <div class="col">{{ $Bot->bot_name }}</div>
                                <div class="col"><a href="{{ route('teacher_bot_update', $Bot->id) }}">編集</a></div>
                                <div class="col"><a href="{{ route('teacher_bot_delete', $Bot->id) }}">削除</a></div>
                            </div>
                        @endforeach
                    @endif
                    <p>
                        <a href="{{ route('teacher_home') }}">戻る</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
