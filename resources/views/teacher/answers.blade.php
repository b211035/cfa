@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if ($QandA->isNotEmpty())
                        <div class="row">
                            <div class="col">
                                質問内容
                            </div>
                            <div class="col">
                                回答
                            </div>
                        </div>

                        @foreach ($QandA as $QA)
                            <div class="row">
                                <div class="col">
                                    {{ $QA->question_name }}
                                </div>
                                <div class="col">
                                    {{ $QA->answer }}
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <a href="{{ route('teacher_user_log', $User->id)  }}">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
