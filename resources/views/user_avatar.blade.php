@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if ($UserAvatar)
                            <div class="row border-bottom border-top">
                                <div class="col">表情</div>
                                <div class="col"></div>
                            </div>
                            <div class="row border-bottom">
                                <div class="col"> <img src="{{ route('root') }}/storage/user/{{ $UserAvatar->filename }}"></div>
                                <div class="col"><a href="{{ route('user_avatar_delete', $UserAvatar->id) }}">削除</a></div>
                            </div>
                    @else
                    <p>
                        <a href="{{ route('user_avatar_regist') }}" class="btn btn-primary">アバター追加</a>
                    </p>
                    @endif
                    <p>
                        <a href="{{ route('home') }}">戻る</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
