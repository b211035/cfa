@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                    <form method="POST" action="{{ route('admin_bot') }}" aria-label="{{ __('Bot') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="bot_id" class="col-md-4 col-form-label text-md-right">{{ __('Bot ID') }}</label>

                            <div class="col-md-6">
                                <input id="bot_id" type="text" class="form-control{{ $errors->has('bot_id') ? ' is-invalid' : '' }}" name="bot_id" value="{{ old('bot_id') }}" required>

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
                                <input id="bot_name" type="text" class="form-control{{ $errors->has('bot_name') ? ' is-invalid' : '' }}" name="bot_name" value="{{ old('bot_name') }}" required autofocus>

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

                    @if ($Bots)
                            <div class="row border-bottom border-top">
                                <div class="col">ID</div>
                                <div class="col">{{ __('Bot ID') }}</div>
                                <div class="col">{{ __('Botname') }}</div>
                                <div class="col"></div>
                            </div>
                        @foreach ($Bots as $Bot)
                            <div class="row border-bottom">
                                <div class="col">{{ $Bot->id }}</div>
                                <div class="col">{{ $Bot->bot_id }}</div>
                                <div class="col">{{ $Bot->bot_name }}</div>
                                <div class="col"><a href="{{ route('admin_bot_delete', $Bot->id) }}">削除</a></div>
                            </div>
                        @endforeach
                    @endif

                    <a href="{{ route('admin_home') }}">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
