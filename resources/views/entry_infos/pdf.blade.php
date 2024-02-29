<html lang="ja">

<head>
    <title>pdf output</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="{{ url('/uikit/uikit.min.css') }}" media="all">
    <style>
        @font-face {
            font-family: migmix;
            font-style: normal;
            font-weight: normal;
        }

        body {
            font-family: migmix;
            line-height: 30%;
        }
    </style>
</head>

<body>

    <div><img src="{{ url('/images/woggle.png') }}" class="uk-align-left" style="height:80px;"></div>
    <div class="uk-text-center">
        <p class="uk-text-large">指導者研修参加申込書</p>
    </div>


    <p class="uk-text-right uk-text-small">
        東京連盟書式<br>
        データ入力日時:{{ $entryInfo->entry_info->updated_at }}<br>
        申込番号:{{ $entryInfo->entry_info->id }}
    </p>

    <table class="uk-table uk-table-striped uk-table-small uk-text-small uk-table-justify">
        <tbody class="uk-text-small">
            <tr>
                <td>申込コース</td>
                <td>
                    @if ($entryInfo->entry_info->danken)
                        団委員研修所 東京第 {{ $entryInfo->entry_info->danken }} 期
                    @else
                        @if (isset($entryInfo->entry_info->sc_number))
                            スカウトコース: {{ $entryInfo->entry_info->sc_number }}<br>
                        @elseif(isset($entryInfo->entry_info->sc_number_done))
                            スカウトコース: {{ $entryInfo->entry_info->sc_number_done }}(修了済み)<br>
                        @endif

                        @unless ($entryInfo->entry_info->division_number == 'etc')
                            課程別研修: {{ $entryInfo->entry_info->division_number }}
                            {{ $entryInfo->entry_info->bvs_exception ? '(ビーバー課程特例)' : '' }}
                        @else
                            課程別研修: それ以外
                        @endunless
                    @endif
                </td>
            </tr>
            <tr>
                <td>基本情報</td>
                <td>
                    @if ($entryInfo->face_picture)
                        <img src="{{ url('/storage/picture/') }}{{ '/' . $entryInfo->face_picture }}" width="100px">
                    @endif
                    {{ $entryInfo->name }}({{ $entryInfo->entry_info->furigana }})
                    {{ $entryInfo->entry_info->gender }} 【登録番号:】 {{ $entryInfo->entry_info->bs_id }}
                </td>
            </tr>
            <tr>
                <td>所属・役務</td>
                <td>{{ $entryInfo->entry_info->prefecture }}連盟 {{ $entryInfo->entry_info->district }}地区
                    {{ $entryInfo->entry_info->dan }} {{ $entryInfo->entry_info->troop }}
                    {{ $entryInfo->entry_info->troop_role }}
                </td>
            </tr>
            <tr>
                <td>生年月日</td>
                <td>
                    {{ $entryInfo->entry_info->birthday->format('Y年m月d日') }}
                    ({{ \Carbon\Carbon::parse($entryInfo->entry_info->birthday)->age }}才)
                </td>
            </tr>
            <tr>
                <td>住所</td>
                <td>〒{{ $entryInfo->entry_info->zip }} {{ $entryInfo->entry_info->address }}</td>
            </tr>
            <tr>
                <td>本人連絡先</td>
                <td>【ケータイ:】 {{ $entryInfo->entry_info->cell_phone }} 【email:】 {{ $entryInfo->email }}
                </td>
            </tr>
            <tr>
                <td>緊急連絡先</td>
                <td>【氏名:】 {{ $entryInfo->entry_info->emer_name }}({{ $entryInfo->entry_info->emer_relation }})<br>
                    【連絡先】 {{ $entryInfo->entry_info->emer_phone }}
                </td>
            </tr>
            <tr>
                <td>地区・県連役務</td>
                <td>
                    【地区】 {{ $entryInfo->entry_info->district_role }} 【県連】
                    {{ $entryInfo->entry_info->prefecture_role }}
                </td>
            </tr>
            <tr>
                <td>承認と確認</td>
                <td>
                    @if (isset($entryInfo->entry_info->gm_checked_at))
                        【団:】 {{ $entryInfo->entry_info->gm_checked_at->format('Y年m月d日') }}
                    @endif
                    @if (isset($entryInfo->entry_info->commi_checked_at))
                        【地区コミ:】 {{ $entryInfo->entry_info->commi_checked_at->format('Y年m月d日') }}
                    @endif
                    @if (isset($entryInfo->entry_info->ais_checked_at))
                        【AIS:】 {{ $entryInfo->entry_info->ais_checked_at->format('Y年m月d日') }}
                    @endif
                </td>
            </tr>
            <tr>
                <td>研修歴</td>
                <td>
                    ボーイスカウト講習会:{{ $entryInfo->entry_info->bs_basic_course }}<br>
                    スカウトキャンプ研修会:{{ $entryInfo->entry_info->scout_camp }}<br>

                    {{-- 研修所 --}}
                    @for ($i = 1; $i <= 3; $i++)
                        @if (isset($entryInfo->entry_info->{"wb_basic{$i}_category"}))
                            WB研修所{{ $entryInfo->entry_info->{"wb_basic{$i}_category"} }}課程
                            {{ $entryInfo->entry_info->{"wb_basic{$i}_number"} }}
                            @if (mb_strpos($entryInfo->entry_info->{"wb_basic{$i}_number"}, '期') == false)
                                期
                            @endif
                            ({{ $entryInfo->entry_info->{"wb_basic{$i}_date"} }}修了)<br>
                        @endif
                    @endfor

                    {{-- 実修所 --}}
                    @for ($i = 1; $i <= 3; $i++)
                        @if (isset($entryInfo->entry_info->{"wb_adv{$i}_category"}))
                            WB実修所{{ $entryInfo->entry_info->{"wb_adv{$i}_category"} }}課程
                            {{ $entryInfo->entry_info->{"wb_adv{$i}_number"} }}
                            @if (mb_strpos($entryInfo->entry_info->{"wb_adv{$i}_number"}, '期') == false)
                                期
                            @endif
                            ({{ $entryInfo->entry_info->{"wb_adv{$i}_date"} }}修了)<br>
                        @endif
                    @endfor

                </td>
            </tr>
            <tr>
                <td>奉仕歴</td>
                <td>
                    @for ($i = 1; $i <= 5; $i++)
                        @if (isset($entryInfo->entry_info->{'service_hist' . $i . '_role'}))
                            役務:{{ $entryInfo->entry_info->{'service_hist' . $i . '_role'} }}
                            期間:{{ $entryInfo->entry_info->{'service_hist' . $i . '_term'} }}<br>
                        @endif
                    @endfor
                </td>
            </tr>
            <tr>
                <td>健康</td>
                <td>
                    【食物アレルギー】{{ $entryInfo->health_info->treating_disease }}<br>
                    【直近3ヶ月の健康状態】{{ $entryInfo->health_info->health_status_last_3_months }}<br>
                    【最近の体調】{{ $entryInfo->health_info->recent_health_status == 1 ? '特に異常なし' : $entryInfo->health_info->recent_health_status }}<br>
                    【医師からの注意】{{ $entryInfo->health_info->doctor_advice == 1 ? '特になし' : $entryInfo->health_info->doctor_advice }}<br>
                    【特記事項】{{ $entryInfo->health_info->medical_history == 1 ? '特になし' : $entryInfo->health_info->medical_history }}<br>
                </td>
            </tr>
            <tr>
                <td>アレルギー</td>
                <td>
                    【食物アレルギー】{{ $entryInfo->health_info->food_allergies }}<br>
                    【アレルゲン】{{ $entryInfo->health_info->allergen }}<br>
                    【摂取するとどうなるか】{{ $entryInfo->health_info->reaction_to_allergen }}<br>
                    【家庭での対応】{{ $entryInfo->health_info->usual_response_to_reaction }}<br>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
