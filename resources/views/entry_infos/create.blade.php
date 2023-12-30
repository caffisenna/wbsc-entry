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
                <p class=""><a href="#modal-personal_info" uk-toggle><span uk-icon="icon: info"></span>個人情報の取り扱いについて</a>
                </p>

                <div class="row">
                    @include('entry_infos.fields')
                </div>

            </div>
            <div class="uk-card">
                <div class="uk-card-header">
                    <h3 class="uk-card-title">履修者名簿の作成</h3>
                </div>
                <div class="uk-card-body">
                    {!! Form::checkbox('meibo', 'meibo', false, ['class' => 'uk-checkbox', 'required']) !!}参加コースで履修者名簿を作成し、参加者及びスタッフに配布することに同意します。(掲載項目は氏名、所属、役務等)
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
    <div id="modal-personal_info" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <h3 class="uk-modal-title">個人情報の取り扱いについて</h3>
            当システムで収集した情報はAIS委員会、当該訓練、東京連盟事務局において指導者訓練に関する範囲で使用します。
            <ul>
                <li>東京連盟事務局より日本連盟に履修者名簿を提出します</li>
                <li>東京連盟事務局で履修者名簿を保管します</li>
                <li>東京連盟年次総会に履修者名を掲載します</li>
                <li>コース修了後一定期間の後、入力データ及びアップロードされたファイルを事前の告知なく削除します</li>
            </ul>
            <p class="uk-text-right">
                <button class="uk-button uk-button-primary uk-modal-close" type="button">閉じる</button>
            </p>
        </div>
    </div>
@endsection
