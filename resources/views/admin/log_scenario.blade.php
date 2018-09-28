@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <p>
                        <a href="{{ route('admin_user_log_scenario_download', [$User->id, $scenario_id]) }}" class="btn btn-primary" target="_blank">ログダウンロード</a>
                    </p>
                    @if ($Logs->isNotEmpty())
                            <div class="row border-bottom border-top">
                                <div class="col">シナリオ</div>
                                <div class="col">発言者</div>
                                <div class="col">発言内容</div>
                                <div class="col">発言日時</div>
                            </div>
                        @foreach ($Logs as $Log)
                            <div class="row border-bottom">
                                <div class="col">{{ $Log->scenario_name }}</div>
                                <div class="col">
                                    @if ($Log->sender_flg == 1)
                                        {{ $Log->bot_name }}
                                    @else
                                        {{ $User->user_name }}
                                    @endif
                                </div>
                                <div class="col">{{ $Log->contents }}</div>
                                <div class="col">{{ $Log->send_date }}</div>
                            </div>
                        @endforeach
                    @endif

                    <a href="{{ route('admin_user_log', $User->id)  }}">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
