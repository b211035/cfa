@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <p>
                        <a href="{{ route('admin_class_regist', $School->id) }}" class="btn btn-primary">クラス追加</a>
                    </p>
                    @if ($School->Classes->isNotEmpty())
                            <div class="row border-bottom border-top">
                                <div class="col">ID</div>
                                <div class="col">{{ __('Classname') }}</div>
                                <div class="col"></div>
                            </div>
                        @foreach ($School->Classes as $Class)
                            <div class="row border-bottom">
                                <div class="col">{{ $Class->id }}</div>
                                <div class="col">{{ $Class->class_name }}</div>
                                <div class="col"><a href="{{ route('admin_class_delete', [$School->id, $Class->id]) }}">削除</a></div>
                            </div>
                        @endforeach
                    @endif

                    <p>
                        <a href="{{ route('admin_school') }}">戻る</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
