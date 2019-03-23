@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            @if ($Teacher->School && $Teacher->School->Grades->isNotEmpty() && $Teacher->School->Classes->isNotEmpty())
                                @php
                                    $startYear = date('Y');
                                @endphp
                                @for ($i = $startYear; $startYear - $i < 10 ; $i--)
                                <h2>{{ $i }}年度</h2>
                                @foreach ($Teacher->School->Grades as $Grade)
                                    <div class="row">
                                        <div class="col">{{ $Grade->grade_name }}</div>
                                        <div class="col">
                                            <a href="{{ route('teacher_manage_school_list', [$i, $Grade->id, 0]) }}">全クラス</a>
                                        </div>
                                        @foreach ($Teacher->School->Classes as $Class)
                                            <div class="col">
                                                <a href="{{ route('teacher_manage_school_list', [$i, $Grade->id, $Class->id]) }}">{{ $Class->class_name }}</a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                                @endfor
                            @endif
                        </div>
                        <div class="col-6">
                            <h2>テーマ</h2>
                            @if ($Teacher->Themes->isNotEmpty())
                                <ul>
                                @foreach ($Teacher->Themes as $Theme)
                                    <li>
                                        <a href="{{ route('teacher_manage_school_theme_answer', $Theme->id) }}">{{ $Theme->theme_name }}</a>
                                    </li>
                                @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('teacher_home') }}">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
