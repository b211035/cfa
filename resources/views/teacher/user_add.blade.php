@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (isset($User))
                        <form method="POST" action="{{ route('teacher_user_update', $User->id) }}" aria-label="{{ __('User') }}">
                    @else
                        <form method="POST" action="{{ route('teacher_user_regist') }}" aria-label="{{ __('User') }}">
                    @endif
                        @csrf

                        <div class="form-group row">
                            <label for="login_id" class="col-md-4 col-form-label text-md-right">{{ __('Login ID') }}</label>

                            <div class="col-md-6">
                                @php
                                    $login_id = isset($User) ? $User->login_id : '';
                                @endphp
                                <input id="login_id" type="text" class="form-control{{ $errors->has('login_id') ? ' is-invalid' : '' }}" name="login_id" value="{{ old('login_id', $login_id) }}" required>

                                @if ($errors->has('login_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('login_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_name" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                @php
                                    $user_name = isset($User) ? $User->user_name : '';
                                @endphp
                                <input id="user_name" type="text" class="form-control{{ $errors->has('user_name') ? ' is-invalid' : '' }}" name="user_name" value="{{ old('user_name', $user_name) }}" required autofocus>

                                @if ($errors->has('user_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('user_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if (!isset($User))

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>
                        @endif

                        <div class="form-group row">
                            <label for="admission_year" class="col-md-4 col-form-label text-md-right">{{ __('Admission Year') }}</label>

                            <div class="col-md-6">
                                @php
                                    $admission_year = isset($User) ? $User->admission_year : '';
                                @endphp
                                <input id="admission_year" type="text" class="form-control{{ $errors->has('admission_year') ? ' is-invalid' : '' }}" name="admission_year" value="{{ old('admission_year', $admission_year) }}" required>

                                @if ($errors->has('admission_year'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('admission_year') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        @if ($Teacher->School && $Teacher->School->Grades->isNotEmpty() && $Teacher->School->Classes->isNotEmpty())
                            @foreach ($Teacher->School->Grades as $Grade)
                                <div class="form-group row">
                                    <label for="gradecalsses[{{ $Grade->id }}]" class="col-md-4 col-form-label text-md-right">{{ $Grade->grade_name }}</label>

                                    <div class="col-md-6">
                                        @php
                                            $gradecalss = isset($User) && $User->Classes->where('grade_id', $Grade->id)->isNotEmpty() ? $User->Classes->where('grade_id', $Grade->id)->first()->class_id : '';
                                        @endphp
                                        <select id="gradecalsses" name="gradecalsses[{{ $Grade->id }}]" class="form-control{{ $errors->has('gradecalsses') ? ' is-invalid' : '' }}" >
                                            @foreach ($Teacher->School->Classes as $Class)
                                                <option value="{{ $Class->id }}" @if ($Class->id == old('gradecalsses', $gradecalss)) selected @endif>{{ $Class->class_name }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('gradecalsses'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('gradecalsses') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <a href="{{ route('teacher_user') }}">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
