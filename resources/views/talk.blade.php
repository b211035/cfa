@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <talk-component
                        logs = '@json($Logs)'
                        user_id ="{{ $Repluser->repl_user_id }}"
                        bot_id ="{{ $Bot->bot_id }}"
                        scenario_id ="{{ $Scenario->scenario_id }}"
                        haslog = '{{ $Scenario->haslog }}'
                        user_avatar =@if ($UserAvatar) "{{ route('root') }}/storage/user/{{ $UserAvatar->filename }}" @else "{{ route('root') }}/storage/default_avatar.png" @endif
                    >
                    </talk-component>
                    <div>
                        <p>
                            <a href="{{ route('home') }}">戻る</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection