@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <p>
                        <a href="{{ route('admin_teacher_regist') }}" class="btn btn-primary">教師追加</a>
                    </p>
                    @if ($Teachers->isNotEmpty())
                            <div class="row border-bottom border-top">
                                <div class="col">ID</div>
                                <div class="col">{{ __('Teacher ID') }}</div>
                                <div class="col">{{ __('Teachername') }}</div>
                                <div class="col"></div>
                            </div>
                        @foreach ($Teachers as $Teacher)
                            <div class="row border-bottom">
                                <div class="col">{{ $Teacher->id }}</div>
                                <div class="col">{{ $Teacher->login_id }}</div>
                                <div class="col">{{ $Teacher->user_name }}</div>
                                <div class="col"><a href="{{ route('admin_teacher_delete', $Teacher->id) }}">削除</a></div>
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
