@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (isset($Scenario))
                        <form method="POST" action="{{ route('teacher_scenario_update', $Scenario->id) }}" aria-label="{{ __('Scenario') }}">
                    @else
                        <form method="POST" action="{{ route('teacher_scenario_regist') }}" aria-label="{{ __('Scenario') }}">
                    @endif
                        @csrf

                        <div class="form-group row">
                            <label for="bot_id" class="col-md-4 col-form-label text-md-right">{{ __('Bot') }}</label>

                            <div class="col-md-6">
                                @php
                                    $bot_id = isset($Scenario) ? $Scenario->bot_id : '';
                                @endphp
                                <select id="bot_id" name="bot_id" class="form-control{{ $errors->has('bot_id') ? ' is-invalid' : '' }}" >
                                    @if ($Bots->isNotEmpty())
                                        @foreach ($Bots as $Bot)
                                            <option value="{{ $Bot->id }}" @if ($Bot->bot_id == old('bot_id', $bot_id)) selected @endif>{{ $Bot->bot_name }}</option>
                                        @endforeach
                                    @endif
                                </select>

                                @if ($errors->has('bot_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bot_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="scenario_id" class="col-md-4 col-form-label text-md-right">{{ __('Scenario ID') }}</label>

                            <div class="col-md-6">
                                @php
                                    $scenario_id = isset($Scenario) ? $Scenario->scenario_id : '';
                                @endphp
                                <input id="scenario_id" type="text" class="form-control{{ $errors->has('scenario_id') ? ' is-invalid' : '' }}" name="scenario_id" value="{{ old('scenario_id', $scenario_id) }}" required>

                                @if ($errors->has('scenario_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('scenario_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="scenario_name" class="col-md-4 col-form-label text-md-right">{{ __('Scenarioname') }}</label>

                            <div class="col-md-6">
                                @php
                                    $scenario_name = isset($Scenario) ? $Scenario->scenario_name : '';
                                @endphp
                                <input id="scenario_name" type="text" class="form-control{{ $errors->has('scenario_name') ? ' is-invalid' : '' }}" name="scenario_name" value="{{ old('scenario_name', $scenario_name) }}" required autofocus>

                                @if ($errors->has('scenario_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('scenario_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="stage_id" class="col-md-4 col-form-label text-md-right">{{ __('Stage') }}</label>

                            <div class="col-md-6">
                                @php
                                    $stage_id = isset($Scenario) ? $Scenario->stage_id : '';
                                @endphp
                                <select id="stage_id" name="stage_id" class="form-control{{ $errors->has('stage_id') ? ' is-invalid' : '' }}" >
                                    @if ($Stages->isNotEmpty())
                                        @foreach ($Stages as $Stage)
                                            <option value="{{ $Stage->id }}" @if ($Stage->id == old('stage_id', $stage_id)) selected @endif>{{ $Stage->stage_name }}</option>
                                        @endforeach
                                    @endif
                                </select>

                                @if ($errors->has('stage_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('stage_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="times" class="col-md-4 col-form-label text-md-right">{{ __('Times') }}</label>

                            <div class="col-md-6">
                                @php
                                    $times = isset($Scenario) ? $Scenario->times : '';
                                @endphp
                                <select id="times" name="times" class="form-control{{ $errors->has('times') ? ' is-invalid' : '' }}" >
                                    @for ($i = 1; $i < 5; $i++)
                                        <option value="{{ $i }}" @if ($i == old('times', $times)) selected @endif>{{ $i }}回目</option>
                                    @endfor
                                </select>

                                @if ($errors->has('times'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('times') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <a href="{{ route('teacher_scenario') }}">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
