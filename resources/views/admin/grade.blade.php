@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <p>
                        <a href="{{ route('admin_grade_regist', $School->id) }}" class="btn btn-primary">学年追加</a>
                    </p>
                    @if ($School->Grades->isNotEmpty())
                            <div class="row border-bottom border-top">
                                <div class="col">ID</div>
                                <div class="col">{{ __('Gradename') }}</div>
                                <div class="col"></div>
                            </div>
                        @foreach ($School->Grades as $Grade)
                            <div class="row border-bottom">
                                <div class="col">{{ $Grade->id }}</div>
                                <div class="col">{{ $Grade->grade_name }}</div>
                                <div class="col"><a href="{{ route('admin_grade_delete', [$School->id, $Grade->id]) }}">削除</a></div>
                            </div>
                        @endforeach
                    @endif

                    <p>
                        <a href="{{ route('admin_school') }}">戻る</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
