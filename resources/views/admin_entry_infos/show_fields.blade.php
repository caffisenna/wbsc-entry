<div class="table-responsive">
    <table class="uk-table uk-table-divider uk-table-hover uk-table-striped">
        <tr>
            <th>スカウトコースの期数</th>
            @if ($entryInfo->entry_info->sc_number != 'done' && $entryInfo->entry_info->sc_number_done != '')
                <td>{{ $entryInfo->entry_info->sc_number }}</td>
            @else
                <td>{{ $entryInfo->entry_info->sc_number_done }}</td>
            @endif
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

        <tr>
            <th>緊急連絡先</th>
            <td>【氏名:】 {{ $entryInfo->entry_info->emer_name }}({{ $entryInfo->entry_info->emer_relation }})<br>
                【連絡先】 {{ $entryInfo->entry_info->emer_phone }}
            </td>
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
        @if (Auth::user()->is_admin)
            <tr>
                <th><span class="uk-text-danger">団承認取り消し</th>
                <td>
                    @if (isset($entryInfo->entry_info->gm_checked_at))
                        <a href="{{ url('admin/revert?cat=dan') }}&uuid={{ $entryInfo->entry_info->uuid }}"
                            class="uk-button uk-button-danger"
                            onclick="return confirm('{{ $entryInfo->name }}さんの団承認を取り消しますか?')">取り消し</a>
                        {{ $entryInfo->entry_info->gm_checked_at->format('Y-m-d') }}
                    @else
                        団委員長 未確認
                    @endif
                </td>
            </tr>
            <tr>
                <th><span class="uk-text-danger">トレーナー認定取り消し</th>
                <td>
                    @if ($entryInfo->entry_info->assignment_sc == 'up' || $entryInfo->entry_info->assignment_division == 'up')
                        <a href="{{ url('admin/revert?cat=trainer') }}&uuid={{ $entryInfo->entry_info->uuid }}"
                            class="uk-button uk-button-danger"
                            onclick="return confirm('{{ $entryInfo->name }}さんのトレーナー認定を取り消しますか?\n(スカウトコース、課程別両方の認定が取り消されます。)')">取り消し</a>
                        <ul>
                            <li>スカウトコース: @if ($entryInfo->entry_info->trainer_sc_name)
                                    {{ $entryInfo->entry_info->trainer_sc_name }}
                                @else
                                    未認定
                                @endif
                            </li>
                            <li>スカウトコース: @if ($entryInfo->entry_info->trainer_division_name)
                                    {{ $entryInfo->entry_info->trainer_division_name }}
                                @else
                                    未認定
                                @endif
                            </li>
                        </ul>
                    @elseif(empty($entryInfo->entry_info->assignment_sc) && empty($entryInfo->entry_info->assignment_division))
                        未認定
                    @endif

                </td>
            </tr>
            <tr>
                <th><span class="uk-text-danger">地区コミ認定取り消し</th>
                <td>
                    @if ($entryInfo->entry_info->commi_checked_at)
                        <a href="{{ url('admin/revert?cat=commi') }}&uuid={{ $entryInfo->entry_info->uuid }}"
                            class="uk-button uk-button-danger"
                            onclick="return confirm('{{ $entryInfo->name }}さんの地区コミ確認を取り消しますか?')">取り消し</a>
                        {{ $entryInfo->entry_info->commi_checked_at->format('Y-m-d') }}
                    @else
                        地区コミ未確認
                    @endif
                </td>
            </tr>
            <tr>
                <th><span class="uk-text-danger">地区AIS確認取り消し</th>
                <td>
                    @if (isset($entryInfo->entry_info->ais_checked_at))
                        <a href="{{ url('admin/revert?cat=ais') }}&uuid={{ $entryInfo->entry_info->uuid }}"
                            class="uk-button uk-button-danger"
                            onclick="return confirm('{{ $entryInfo->name }}さんの地区AIS確認を取り消しますか?')">取り消し</a>
                        {{ $entryInfo->entry_info->ais_checked_at->format('Y-m-d') }}
                    @else
                        未認定
                    @endif
                </td>
            </tr>
        @endif
        <tr>
            <th>団承認URL</th>
            <td>
                <a
                    href="{{ url('/confirm/gm?uuid=') }}{{ $entryInfo->entry_info->uuid }}">{{ url('/confirm/gm?uuid=') }}{{ $entryInfo->entry_info->uuid }}</a><br>
                <span class="uk-text-warning uk-text-small">このURLから団承認を行うことができます</span>
            </td>
        </tr>
        <tr>
            <th>トレーナー認定URL</th>
            <td>
                <a
                    href="{{ url('/confirm/trainer?uuid=') }}{{ $entryInfo->entry_info->uuid }}">{{ url('/confirm/trainer?uuid=') }}{{ $entryInfo->entry_info->uuid }}</a><br>
                <span class="uk-text-warning uk-text-small">このURLから課題のトレーナー認定を行うことができます</span>
            </td>
        </tr>
        @if ($entryInfo->entry_info->additional_comment)
            <tr>
                <th>副信書</th>
                <td>{{ $entryInfo->entry_info->additional_comment }}</td>
            </tr>
        @endif

    </table>
</div>
