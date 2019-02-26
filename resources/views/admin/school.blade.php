@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <p>
                        <a href="{{ route('admin_school_regist') }}" class="btn btn-primary">学校追加</a>
                    </p>
                    @if ($Schools->isNotEmpty())
                            <div class="row border-bottom border-top">
                                <div class="col">ID</div>
                                <div class="col">{{ __('Schoolname') }}</div>
                                <div class="col"></div>
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>
                        @foreach ($Schools as $School)
                            <div class="row border-bottom">
                                <div class="col">{{ $School->id }}</div>
                                <div class="col">{{ $School->school_name }}</div>
                                <div class="col"><a href="{{ route('admin_grade', $School->id) }}">学年</a></div>
                                <div class="col"><a href="{{ route('admin_class', $School->id) }}">クラス</a></div>
                                <div class="col"><a href="{{ route('admin_school_delete', $School->id) }}">削除</a></div>
                            </div>
                        @endforeach
                    @endif

                    <p>
                        <a href="{{ route('admin_home') }}">戻る</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
