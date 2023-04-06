@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>WB研修所申込 トレーナー認定依頼</h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        <p class="uk-text">{{ $userinfo->user->name }}さんの提出課題について、担当トレーナーに認定依頼のメールを送付します。<br>
            下記フォームに担当トレーナーの氏名、メールアドレスを入力してください。</p>

        <div class="uk-card uk-card-default uk-card-body uk-width-1-2@m">

            <form method="POST" action="{{ route('trainer_request_send') }}">
                @csrf
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">氏名</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="form-stacked-text" type="text" name="name" required>
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">email</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="form-stacked-text" type="text" name="email" required>
                    </div>
                </div>

                <input type="hidden" name="uuid" value="{{ $userinfo->uuid }}">
                <input type="submit" value="依頼する" class="uk-button uk-button-primary uk-width-1-1@m">
                <button class="uk-button uk-button-default uk-modal-close uk-width-1-1@m" type="button"
                    onclick="history.back()">キャンセル</button>

            </form>
        </div>

    </div>
@endsection
