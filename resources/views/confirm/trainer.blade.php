@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>WB研修所申込 トレーナー認定</h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        <p class="uk-text">{{ $userinfo->user->name }}さんの提出課題について、トレーナー認定を依頼します。<br>
        ページ下部に提出課題と認定ボタンがありますので、認定手続きをお願い致します。</p>
        <h3>参加者情報</h3>
        <table class="uk-table uk-table-divider">
            <tr>
                <th>写真</th>
                <td>
                    @if ($userinfo->user->face_picture)
                        <img src="{{ url('/storage/picture/') }}/{{ $userinfo->user->face_picture }}" width="150px">
                    @else
                        写真なし
                    @endif
                </td>
            </tr>
            <tr>
                <th>氏名</th>
                <td>{{ $userinfo->user->name }}({{ $userinfo->furigana }})</td>
            </tr>
            <tr>
                <th>所属</th>
                <td>{{ $userinfo->district }}地区 {{ $userinfo->dan }}</td>
            </tr>
            <tr>
                <th>役務</th>
                <td>{{ $userinfo->troop }} {{ $userinfo->troop_role }}</td>
            </tr>
            <tr>
                <th>参加コース</th>
                <td>
                    @if ($userinfo->sc_number == 'done')
                        <span class="uk-text-warning">スカウトコース {{ $userinfo->sc_number_done }} (修了済み)</span><br>
                    @else
                        スカウトコース {{ $userinfo->sc_number }}期<br>
                    @endif
                    課程別研修 {{ $userinfo->division_number }}回
                </td>
            </tr>
        </table>
        <h3>認定ステータス</h3>
        <table class="uk-table uk-table-divider">
            <tr>
                <th></th>
                <th>ステータス</th>
                <th>認定日</th>
                <th>トレーナー名</th>
                <th>課題</th>
            </tr>
            <tr>
                <th>スカウトコース</th>
                @if (isset($userinfo->trainer_sc_checked_at))
                    <td><span class="uk-text-success">認定済み</span></td>
                @else
                    <td><a href="#modal-confirm-assignment-sc" uk-toggle class="uk-button uk-button-primary">認定する</a></td>
                @endif
                @if (isset($userinfo->trainer_sc_checked_at))
                    <td>{{ $userinfo->trainer_sc_checked_at->format('Y-m-d') }}</td>
                @else
                    <td>---</td>
                @endif
                @if (isset($userinfo->trainer_sc_name))
                    <td>{{ $userinfo->trainer_sc_name }}</td>
                @else
                    <td>---</td>
                @endif
                <td>
                    @if (File::exists(storage_path('app/public/assignment/sc/') . $userinfo->uuid . '.pdf'))
                        <a href="{{ url("/storage/assignment/sc/$userinfo->uuid" . '.pdf') }}" target="_blank"><span
                                uk-icon="file-pdf"></span>スカウトコース課題を確認</a>
                    @else
                        <span class="uk-text-danger">未提出</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>課程別</th>
                @if (isset($userinfo->trainer_division_checked_at))
                    <td><span class="uk-text-success">認定済み</span></td>
                @else
                    <td><a href="#modal-confirm-assignment-division" uk-toggle class="uk-button uk-button-primary">認定する</a>
                    </td>
                @endif
                @if (isset($userinfo->trainer_division_checked_at))
                    <td>{{ $userinfo->trainer_division_checked_at->format('Y-m-d') }}</td>
                @else
                    <td>---</td>
                @endif
                @if (isset($userinfo->trainer_division_name))
                    <td>{{ $userinfo->trainer_division_name }}</td>
                @else
                    <td>---</td>
                @endif
                <td>
                    @if (File::exists(storage_path('app/public/assignment/division/') . $userinfo->uuid . '.pdf'))
                        <a href="{{ url("/storage/assignment/division/$userinfo->uuid" . '.pdf') }}" target="_blank"><span
                                uk-icon="file-pdf"></span>課程別研修課題を確認</a>
                    @else
                        <span class="uk-text-danger">未提出</span>
                    @endif
                </td>
            </tr>
        </table>

        <div id="modal-confirm-assignment-sc" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <div class="uk-card uk-card-default uk-card-body uk-width-1-1@m">
                    <h3 class="uk-card-title">スカウトコース課題</h3>
                    <p class="uk-text">スカウトコースの課題について認定サインをします。お名前と認定日を入力してください。</p>
                    <form method="POST" action="{{ route('trainer_confirm_post') }}">
                        @csrf
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-text">トレーナー氏名</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" id="form-stacked-text" type="text" name="name_sc" required>
                            </div>
                        </div>

                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-text">認定日</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" id="form-stacked-text" type="date" name="confirm_date_sc"
                                    required>
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

        <div id="modal-confirm-assignment-division" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <div class="uk-card uk-card-default uk-card-body uk-width-1-1@m">
                    <h3 class="uk-card-title">課程別研修課題</h3>
                    <p class="uk-text">課程別研修の課題について認定サインをします。お名前と認定日を入力してください。</p>
                    <form method="POST" action="{{ route('trainer_confirm_post') }}">
                        @csrf
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-text">トレーナー氏名</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" id="form-stacked-text" type="text" name="name_division" required>
                            </div>
                        </div>

                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-text">認定日</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" id="form-stacked-text" type="date" name="confirm_date_division"
                                    required>
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
