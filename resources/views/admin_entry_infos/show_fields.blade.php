<div class="table-responsive">
    <table class="uk-table uk-table-divider uk-table-hover uk-table-striped">
        <tr>
            <th>スカウトコースの期数</td>
            <td>{{ $entryInfo->entry_info->sc_number }}</td>
        </tr>
        <tr>
            <th>課程別研修の回数</th>
            <td>{{ $entryInfo->entry_info->division_number }}</td>
        </tr>
        <tr>
            <th>お名前</th>
            <td>{{ $entryInfo->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $entryInfo->email }}</td>
        </tr>
        <tr>
            <th>ふりがな</th>
            <td>{{ $entryInfo->entry_info->furigana }}</td>
        </tr>
        <tr>
            <th>性別</th>
            <td>{{ $entryInfo->entry_info->gender }}</td>
        </tr>
        <tr>
            <th>生年月日</th>
            <td>
                {{ $entryInfo->entry_info->birthday->format('Y年m月d日') }}
                ({{ \Carbon\Carbon::parse($entryInfo->entry_info->birthday)->age }}才)
            </td>
        </tr>
        <tr>
            <th>登録番号</th>
            <td>{{ $entryInfo->entry_info->bs_id }}</td>
        </tr>
        <tr>
            <th>所属</th>
            <td>{{ $entryInfo->entry_info->prefecture }}連盟 {{ $entryInfo->entry_info->district }}地区
                {{ $entryInfo->entry_info->dan }}</td>
        </tr>

        <tr>
            <th>所属隊・役務</th>
            <td>{{ $entryInfo->entry_info->troop }} {{ $entryInfo->entry_info->troop_role }}</td>
        </tr>

        <tr>
            <th>ケータイ</th>
            <td>{{ $entryInfo->entry_info->cell_phone }}</td>
        </tr>

        <tr>
            <th>住所</th>
            <td>{{ $entryInfo->entry_info->zip }}<br>{{ $entryInfo->entry_info->address }}</td>
        </tr>

        @if (isset($entryInfo->entry_info->district_role))
            <tr>
                <th>地区役務</th>
                <td>{{ $entryInfo->entry_info->district_role }}</td>
            </tr>
        @endif

        @if (isset($entryInfo->entry_info->prefecture_role))
            <tr>
                <th>県連役務</th>
                <td>{{ $entryInfo->entry_info->prefecture_role }}</td>
            </tr>
        @endif

        <tr>
            <th>スカウトキャンプ研修会</th>
            <td>{{ $entryInfo->entry_info->scout_camp }}</td>
        </tr>

        <tr>
            <th>ボーイスカウト講習会</th>
            <td>{{ $entryInfo->entry_info->bs_basic_course }}</td>
        </tr>

        @if (isset($entryInfo->entry_info->wb_basic1_category))
            <tr>
                <th>その他の研修所履歴(1)</th>
                <td>
                    {{ $entryInfo->entry_info->wb_basic1_category }}課程 {{ $entryInfo->entry_info->wb_basic1_number }}期
                    ({{ $entryInfo->entry_info->wb_basic1_date }}修了)
                </td>
            </tr>
        @endif

        @if (isset($entryInfo->entry_info->wb_basic2_category))
            <tr>
                <th>その他の研修所履歴(2)</th>
                <td>{{ $entryInfo->entry_info->wb_basic2_category }}課程 {{ $entryInfo->entry_info->wb_basic2_number }}期
                    ({{ $entryInfo->entry_info->wb_basic2_date }}修了)</td>
            </tr>
        @endif

        @if (isset($entryInfo->entry_info->wb_basic3_category))
            <tr>
                <th>その他の研修所履歴(3)</th>
                <td>{{ $entryInfo->entry_info->wb_basic3_category }}課程 {{ $entryInfo->entry_info->wb_basic3_number }}期
                    ({{ $entryInfo->entry_info->wb_basic3_date }}修了)</td>
            </tr>
        @endif

        @if (isset($entryInfo->entry_info->wb_basic4_category))
            <tr>
                <th>その他の研修所履歴(4)</th>
                <td>{{ $entryInfo->entry_info->wb_basic4_category }}課程 {{ $entryInfo->entry_info->wb_basic4_number }}期
                    ({{ $entryInfo->entry_info->wb_basic4_date }}修了)</td>
            </tr>
        @endif

        @if (isset($entryInfo->entry_info->wb_basic5_category))
            <tr>
                <th>その他の研修所履歴(5)</th>
                <td>{{ $entryInfo->entry_info->wb_basic5_category }}課程 {{ $entryInfo->entry_info->wb_basic5_number }}期
                    ({{ $entryInfo->entry_info->wb_basic5_date }}修了)</td>
            </tr>
        @endif


        @if (isset($entryInfo->entry_info->wb_adv1_category))
            <tr>
                <th>その他の実修所履歴(1)</th>
                <td>{{ $entryInfo->entry_info->wb_adv1_category }}課程 {{ $entryInfo->entry_info->wb_adv1_number }}期
                    ({{ $entryInfo->entry_info->wb_adv1_date }}修了)</td>
            </tr>
        @endif

        @if (isset($entryInfo->entry_info->wb_adv2_category))
            <tr>
                <th>その他の実修所履歴(2)</th>
                <td>{{ $entryInfo->entry_info->wb_adv2_category }}課程 {{ $entryInfo->entry_info->wb_adv2_number }}期
                    ({{ $entryInfo->entry_info->wb_adv2_date }}修了)</td>
            </tr>
        @endif

        @if (isset($entryInfo->entry_info->wb_adv3_category))
            <tr>
                <th>その他の実修所履歴(3)</th>
                <td>{{ $entryInfo->entry_info->wb_adv3_category }}課程 {{ $entryInfo->entry_info->wb_adv3_number }}期
                    ({{ $entryInfo->entry_info->wb_adv3_date }}修了)</td>
            </tr>
        @endif

        @if (isset($entryInfo->entry_info->wb_adv4_category))
            <tr>
                <th>その他の実修所履歴(4)</th>
                <td>{{ $entryInfo->entry_info->wb_adv4_category }}課程 {{ $entryInfo->entry_info->wb_adv4_number }}期
                    ({{ $entryInfo->entry_info->wb_adv4_date }}修了)</td>
            </tr>
        @endif

        @if (isset($entryInfo->entry_info->wb_adv5_category))
            <tr>
                <th>その他の実修所履歴(5)</th>
                <td>{{ $entryInfo->entry_info->wb_adv5_category }}課程 {{ $entryInfo->entry_info->wb_adv5_number }}期
                    ({{ $entryInfo->entry_info->wb_adv5_date }}修了)</td>
            </tr>
        @endif

        <tr>
            <th>奉仕歴</th>
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
            <th>現在治療中の病気</th>
            <td>{{ $entryInfo->entry_info->health_illness }}</td>
        </tr>

        <tr>
            <th>健康上で不安なことなど</th>
            <td>{{ $entryInfo->entry_info->health_memo }}</td>
        </tr>

    </table>
</div>
