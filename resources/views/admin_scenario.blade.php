@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                    <form method="POST" action="{{ route('admin_scenario') }}" aria-label="{{ __('Bot') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="bot_id" class="col-md-4 col-form-label text-md-right">{{ __('Bot') }}</label>

                            <div class="col-md-6">
                                <select id="bot_id" name="bot_id" class="form-control{{ $errors->has('bot_id') ? ' is-invalid' : '' }}" >
                                    @if ($Bots)
                                        @foreach ($Bots as $Bot)
                                            <option value="{{ $Bot->id }}" @if ($Bot->bot_id == old('bot_id')) selected @endif>{{ $Bot->bot_name }}</option>
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
                                <input id="scenario_id" type="text" class="form-control{{ $errors->has('scenario_id') ? ' is-invalid' : '' }}" name="scenario_id" value="{{ old('scenario_id') }}" required>

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
                                <input id="scenario_name" type="text" class="form-control{{ $errors->has('scenario_name') ? ' is-invalid' : '' }}" name="scenario_name" value="{{ old('scenario_name') }}" required autofocus>

                                @if ($errors->has('scenario_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('scenario_name') }}</strong>
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

                    @if ($Scenarios)
                        @foreach ($Scenarios as $Scenario)
                            <p>{{ $Scenario->scenario_name }}</p>
                        @endforeach
                    @endif

                    <a href="{{ route('admin_home') }}">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
