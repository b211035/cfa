@extends('layouts.app')

@section('content')
    <talk-component
        user_id ="{{ $User->id }}"
        bot_id ="{{ $Bot->id }}"
        scenario_id ="{{ $Scenario->id }}"
    ></talk-component>
@endsection