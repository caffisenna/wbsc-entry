<div class="table-responsive">
    <table class="uk-table uk-table-divider uk-table-hover uk-table-striped">
        <tr>
            <td>スカウトコースの期数</td>
            <td>
                <select name="sc_number" class="form-control custom-select uk-form-width-small" id="sc_select"
                    onchange="toggleTextbox()">
                    <option disabled style='display:none;' @if (empty($courselist->number)) selected @endif>選択してください
                    </option>
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
                            placeholder="例: 東京15期"
                            value="@if ($entryInfo->sc_number_done) {{ $entryInfo->sc_number_done }}@else{{ old('sc_number_done') }} @endif">
                    @else
                        <input type="text" id="myTextbox" name="sc_number_done" class="form-control uk-form-width-medium"
                            placeholder="例: 東京15期" value="{{ old('sc_number_done') }}">
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
                <select name="division_number" class="form-control custom-select uk-form-width-small">
                    <option disabled style='display:none;' @if (empty($divisionlist)) selected @endif>選択してください
                    </option>
                    @foreach ($divisionlists as $divisionlist)
                        <option value="{{ $divisionlist }}" @if (
                            (isset($divisionlist) && isset($entryInfo->division_number) && $divisionlist == $entryInfo->division_number) ||
                                old('division_number') == $divisionlist) selected @endif>
                            {{ $divisionlist }}回</option>
                    @endforeach
                </select>
                @error('division_number')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <td>お名前</td>
            <td>{{ Auth::user()->name }}</td>
        </tr>
        <tr>
            <td>ふりがな</td>
            <td>{!! Form::text('furigana', null, ['class' => 'form-control uk-form-width-medium']) !!}
                @error('furigana')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{ Auth::user()->email }}</td>
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
                {!! Form::selectRange('bd_year', 1942, 2004, null, [
                    'class' => 'form-control custom-select uk-form-width-small',
                    'placeholder' => '年',
                ]) !!}年{!! Form::selectrange('bd_month', 1, 12, null, [
                    'class' => 'form-control custom-select uk-form-width-xsmall',
                    'placeholder' => '月',
                ]) !!}月
                {!! Form::selectRange('bd_day', 1, 31, null, [
                    'class' => 'form-control custom-select uk-form-width-xsmall',
                    'placeholder' => '日',
                ]) !!}日
                @error('birthday')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <td>登録番号<br><span class="uk-text-danger uk-text-small">2023年度より登録番号が11桁に変わっています</td>
            <td>{!! Form::text('bs_id', null, [
                'class' => 'form-control uk-form-width-large',
                'placeholder' => '団に確認し11桁の登録番号を入力してください',
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
                '東京',
                ['class' => 'form-control custom-select uk-form-width-small'],
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
                    'id' => 'selectDistrict',
                    'onchange' => 'updateDan()',
                ],
            ) !!}
                @error('district')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <td>団</td>
            {{-- <td>{!! Form::text('dan', null, ['class' => 'form-control', 'placeholder' => '例:渋谷14']) !!}
                @error('dan')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td> --}}
            <td>
                <select id="selectDan" class="form-control" name="dan"></select>
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
                    'class' => 'form-control custom-select uk-form-width-medium',
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
                ],
                null,
                [
                    'class' => 'form-control custom-select uk-form-width-medium',
                ],
            ) !!}
                @error('troop_role')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>

        <tr>
            <td>ケータイ</td>
            <td>{!! Form::text('cell_phone', null, ['class' => 'form-control uk-form-width-medium', 'placeholder'=>'ハイフン不要']) !!}
                @error('cell_phone')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>

        <tr>
            <td>郵便番号</td>
            <td>{!! Form::text('zip', null, ['class' => 'form-control uk-form-width-medium', 'placeholder'=>'7桁の整数で入力']) !!}
                @error('zip')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>

        <tr>
            <td>住所</td>
            <td>{!! Form::text('address', null, ['class' => 'form-control', 'placeholder'=>'都道府県から番地まで入力']) !!}
                @error('address')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>

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
            <td>{!! Form::text('emer_phone', null, ['class' => 'form-control uk-form-width-medium', 'placeholder'=>'日中連絡の取れるケータイなど']) !!}
                @error('emer_phone')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>

        <tr>
            <td>地区役務</td>
            <td>{!! Form::text('district_role', null, ['class' => 'form-control uk-form-width-medium']) !!}</td>
        </tr>

        <tr>
            <td>県連役務</td>
            <td>{!! Form::text('prefecture_role', null, ['class' => 'form-control uk-form-width-medium']) !!}</td>
        </tr>

        <tr>
            <td>スカウトキャンプ研修会</td>
            <td>{!! Form::text('scout_camp', null, [
                'class' => 'form-control uk-form-width-medium',
                'placeholder' => '例:2023/3/6(修了年月日)',
            ]) !!}
                @error('scout_camp')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>

        <tr>
            <td>ボーイスカウト講習会</td>
            <td>{!! Form::text('bs_basic_course', null, [
                'class' => 'form-control uk-form-width-medium',
                'placeholder' => '例:2020/5/14(修了年月日)',
            ]) !!}
                @error('bs_basic_course')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>

        @for ($i = 1; $i <= 3; $i++)
            <tr>
                <td>その他の研修所履歴({{ $i }})</td>
                <td>課程:{!! Form::text("wb_basic{$i}_category", null, [
                    'class' => 'form-control uk-form-width-medium',
                    'placeholder' => '例: ボーイ課程',
                ]) !!}<br>
                    期数:{!! Form::text("wb_basic{$i}_number", null, [
                        'class' => 'form-control uk-form-width-small',
                        'placeholder' => '例: 東京21期',
                    ]) !!}<br>
                    修了年月:{!! Form::text("wb_basic{$i}_date", null, [
                        'class' => 'form-control uk-form-width-medium',
                        'placeholder' => '例: 2021年10月',
                    ]) !!}</td>
            </tr>
        @endfor

        @for ($i = 1; $i <= 3; $i++)
            <tr>
                <td>その他の実修所履歴({{ $i }})</td>
                <td>課程:{!! Form::text("wb_adv{$i}_category", null, [
                    'class' => 'form-control uk-form-width-medium',
                    'placeholder'=>'例:ボーイ課程'
                ]) !!}<br>
                    期数:{!! Form::text("wb_adv{$i}_number", null, [
                        'class' => 'form-control uk-form-width-small',
                        'placeholder'=>'例:161期'
                    ]) !!}<br>
                    修了年月:{!! Form::text("wb_adv{$i}_date", null, [
                        'class' => 'form-control uk-form-width-medium',
                        'placeholder'=>'例:2006/11/5'
                    ]) !!}</td>
            </tr>
        @endfor

        @for ($i = 1; $i <= 5; $i++)
            <tr>
                <td>奉仕歴({{ $i }}) @if ($i == 1)
                        最新のものから順に直近5年
                    @endif
                </td>
                <td>役務:{!! Form::text("service_hist{$i}_role", null, [
                    'class' => 'form-control uk-form-width-medium',
                    'placeholder' => '例:カブ副長',
                ]) !!}<br>
                    期間:{!! Form::text("service_hist{$i}_term", null, [
                        'class' => 'form-control uk-form-width-large',
                        'placeholder' => '例: 2019/4/1〜2020/3/31',
                    ]) !!}
                    @error("service_hist{$i}_role")
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                    @error("service_hist{$i}_term")
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                </td>
            </tr>
        @endfor

        <tr>
            <td>現在治療中の病気(病名などをご記入ください)</td>
            <td>
                <label>{!! Form::checkbox('health_illness_none', 'true', null, ['class' => 'uk-checkbox']) !!} 特になし</label>
                @error('health_illness_none')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
                {!! Form::textarea('health_illness', null, [
                    'class' => 'form-control',
                    'placeholder' => '何かある場合はこちらに記入してください。特になければ↑のチェックを忘れずに!',
                ]) !!}
            </td>
        </tr>

        <tr>
            <td>健康上で不安なこと、食品アレルギーなど特記事項をご記入ください</td>
            <td>
                <label>{!! Form::checkbox('health_memo_none', 'true', null, ['class' => 'uk-checkbox']) !!} 特になし</label>
                @error('health_memo_none')
                    <div class="error text-danger">{{ $message }}</div>
                @enderror
                {!! Form::textarea('health_memo', null, [
                    'class' => 'form-control',
                    'placeholder' => '何かある場合はこちらに記入してください。特になければ↑のチェックを忘れずに!',
                ]) !!}
            </td>
        </tr>

    </table>
</div>

<script>
    // ページ読み込み時に初期値をチェック
    document.addEventListener("DOMContentLoaded", function() {
        var selectbox = document.getElementById("sc_select");
        var selectedOption = selectbox.options[selectbox.selectedIndex].value;
        if (selectedOption === "done") {
            showTextbox();
        }
    });

    function toggleTextbox() {
        var selectbox = document.getElementById("sc_select");
        var selectedOption = selectbox.options[selectbox.selectedIndex].value;

        if (selectedOption === "done") {
            showTextbox();
        } else {
            hideTextbox();
        }
    }

    function showTextbox() {
        var textboxContainer = document.getElementById("textboxContainer");
        textboxContainer.style.display = "block";
    }

    function hideTextbox() {
        var textboxContainer = document.getElementById("textboxContainer");
        textboxContainer.style.display = "none";
    }
</script>

<script>
    // セレクトボックスAの選択によってセレクトボックスBのoptionを変更する関数
    function updateDan() {
        var selectDistrict = document.getElementById("selectDistrict");
        var selectDan = document.getElementById("selectDan");
        var selectedValue = selectDistrict.value;

        // セレクトボックスBのoptionを一旦クリア
        selectDan.innerHTML = "";

        // 選択された値に応じてセレクトボックスBのoptionを追加
        if (selectedValue === "大都心") {
            selectDan.innerHTML =
                "<option value='千代田第1団'>千代田第1団</option><option value='千代田第6団'>千代田第6団</option><option value='千代田第7団'>千代田第7団</option><option value='千代田第8団'>千代田第8団</option><option value='千代田第9団'>千代田第9団</option><option value='千代田第10団'>千代田第10団</option><option value='千代田第11団'>千代田第11団</option><option value='中央第5団'>中央第5団</option><option value='中央第6団'>中央第6団</option><option value='中央第7団'>中央第7団</option><option value='中央第10団'>中央第10団</option><option value='中央第11団'>中央第11団</option><option value='港第1団'>港第1団</option><option value='港第3団'>港第3団</option><option value='港第5団'>港第5団</option><option value='港第12団'>港第12団</option><option value='港第14団'>港第14団</option><option value='港第15団'>港第15団</option><option value='港第16団'>港第16団</option><option value='港第18団'>港第18団</option><option value='新宿第1団'>新宿第1団</option><option value='新宿第2団'>新宿第2団</option><option value='新宿第4団'>新宿第4団</option><option value='新宿第8団'>新宿第8団</option><option value='新宿第9団'>新宿第9団</option><option value='新宿第17団'>新宿第17団</option><option value='新宿第18団'>新宿第18団</option>";
        } else if (selectedValue === "さくら") {
            selectDan.innerHTML =
                "<option value='台東第1団'>台東第1団</option><option value='台東第2団'>台東第2団</option><option value='台東第3団'>台東第3団</option><option value='台東第4団'>台東第4団</option><option value='台東第7団'>台東第7団</option><option value='文京第1団'>文京第1団</option><option value='文京第2団'>文京第2団</option><option value='文京第3団'>文京第3団</option><option value='文京第5団'>文京第5団</option><option value='文京第6団'>文京第6団</option><option value='荒川第1団'>荒川第1団</option><option value='荒川第2団'>荒川第2団</option><option value='荒川第6団'>荒川第6団</option><option value='足立第3団'>足立第3団</option><option value='足立第4団'>足立第4団</option><option value='足立第5団'>足立第5団</option><option value='足立第14団'>足立第14団</option>";
        } else if (selectedValue === "城東") {
            selectDan.innerHTML =
                "<option value='江戸川第1団'>江戸川第1団</option><option value='江戸川第2団'>江戸川第2団</option><option value='江戸川第3団'>江戸川第3団</option><option value='江戸川第5団'>江戸川第5団</option><option value='江戸川第7団'>江戸川第7団</option><option value='葛飾第2団'>葛飾第2団</option><option value='葛飾第3団'>葛飾第3団</option><option value='葛飾第4団'>葛飾第4団</option><option value='葛飾第5団'>葛飾第5団</option><option value='葛飾第9団'>葛飾第9団</option><option value='江東第2団'>江東第2団</option><option value='江東第3団'>江東第3団</option><option value='江東第6団'>江東第6団</option><option value='墨田第3団'>墨田第3団</option><option value='墨田第4団'>墨田第3団</option><option value='墨田第8団'>墨田第3団</option><option value='墨田第9団'>墨田第3団</option>";
        } else if (selectedValue === "山手") {
            selectDan.innerHTML =
                "<option value='目黒第1団'>目黒第1団</option><option value='目黒第3団'>目黒第3団</option><option value='目黒第6団'>目黒第6団</option><option value='目黒第7団'>目黒第7団</option><option value='目黒第8団'>目黒第8団</option><option value='目黒第9団'>目黒第9団</option><option value='目黒第15団'>目黒第15団</option><option value='渋谷第2団'>渋谷第2団</option><option value='渋谷第5団'>渋谷第5団</option><option value='渋谷第6団'>渋谷第6団</option><option value='渋谷第9団'>渋谷第9団</option><option value='渋谷第10団'>渋谷第10団</option><option value='渋谷第14団'>渋谷第14団</option>";
        } else if (selectedValue === "つばさ") {
            selectDan.innerHTML =
                "<option value='品川第1団'>品川第1団</option><option value='品川第2団'>品川第2団</option><option value='品川第6団'>品川第6団</option><option value='品川第8団'>品川第8団</option><option value='大田第1団'>大田第1団</option><option value='大田第2団'>大田第2団</option><option value='大田第3団'>大田第3団</option><option value='大田第4団'>大田第4団</option><option value='大田第6団'>大田第6団</option><option value='大田第7団'>大田第7団</option><option value='大田第11団'>大田第11団</option><option value='大田第14団'>大田第14団</option><option value='大田第15団'>大田第15団</option><option value='大田第17団'>大田第17団</option><option value='大田第18団'>大田第18団</option><option value='大田第19団'>大田第19団</option>";
        } else if (selectedValue === "城北") {
            selectDan.innerHTML =
                "<option value='豊島第1団'>豊島第1団</option><option value='豊島第4団'>豊島第4団</option><option value='豊島第6団'>豊島第6団</option><option value='豊島第7団'>豊島第7団</option><option value='豊島第8団'>豊島第8団</option><option value='豊島第9団'>豊島第9団</option><option value='豊島第17団'>豊島第17団</option><option value='北第1団'>北第1団</option><option value='北第3団'>北第3団</option><option value='北第5団'>北第5団</option><option value='北第8団'>北第8団</option><option value='北第11団'>北第11団</option><option value='板橋第2団'>板橋第2団</option><option value='板橋第3団'>板橋第3団</option><option value='板橋第4団'>板橋第4団</option><option value='板橋第5団'>板橋第5団</option><option value='板橋第7団'>板橋第7団</option><option value='板橋第9団'>板橋第9団</option><option value='板橋第10団'>板橋第10団</option><option value='板橋第11団'>板橋第11団</option><option value='板橋第15団'>板橋第15団</option>";
        } else if (selectedValue === "世田谷") {
            selectDan.innerHTML =
                "<option value='世田谷第1団'>世田谷第1団</option><option value='世田谷第2団'>世田谷第2団</option><option value='世田谷第3団'>世田谷第3団</option><option value='世田谷第4団'>世田谷第4団</option><option value='世田谷第5団'>世田谷第5団</option><option value='世田谷第6団'>世田谷第6団</option><option value='世田谷第7団'>世田谷第7団</option><option value='世田谷第8団'>世田谷第8団</option><option value='世田谷第9団'>世田谷第9団</option><option value='世田谷第10団'>世田谷第10団</option><option value='世田谷第11団'>世田谷第11団</option><option value='世田谷第12団'>世田谷第12団</option><option value='世田谷第14団'>世田谷第14団</option><option value='世田谷第15団'>世田谷第15団</option><option value='世田谷第16団'>世田谷第16団</option><option value='世田谷第19団'>世田谷第19団</option><option value='世田谷第20団'>世田谷第20団</option><option value='世田谷第22団'>世田谷第22団</option><option value='世田谷第23団'>世田谷第23団</option><option value='世田谷第24団'>世田谷第24団</option><option value='世田谷第25団'>世田谷第25団</option>";
        } else if (selectedValue === "あすなろ") {
            selectDan.innerHTML =
                "<option value='中野第3団'>中野第3団</option><option value='中野第5団'>中野第5団</option><option value='中野第8団'>中野第8団</option><option value='中野第11団'>中野第11団</option><option value='杉並第2団'>杉並第2団</option><option value='杉並第3団'>杉並第3団</option><option value='杉並第4団'>杉並第4団</option><option value='杉並第5団'>杉並第5団</option><option value='杉並第6団'>杉並第6団</option><option value='杉並第9団'>杉並第9団</option><option value='杉並第11団'>杉並第11団</option><option value='杉並第12団'>杉並第12団</option><option value='杉並第13団'>杉並第13団</option>";
        } else if (selectedValue === "練馬") {
            selectDan.innerHTML =
                "<option value='練馬第1団'>練馬第1団</option><option value='練馬第3団'>練馬第3団</option><option value='練馬第4団'>練馬第4団</option><option value='練馬第5団'>練馬第5団</option><option value='練馬第6団'>練馬第6団</option><option value='練馬第7団'>練馬第7団</option><option value='練馬第8団'>練馬第8団</option><option value='練馬第9団'>練馬第9団</option><option value='練馬第10団'>練馬第10団</option><option value='練馬第13団'>練馬第13団</option><option value='練馬第15団'>練馬第15団</option><option value='練馬第16団'>練馬第16団</option><option value='練馬第17団'>練馬第17団</option>";
        } else if (selectedValue === "多摩西") {
            selectDan.innerHTML =
                "<option value='青梅第2団'>青梅第2団</option><option value='青梅第4団'>青梅第4団</option><option value='福生第1団'>福生第1団</option><option value='福生第2団'>福生第2団</option><option value='あきる野第1団'>あきる野第1団</option><option value='瑞穂第1団'>瑞穂第1団</option><option value='羽村第1団'>羽村第1団</option><option value='八王子第1団'>八王子第1団</option><option value='八王子第2団'>八王子第2団</option><option value='八王子第5団'>八王子第5団</option><option value='八王子第6団'>八王子第6団</option><option value='八王子第7団'>八王子第7団</option><option value='八王子第11団'>八王子第11団</option><option value='八王子第12団'>八王子第12団</option><option value='八王子第13団'>八王子第13団</option>";
        } else if (selectedValue === "新多磨") {
            selectDan.innerHTML =
                "<option value='立川第3団'>立川第3団</option><option value='立川第4団'>立川第4団</option><option value='立川第6団'>立川第6団</option><option value='立川第10団'>立川第10団</option><option value='国立第1団'>国立第1団</option><option value='国立第2団'>国立第2団</option><option value='昭島第1団'>昭島第1団</option><option value='日野第2団'>日野第2団</option><option value='日野第4団'>日野第4団</option><option value='多摩第1団'>多摩第1団</option><option value='多摩第3団'>多摩第3団</option><option value='稲城第1団'>稲城第1団</option>";
        } else if (selectedValue === "南武蔵野") {
            selectDan.innerHTML =
                "<option value='武蔵野第1団'>武蔵野第1団</option><option value='三鷹第1団'>三鷹第1団</option><option value='三鷹第2団'>三鷹第2団</option><option value='三鷹第3団'>三鷹第3団</option><option value='小金井第1団'>小金井第1団</option><option value='小金井第2団'>小金井第2団</option><option value='小金井第4団'>小金井第4団</option><option value='国分寺第1団'>国分寺第1団</option><option value='国分寺第2団'>国分寺第2団</option><option value='調布第2団'>調布第2団</option><option value='調布第3団'>調布第3団</option><option value='調布第6団'>調布第6団</option><option value='調布第9団'>調布第9団</option><option value='調布第10団'>調布第10団</option><option value='狛江第1団'>狛江第1団</option><option value='狛江第3団'>狛江第3団</option><option value='狛江第5団'>狛江第5団</option><option value='府中第1団'>府中第1団</option><option value='府中第2団'>府中第2団</option><option value='府中第6団'>府中第6団</option>";
        } else if (selectedValue === "町田") {
            selectDan.innerHTML =
                "<option value='町田第1団'>町田第1団</option><option value='町田第3団'>町田第3団</option><option value='町田第6団'>町田第6団</option><option value='町田第9団'>町田第9団</option><option value='町田第13団'>町田第13団</option><option value='町田第15団'>町田第15団</option><option value='町田第16団'>町田第16団</option><option value='町田第18団'>町田第18団</option><option value='町田第20団'>町田第20団</option>";
        } else if (selectedValue === "北多摩") {
            selectDan.innerHTML =
                "<option value='東大和第1団'>東大和第1団</option><option value='東大和第2団'>東大和第2団</option><option value='東村山第6団'>東村山第6団</option><option value='小平第1団'>小平第1団</option><option value='小平第2団'>小平第2団</option><option value='小平第3団'>小平第3団</option><option value='小平第4団'>小平第4団</option><option value='小平第5団'>小平第5団</option><option value='清瀬第2団'>清瀬第2団</option><option value='東久留米第1団'>東久留米第1団</option><option value='東久留米第2団'>東久留米第2団</option><option value='西東京第1団'>西東京第1団</option><option value='西東京第2団'>西東京第2団</option>";
        }
    }

    // ページ読み込み時の処理
    window.onload = function() {
        // 保存されているデータからセレクトボックスAとBの選択を自動で設定
        var savedData = "{{ @$entryInfo->district }}";
        var selectDistrict = document.getElementById("selectDistrict");
        var selectDan = document.getElementById("selectDan");

        selectDistrict.value = savedData;
        updateDan(); // セレクトボックスBのoptionを更新
        selectDan.value = "{{ @$entryInfo->dan }}"; // 保存されているデータに応じたセレクトボックスBの選択を設定
    };
</script>
