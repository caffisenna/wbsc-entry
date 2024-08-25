<div class="table-responsive">
    <table class="uk-table uk-table-divider uk-table-hover uk-table-striped">
        <tr>
            <th>申込書PDF</th>
            <td><a href="{{ route('course_staff_pdf', ['id' => $entryInfo->uuid]) }}" class='btn btn-default'>
                    <span uk-icon="download"></span>ダウンロード
                </a></td>
        </tr>
        @unless ($entryInfo->danken)
            <tr>
                <th>スカウトコースの期数</th>
                @if ($entryInfo->sc_number == 'done')
                    <td><span class="uk-text-warning">{{ $entryInfo->sc_number_done }}(修了済み)</span></td>
                @else
                    <td>{{ $entryInfo->sc_number }}期</td>
                @endif
            </tr>
            <tr>
                <th>課程別研修の回数</th>
                <td>
                    @unless ($entryInfo->division_number == 'etc')
                        {{ $entryInfo->division_number }}回
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
            <td>{{ $entryInfo->user->name }} ({{ $entryInfo->furigana }})</td>
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
                    {{ $entryInfo->gm_name }} ({{ $entryInfo->gm_checked_at->format('Y-m-d') }})
                @else
                    未承認
                @endif
            </td>
        </tr>
        <tr>
            <th>課題</td>
            <td>
                @if (File::exists(storage_path('app/public/assignment/sc/') . $entryInfo->uuid . '.pdf'))
                    <a href="{{ url('/storage/assignment/sc/') . '/' . $entryInfo->uuid . '.pdf' }}"
                        target="_blank"><span uk-icon="file-pdf"></span>
                        @if ($entryInfo->danken)
                            団委員研修所課題
                        @else
                            スカウトコース課題
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
                            target="_blank"><span uk-icon="file-pdf"></span>課程別研修課題</a>
                    @else
                        <span class="uk-text-danger">未提出</span>
                    @endif
                </td>
            </tr>
        @endunless
        @if ($entryInfo->additional_comment)
            <tr>
                <th>副申請書</th>
                <td>{{ $entryInfo->additional_comment }}</td>
            </tr>
        @endif
        @if (isset($entryInfo->health_info))
            <tr>
                <th>健康情報</th>
                <td>
                    【治療中の病気】
                    {{ $entryInfo->health_info->treating_disease == '1' ? '特になし' : $entryInfo->health_info->treating_disease }}
                    <br>
                    【携行持薬】
                    {{ $entryInfo->health_info->carried_medications == '' ? 'なし' : $entryInfo->health_info->carried_medications }}
                    <br>
                    【直近3ヶ月の健康】 {{ $entryInfo->health_info->health_status_last_3_months }}
                    <br>
                    【最近の体調】
                    {{ $entryInfo->health_info->recent_health_status == '1' ? '特に問題はなかった' : $entryInfo->health_info->recent_health_status }}
                    <br>
                    【医師の助言】 {{ $entryInfo->health_info->doctor_advice == '1' ? '特になし' : '' }}
                    <br>
                    【特記事項】 {{ $entryInfo->health_info->medical_history == '1' ? '特になし' : '' }}
                </td>
            </tr>
            <tr>
                <th>アレルギー情報</th>
                <td>
                    【食物アレルギー】{{ $entryInfo->health_info->food_allergies == '' ? 'なし' : $entryInfo->health_info->food_allergies }}
                    <br>
                    【アレルゲン】{{ $entryInfo->health_info->allergen == '' ? 'なし' : $entryInfo->health_info->allergen }}
                    <br>
                    【摂取するとどうなるか】{{ $entryInfo->health_info->reaction_to_allergen == '' ? 'なし' : $entryInfo->health_info->reaction_to_allergen }}
                    <br>
                    【家庭での対応】{{ $entryInfo->health_info->usual_response_to_reaction == '' ? 'なし' : $entryInfo->health_info->usual_response_to_reaction }}
                </td>
            </tr>
        @else
            <tr>
                <th>健康情報</th>
                <td><span class="uk-text-danger">未入力</span></td>
            </tr>
        @endif
        <tr>
            <th>キャンセル</th>
            <td><a href="{{ route('cancel', ['uuid' => $entryInfo->uuid]) }}"
                    class="uk-button uk-button-danger">キャンセル入力</a></td>
        </tr>

    </table>
</div>
