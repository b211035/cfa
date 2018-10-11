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

                    @if ($matrix)
                        <div class="row border-bottom border-top">
                            シナリオ選択
                        </div>
                        @foreach ($matrix as $stage)
                            <div class="row border-bottom">
                                <div class="col">
                                    {{ $stage[1]->stage_name }}
                                </div>
                                <div class="col">
                                        <a href="{{ route('stage_log', $stage[1]->stage_id) }}">ステージログ表示</a>
                                </div>
                            </div>
                            <div class="row border-bottom">
                                @for ($i = 1; $i < 5; $i++)
                                <div class="col-3">
                                    @if (isset($stage[$i]))
                                        @if ($stage[$i]->haslog > 1)
                                        <a href="{{ route('log', $stage[$i]->id) }}">{{ $stage[$i]->scenario_name }}</a>
                                        @else
                                        <a href="{{ route('talk', $stage[$i]->id) }}">{{ $stage[$i]->scenario_name }}</a>
                                        @endif
                                    @endif
                                </div>
                                @endfor
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
