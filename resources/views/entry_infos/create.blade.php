@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>申込書作成</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'entryInfos.store']) !!}

            <div class="card-body">
                <p class="uk-text-danger">私、{{ Auth::user()->name }}は参加者説明会が開催される場合は参加義務があることを承知の上で研修に申し込みます。</p>
                <div class="row">
                    @include('entry_infos.fields')
                </div>

            </div>

            <div class="card-footer">
                <p class="uk-text-danger">私、{{ Auth::user()->name }}は参加者説明会が開催される場合は参加義務があることを承知の上で研修に申し込みます。</p>
                {!! Form::submit('登録する', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('entryInfos.index') }}" class="btn btn-default">キャンセル</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
