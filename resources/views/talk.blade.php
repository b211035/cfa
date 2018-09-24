@extends('layouts.app')

@section('content')
    <talk-component
        user_id ="{{ $Repluser->repl_user_id }}"
        bot_id ="{{ $Bot->bot_id }}"
        scenario_id ="{{ $Scenario->scenario_id }}"
        user_avatar =@if ($UserAvatar) "{{ route('root') }}/storage/user/{{ $UserAvatar->filename }}" @else "{{ route('root') }}/storage/default_avatar.png" @endif
    ></talk-component>
@endsection