@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <p>
                        <a href="{{ route('teacher_stage_regist') }}" class="btn btn-primary">学習ステージ追加</a>
                    </p>
                    @if ($Stages->isNotEmpty())
                            <div class="row border-bottom border-top">
                                <div class="col">ID</div>
                                <div class="col">{{ __('Stagename') }}</div>
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>
                        @foreach ($Stages as $Stage)
                            <div class="row border-bottom">
                                <div class="col">{{ $Stage->id }}</div>
                                <div class="col">{{ $Stage->stage_name }}</div>
                                <div class="col"><a href="{{ route('teacher_stage_update', $Stage->id) }}">編集</a></div>
                                <div class="col"><a href="{{ route('teacher_stage_delete', $Stage->id) }}">削除</a></div>
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
