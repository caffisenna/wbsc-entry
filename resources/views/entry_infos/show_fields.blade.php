<div class="table-responsive">
    <table class="uk-table uk-table-divider uk-table-hover uk-table-striped">
        @if ($entryInfo->danken)
            <tr>
                <th>団委員研修所の期数</td>
                <td>東京第{{ $entryInfo->danken }}期</td>
            </tr>
        @else
            @if ($entryInfo->sc_number || $entryInfo->sc_number_done)
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
            @endif
            <tr>
                <th>課程別研修の回数</th>
                <td>
                    @unless ($entryInfo->division_number == 'etc')
                        {{ $entryInfo->division_number }} {{ $entryInfo->bvs_exception == 'on' ? '(ビーバー課程特例)' : '' }}
                    @else
                        それ以外
                    @endunless
                </td>
            </tr>
        @endif
        <tr>
            <th>お名前</th>
            <td>{{ Auth::user()->name }} ({{ $entryInfo->furigana }})</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ Auth::user()->email }}</td>
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
            <th>ボーイスカウト講習会</th>
            <td>{{ $entryInfo->bs_basic_course }}</td>
        </tr>

        @if ($entryInfo->scout_camp)
            <tr>
                <th>スカウトキャンプ研修会</th>
                <td>{{ $entryInfo->scout_camp }}</td>
            </tr>
        @endif

        @for ($i = 1; $i <= 3; $i++)
            @if (isset($entryInfo->{"wb_basic{$i}_category"}))
                <tr>
                    <th>その他の研修所履歴({{ $i }})</th>
                    <td>
                        {{ $entryInfo->{"wb_basic{$i}_category"} }}課程 {{ $entryInfo->{"wb_basic{$i}_number"} }}
                        @if (mb_strpos($entryInfo->{"wb_basic{$i}_number"}, '期') == false)
                            期
                        @endif
                        ({{ $entryInfo->{"wb_basic{$i}_date"} }}修了)
                    </td>
                </tr>
            @endif
        @endfor

        @for ($i = 1; $i <= 3; $i++)
            @if (isset($entryInfo->{"wb_adv{$i}_category"}))
                <tr>
                    <th>その他の実修所履歴({{ $i }})</th>
                    <td>{{ $entryInfo->{"wb_adv{$i}_category"} }}課程 {{ $entryInfo->{"wb_adv{$i}_number"} }}
                        @if (mb_strpos($entryInfo->{"wb_adv{$i}_number"}, '期') == false)
                            期
                        @endif
                        ({{ $entryInfo->{"wb_adv{$i}_date"} }}修了)
                    </td>
                </tr>
            @endif
        @endfor


        <tr>
            <th>奉仕歴</th>
            <td>
                @for ($i = 1; $i <= 5; $i++)
                    @if (isset($entryInfo->{'service_hist' . $i . '_role'}))
                        役務:{{ $entryInfo->{'service_hist' . $i . '_role'} }}
                        期間:{{ $entryInfo->{'service_hist' . $i . '_term'} }}<br>
                    @endif
                @endfor
            </td>
        </tr>

        {{-- <tr>
            <th>現在治療中の病気</th>
            <td>{{ $entryInfo->health_illness }}</td>
        </tr>

        <tr>
            <th>健康上で不安なことなど</th>
            <td>{{ $entryInfo->health_memo }}</td>
        </tr> --}}

    </table>
</div>
