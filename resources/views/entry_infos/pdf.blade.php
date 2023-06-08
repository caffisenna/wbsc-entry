{{-- {{ dd($entryInfo) }} --}}
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
            src: url('{{ storage_path('fonts/migmix-2p-regular.ttf') }}') format('truetype');
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


    <p class="uk-text-right uk-text-small">データ入力日時:{{ $entryInfo->entry_info->updated_at }}<br>
        申込番号:{{ $entryInfo->entry_info->id }}</p>

    <table class="uk-table uk-table-striped uk-table-small uk-text-small uk-table-justify">
        <tbody class="uk-text-small">
            <tr>
                <td>申込コース</td>
                <td>
                    スカウトコース: {{ $entryInfo->entry_info->sc_number }}<br>
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
                    {{ $entryInfo->entry_info->dan }}団 {{ $entryInfo->entry_info->troop }}
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
                        団: {{ $entryInfo->entry_info->gm_checked_at->format('Y年m月d日') }}<br>
                    @endif
                    @if (isset($entryInfo->entry_info->commi_checked_at))
                        地区コミ: {{ $entryInfo->entry_info->commi_checked_at->format('Y年m月d日') }}<br>
                    @endif
                    @if (isset($entryInfo->entry_info->ais_checked_at))
                        AIS: {{ $entryInfo->entry_info->ais_checked_at->format('Y年m月d日') }}
                    @endif
                </td>
            </tr>
            <tr>
                <td>研修歴</td>
                <td>
                    ボーイスカウト講習会:{{ $entryInfo->entry_info->bs_basic_course }}<br>
                    スカウトキャンプ研修会:{{ $entryInfo->entry_info->scout_camp }}<br>
                    @if (isset($entryInfo->entry_info->wb_basic1_category))
                        WB研修所{{ $entryInfo->entry_info->wb_basic1_category }}課程
                        {{ $entryInfo->entry_info->wb_basic1_number }}期
                        ({{ $entryInfo->entry_info->wb_basic1_date }}修了)<br>
                    @endif
                    @if (isset($entryInfo->entry_info->wb_basic2_category))
                        WB研修所{{ $entryInfo->entry_info->wb_basic2_category }}課程
                        {{ $entryInfo->entry_info->wb_basic2_number }}期
                        ({{ $entryInfo->entry_info->wb_basic2_date }}修了)<br>
                    @endif
                    @if (isset($entryInfo->entry_info->wb_basic3_category))
                        WB研修所{{ $entryInfo->entry_info->wb_basic3_category }}課程
                        {{ $entryInfo->entry_info->wb_basic3_number }}期
                        ({{ $entryInfo->entry_info->wb_basic3_date }}修了)<br>
                    @endif
                    @if (isset($entryInfo->entry_info->wb_basic4_category))
                        WB研修所{{ $entryInfo->entry_info->wb_basic4_category }}課程
                        {{ $entryInfo->entry_info->wb_basic4_number }}期
                        ({{ $entryInfo->entry_info->wb_basic4_date }}修了)<br>
                    @endif
                    @if (isset($entryInfo->entry_info->wb_basic5_category))
                        WB研修所{{ $entryInfo->entry_info->wb_basic5_category }}課程
                        {{ $entryInfo->entry_info->wb_basic5_number }}期
                        ({{ $entryInfo->entry_info->wb_basic5_date }}修了)<br>
                    @endif
                    @if (isset($entryInfo->entry_info->wb_adv1_category))
                        WB実修所{{ $entryInfo->entry_info->wb_adv1_category }}課程
                        {{ $entryInfo->entry_info->wb_adv1_number }}期
                        ({{ $entryInfo->entry_info->wb_adv1_date }}修了)<br>
                    @endif
                    @if (isset($entryInfo->entry_info->wb_adv2_category))
                        WB実修所{{ $entryInfo->entry_info->wb_adv2_category }}課程
                        {{ $entryInfo->entry_info->wb_adv2_number }}期
                        ({{ $entryInfo->entry_info->wb_adv2_date }}修了)<br>
                    @endif
                    @if (isset($entryInfo->entry_info->wb_adv3_category))
                        WB実修所{{ $entryInfo->entry_info->wb_adv3_category }}課程
                        {{ $entryInfo->entry_info->wb_adv3_number }}期
                        ({{ $entryInfo->entry_info->wb_adv3_date }}修了)<br>
                    @endif
                    @if (isset($entryInfo->entry_info->wb_adv4_category))
                        WB実修所{{ $entryInfo->entry_info->wb_adv4_category }}課程
                        {{ $entryInfo->entry_info->wb_adv4_number }}期
                        ({{ $entryInfo->entry_info->wb_adv4_date }}修了)<br>
                    @endif
                    @if (isset($entryInfo->entry_info->wb_adv5_category))
                        WB実修所{{ $entryInfo->entry_info->wb_adv5_category }}課程
                        {{ $entryInfo->entry_info->wb_adv5_number }}期
                        ({{ $entryInfo->entry_info->wb_adv5_date }}修了)<br>
                    @endif
                </td>
            </tr>
            <tr>
                <td>奉仕歴</td>
                <td>
                    役務:{{ $entryInfo->entry_info->service_hist1_role }}
                    期間:{{ $entryInfo->entry_info->service_hist1_term }}<br>
                    @if (isset($entryInfo->entry_info->service_hist2_role))
                        役務:{{ $entryInfo->entry_info->service_hist2_role }}
                        期間:{{ $entryInfo->entry_info->service_hist2_term }}<br>
                    @endif
                    @if (isset($entryInfo->entry_info->service_hist2_role))
                        役務:{{ $entryInfo->entry_info->service_hist3_role }}
                        期間:{{ $entryInfo->entry_info->service_hist3_term }}<br>
                    @endif
                    @if (isset($entryInfo->entry_info->service_hist2_role))
                        役務:{{ $entryInfo->entry_info->service_hist4_role }}
                        期間:{{ $entryInfo->entry_info->service_hist4_term }}<br>
                    @endif
                    @if (isset($entryInfo->entry_info->service_hist2_role))
                        役務:{{ $entryInfo->entry_info->service_hist5_role }}
                        期間:{{ $entryInfo->entry_info->service_hist5_term }}
                    @endif
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
