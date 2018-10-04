@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user_school') }}" aria-label="{{ __('User') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="school_id" class="col-md-4 col-form-label text-md-right">{{ __('School') }}</label>

                            <div class="col-md-6">
                                @php
                                    $school_id = isset($User) ? $User->school_id : '';
                                @endphp
                                <select id="school_id" name="school_id" class="form-control{{ $errors->has('school_id') ? ' is-invalid' : '' }}" >
                                    @if ($Schools->isNotEmpty())
                                        @foreach ($Schools as $School)
                                            <option value="{{ $School->id }}" @if ($School->school_id == old('school_id', $school_id)) selected @endif>{{ $School->school_name }}</option>
                                        @endforeach
                                    @endif
                                </select>

                                @if ($errors->has('school_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('school_id') }}</strong>
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

                    <a href="{{ route('profile') }}">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
