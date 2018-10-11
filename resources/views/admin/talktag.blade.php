@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <p>
                        <a href="{{ route('admin_talktag_regist', $Talktagtype->id) }}" class="btn btn-primary">タグ追加</a>
                    </p>
                    @if ($Talktags->isNotEmpty())
                            <div class="row border-bottom border-top">
                                <div class="col">タグ名</div>
                                <div class="col">タグ</div>
                                <div class="col"></div>
                            </div>
                        @foreach ($Talktags as $Talktag)
                            <div class="row border-bottom">
                                <div class="col">{{ $Talktag->protcol_name }}</div>
                                <div class="col">{{ $Talktagtype->protcol }}{{ $Talktag->protcol }}</div>
                                <div class="col"><a href="{{ route('admin_talktag_delete', [$Talktagtype->id, $Talktag->id]) }}">削除</a></div>
                            </div>
                        @endforeach
                    @endif

                    <p>
                        <a href="{{ route('admin_home') }}">戻る</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
