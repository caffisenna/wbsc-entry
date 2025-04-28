<script src="{{ url('js/yubinbango.js') }}" charset="UTF-8"></script>
@if (isset($user))
    <input type="hidden" name="create_id" value="{{ $user->id }}">
@else
    <input type="hidden" name="create_id" value="{{ $entryInfo->user->id }}">
@endif

<div class="table-responsive">
    <table class="uk-table uk-table-divider uk-table-hover uk-table-striped">
        <tr>
            <td>スカウトコースの期数</td>
            <td>
                <select name="sc_number" class="form-control custom-select uk-form-width-small" id="sc_number"
                    onchange="checkSelection()">
                    <option disabled style='display:none;' @if (empty($courselist->number)) selected @endif>選択してください
                    </option>
                    <option value=""></option>
                    @foreach ($courselists as $courselist)
                        <option value="{{ $courselist->number }}" @if (
                            (isset($courselist->number) && isset($entryInfo->sc_number) && $courselist->number == $entryInfo->sc_number) ||
                                old('sc_number') == $courselist->number) selected @endif>
                            {{ $courselist->number }}期</option>
                    @endforeach
                    @isset($entryInfo->sc_number)
                        <option value="done" @if (old('sc_number') == 'done' || $entryInfo->sc_number == 'done') selected @endif>履修済み</option>
                    @else
                        <option value="done" @if (old('sc_number') == 'done') selected @endif>履修済み</option>
                    @endisset
                </select>
                @error('sc_number')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
                {{-- 既修了者入力ボックス --}}
                <div id="textboxContainer" style="display:none;">
                    <label for="myTextbox">修了コース名を入力してください</label>
                    @isset($entryInfo->sc_number_done)
                        <input type="text" id="myTextbox" name="sc_number_done" class="form-control uk-form-width-medium"
                            placeholder="例: 東京15期" id="sc_number_done"
                            value="@if ($entryInfo->sc_number_done) {{ $entryInfo->sc_number_done }}@else{{ old('sc_number_done') }} @endif">
                    @else
                        <input type="text" id="myTextbox" name="sc_number_done" class="form-control uk-form-width-medium"
                            placeholder="例: 東京15期" value="{{ old('sc_number_done') }}" id="sc_number_done">
                    @endisset
                    @error('sc_number_done')
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                </div>
                {{-- 既修了者入力ボックス --}}
            </td>
        </tr>
        <tr>
            <td>課程別研修の回数</td>
            <td>
                <select name="division_number" class="form-control custom-select uk-form-width-medium"
                    id="division_number" onchange="checkSelection()">
                    <option disabled style='display:none;' @if (empty($divisionlist)) selected @endif>選択してください
                    </option>
                    <option value=""></option>
                    @foreach ($divisionlists as $divisionlist)
                        <option value="{{ $divisionlist }}" @if (
                            (isset($divisionlist) && isset($entryInfo->division_number) && $divisionlist == $entryInfo->division_number) ||
                                old('division_number') == $divisionlist) selected @endif>
                            {{ $divisionlist }}回
                        </option>
                    @endforeach
                    {{-- その他対応 --}}
                    @php
                        $selectedValue = isset($entryInfo->division_number)
                            ? $entryInfo->division_number
                            : old('division_number');
                    @endphp
                    <option value="etc" {{ $selectedValue == 'etc' ? 'selected' : '' }}>それ以外</option>
                    {{-- その他対応 --}}
                    <input type="hidden" name="bvs_exception" value="off">
                    <input type="checkbox" name="bvs_exception" id="bvs_exception_cb" class="uk-checkbox" value="on"
                        {{ old('bvs_exception') == 'on' || (isset($entryInfo) && $entryInfo->bvs_exception == 'on') ? 'checked' : '' }}>ビーバー課程特例
                </select>

                @error('division_number')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <td>団委員研修所</td>
            <td>{!! Form::number('danken', null, [
                'class' => 'form-control uk-form-width-small',
                'placeholder' => '団研期数を半角で入力',
                'id' => 'danken',
                'oninput' => 'checkInput()',
                'max' => '99',
            ]) !!}</td>
        </tr>
        <tr>
            <td>お名前</td>
            <td>
                @if (isset($user))
                    {{ $user->name }}
                @else
                    {{ $entryInfo->user->name }}
                @endif
            </td>
        </tr>
        <tr>
            <td>Email</td>
            <td>
                @if (isset($user))
                    {{ $user->email }}
                @else
                    {{ $entryInfo->user->email }}
                @endif
            </td>
        </tr>
        <tr>
            <td>ふりがな</td>
            <td>{!! Form::text('furigana', null, ['class' => 'form-control uk-form-width-small']) !!}
                @error('furigana')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <td>性別</td>
            <td>{!! Form::select('gender', ['' => '', '男' => '男', '女' => '女'], null, [
                'class' => 'form-control custom-select uk-form-width-small',
            ]) !!}
                @error('gender')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <td>生年月日</td>
            <td>
                {{-- {!! Form::date('birthday', null, ['class' => 'form-control', 'min'=>'1947-01-01', 'max'=>'2004-12-31']) !!} --}}
                {!! Form::selectRange('bd_year', 1942, 2008, null, [
                    'class' => 'form-control custom-select uk-form-width-small',
                    'placeholder' => '年',
                ]) !!}
                {!! Form::selectrange('bd_month', 1, 12, null, [
                    'class' => 'form-control custom-select uk-form-width-small',
                    'placeholder' => '月',
                ]) !!}
                {!! Form::selectRange('bd_day', 1, 31, null, [
                    'class' => 'form-control custom-select uk-form-width-small',
                    'placeholder' => '日',
                ]) !!}
                @error('birthday')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <td>登録番号</td>
            <td>{!! Form::text('bs_id', null, [
                'class' => 'form-control uk-form-width-small',
                'placeholder' => '登録証を確認し11桁の登録番号を入力してください',
                'pattern' => '[0-9]{1,11}', // 半角整数で最大11桁
                'oninput' => "this.value = this.value.replace(/[^0-9]/g, '').substring(0, 11)", // 半角整数以外の文字を削除し、最大11桁に制限
            ]) !!}
                @error('bs_id')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <td>所属県連盟</td>
            <td>{!! Form::select(
                'prefecture',
                [
                    '' => '',
                    '北海道' => '北海道',
                    '青森' => '青森',
                    '岩手' => '岩手',
                    '宮城' => '宮城',
                    '秋田' => '秋田',
                    '山形' => '山形',
                    '福島' => '福島',
                    '茨城' => '茨城',
                    '栃木' => '栃木',
                    '群馬' => '群馬',
                    '埼玉' => '埼玉',
                    '千葉' => '千葉',
                    '神奈川' => '神奈川',
                    '山梨' => '山梨',
                    '東京' => '東京',
                    '新潟' => '新潟',
                    '富山' => '富山',
                    '石川' => '石川',
                    '福井' => '福井',
                    '長野' => '長野',
                    '岐阜' => '岐阜',
                    '静岡' => '静岡',
                    '愛知' => '愛知',
                    '三重' => '三重',
                    '滋賀' => '滋賀',
                    '京都' => '京都',
                    '兵庫' => '兵庫',
                    '奈良' => '奈良',
                    '和歌山' => '和歌山',
                    '大阪' => '大阪',
                    '鳥取' => '鳥取',
                    '島根' => '島根',
                    '岡山' => '岡山',
                    '広島' => '広島',
                    '山口' => '山口',
                    '徳島' => '徳島',
                    '香川' => '香川',
                    '愛媛' => '愛媛',
                    '高知' => '高知',
                    '福岡' => '福岡',
                    '佐賀' => '佐賀',
                    '長崎' => '長崎',
                    '熊本' => '熊本',
                    '大分' => '大分',
                    '宮崎' => '宮崎',
                    '鹿児島' => '鹿児島',
                    '沖縄' => '沖縄',
                ],
                null,
                [
                    'class' => 'form-control custom-select uk-form-width-small',
                    'id' => 'pref',
                    'onchange' => 'updateDistrictOptions()',
                ],
            ) !!}
                @error('prefecture')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <td>地区</td>
            <td>{!! Form::select(
                'district',
                [
                    '' => '',
                    '大都心' => '大都心',
                    'さくら' => 'さくら',
                    '城東' => '城東',
                    '山手' => '山手',
                    'つばさ' => 'つばさ',
                    '世田谷' => '世田谷',
                    'あすなろ' => 'あすなろ',
                    '城北' => '城北',
                    '練馬' => '練馬',
                    '多摩西' => '多摩西',
                    '新多磨' => '新多磨',
                    '南武蔵野' => '南武蔵野',
                    '町田' => '町田',
                    '北多摩' => '北多摩',
                ],
                null,
                [
                    'class' => 'form-control custom-select uk-form-width-small',
                    'id' => 'district',
                    'onchange' => 'updateNonTokyo()',
                ],
            ) !!}
                <br>
                {!! Form::text('district', null, [
                    'class' => 'form-control uk-form-width-midium',
                    'placeholder' => '東連以外は地区名を入力',
                    'id' => 'district-non-tokyo',
                ]) !!}
                @error('district')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <td>団</td>
            <td>{!! Form::text('dan', null, ['class' => 'form-control uk-form-width-small', 'placeholder' => '例:渋谷第14団']) !!}
                @error('dan')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <td>所属隊</td>
            <td>{!! Form::select(
                'troop',
                [
                    '' => '',
                    '団' => '団',
                    'ビーバー隊' => 'ビーバー隊',
                    'カブ隊' => 'カブ隊',
                    'ボーイ隊' => 'ボーイ隊',
                    'ベンチャー隊' => 'ベンチャー隊',
                    'ローバー隊' => 'ローバー隊',
                ],
                null,
                [
                    'class' => 'form-control custom-select uk-form-width-small',
                ],
            ) !!}
                @error('troop')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <td>役務</td>
            <td>{!! Form::select(
                'troop_role',
                [
                    '' => '',
                    '団委員長' => '団委員長',
                    '副団委員長' => '副団委員長',
                    '団委員' => '団委員',
                    '育成会員' => '育成会員',
                    '隊長' => '隊長',
                    '副長' => '副長',
                    '副長補' => '副長補',
                    'ビーバー補助者' => 'ビーバー補助者',
                    'デンリーダー' => 'デンリーダー',
                    'インストラクター' => 'インストラクター',
                    'スカウト' => 'スカウト',
                ],
                null,
                [
                    'class' => 'form-control custom-select uk-form-width-midium',
                ],
            ) !!}
                @error('troop_role')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>

        <tr>
            <td>ケータイ</td>
            <td>{!! Form::text('cell_phone', null, ['class' => 'form-control']) !!}
                @error('cell_phone')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>

        <tr>
            <td>郵便番号</td>
            <td>
                <div class="h-adr">
                    <span class="p-country-name" style="display:none;">Japan</span>
                    {!! Form::text('zip', null, [
                        'class' => 'p-postal-code form-control',
                        'placeholder' => '郵便番号を7桁の整数で入力(例: 1510071)',
                    ]) !!}
                    {!! Form::text('address', null, [
                        'class' => 'p-region p-locality p-street-address p-extended-address form-control',
                        'placeholder' => '住所が自動で補完されます。番地以降を追記入力してください。',
                    ]) !!}
                </div>
            </td>
        </tr>

        {{-- <tr>
            <td>住所</td>
            <td>{!! Form::text('address', null, ['class' => 'form-control']) !!}
                @error('address')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr> --}}

        <tr>
            <td>緊急連絡先 氏名</td>
            <td>{!! Form::text('emer_name', null, ['class' => 'form-control uk-form-width-medium']) !!}
                @error('emer_name')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>

        <tr>
            <td>緊急連絡先 続柄</td>
            <td>{!! Form::text('emer_relation', null, ['class' => 'form-control uk-form-width-medium']) !!}
                @error('emer_relation')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>

        <tr>
            <td>緊急連絡先 電話</td>
            <td>{!! Form::text('emer_phone', null, ['class' => 'form-control uk-form-width-medium']) !!}
                @error('emer_phone')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>

        <tr>
            <td>地区役務</td>
            <td>{!! Form::text('district_role', null, ['class' => 'form-control']) !!}</td>
        </tr>

        <tr>
            <td>県連役務</td>
            <td>{!! Form::text('prefecture_role', null, ['class' => 'form-control']) !!}</td>
        </tr>

        <tr>
            <td>ボーイスカウト講習会</td>
            <td>{!! Form::text('bs_basic_course', null, [
                'class' => 'form-control',
                'placeholder' => '修了年月日を入力してください',
            ]) !!}
                @error('bs_basic_course')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>

        <tr>
            <td>スカウトキャンプ研修会</td>
            <td>{!! Form::text('scout_camp', null, ['class' => 'form-control', 'placeholder' => '修了年月日を入力してください']) !!}
                <br>
                <span class="uk-text-small">「ビーバー課程特例」の参加者は入力不要です</span>
                @error('scout_camp')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>

        @for ($i = 1; $i <= 3; $i++)
            <tr>
                <td>その他の研修所履歴({{ $i }})</td>
                <td>課程:{!! Form::text("wb_basic{$i}_category", null, [
                    'class' => 'form-control',
                    'placeholder' => '課程を入力してください(例: ボーイ課程)',
                ]) !!}<br>
                    期数:{!! Form::text("wb_basic{$i}_number", null, [
                        'class' => 'form-control',
                        'placeholder' => '期数を入力してください(例: 東京21期)',
                    ]) !!}<br>
                    修了年月:{!! Form::text("wb_basic{$i}_date", null, [
                        'class' => 'form-control',
                        'placeholder' => '修了年月を入力してください(例: 2021年10月)',
                    ]) !!}</td>
            </tr>
        @endfor

        @for ($i = 1; $i <= 3; $i++)
            <tr>
                <td>その他の実修所履歴({{ $i }})</td>
                <td>課程:{!! Form::text("wb_adv{$i}_category", null, [
                    'class' => 'form-control',
                ]) !!}<br>
                    期数:{!! Form::text("wb_adv{$i}_number", null, [
                        'class' => 'form-control',
                    ]) !!}<br>
                    修了年月:{!! Form::text("wb_adv{$i}_date", null, [
                        'class' => 'form-control',
                    ]) !!}</td>
            </tr>
        @endfor

        @for ($i = 1; $i <= 5; $i++)
            <tr>
                <td>奉仕歴({{ $i }})</td>
                <td>役務:{!! Form::text("service_hist{$i}_role", null, ['class' => 'form-control', 'placeholder' => '例:カブ副長']) !!}<br>
                    期間:{!! Form::text("service_hist{$i}_term", null, [
                        'class' => 'form-control',
                        'placeholder' => '2019/4/1〜2020/3/31',
                    ]) !!}</td>
            </tr>
        @endfor

        <tr>
            <td>団承認</td>
            <td>
                年月日: {!! Form::text('gm_checked_at', null, ['class' => 'form-control', 'placeholder' => 'YYYY-mm-dd hh:mm:ss']) !!}<br>
                氏名: {!! Form::text('gm_name', null, ['class' => 'form-control']) !!}
            </td>
        </tr>

        <tr>
            <td>トレーナー認定(SC)</td>
            <td>
                年月日: {!! Form::text('trainer_sc_checked_at', null, [
                    'class' => 'form-control',
                    'placeholder' => 'YYYY-mm-dd hh:mm:ss',
                ]) !!}<br>
                氏名: {!! Form::text('trainer_sc_name', null, ['class' => 'form-control']) !!}<br>
                アップロード: {!! Form::text('assignment_sc', null, ['class' => 'form-control', 'placeholder' => 'アップ済みなら up と入力']) !!}
            </td>
        </tr>

        <tr>
            <td>トレーナー認定(課程別)</td>
            <td>
                年月日: {!! Form::text('trainer_division_checked_at', null, [
                    'class' => 'form-control',
                    'placeholder' => 'YYYY-mm-dd hh:mm:ss',
                ]) !!}<br>
                氏名: {!! Form::text('trainer_division_name', null, ['class' => 'form-control']) !!}<br>
                アップロード: {!! Form::text('assignment_division', null, [
                    'class' => 'form-control',
                    'placeholder' => 'アップ済みなら up と入力',
                ]) !!}
            </td>
        </tr>

        <tr>
            <td>トレーナー認定(団研)</td>
            <td>
                年月日: {!! Form::text('trainer_danken_checked_at', null, [
                    'class' => 'form-control',
                    'placeholder' => 'YYYY-mm-dd hh:mm:ss',
                ]) !!}<br>
                氏名: {!! Form::text('trainer_danken_name', null, ['class' => 'form-control']) !!}<br>
                アップロード: {!! Form::text('assignment_danken', null, [
                    'class' => 'form-control',
                    'placeholder' => 'アップ済みなら up と入力',
                ]) !!}
            </td>
        </tr>

        <tr>
            <td>地区コミ推薦日</td>
            <td>
                年月日: {!! Form::text('commi_checked_at', null, ['class' => 'form-control']) !!}<br>
            </td>
        </tr>

        <tr>
            <td>欠席情報</td>
            <td>
                SC&団研: {!! Form::text('cancel', null, ['class' => 'form-control', 'placeholder' => '欠席理由を簡潔に入力']) !!}<br>
                課程別: {!! Form::text('cancel_div', null, ['class' => 'form-control', 'placeholder' => '欠席理由を簡潔に入力']) !!}
            </td>
        </tr>

    </table>
</div>
