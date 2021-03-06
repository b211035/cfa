@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <p>
                        <a href="{{ route('admin_user_log_scenario_download', [$User->id, 0]) }}" class="btn btn-primary" target="_blank">全ログダウンロード</a>
                    </p>
                    @if ($Scenarios->isNotEmpty())
                            <div class="row border-bottom border-top">
                                <div class="col">シナリオ</div>
                                <div class="col"></div>
                            </div>
                        @foreach ($Scenarios as $Scenario)
                            <div class="row border-bottom">
                                <div class="col">
                                    <a href="{{ route('admin_user_log_scenario', [$User->id, $Scenario->id]) }}">{{ $Scenario->scenario_name }}</a>
                                </div>
                                <div class="col"><a href="{{ route('admin_user') }}"></a></div>
                            </div>
                        @endforeach
                    @endif

                    <a href="{{ route('admin_user') }}">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
