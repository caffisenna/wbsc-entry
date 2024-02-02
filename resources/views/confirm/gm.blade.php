@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1>指導者研修申込 参加承認</h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        <p class="uk-text">{{ $userinfo->user->name }}さんについて、参加承認依頼をお送りします。<br>
            内容をご確認いただき、承認操作をしてください。</p>
        @if (empty($userinfo->gm_name))
            <a href="#modal-confirm-gm" uk-toggle class="uk-button uk-button-primary">承認する</a>
        @else
            <p class="uk-text uk-text-primary">承認済み</p> {{ $userinfo->gm_checked_at->format('Y-m-d') }}
            {{ $userinfo->gm_name }}
        @endif
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
                    @if ($userinfo->danken == 'true')
                        団委員研修所
                    @else
                        @if ($userinfo->sc_number == 'done')
                            <span class="uk-text-warning">スカウトコース {{ $userinfo->sc_number_done }} (修了済み)</span><br>
                        @else
                            スカウトコース {{ $userinfo->sc_number }}期<br>
                        @endif
                        @unless ($userinfo->division_number == 'etc')
                            課程別研修 {{ $userinfo->division_number }}回
                        @else
                            課程別研修 <span class="uk-text-warning">次回以降(開催予定以外)</span>
                        @endunless
                    @endif

                </td>
            </tr>
            <tr>
                <th>生年月日</th>
                <td>{{ $userinfo->birthday->format('Y年m月d日') }}
                    ({{ \Carbon\Carbon::parse($userinfo->birthday)->age }}才)</td>
            </tr>
            <tr>
                <th>登録番号</th>
                <td>{{ $userinfo->bs_id }}</td>
            </tr>

            <tr>
                <th>ケータイ</th>
                <td>{{ $userinfo->cell_phone }}</td>
            </tr>

            <tr>
                <th>住所</th>
                <td>{{ $userinfo->zip }}<br>{{ $userinfo->address }}</td>
            </tr>

            <tr>
                <th>緊急連絡先</th>
                <td>【氏名:】 {{ $userinfo->emer_name }}({{ $userinfo->emer_relation }})<br>
                    【連絡先】 {{ $userinfo->emer_phone }}
                </td>
            </tr>

            @if (isset($userinfo->district_role))
                <tr>
                    <th>地区役務</th>
                    <td>{{ $userinfo->district_role }}</td>
                </tr>
            @endif

            @if (isset($userinfo->prefecture_role))
                <tr>
                    <th>県連役務</th>
                    <td>{{ $userinfo->prefecture_role }}</td>
                </tr>
            @endif

            <tr>
                <th>スカウトキャンプ研修会</th>
                <td>{{ $userinfo->scout_camp }}</td>
            </tr>

            <tr>
                <th>ボーイスカウト講習会</th>
                <td>{{ $userinfo->bs_basic_course }}</td>
            </tr>

            @for ($i = 1; $i <= 3; $i++)
                @if (isset($userinfo->{"wb_basic{$i}_category"}))
                    <tr>
                        <th>その他の研修所履歴({{ $i }})</th>
                        <td>
                            {{ $userinfo->{"wb_basic{$i}_category"} }}課程 {{ $userinfo->{"wb_basic{$i}_number"} }}
                            @if (mb_strpos($userinfo->{"wb_basic{$i}_number"}, '期') == false)
                                期
                            @endif
                            ({{ $userinfo->{"wb_basic{$i}_date"} }}修了)
                        </td>
                    </tr>
                @endif
            @endfor


            @for ($i = 1; $i <= 3; $i++)
                @if (isset($userinfo->{"wb_adv{$i}_category"}))
                    <tr>
                        <th>その他の実修所履歴({{ $i }})</th>
                        <td>{{ $userinfo->{"wb_adv{$i}_category"} }}課程 {{ $userinfo->{"wb_adv{$i}_number"} }}
                            @if (mb_strpos($userinfo->{"wb_adv{$i}_number"}, '期') == false)
                                期
                            @endif
                            ({{ $userinfo->{"wb_adv{$i}_date"} }}修了)
                        </td>
                    </tr>
                @endif
            @endfor

            <tr>
                <th>奉仕歴</th>
                <td>
                    @for ($i = 1; $i <= 5; $i++)
                        @if (isset($userinfo->{'service_hist' . $i . '_role'}))
                            役務:{{ $userinfo->{'service_hist' . $i . '_role'} }}
                            期間:{{ $userinfo->{'service_hist' . $i . '_term'} }}<br>
                        @endif
                    @endfor
                </td>
            </tr>

            <tr>
                <th>現在治療中の病気</th>
                <td>{{ $userinfo->health_illness }}</td>
            </tr>

            <tr>
                <th>健康上で不安なことなど</th>
                <td>{{ $userinfo->health_memo }}</td>
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
                <td>
                    @if (File::exists(storage_path('app/public/assignment/sc/') . $userinfo->uuid . '.pdf'))
                        <a href="{{ url("/storage/assignment/sc/$userinfo->uuid" . '.pdf') }}" target="_blank"><span
                                uk-icon="file-pdf"></span>
                            @if ($userinfo->danken == 'true')
                                団委員研修所課題を確認
                            @else
                                スカウトコース課題を確認
                            @endif
                        </a>
                    @else
                        <span class="uk-text-danger">未提出</span>
                    @endif
                </td>
            </tr>
            @unless ($userinfo->danken == 'true')
                <tr>
                    <th>課程別</th>
                    <td>
                        @if (File::exists(storage_path('app/public/assignment/division/') . $userinfo->uuid . '.pdf'))
                            <a href="{{ url("/storage/assignment/division/$userinfo->uuid" . '.pdf') }}" target="_blank"><span
                                    uk-icon="file-pdf"></span>課程別研修課題を確認</a>
                        @else
                            <span class="uk-text-danger">未提出</span>
                        @endif
                    </td>
                </tr>
            @endunless
        </table>

        <div id="modal-confirm-gm" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <div class="uk-card uk-card-default uk-card-body uk-width-1-1@m">
                    <h3 class="uk-card-title">団委員長の承認</h3>
                    <p class="uk-text">指導者訓練への参加承認をします。お名前と認定日を入力してください。</p>
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
                        <h3><span uk-icon="icon: mail"></span>控えのメールを受け取る</h3>
                        <span class="uk-text-small">参加者に通知されるメールを控えとして受信を希望する方は、以下のフォームにメールアドレスを入力してください。(団承認、参加確定の際にメールをお送りします。)</span>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-text">メールアドレス</label>
                            <div class="uk-form-controls">
                                <input class="uk-input" id="form-stacked-text" type="email" name="gm_email">
                            </div>
                        </div>

                        <input type="hidden" name="uuid" value="{{ $userinfo->uuid }}">
                        <input type="submit" value="承認する" class="uk-button uk-button-primary uk-width-1-1@m">
                        <button class="uk-button uk-button-default uk-modal-close uk-width-1-1@m"
                            type="button">キャンセル</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
