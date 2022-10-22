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
                <h3>アップロード管理</h3>
                <ul class="uk-list">
                    @if (isset($entryInfo->assignment_sc))
                        <li><a href="#modal-delete-assignment-sc" uk-toggle
                                class="uk-link uk-button uk-button-danger">スカウトコースの課題を削除</a></li>
                    @endif
                    @if (isset($entryInfo->assignment_division))
                        <li><a href="#modal-delete-assignment-division" uk-toggle
                                class="uk-link uk-button uk-button-danger">課程別研修の課題を削除</a></li>
                    @endif
                    @if (isset(Auth::user()->face_picture))
                        <li><a href="#modal-delete-face" uk-toggle class="uk-link uk-button uk-button-danger">顔写真を削除</a>
                        </li>
                    @endif
                </ul>

            </div>
        @endif
    </div>
    <div id="modal-delete-assignment-sc" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <h2 class="uk-modal-title uk-text-danger">課題の削除</h2>
            <p>アップロード済みのスカウトコースの課題を削除します。</p>
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
            <p>課程別研修の課題を削除します。</p>
            <p class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close uk-width-1-1@m" type="button">キャンセル</button>
                <a class="uk-button uk-button-danger uk-width-1-1@m"
                    href="{{ url('/') }}/user/delete_file/?id={{ $entryInfo->uuid }}&q=division">削除する</a>
            </p>
        </div>
    </div>

    <div id="modal-delete-face" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <h2 class="uk-modal-title uk-text-danger">顔写真の削除</h2>
            <p>顔写真を削除します。</p>
            <p class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close uk-width-1-1@m" type="button">キャンセル</button>
                <a class="uk-button uk-button-danger uk-width-1-1@m"
                    href="{{ url('/') }}/user/delete_file/?id={{ Auth::user()->face_picture }}&q=face">削除する</a>
            </p>
        </div>
    </div>
@endsection
