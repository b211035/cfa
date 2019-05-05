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
                        <a href="{{ route('teacher_user_stage_check') }}" class="btn btn-primary">ステージ確認</a>
                    </p>
                    <relation-component
                        users = @json($Users)
                    >
                    </relation-component>

                    <p>
                        <a href="{{ route('teacher_home') }}">戻る</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
