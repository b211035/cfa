@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('teacher_question_regist', $Theme->id) }}" aria-label="{{ __('Question') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="question_name" class="col-md-4 col-form-label text-md-right">{{ __('Question name') }}</label>

                            <div class="col-md-6">
                                @php
                                    $question_name = isset($Question) ? $Question->question_name : '';
                                @endphp
                                <input id="question_name" type="text" class="form-control{{ $errors->has('question_name') ? ' is-invalid' : '' }}" name="question_name" value="{{ old('question_name', $question_name) }}" required autofocus>

                                @if ($errors->has('question_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('question_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="question_type" class="col-md-4 col-form-label text-md-right">{{ __('Question type') }}</label>

                            <div class="col-md-6">
                                @php
                                    $question_type = isset($Question) ? $Question->question_type : '';
                                @endphp
                                <select id="question_type" name="question_type" class="form-control{{ $errors->has('question_type') ? ' is-invalid' : '' }}" >
                                    <option value="1" @if (1 == old('question_type', $question_type)) selected @endif>レプル変数</option>
                                    <option value="2" @if (2 == old('question_type', $question_type)) selected @endif>レプルコード</option>
                                    <option value="3" @if (3 == old('question_type', $question_type)) selected @endif>過去ログ</option>
                                </select>

                                @if ($errors->has('question_type'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('question_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row protcol">
                            <label for="protcol" class="col-md-4 col-form-label text-md-right">{{ __('Protcol') }}</label>

                            <div class="col-md-6">
                                @php
                                    $protcol = isset($Question) ? $Question->protcol : '';
                                @endphp
                                <input id="protcol" type="text" class="form-control{{ $errors->has('protcol') ? ' is-invalid' : '' }}" name="protcol" value="{{ old('protcol', $protcol) }}" autofocus>

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
                    <a href="{{ route('teacher_question', $Theme->id) }}">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

</script>
@endsection
