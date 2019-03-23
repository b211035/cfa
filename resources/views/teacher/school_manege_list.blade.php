@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <h2>テーマ</h2>
                    @if ($Teacher->Themes->isNotEmpty())
                        <ul>
                        @foreach ($Teacher->Themes as $Theme)
                            <li>
                                <a href="{{ route('teacher_manage_school_theme_list_answer', [$year, $grade_id, $class_id, $Theme->id]) }}">{{ $Theme->theme_name }}</a>
                            </li>
                        @endforeach
                        </ul>
                    @endif

                    <a href="{{ route('teacher_manage_school') }}">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
