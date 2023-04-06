@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>WB研修所申込 参加承認</h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        <p class="uk-text">{{ $userinfo->user->name }}さんについて、参加承認を依頼します。</p>
        @if (empty($userinfo->gm_name))
            <a href="#modal-confirm-gm" uk-toggle class="uk-button uk-button-primary">承認する</a>
        @else
            <p class="uk-text uk-text-primary">承認済み</p> {{ $userinfo->gm_checked_at->format('Y-m-d') }} {{ $userinfo->gm_name }}
        @endif
        <h3>参加者情報</h3>
        <table class="uk-table uk-table-divider">
            <tr>
                <th>写真</th>
                <td><img src="{{ url('/storage/picture/') }}/{{ $userinfo->user->face_picture }}" width="150px"></td>
            </tr>
            <tr>
                <th>氏名</th>
                <td>{{ $userinfo->user->name }}({{ $userinfo->furigana }})</td>
            </tr>
            <tr>
                <th>所属</th>
                <td>{{ $userinfo->district }}地区 {{ $userinfo->dan }}団</td>
            </tr>
            <tr>
                <th>役務</th>
                <td>{{ $userinfo->troop }} {{ $userinfo->troop_role }}</td>
            </tr>
            <tr>
                <th>参加コース</th>
                <td>
                    スカウトコース {{ $userinfo->sc_number }}期<br>
                    課程別研修 {{ $userinfo->division_number }}回
                </td>
            </tr>
        </table>
        <h3>課題研修</h3>
        <table class="uk-table uk-table-divider">
            <tr>
                <th></th>
                <th>課題</th>
            </tr>
            <tr>
                <th>スカウトコース</th>
                <td><a href="{{ url("/storage/assignment/sc/$userinfo->uuid" . '.pdf') }}" target="_blank"><span
                            uk-icon="file-pdf"></span>スカウトコース課題を確認</a></td>
            </tr>
            <tr>
                <th>課程別</th>
                <td><a href="{{ url("/storage/assignment/division/$userinfo->uuid" . '.pdf') }}" target="_blank"><span
                            uk-icon="file-pdf"></span>課程別研修課題を確認</a></td>
            </tr>
        </table>

        <div id="modal-confirm-gm" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <div class="uk-card uk-card-default uk-card-body uk-width-1-1@m">
                    <h3 class="uk-card-title">団委員長の承認</h3>
                    <p class="uk-text">スカウトコース/課程別研修への参加承認をします。お名前と認定日を入力してください。</p>
                    <form method="POST" action="{{ route('gm_confirm_post') }}">
                        @csrf
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-text">団委員長氏名</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" id="form-stacked-text" type="text" name="gm_name" required>
                            </div>
                        </div>

                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-text">承認日</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" id="form-stacked-text" type="date" name="gm_checked_at" required>
                                <p class="uk-text-small">認定日はカレンダーから選択するかYYYY-mm-ddの形式で入力してください</p>
                            </div>
                        </div>

                        <input type="hidden" name="uuid" value="{{ $userinfo->uuid }}">
                        <input type="submit" value="認定する" class="uk-button uk-button-primary uk-width-1-1@m">
                        <button class="uk-button uk-button-default uk-modal-close uk-width-1-1@m"
                            type="button">キャンセル</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
