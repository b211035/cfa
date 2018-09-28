@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if ($Users->isNotEmpty())
                            <div class="row border-bottom border-top">
                                <div class="col">ID</div>
                                <div class="col">{{ __('Username') }}</div>
                                <div class="col"></div>
                            </div>
                        @foreach ($Users as $User)
                            <div class="row border-bottom">
                                <div class="col">{{ $User->id }}</div>
                                <div class="col">{{ $User->user_name }}</div>
                                <div class="col"><a href="{{ route('admin_user_log', $User->id) }}">会話ログ確認</a></div>
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
