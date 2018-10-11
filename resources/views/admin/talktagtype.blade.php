@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if ($Talktagtypes->isNotEmpty())
                            <div class="row border-bottom border-top">
                                <div class="col">タグ種類名</div>
                                <div class="col">タグ</div>
                                <div class="col"></div>
                            </div>
                        @foreach ($Talktagtypes as $Talktagtype)
                            <div class="row border-bottom">
                                <div class="col">{{ $Talktagtype->protcol_name }}</div>
                                <div class="col">{{ $Talktagtype->protcol }}</div>
                                <div class="col"><a href="{{ route('admin_talktag', $Talktagtype->id) }}">追加</a></div>
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
