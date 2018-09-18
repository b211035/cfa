@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <p>
                        <a href="{{ route('teacher_user_regist') }}" class="btn btn-primary">生徒追加</a>
                    </p>
                    @if ($Users->isNotEmpty())
                            <div class="row border-bottom border-top">
                                <div class="col">ID</div>
                                <div class="col">{{ __('Username') }}</div>
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>
                        @foreach ($Users as $User)
                            <div class="row border-bottom">
                                <div class="col">{{ $User->id }}</div>
                                <div class="col">{{ $User->user_name }}</div>
                                <div class="col">
                                    @if ($User->teacher_id)
                                        生徒登録済み
                                    @else
                                        <a href="{{ route('teacher_user_relation', $User->id) }}">生徒認証</a>
                                    @endif
                                </div>
                                <div class="col"><a href="{{ route('teacher_user_log', $User->id) }}">会話ログ確認</a></div>
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
