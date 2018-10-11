@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin_talktag_regist', $Talktagtype->id) }}" aria-label="{{ __('Teacher') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="protcol_name" class="col-md-4 col-form-label text-md-right">タグ名</label>

                            <div class="col-md-6">
                                @php
                                    $protcol_name = isset($Teacher) ? $Teacher->protcol_name : '';
                                @endphp
                                <input id="protcol_name" type="text" class="form-control{{ $errors->has('protcol_name') ? ' is-invalid' : '' }}" name="protcol_name" value="{{ old('protcol_name', $protcol_name) }}" required>

                                @if ($errors->has('protcol_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('protcol_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="protcol" class="col-md-4 col-form-label text-md-right">タグ</label>

                            <div class="col-md-6">
                                @php
                                    $protcol = isset($Teacher) ? $Teacher->protcol : '';
                                @endphp
                                <div class="row no-gutters">
                                    <div class="col-auto">
                                        <p>{{ $Talktagtype->protcol }}</p>
                                    </div>
                                    <div class="col">
                                        <input id="protcol" type="text" class="form-control{{ $errors->has('protcol') ? ' is-invalid' : '' }}" name="protcol" value="{{ old('protcol', $protcol) }}" required autofocus>
                                    </div>
                                </div>

                                @if ($errors->has('protcol'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('protcol') }}</strong>
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
                    <a href="{{ route('admin_teacher') }}">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
