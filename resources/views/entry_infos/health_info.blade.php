@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="uk-text-danger">健康情報</h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </section>

    <div class="content">

        @include('flash::message')
        @include('adminlte-templates::common.errors')
        <div class="clearfix"></div>
        <p class="uk-text">健康情報を入力してください</p>

        <div class="uk-card uk-card-default uk-card-body uk-width-1-1@m">

            <form method="POST" action="{{ route('health_info') }}">
                @csrf

                <div class="uk-form-controls uk-margin">
                    <h3>現在治療中の病気</h3>
                    <label>
                        {!! Form::checkbox('treating_disease', 1, optional($user->health_info)->treating_disease == 1, [
                            'id' => 'treating_disease_cb',
                            'class' => 'uk-checkbox',
                        ]) !!}特になし
                    </label>
                    <input type="text" name="treating_disease" class="uk-input" placeholder=""
                        value="@if ($user->health_info && $user->health_info->treating_disease) {{ $user->health_info->treating_disease }} @endif"
                        id="treating_disease">
                    @error('treating_disease')
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- <div class="form-controls uk-margin">
                    <h3>携行持薬</h3>
                    <label>
                        {!! Form::checkbox('carried_medications', 1, optional($user->health_info)->carried_medications == 1, [
                            'id' => 'carried_medications_cb',
                            'class' => 'uk-checkbox',
                        ]) !!}特になし
                    </label>
                    <input type="text" name="carried_medications" class="uk-input" placeholder=""
                        value="@if ($user->health_info && $user->health_info->carried_medications) {{ $user->health_info->carried_medications }} @endif"
                        id="carried_medications">
                </div> --}}

                <div class="form-controls uk-margin">
                    <h3>直近3ヶ月の健康状態</h3>
                    {!! Form::select(
                        'health_status_last_3_months',
                        [
                            '' => '',
                            'きわめて調子は良かった' => 'きわめて調子は良かった',
                            '特に問題は無かった' => '特に問題は無かった',
                            '病気はしたが休むほどではなかった' => '病気はしたが休むほどではなかった',
                            '病気のため休んだ' => '病気のため休んだ',
                        ],
                        $user->health_info && $user->health_info->health_status_last_3_months
                            ? $user->health_info->health_status_last_3_months
                            : null,
                        ['class' => 'form-control custom-select', 'required'],
                    ) !!}
                </div>

                <div class="form-controls uk-margin">
                    <h3>最近の体調</h3>
                    <label>
                        {!! Form::checkbox('recent_health_status', 1, optional($user->health_info)->recent_health_status == 1, [
                            'id' => 'recent_health_status_cb',
                            'class' => 'uk-checkbox',
                        ]) !!}特に異常なし
                    </label>
                    <input type="text" name="recent_health_status" class="uk-input" placeholder=""
                        value="@if ($user->health_info && $user->health_info->recent_health_status) {{ $user->health_info->recent_health_status }} @endif"
                        id="recent_health_status">
                    @error('recent_health_status')
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                </div>


                <div class="form-controls uk-margin">
                    <h3>医師からの注意</h3>
                    <label>
                        {!! Form::checkbox('doctor_advice', 1, optional($user->health_info)->doctor_advice == 1, [
                            'id' => 'doctor_advice_cb',
                            'class' => 'uk-checkbox',
                        ]) !!}特になし
                    </label>
                    {!! Form::textarea(
                        'doctor_advice',
                        $user->health_info && $user->health_info->doctor_advice ? $user->health_info->doctor_advice : null,
                        [
                            'class' => 'uk-textarea',
                            'id' => 'doctor_advice',
                        ],
                    ) !!}
                    @error('doctor_advice')
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror

                </div>

                <div class="form-controls uk-margin">
                    <h3>特記事項、過去の傷病等</h3>
                    <label>
                        {!! Form::checkbox('medical_history', 1, optional($user->health_info)->medical_history == 1, [
                            'id' => 'medical_history_cb',
                            'class' => 'uk-checkbox',
                        ]) !!}特になし
                    </label>
                    {!! Form::textarea(
                        'medical_history',
                        $user->health_info && $user->health_info->medical_history ? $user->health_info->doctor_advice : null,
                        [
                            'class' => 'uk-textarea',
                            'id' => 'medical_history',
                        ],
                    ) !!}
                    @error('medical_history')
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-controls uk-margin">
                    <h3>食物アレルギー</h3>
                    {!! Form::select(
                        'food_allergies',
                        [
                            '' => '',
                            '食物アレルギーがない' => '食物アレルギーがない',
                            '食物アレルギーがある' => '食物アレルギーがある',
                        ],
                        $user->health_info && $user->health_info->food_allergies ? $user->health_info->food_allergies : null,
                        ['class' => 'form-control custom-select', 'id' => 'food_allergies', 'required'],
                    ) !!}
                </div>

                <div id="allergies_detail">
                    <div class="form-controls uk-margin">
                        <h3>アレルゲン</h3>
                        <input type="text" id="allergen" name="allergen" class="uk-input" placeholder=""
                            value="@if ($user->health_info && $user->health_info->allergen) {{ $user->health_info->allergen }} @endif">
                    </div>
                    <div class="form-controls uk-margin">
                        <h3>アレルゲンを摂取するとどうなるか</h3>
                        {!! Form::textarea(
                            'reaction_to_allergen',
                            $user->health_info && $user->health_info->reaction_to_allergen ? $user->health_info->reaction_to_allergen : null,
                            ['class' => 'uk-textarea', 'id' => 'reaction_to_allergen'],
                        ) !!}
                    </div>
                    <div class="form-controls uk-margin">
                        <h3>アレルゲン接種後の家庭での対応</h3>
                        {!! Form::textarea(
                            'usual_response_to_reaction',
                            $user->health_info && $user->health_info->usual_response_to_reaction
                                ? $user->health_info->usual_response_to_reaction
                                : null,
                            [
                                'class' => 'uk-textarea',
                                'id' => 'usual_response_to_reaction',
                            ],
                        ) !!}
                    </div>
                </div>

                <input type="hidden" name="id" value="{{ $user->id }}">
                <input type="submit" value="登録する" class="uk-button uk-button-primary uk-width-1-1@m">
                <button class="uk-button uk-button-default uk-modal-close uk-width-1-1@m" type="button"
                    onclick="history.back()">キャンセル</button>

            </form>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            function handleCheckboxChange(checkbox, targetInput) {
                if (checkbox.prop('checked')) {
                    targetInput.val('').prop('disabled', true);
                } else {
                    targetInput.prop('disabled', false);
                }
            }

            function handleFoodAllergiesChange(selectBox, allergiesDetail) {
                var selectedOption = selectBox.val();

                if (selectedOption === '' || selectedOption === '食物アレルギーがない') {
                    allergiesDetail.hide();

                    // '食物アレルギーがない' の場合、関連するテキストボックスとテキストエリアの入力をnullに
                    $('#allergen, #reaction_to_allergen, #usual_response_to_reaction').val('');
                } else if (selectedOption === '食物アレルギーがある') {
                    allergiesDetail.show();
                }
            }

            function initializeCheckbox(checkbox, targetInput) {
                var allergiesDetail = $('#allergies_detail');
                var healthInfo = allergiesDetail.data('health-info');

                if (healthInfo !== null) {
                    handleCheckboxChange(checkbox, targetInput);
                }

                // イベントリスナーの設定
                checkbox.change(function() {
                    handleCheckboxChange(checkbox, targetInput);
                });
            }

            // treating_diseaseチェックボックスの初期化とイベントリスナーの設定
            initializeCheckbox($('#treating_disease_cb'), $('#treating_disease'));

            // carried_medicationsチェックボックスの初期化とイベントリスナーの設定
            initializeCheckbox($('#carried_medications_cb'), $('#carried_medications'));

            // doctor_adviceチェックボックスの初期化とイベントリスナーの設定
            initializeCheckbox($('#doctor_advice_cb'), $('#doctor_advice'));

            // recent_health_statusチェックボックスの初期化とイベントリスナーの設定
            initializeCheckbox($('#recent_health_status_cb'), $('#recent_health_status'));

            // medical_historyチェックボックスの初期化とイベントリスナーの設定
            initializeCheckbox($('#medical_history_cb'), $('#medical_history'));

            // food_allergiesのセレクトボックスの初期化とイベントリスナーの設定
            var foodAllergiesSelect = $('#food_allergies');
            var allergiesDetail = $('#allergies_detail');

            // 初回表示時の設定
            handleFoodAllergiesChange(foodAllergiesSelect, allergiesDetail);

            // イベントリスナーの設定
            foodAllergiesSelect.change(function() {
                handleFoodAllergiesChange(foodAllergiesSelect, allergiesDetail);
            });

            // フォームがサブミットされたときのイベントリスナー
            $('form').submit(function(event) {
                var foodAllergiesSelect = $('#food_allergies');
                var allergenInput = $('#allergen');
                var reactionInput = $('#reaction_to_allergen');
                var usualResponseInput = $('#usual_response_to_reaction');

                // '食物アレルギーがある' が選択されている場合にチェック
                if (foodAllergiesSelect.val() === '食物アレルギーがある') {
                    // テキストボックスが null の場合、アラートを表示してフォーム送信をキャンセル
                    if (allergenInput.val() === null || allergenInput.val().trim() === '') {
                        alert('アレルゲンを入力してください。');
                        event.preventDefault();
                        return;
                    }

                    if (reactionInput.val() === null || reactionInput.val().trim() === '') {
                        alert('アレルゲンを摂取するとどうなるかを入力してください。');
                        event.preventDefault();
                        return;
                    }

                    if (usualResponseInput.val() === null || usualResponseInput.val().trim() === '') {
                        alert('アレルゲン接種後の家庭での対応を入力してください。');
                        event.preventDefault();
                        return;
                    }
                }
            });
        });
    </script>
@endsection
