@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin_school_regist') }}" aria-label="{{ __('School') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="school_name" class="col-md-4 col-form-label text-md-right">{{ __('Schoolname') }}</label>

                            <div class="col-md-6">
                                @php
                                    $school_name = isset($School) ? $School->school_name : '';
                                @endphp
                                <input id="school_name" type="text" class="form-control{{ $errors->has('school_name') ? ' is-invalid' : '' }}" name="school_name" value="{{ old('school_name', $school_name) }}" required autofocus>

                                @if ($errors->has('school_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('school_name') }}</strong>
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
                    <a href="{{ route('admin_school') }}">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
