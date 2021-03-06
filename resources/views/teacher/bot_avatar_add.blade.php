@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('teacher_bot_avatar_regist') }}" aria-label="{{ __('Bot Avatar') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="emotion" class="col-md-4 col-form-label text-md-right">{{ __('Avatar Emotion') }}</label>

                            <div class="col-md-6">
                                @php
                                    $emotion = isset($BotAvatar) ? $BotAvatar->emotion : '';
                                @endphp
                                <select id="emotion" name="emotion" class="form-control{{ $errors->has('emotion') ? ' is-invalid' : '' }}" >
                                    @foreach ($Talktags as $Talktag)
                                        <option value="{{ $Talktag->protcol }}" @if ( $Talktag->protcol == old('emotion', $emotion)) selected @endif>{{ $Talktag->protcol_name }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('emotion'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('emotion') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="protcol" class="col-md-4 col-form-label text-md-right">{{ __('Avatar ID') }}</label>

                            <div class="col-md-6">
                                @php
                                    $protcol = isset($Bot) ? $Bot->protcol : '';
                                @endphp
                                <input id="protcol" type="text" class="form-control{{ $errors->has('protcol') ? ' is-invalid' : '' }}" name="protcol" value="{{ old('protcol', $protcol) }}" required>

                                @if ($errors->has('protcol'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('protcol') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="avatar" class="col-md-4 col-form-label text-md-right">{{ __('Avatar image') }}</label>

                            <div class="col-md-6">
                                <input id="avatar" type="file" class="{{ $errors->has('avatar') ? ' is-invalid' : '' }}" name="avatar" required>
                                @if ($errors->has('avatar'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('avatar') }}</strong>
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
