<div class="table-responsive">
    <table class="uk-table uk-table-divider uk-table-hover uk-table-striped">
        <tr>
            <th>スカウトコースの期数</td>
            <td>
                @if ($entryInfo->sc_number && !$entryInfo->sc_number_done == 'done')
                    スカウトコース{{ $entryInfo->sc_number }}期
                @elseif($entryInfo->sc_number_done)
                    スカウトコース{{ $entryInfo->sc_number_done }} (修了済み)
                @endif
            </td>
        </tr>
        <tr>
            <th>課程別研修の回数</th>
            <td>
                @unless ($entryInfo->division_number == 'etc')
                    {{ $entryInfo->division_number }}
                @else
                    それ以外
                @endunless
            </td>
        </tr>
        <tr>
            <th>お名前</th>
            <td>{{ Auth::user()->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ Auth::user()->email }}</td>
        </tr>
        <tr>
            <th>ふりがな</th>
            <td>{{ $entryInfo->furigana }}</td>
        </tr>
        <tr>
            <th>性別</th>
            <td>{{ $entryInfo->gender }}</td>
        </tr>
        <tr>
            <th>生年月日</th>
            <td>{{ $entryInfo->birthday->format('Y年m月d日') }}
                ({{ \Carbon\Carbon::parse($entryInfo->birthday)->age }}才)</td>
        </tr>
        <tr>
            <th>登録番号</th>
            <td>{{ $entryInfo->bs_id }}</td>
        </tr>
        <tr>
            <th>所属</th>
            <td>{{ $entryInfo->prefecture }}連盟 {{ $entryInfo->district }}地区 {{ $entryInfo->dan }}</td>
        </tr>

        <tr>
            <th>所属隊・役務</th>
            <td>{{ $entryInfo->troop }} {{ $entryInfo->troop_role }}</td>
        </tr>

        <tr>
            <th>ケータイ</th>
            <td>{{ $entryInfo->cell_phone }}</td>
        </tr>

        <tr>
            <th>住所</th>
            <td>{{ $entryInfo->zip }}<br>{{ $entryInfo->address }}</td>
        </tr>

        <tr>
            <th>緊急連絡先</th>
            <td>【氏名:】 {{ $entryInfo->emer_name }}({{ $entryInfo->emer_relation }})<br>
                【連絡先】 {{ $entryInfo->emer_phone }}
            </td>
        </tr>

        @if (isset($entryInfo->district_role))
            <tr>
                <th>地区役務</th>
                <td>{{ $entryInfo->district_role }}</td>
            </tr>
        @endif

        @if (isset($entryInfo->prefecture_role))
            <tr>
                <th>県連役務</th>
                <td>{{ $entryInfo->prefecture_role }}</td>
            </tr>
        @endif

        <tr>
            <th>スカウトキャンプ研修会</th>
            <td>{{ $entryInfo->scout_camp }}</td>
        </tr>

        <tr>
            <th>ボーイスカウト講習会</th>
            <td>{{ $entryInfo->bs_basic_course }}</td>
        </tr>

        @if (isset($entryInfo->wb_basic1_category))
            <tr>
                <th>その他の研修所履歴(1)</th>
                <td>
                    {{ $entryInfo->wb_basic1_category }}課程 {{ $entryInfo->wb_basic1_number }}期
                    ({{ $entryInfo->wb_basic1_date }}修了)
                </td>
            </tr>
        @endif

        @if (isset($entryInfo->wb_basic2_category))
            <tr>
                <th>その他の研修所履歴(2)</th>
                <td>{{ $entryInfo->wb_basic2_category }}課程 {{ $entryInfo->wb_basic2_number }}期
                    ({{ $entryInfo->wb_basic2_date }}修了)</td>
            </tr>
        @endif

        @if (isset($entryInfo->wb_basic3_category))
            <tr>
                <th>その他の研修所履歴(3)</th>
                <td>{{ $entryInfo->wb_basic3_category }}課程 {{ $entryInfo->wb_basic3_number }}期
                    ({{ $entryInfo->wb_basic3_date }}修了)</td>
            </tr>
        @endif

        @if (isset($entryInfo->wb_basic4_category))
            <tr>
                <th>その他の研修所履歴(4)</th>
                <td>{{ $entryInfo->wb_basic4_category }}課程 {{ $entryInfo->wb_basic4_number }}期
                    ({{ $entryInfo->wb_basic4_date }}修了)</td>
            </tr>
        @endif

        @if (isset($entryInfo->wb_basic5_category))
            <tr>
                <th>その他の研修所履歴(5)</th>
                <td>{{ $entryInfo->wb_basic5_category }}課程 {{ $entryInfo->wb_basic5_number }}期
                    ({{ $entryInfo->wb_basic5_date }}修了)</td>
            </tr>
        @endif


        @if (isset($entryInfo->wb_adv1_category))
            <tr>
                <th>その他の実修所履歴(1)</th>
                <td>{{ $entryInfo->wb_adv1_category }}課程 {{ $entryInfo->wb_adv1_number }}期
                    ({{ $entryInfo->wb_adv1_date }}修了)</td>
            </tr>
        @endif

        @if (isset($entryInfo->wb_adv2_category))
            <tr>
                <th>その他の実修所履歴(2)</th>
                <td>{{ $entryInfo->wb_adv2_category }}課程 {{ $entryInfo->wb_adv2_number }}期
                    ({{ $entryInfo->wb_adv2_date }}修了)</td>
            </tr>
        @endif

        @if (isset($entryInfo->wb_adv3_category))
            <tr>
                <th>その他の実修所履歴(3)</th>
                <td>{{ $entryInfo->wb_adv3_category }}課程 {{ $entryInfo->wb_adv3_number }}期
                    ({{ $entryInfo->wb_adv3_date }}修了)</td>
            </tr>
        @endif

        @if (isset($entryInfo->wb_adv4_category))
            <tr>
                <th>その他の実修所履歴(4)</th>
                <td>{{ $entryInfo->wb_adv4_category }}課程 {{ $entryInfo->wb_adv4_number }}期
                    ({{ $entryInfo->wb_adv4_date }}修了)</td>
            </tr>
        @endif

        @if (isset($entryInfo->wb_adv5_category))
            <tr>
                <th>その他の実修所履歴(5)</th>
                <td>{{ $entryInfo->wb_adv5_category }}課程 {{ $entryInfo->wb_adv5_number }}期
                    ({{ $entryInfo->wb_adv5_date }}修了)</td>
            </tr>
        @endif

        <tr>
            <th>奉仕歴</th>
            <td>
                役務:{{ $entryInfo->service_hist1_role }} 期間:{{ $entryInfo->service_hist1_term }}<br>
                @if (isset($entryInfo->service_hist2_role))
                    役務:{{ $entryInfo->service_hist2_role }} 期間:{{ $entryInfo->service_hist2_term }}<br>
                @endif
                @if (isset($entryInfo->service_hist3_role))
                    役務:{{ $entryInfo->service_hist3_role }} 期間:{{ $entryInfo->service_hist3_term }}<br>
                @endif
                @if (isset($entryInfo->service_hist4_role))
                    役務:{{ $entryInfo->service_hist4_role }} 期間:{{ $entryInfo->service_hist4_term }}<br>
                @endif
                @if (isset($entryInfo->service_hist5_role))
                    役務:{{ $entryInfo->service_hist5_role }} 期間:{{ $entryInfo->service_hist5_term }}
                @endif
            </td>
        </tr>

        <tr>
            <th>現在治療中の病気</th>
            <td>{{ $entryInfo->health_illness }}</td>
        </tr>

        <tr>
            <th>健康上で不安なことなど</th>
            <td>{{ $entryInfo->health_memo }}</td>
        </tr>

    </table>
</div>
