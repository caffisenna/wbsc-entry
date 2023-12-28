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
            <div class="uk-card">
                <div class="uk-card-header">
                    <h3 class="uk-card-title">参加者名簿の作成</h3>
                </div>
                <div class="uk-card-body">
                    {!! Form::checkbox('meibo', 'meibo', false, ['class' => 'uk-checkbox', 'required']) !!}参加コースで名簿を作成し、参加者及びスタッフに配布することに同意します。(掲載項目は氏名、所属、役務等)
                </div>
            </div>
            <div class="card-footer">
                <p class="uk-text-danger">私、{{ Auth::user()->name }}は参加者説明会が開催される場合は参加義務があることを承知の上で研修に申し込みます。</p>
                {!! Form::submit('登録する', ['class' => 'btn btn-primary', 'onclick' => 'window.onbeforeunload=null']) !!}
                <a href="{{ route('entryInfos.index') }}" class="btn btn-default">キャンセル</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
