@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if ($stages->isNotEmpty())
                        @php
                            $prev = null
                        @endphp
                        @foreach ($stages as $stage)
                            @if ($stage->stage_id != $prev)
                                <h3>{{ $stage->stage_name }}</h3>
                                @php
                                    $prev = $stage->stage_id
                                @endphp
                            @endif
                            <div class="row border-bottom">
                                <div class="col">{{ $stage->user_name }}</div>
                            </div>
                        @endforeach
                    @endif
                    <p>
                        <a href="{{ route('teacher_user') }}">戻る</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
