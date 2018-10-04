@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <ul>
                        <li><a href="{{ route('user_avatar') }}">アバター設定</a></li>
                        <li><a href="{{ route('user_school') }}">学校選択</a></li>
                    </ul>
                    <a href="{{ route('home') }}">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
