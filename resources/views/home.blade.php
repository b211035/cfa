@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p>
                        <a href="{{ route('profile') }}">プロフィール設定</a>
                    </p>
                    @if ($LastScenarios)
                        最後に会話したシナリオは{{ $LastScenarios->scenario_name }}です
                    @endif

                    @if ($Stages->isNotEmpty())
                        <div class="row border-bottom border-top">
                            シナリオ選択
                        </div>
                        @foreach ($Stages as $Stage)
                            @if ($Stage->matrix)
                                <div class="row border-bottom">
                                    <div class="col">
                                        {{ $Stage->stage_name }}
                                    </div>
                                    <div class="col">
                                            <a href="{{ route('stage_log', $Stage->id) }}">ステージログ表示</a>
                                    </div>
                                </div>
                                <div class="row border-bottom">
                                    @for ($i = 1; $i < 5; $i++)
                                    <div class="col-3">
                                        @if (isset($Stage->matrix[$i]))
                                            @if ($Stage->matrix[$i]->finished)
                                            <a href="{{ route('log', $Stage->matrix[$i]->id) }}">{{ $Stage->matrix[$i]->scenario_name }}</a>
                                            @else
                                                @if (
                                                  ($Progress->next_scenario_id == $Stage->matrix[$i]->id) ||
                                                  ($Progress->next_scenario_id == null && $Stage->PrevStages->isEmpty() && $i == 1)
                                                )
                                                <a href="{{ route('talk', $Stage->matrix[$i]->id) }}">{{ $Stage->matrix[$i]->scenario_name }}</a>
                                                @else
                                                    {{ $Stage->matrix[$i]->scenario_name }}
                                                @endif
                                            @endif
                                        @endif
                                    </div>
                                    @endfor
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
