@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (isset($Stage))
                        <form method="POST" action="{{ route('teacher_stage_update', $Stage->id) }}" aria-label="{{ __('Stage') }}">
                    @else
                        <form method="POST" action="{{ route('teacher_stage_regist') }}" aria-label="{{ __('Stage') }}">
                    @endif
                        @csrf

                        <div class="form-group row">
                            <label for="stage_name" class="col-md-4 col-form-label text-md-right">{{ __('Stagename') }}</label>

                            <div class="col-md-6">
                                @php
                                    $stage_name = isset($Stage) ? $Stage->stage_name : '';
                                @endphp
                                <input id="stage_name" type="text" class="form-control{{ $errors->has('stage_name') ? ' is-invalid' : '' }}" name="stage_name" value="{{ old('stage_name', $stage_name) }}" required autofocus>

                                @if ($errors->has('stage_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('stage_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="theme_id" class="col-md-4 col-form-label text-md-right">{{ __('Theme') }}</label>

                            <div class="col-md-6">
                                @php
                                    $theme_id = isset($Scenario) ? $Scenario->theme_id : '';
                                @endphp
                                <select id="theme_id" name="theme_id" class="form-control{{ $errors->has('theme_id') ? ' is-invalid' : '' }}" >
                                    @if ($Themes->isNotEmpty())
                                        @foreach ($Themes as $Theme)
                                            <option value="{{ $Theme->id }}" @if ($Theme->theme_id == old('theme_id', $theme_id)) selected @endif>{{ $Theme->theme_name }}</option>
                                        @endforeach
                                    @endif
                                </select>

                                @if ($errors->has('theme_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('theme_id') }}</strong>
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
                    <a href="{{ route('teacher_stage') }}">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
