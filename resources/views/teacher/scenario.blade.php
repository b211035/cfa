@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <p>
                        <a href="{{ route('teacher_scenario_regist') }}" class="btn btn-primary">シナリオ追加</a>
                    </p>
                    @if ($Scenarios->isNotEmpty())
                            <div class="row border-bottom border-top">
                                <div class="col">ID</div>
                                <div class="col">{{ __('Scenario ID') }}</div>
                                <div class="col">{{ __('Scenarioname') }}</div>
                                <div class="col">{{ __('Stage') }}</div>
                                <div class="col">{{ __('Times') }}</div>
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>
                        @foreach ($Scenarios as $Scenario)
                            <div class="row border-bottom">
                                <div class="col">{{ $Scenario->id }}</div>
                                <div class="col">{{ $Scenario->scenario_id }}</div>
                                <div class="col">{{ $Scenario->scenario_name }}</div>
                                <div class="col">{{ $Scenario->stage_name }}</div>
                                <div class="col">{{ $Scenario->times }}</div>
                                <div class="col"><a href="{{ route('teacher_scenario_update', $Scenario->id) }}">編集</a></div>
                                <div class="col"><a href="{{ route('teacher_scenario_delete', $Scenario->id) }}">削除</a></div>
                            </div>
                        @endforeach
                    @endif
                    <p>
                        <a href="{{ route('teacher_home') }}">戻る</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
