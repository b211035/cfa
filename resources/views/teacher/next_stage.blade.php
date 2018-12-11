@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('teacher_next_stage', $PrevStage->id) }}" aria-label="{{ __('Scenario') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="next_id" class="col-md-4 col-form-label text-md-right">{{ __('Stage') }}</label>

                            <div class="col-md-6">
                                @php
                                    $stage_id = isset($Scenario) ? $Scenario->stage_id : '';
                                @endphp
                                <select id="next_id" name="next_id" class="form-control{{ $errors->has('next_id') ? ' is-invalid' : '' }}" >
                                    <option value="">------------</option>
                                    @if ($Stages->isNotEmpty())
                                        @foreach ($Stages as $Stage)
                                            @if ($Stage->id != $PrevStage->id)
                                            <option value="{{ $Stage->id }}" @if ($Stage->id == old('stage_id', $stage_id)) selected @endif>{{ $Stage->stage_name }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>

                                @if ($errors->has('next_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('next_id') }}</strong>
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


                    @if ($PrevStage->NextStages->isNotEmpty())
                            <div class="row border-bottom border-top">
                                <div class="col">No</div>
                                <div class="col">{{ __('Stagename') }}</div>
                                <div class="col"></div>
                            </div>
                        @foreach ($PrevStage->NextStages as $Stage)
                            <div class="row border-bottom">
                                <div class="col">{{ $Stage->pivot->level }}</div>
                                <div class="col">{{ $Stage->stage_name }}</div>
                                <div class="col"><a href="{{ route('teacher_next_stage_delete', [$PrevStage->id, $Stage->id]) }}">削除</a></div>
                            </div>
                        @endforeach
                    @endif
                    <p>
                        <a href="{{ route('teacher_stage') }}">戻る</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
