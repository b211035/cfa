@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (isset($Bot))
                        <form method="POST" action="{{ route('teacher_bot_update', $Bot->id) }}" aria-label="{{ __('Bot') }}">
                    @else
                        <form method="POST" action="{{ route('teacher_bot_regist') }}" aria-label="{{ __('Bot') }}">
                    @endif
                        @csrf

                        <div class="form-group row">
                            <label for="bot_id" class="col-md-4 col-form-label text-md-right">{{ __('Bot ID') }}</label>

                            <div class="col-md-6">
                                @php
                                    $bot_id = isset($Bot) ? $Bot->bot_id : '';
                                @endphp
                                <input id="bot_id" type="text" class="form-control{{ $errors->has('bot_id') ? ' is-invalid' : '' }}" name="bot_id" value="{{ old('bot_id', $bot_id) }}" required>

                                @if ($errors->has('bot_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bot_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bot_name" class="col-md-4 col-form-label text-md-right">{{ __('Botname') }}</label>

                            <div class="col-md-6">
                                @php
                                    $bot_name = isset($Bot) ? $Bot->bot_name : '';
                                @endphp
                                <input id="bot_name" type="text" class="form-control{{ $errors->has('bot_name') ? ' is-invalid' : '' }}" name="bot_name" value="{{ old('bot_name', $bot_name) }}" required autofocus>

                                @if ($errors->has('bot_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bot_name') }}</strong>
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
                    <a href="{{ route('teacher_bot') }}">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
