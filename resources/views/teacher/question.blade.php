@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <p>
                        <a href="{{ route('teacher_question_regist', $Theme->id) }}" class="btn btn-primary">質問追加</a>
                    </p>
                    @if ($Theme->Questions->isNotEmpty())
                            <div class="row border-bottom border-top">
                                <div class="col">ID</div>
                                <div class="col">{{ __('Questionname') }}</div>
                                <div class="col"></div>
                            </div>
                        @foreach ($Theme->Questions as $Question)
                            <div class="row border-bottom">
                                <div class="col">{{ $Question->id }}</div>
                                <div class="col">{{ $Question->question_name }}</div>
                                <div class="col"><a href="{{ route('teacher_question_delete', [$Theme->id, $Question->id]) }}">削除</a></div>
                            </div>
                        @endforeach
                    @endif

                    <p>
                        <a href="{{ route('teacher_school') }}">戻る</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
