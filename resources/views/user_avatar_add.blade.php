@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (isset($BotAvatar))
                        <form method="POST" enctype="multipart/form-data" action="{{ route('user_avatar_update', $BotAvatar->id) }}" aria-label="{{ __('Bot Avatar') }}">
                    @else
                        <form method="POST" enctype="multipart/form-data" action="{{ route('user_avatar_regist') }}" aria-label="{{ __('Bot Avatar') }}">
                    @endif
                        @csrf

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
                    <a href="{{ route('user_avatar') }}">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
