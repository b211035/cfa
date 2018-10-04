@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <ul>
                        <li><a href="{{ route('teacher_school') }}">学校選択</a></li>
                    </ul>
                    <a href="{{ route('teacher_home') }}">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
