<div class="table-responsive">
    <table class="uk-table uk-table-divider uk-table-hover uk-table-striped">
        @unless ($entryInfo->danken)
            @unless ($entryInfo->bvs_exception == 'on')
                <tr>
                    <th>スカウトコースの期数</th>
                    @if ($entryInfo->sc_number == 'done')
                        <td><span class="uk-text-warning">{{ $entryInfo->sc_number_done }}(修了済み)</span></td>
                    @else
                        <td>{{ $entryInfo->sc_number }}期</td>
                    @endif
                </tr>
            @endunless
            <tr>
                <th>課程別研修の回数</th>
                <td>
                    @unless ($entryInfo->division_number == 'etc')
                        {{ $entryInfo->division_number }}回
                        {{ $entryInfo->bvs_exception == 'on' ? '(ビーバー課程特例)' : '' }}
                    @else
                        それ以外
                    @endunless
                </td>
            </tr>
        @else
            <tr>
                <th>団委員研修所の期数</th>
                <td>東京第{{ $entryInfo->danken }}期</td>
            </tr>

        @endunless

        <tr>
            <th>お名前</th>
            <td>{{ $entryInfo->name }} ({{ $entryInfo->furigana }})</td>
        </tr>
        <tr>
            <th>写真</th>
            <td>
                @if ($entryInfo->user->face_picture)
                    <img src="{{ url('/storage/picture/') }}{{ '/' . $entryInfo->user->face_picture }}" width="100px">
                @endif
            </td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $entryInfo->user->email }}</td>
        </tr>
        <tr>
            <th>性別</th>
            <td>{{ $entryInfo->gender }}</td>
        </tr>
        <tr>
            <th>生年月日</th>
            <td>
                {{ $entryInfo->birthday->format('Y年m月d日') }}
                ({{ \Carbon\Carbon::parse($entryInfo->birthday)->age }}才)
            </td>
        </tr>
        <tr>
            <th>登録番号</th>
            <td>{{ $entryInfo->bs_id }}</td>
        </tr>
        <tr>
            <th>所属</th>
            <td>{{ $entryInfo->prefecture }}連盟 {{ $entryInfo->district }}地区
                {{ $entryInfo->dan }}</td>
        </tr>

        <tr>
            <th>所属隊・役務</th>
            <td>{{ $entryInfo->troop == '団' ? '' : $entryInfo->troop }}
                {{ $entryInfo->troop_role }}</td>
        </tr>

        <tr>
            <th>ケータイ</th>
            <td>{{ $entryInfo->cell_phone }}</td>
        </tr>

        <tr>
            <th>住所</th>
            <td>{{ $entryInfo->zip }}<br>{{ $entryInfo->address }}</td>
        </tr>

        @if ($entryInfo->emer_name)
            <tr>
                <th>緊急連絡先</th>
                <td>【氏名:】 {{ $entryInfo->emer_name }}({{ $entryInfo->emer_relation }})<br>
                    【連絡先】 {{ $entryInfo->emer_phone }}
                </td>
            </tr>
        @endif

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

        <tr>
            <th>スカウトキャンプ研修会</th>
            <td>{{ $entryInfo->scout_camp }}</td>
        </tr>

        @for ($i = 1; $i <= 3; $i++)
            @if (isset($entryInfo->{"wb_basic{$i}_category"}))
                <tr>
                    <th>その他の研修所履歴({{ $i }})</th>
                    <td>
                        {{ $entryInfo->{"wb_basic{$i}_category"} }}
                        {{ $entryInfo->{"wb_basic{$i}_number"} }}
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
                    <td>{{ $entryInfo->{"wb_adv{$i}_category"} }}
                        {{ $entryInfo->{"wb_adv{$i}_number"} }}
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

        @if (Auth::user()->is_admin)
            <tr>
                <th><span class="uk-text-danger">団承認取消</th>
                <td>
                    @if (isset($entryInfo->gm_checked_at))
                        <a href="{{ route('revert', ['cat' => 'dan', 'uuid' => $entryInfo->uuid]) }}"
                            class="uk-button uk-button-danger"
                            onclick="return confirm('{{ $entryInfo->name }}さんの団承認を取り消しますか?')">取消</a>
                        {{ $entryInfo->gm_checked_at->format('Y-m-d') }}
                    @else
                        <span class="uk-text-danger">未承認</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="uk-table-middle"><span class="uk-text-danger">トレーナー認定取消</th>
                <td>
                    @if ($entryInfo->trainer_sc_checked_at || $entryInfo->trainer_danken_checked_at)
                        <a href="{{ route('revert', ['cat' => 'trainer', 'uuid' => $entryInfo->uuid, 'target' => 'sc']) }}"
                            class="uk-button uk-button-danger"
                            onclick="return confirm('{{ $entryInfo->name }} さんのトレーナー認定(SC/団研)を取り消しますか?)')">
                            取消
                        </a>
                        @unless ($entryInfo->danken)
                            スカウトコース: @if ($entryInfo->trainer_sc_name)
                                {{ $entryInfo->trainer_sc_name }}
                            @else
                                <span class="uk-text-danger">未認定(SC)</span>
                            @endif
                        @else
                            団研: @if ($entryInfo->trainer_danken_name)
                                {{ $entryInfo->trainer_danken_name }}
                            @else
                                <span class="uk-text-danger">未認定(団研)</span>
                            @endif
                        @endunless
                    @elseif(empty($entryInfo->trainer_sc_checked_at))
                        <span class="uk-text-danger">未認定</span>
                    @endif

                    {{-- 課程別 --}}
                    @if (empty($entryInfo->danken))
                        <hr>
                        @if ($entryInfo->trainer_division_checked_at)
                            <a href="{{ route('revert', ['cat' => 'trainer', 'uuid' => $entryInfo->uuid, 'target' => 'div']) }}"
                                class="uk-button uk-button-danger"
                                onclick="return confirm('{{ $entryInfo->name }} さんのトレーナー認定(課程別研修)を取り消しますか?)')">
                                取消
                            </a>
                            課程別研修: @if ($entryInfo->trainer_division_name)
                                {{ $entryInfo->trainer_division_name }}
                            @endif
                        @elseif(empty($entryInfo->trainer_division_checked_at))
                            <span class="uk-text-danger">未認定(課程別研修)</span>
                        @endif
                    @endif
                </td>
            </tr>
            <tr>
                <th><span class="uk-text-danger">地区コミ推薦取消</th>
                <td>
                    @if ($entryInfo->commi_checked_at)
                        <a href="{{ route('revert', ['cat' => 'commi', 'uuid' => $entryInfo->uuid]) }}"
                            class="uk-button uk-button-danger"
                            onclick="return confirm('{{ $entryInfo->name }}さんの地区コミ推薦を取り消しますか?')">取消</a>
                        {{ $entryInfo->commi_checked_at->format('Y-m-d') }}
                    @else
                        <span class="uk-text-danger">未推薦</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th><span class="uk-text-danger">地区AIS確認取消</th>
                <td>
                    @if (isset($entryInfo->ais_checked_at))
                        <a href="{{ route('revert', ['cat' => 'ais', 'uuid' => $entryInfo->uuid]) }}"
                            class="uk-button uk-button-danger"
                            onclick="return confirm('{{ $entryInfo->name }}さんの地区AIS確認を取り消しますか?')">取消</a>
                        {{ $entryInfo->ais_checked_at->format('Y-m-d') }}
                    @else
                        <span class="uk-text-danger">未確認</span>
                    @endif
                </td>
            </tr>
        @endif
        <tr>
            <th>団承認URL</th>
            <td>
                <a href="{{ route('gm_confirm', ['uuid' => $entryInfo->uuid]) }}">団承認をする</a>
            </td>
        </tr>
        <tr>
            <th>トレーナー認定URL</th>
            <td>
                <a href="{{ route('trainer_confirm', ['uuid' => $entryInfo->uuid]) }}">トレーナー認定をする</a>
            </td>
        </tr>
        <tr>
            <th>課題認定</th>
            <td>
                <ul class="uk-list">
                    @if ($entryInfo->trainer_sc_name)
                        <li>スカウトコース: {{ $entryInfo->trainer_sc_name }}</li>
                    @endif
                    @if ($entryInfo->trainer_division_name)
                        <li>課程別: {{ $entryInfo->trainer_division_name }}</li>
                    @endif
                    {{-- 団研 --}}
                    @if ($entryInfo->trainer_danken_name)
                        <li>{{ $entryInfo->trainer_danken_name }}</li>
                    @endif
                </ul>
            </td>
        </tr>
        <tr>
            <th>団承認</th>
            <td>
                @if ($entryInfo->gm_name)
                    {{ $entryInfo->gm_name }}
                    @if ($gm_email)
                        <br>
                        <span class="uk-text-small">参加決定通知先: {{ $gm_email->name }} ({{ $gm_email->email }})</span>
                    @endif
                @else
                    <span class="uk-text-danger">未承認</span>
                @endif
            </td>
        </tr>
        <tr>
            <th>課題</th>
            <td>
                @if (File::exists(storage_path('app/public/assignment/sc/') . $entryInfo->uuid . '.pdf'))
                    <a href="{{ url('/storage/assignment/sc/') . '/' . $entryInfo->uuid . '.pdf' }}"
                        target="_blank"><span uk-icon="file-pdf"></span>
                        @if ($entryInfo->danken)
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
        @unless ($entryInfo->danken)
            <tr>
                <th>課程別研修課題</th>
                <td>
                    @if (File::exists(storage_path('app/public/assignment/division/') . $entryInfo->uuid . '.pdf'))
                        <a href="{{ url('/storage/assignment/division/') . '/' . $entryInfo->uuid . '.pdf' }}"
                            target="_blank"><span uk-icon="file-pdf"></span>課程別研修課題を確認</a>
                    @else
                        <span class="uk-text-danger">未提出</span>
                    @endif
                </td>
            </tr>
        @endunless

        <tr>
            <th>副申請書</th>
            <td>
                @if (isset($entryInfo->additional_comment))
                    {{ $entryInfo->additional_comment }}
                @else
                    <span class="uk-text-default">入力なし</span>
                @endif
            </td>
        </tr>

        @if (Auth::user()->is_admin && Auth::user()->is_staff == null)
            <tr>
                <th>地区コミ機能</th>
                <td>
                    <ul class="uk-list">
                        <li><a href="{{ route('gm_request', ['id' => $entryInfo->uuid]) }}">団委員長へ承認依頼</a>
                        </li>
                        <li><a
                                href="{{ route('trainer_request', ['id' => $entryInfo->uuid]) }}">トレーナーへ認定依頼</a>
                        </li>
                        <li><a href="{{ route('commi_check', ['id' => $entryInfo->uuid]) }}"
                                onclick="return confirm('{{ $entryInfo->name }}さんを推薦しますか?')">地区コミ推薦をする</a></li>
                        <li><a
                                href="{{ route('commi_comment', ['id' => $entryInfo->uuid]) }}">副申請書を作成する</a>
                        </li>
                    </ul>

                </td>
            </tr>
            <tr>
                <th>アップロード</th>
                <td>
                    <ul class="uk-list">
                        <li><a
                                href="{{ route('face_upload.index', ['uuid' => $entryInfo->uuid]) }}">顔写真</a>
                        </li>
                        <li><a
                                href="{{ route('upload.index', ['uuid' => $entryInfo->uuid, 'q' => 'sc']) }}">課題研修(スカウトコース
                                or 団研)</a></li>
                        <li><a
                                href="{{ route('upload.index', ['uuid' => $entryInfo->uuid, 'q' => 'division']) }}">課題研修(課程別)</a>
                        </li>
                    </ul>
                </td>
            </tr>
            @if ($entryInfo->cancel)
                <tr>
                    <th>欠席(SC/団研)</th>
                    <td>{{ $entryInfo->cancel }} <a
                            href="{{ route('revert_cancel', ['uuid' => $entryInfo->uuid, 'cat' => 'sc']) }}"
                            onclick="return confirm('欠席情報を消去しますか?')"><span uk-icon="icon: ban"
                                class="uk-text-danger"></span></a></td>
                </tr>
            @endif
            @if ($entryInfo->cancel_div)
                <tr>
                    <th>欠席(課程別)</th>
                    <td>{{ $entryInfo->cancel_div }} <a
                            href="{{ route('revert_cancel', ['uuid' => $entryInfo->uuid, 'cat' => 'div']) }}"
                            onclick="return confirm('欠席情報を消去しますか?')"><span uk-icon="icon: ban"
                                class="uk-text-danger"></span></a></td>
                </tr>
            @endif
            <tr>
                <th>最終ログイン</th>
                <td>{{ $entryInfo->user->last_login_at }}</td>
            </tr>
        @endif

    </table>

    @if (isset($entryInfo->health_info))
        <h3>健康情報</h3>
        <table class="uk-table uk-table-striped uk-table-responsive">
            <tr>
                <th>現在治療中の病気</th>
                <td>{{ $entryInfo->health_info->treating_disease == 1 ? '特になし' : $entryInfo->health_info->treating_disease }}
                </td>
            </tr>

            <tr>
                <th>直近3ヶ月の健康状態</th>
                <td>{{ $entryInfo->health_info->health_status_last_3_months }}</td>
            </tr>

            <tr>
                <th>最近の体調</th>
                <td>{{ $entryInfo->health_info->recent_health_status == 1 ? '特に異常なし' : $entryInfo->health_info->recent_health_status }}
                </td>
            </tr>
            <tr>
                <th>医師からの注意</th>
                <td>{{ $entryInfo->health_info->doctor_advice == 1 ? '特になし' : $entryInfo->health_info->doctor_advice }}
                </td>
            </tr>
            <tr>
                <th>特記事項・過去の傷病等</th>
                <td>{{ $entryInfo->health_info->medical_history == 1 ? '特になし' : $entryInfo->health_info->medical_history }}
                </td>
            </tr>
            <tr>
                <th>食物アレルギー</th>
                <td>{{ $entryInfo->health_info->food_allergies }}</td>
            </tr>
            <tr>
                <th>アレルゲン</th>
                <td>{{ $entryInfo->health_info->allergen == null ? '入力なし' : $entryInfo->health_info->allergen }}</td>
            </tr>
            <tr>
                <th>アレルゲンを摂取するとどうなるか</th>
                <td>{{ $entryInfo->health_info->reaction_to_allergen == null ? '入力なし' : $entryInfo->health_info->reaction_to_allergen }}
                </td>
            </tr>
            <tr>
                <th>アレルゲンに対する家庭での対応</th>
                <td>{{ $entryInfo->health_info->usual_response_to_reaction == null ? '入力なし' : $entryInfo->health_info->usual_response_to_reaction }}
                </td>
            </tr>
        </table>
    @else
        <h3>健康情報</h3>
        <span class="uk-text-warning">健康情報が未入力のため表示できません</span>
    @endif
</div>
