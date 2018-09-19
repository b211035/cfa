@extends('layouts.app')

@section('content')
    <talk-component
        user_id ="{{ $User->id }}"
        bot_id ="{{ $Bot->id }}"
        scenario_id ="{{ $Scenario->id }}"
        user_avatar =@if ($UserAvatar) "{{ route('root') }}/storage/user/{{ $UserAvatar->filename }}" @else "{{ route('root') }}/storage/default_avatar.png" @endif
    ></talk-component>
@endsection