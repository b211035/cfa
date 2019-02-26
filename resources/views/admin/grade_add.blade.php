@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin_grade_regist', $School->id) }}" aria-label="{{ __('Grade') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="grade_name" class="col-md-4 col-form-label text-md-right">{{ __('Gradename') }}</label>

                            <div class="col-md-6">
                                @php
                                    $grade_name = isset($Grade) ? $Grade->grade_name : '';
                                @endphp
                                <input id="grade_name" type="text" class="form-control{{ $errors->has('grade_name') ? ' is-invalid' : '' }}" name="grade_name" value="{{ old('grade_name', $grade_name) }}" required autofocus>

                                @if ($errors->has('grade_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('grade_name') }}</strong>
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
                    <a href="{{ route('admin_grade', $School->id) }}">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
