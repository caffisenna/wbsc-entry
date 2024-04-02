@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>参加キャンセル</h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </section>

    <div class="content">

        @include('flash::message')

        <div class="clearfix"></div>
        <p class="uk-text">{{ $entryInfo->user->name }}さんのキャンセル情報</p>

        <h3>注意</h3>
        <ul class="uk-list uk-list-bullet">
            <li><span class="uk-text-danger">履修認定などに反映されるため、確認作業を必ず行ってから登録してください</span></li>
            <li>コース直前や当日など、欠席連絡が直接あった場合のみ入力してください</li>
            <li>事務局に届いた欠席情報は事務局で入力をします</li>
            <li>当該コースのキャンセル情報のみを入力してください</li>
            <li>キャンセルを取り消す場合は入力されている文字を全て消去してから [登録する] をクリックしてください</li>
        </ul>

        <div class="uk-card uk-card-default uk-card-body uk-width-1-1@m">

            <form method="POST" action="{{ route('cancel') }}">
                @csrf
                <div class="uk-margin">

                    <div class="uk-form-controls">
                        <h3>スカウトコースまたは団研のキャンセル理由</h3>
                        <input type="text" name="cancel_sc" class="uk-input" placeholder="SCまたは団研のキャンセル理由"
                            value="@if ($entryInfo->cancel) {{ $entryInfo->cancel }} @endif">
                    </div>

                    <div class="uk-form-controls uk-margin-top">
                        <h3>課程別研修のキャンセル理由</h3>
                        <input type="text" name="cancel_div" class="uk-input" placeholder="課程別のキャンセル理由"
                            value="@if ($entryInfo->cancel_div) {{ $entryInfo->cancel_div }} @endif">
                    </div>
                </div>

                <input type="hidden" name="uuid" value="{{ $entryInfo->uuid }}">
                <input type="submit" value="登録する" class="uk-button uk-button-danger uk-width-1-1@m">
                <button class="uk-button uk-button-default uk-modal-close uk-width-1-1@m" type="button"
                    onclick="history.back()">キャンセル</button>

            </form>
        </div>

    </div>
@endsection
