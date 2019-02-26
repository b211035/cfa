@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <p>
                        <a href="{{ route('teacher_theme_regist') }}" class="btn btn-primary">学習テーマ追加</a>
                    </p>
                    @if ($Themes->isNotEmpty())
                            <div class="row border-bottom border-top">
                                <div class="col">ID</div>
                                <div class="col">{{ __('Themename') }}</div>
                                <div class="col"></div>
                                <div class="col"></div>
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>
                        @foreach ($Themes as $Theme)
                            <div class="row border-bottom">
                                <div class="col">{{ $Theme->id }}</div>
                                <div class="col">{{ $Theme->theme_name }}</div>
                                <div class="col"><a href="{{ route('teacher_theme_update', $Theme->id) }}">編集</a></div>
                                <div class="col"><a href="{{ route('teacher_question', $Theme->id) }}">質問登録</a></div>
                                <div class="col"><a href="{{ route('teacher_theme_delete', $Theme->id) }}">削除</a></div>
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
