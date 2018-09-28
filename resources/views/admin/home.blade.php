@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <ul>
                        <li><a href="{{ route('admin_teacher') }}">先生</a></li>
                        <li><a href="{{ route('admin_user') }}">ユーザー</a></li>
                        <!-- <li><a href="{{ route('admin_bot') }}">ボット</a></li> -->
                        <!-- <li><a href="{{ route('admin_scenario') }}">シナリオ</a></li> -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
