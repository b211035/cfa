@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (isset($Theme))
                        <form method="POST" action="{{ route('teacher_theme_update', $Theme->id) }}" aria-label="{{ __('Theme') }}">
                    @else
                        <form method="POST" action="{{ route('teacher_theme_regist') }}" aria-label="{{ __('Theme') }}">
                    @endif
                        @csrf

                        <div class="form-group row">
                            <label for="theme_name" class="col-md-4 col-form-label text-md-right">{{ __('Themename') }}</label>

                            <div class="col-md-6">
                                @php
                                    $theme_name = isset($Theme) ? $Theme->theme_name : '';
                                @endphp
                                <input id="theme_name" type="text" class="form-control{{ $errors->has('theme_name') ? ' is-invalid' : '' }}" name="theme_name" value="{{ old('theme_name', $theme_name) }}" required autofocus>

                                @if ($errors->has('theme_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('theme_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="answer_scenario_id" class="col-md-4 col-form-label text-md-right">{{ __('Answer Scenario Id') }}</label>

                            <div class="col-md-6">
                                @php
                                    $answer_scenario_id = isset($Theme) ? $Theme->answer_scenario_id : '';
                                @endphp
                                <input id="answer_scenario_id" type="text" class="form-control{{ $errors->has('answer_scenario_id') ? ' is-invalid' : '' }}" name="answer_scenario_id" value="{{ old('answer_scenario_id', $answer_scenario_id) }}" required autofocus>

                                @if ($errors->has('answer_scenario_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('answer_scenario_id') }}</strong>
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
                    <a href="{{ route('teacher_theme') }}">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
