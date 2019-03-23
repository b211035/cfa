@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if ($Users->isNotEmpty())
                        <div class="row">
                            <div class="col">
                                ユーザー
                            </div>
                            @foreach ($Theme->Questions as $Question)
                                <div class="col">
                                    {{ $Question->question_name }}
                                </div>
                            @endforeach

                        </div>

                        @foreach ($Users as $User)
                            <div class="row">
                                <div class="col">
                                    {{ $User->user_name }}
                                </div>
                                @foreach ($Theme->Questions as $Question)
                                    <div class="col">
                                    @if($Answer = $Question->Answers()->where('user_id', $User->id)->first())
                                        {{ $Answer->answer }}
                                    @endif
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @endif

                    <a href="{{ route('teacher_manage_school')  }}">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
