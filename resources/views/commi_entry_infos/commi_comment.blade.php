@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>副申請書の作成</h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        <p class="uk-text">{{ $userinfo->user->name }}さんについて、副申請書を作成します。</p>

        <div class="uk-card uk-card-default uk-card-body uk-width-1-2@m">

            <form method="POST" action="{{ route('commi_comment_post') }}">
                @csrf
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">副申請書の内容(上限800文字程度)</label>
                    <div class="uk-form-controls">
                        <textarea name="comment" cols="30" rows="10" class="uk-textarea">@if ($userinfo->additional_comment){{ $userinfo->additional_comment }}@endif</textarea>
                        {{-- <input class="uk-input" id="form-stacked-text" type="text" name="name" required> --}}
                    </div>
                </div>

                <input type="hidden" name="uuid" value="{{ $userinfo->uuid }}">
                <input type="submit" value="作成する" class="uk-button uk-button-primary uk-width-1-1@m">
                <button class="uk-button uk-button-default uk-modal-close uk-width-1-1@m" type="button"
                    onclick="history.back()">キャンセル</button>

            </form>
        </div>

    </div>
@endsection
