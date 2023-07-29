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
        <p class="uk-text-large">WB研修所スカウトコース参加申込書</p>
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
                    @if (isset($entryInfo->entry_info->sc_number))
                        スカウトコース: {{ $entryInfo->entry_info->sc_number }}<br>
                    @elseif(isset($entryInfo->entry_info->sc_number_done))
                        スカウトコース: {{ $entryInfo->entry_info->sc_number_done }}(修了済み)<br>
                    @endif
                    課程別研修: {{ $entryInfo->entry_info->division_number }}
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
                    【治療中の病気】{{ $entryInfo->entry_info->health_illness }}<br>
                    【健康上の不安】{{ $entryInfo->entry_info->health_memo }}
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
