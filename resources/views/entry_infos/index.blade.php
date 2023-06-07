@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>WB研修所申込 {{ Auth::user()->name }}さん</h1>
                </div>
                <div class="col-sm-6">
                    @if (empty($entryInfo))
                        <a class="btn btn-primary float-right" href="{{ route('entryInfos.create') }}">
                            申込書作成
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        @if (isset($entryInfo))
            <div class="card">
                <div class="card-body p-0">
                    @include('entry_infos.table')
                </div>

                <h3>参加を辞退する</h3>
                <p class="uk-text-warning">参加を取りやめる場合は地区コミッショナー、または地区内のAIS委員にお伝え下さい。<br>
                    東京連盟の定めるキャンセルポリシーに準拠した対応をさせたいいだきます。</p>

            </div>

    </div>
    <div id="modal-delete-assignment-sc" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <h2 class="uk-modal-title uk-text-danger">課題の削除</h2>
            <p>アップロード済みのスカウトコースの課題を削除します。削除すると再アップロードが必要になりますので充分にご注意ください。</p>
            <p class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close uk-width-1-1@m" type="button">キャンセル</button>
                <a class="uk-button uk-button-danger uk-width-1-1@m"
                    href="{{ url('/') }}/user/delete_file/?id={{ $entryInfo->uuid }}&q=sc">削除する</a>
            </p>
        </div>
    </div>

    <div id="modal-delete-assignment-division" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <h2 class="uk-modal-title uk-text-danger">課題の削除</h2>
            <p>アップロード済みの課程別研修の課題を削除します。削除すると再アップロードが必要になりますので充分にご注意ください。</p>
            <p class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close uk-width-1-1@m" type="button">キャンセル</button>
                <a class="uk-button uk-button-danger uk-width-1-1@m"
                    href="{{ url('/') }}/user/delete_file/?id={{ $entryInfo->uuid }}&q=division">削除する</a>
            </p>
        </div>
    </div>
    @endif
@endsection
