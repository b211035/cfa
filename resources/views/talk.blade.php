@extends('layouts.app')

@section('content')
    <talk-component
        user_id ="{{ $User->id }}"
        bot_id ="{{ $Bot->id }}"
        scenario_id ="{{ $Scenario->id }}"
    ></talk-component>
@endsection
<!-- 
 v-model="params.user_id"
 v-model="params.bot_id"
 v-model="params.scenario_id" -->
<!--          user-id ="{{ $User->id }}"
        bot-id ="{{ $Bot->id }}"
        scenario-id ="{{ $Scenario->id }}"
 -->