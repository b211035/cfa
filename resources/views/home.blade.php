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

                    @if ($Scenarios)
                        <div class="row border-bottom border-top">
                            シナリオ選択
                        </div>
                        @foreach ($Scenarios as $Scenario)
                            <div class="row border-bottom">
                                <a href="{{ route('talk', $Scenario->id) }}">{{ $Scenario->scenario_name }}</a>
                            </div>
                        @endforeach
                    @endif
                    <a href="{{ route('log')}}">会話ログ確認</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
