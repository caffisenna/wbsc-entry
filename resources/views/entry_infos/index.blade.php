@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>指導者研修申込 {{ Auth::user()->name }}さん</h1>
                </div>
                <div class="col-sm-6">
                    @if (empty($entryInfo))
                        {{-- <a class="btn btn-primary float-right" href="{{ route('entryInfos.create') }}">
                            申込書作成
                        </a> --}}
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
                <p class="uk-text-default">参加を取りやめる場合は地区コミッショナー、または各地区AIS委員長にお伝え下さい。<br>
                    東京連盟の定めるキャンセルポリシーに準拠した対応を致します。<br>
                    他県連に所属の方は<a href="mailto:ais@scout.tokyo">東京連盟事務局</a>までお問い合わせください。 </p>
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
@else
    <h3>申込パターンを選択してください</h3>
    <ul class="uk-list">
        <li><a class="uk-button uk-button-large uk-button-primary uk-width-1-2"
                href="{{ route('entryInfos.create') }}">スカウトコース / 課程別研修に申込</a></li>
        @if ($danken->number)
            <li><a class="uk-button uk-button-large uk-button-primary uk-width-1-2"
                    href="{{ route('entryInfos.create') }}?cat=danken">団委員研修所(東京第{{ $danken->number }}期)に申込</a></li>
        @endif
    </ul>
    @endif
@endsection
