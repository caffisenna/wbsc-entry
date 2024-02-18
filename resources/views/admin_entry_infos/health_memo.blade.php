@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-10">
                    <h1>健康情報入力者</h1>
                </div>
                <div class="col-sm-8">
                    {{-- フィルター用にSC期数を表示 --}}
                    <span uk-icon="database"></span>絞り込み:
                    @foreach ($uniqueScNumbers as $sc_number)
                        <a href="{{ route('health_memo', ['sc_number' => $sc_number]) }}"
                            class="uk-button uk-button-primary">SC{{ $sc_number }}期</a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        <div class="table-responsive">
            <div class="uk-overflow-auto">
                <table class="uk-table uk-table-divider uk-table-striped uk-table-small" id="entryInfos-table">
                    <thead>
                        <tr>
                            <th>氏名/所属</th>
                            <th>健康情報</th>
                            <th>アレルギー</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entryinfos as $entryinfo)
                            @php
                                $birthday = $entryinfo->entry_Info->birthday;
                                $currentDate = now();
                                $age = $currentDate->diff($birthday)->y + $currentDate->diff($birthday)->m / 12;
                                $age = number_format($age, 1); // 少数第一位までフォーマット
                            @endphp
                            <tr>
                                <td class="uk-table-expand">
                                    <a href="{{ route('admin_entryInfos.show', [$entryinfo->user_id]) }}"
                                        class="uk-link">{{ $entryinfo->user->name }}</a><br>
                                    SC{{ $entryinfo->entry_Info->sc_number }}期<br>
                                    年齢: {{ $age }} 歳<br>
                                    <span class="uk-text-small">{{ $entryinfo->entry_Info->district }}地区<br>
                                        {{ $entryinfo->entry_Info->dan }}<br>
                                        {{ $entryinfo->entry_Info->troop }}<br>
                                        {{ $entryinfo->entry_Info->troop_role }}
                                    </span>
                                </td>
                                <td>
                                    <dl class="uk-description-list uk-description-list-divider">
                                        @if ($entryinfo->treating_disease)
                                            <dt>治療中の病気</dt>
                                            <dd>{{ $entryinfo->treating_disease }}</dd>
                                        @endif
                                        @if ($entryinfo->carried_medications)
                                            <dt>携行持薬</dt>
                                            <dd>{{ $entryinfo->carried_medications }}</dd>
                                        @endif
                                        @if ($entryinfo->health_status_last_3_months)
                                            <dt>直近3ヶ月</dt>
                                            <dd>{{ $entryinfo->health_status_last_3_months }}
                                            </dd>
                                        @endif
                                        @if ($entryinfo->recent_health_status)
                                            <dt>最近の体調</dt>
                                            <dd>{{ $entryinfo->recent_health_status == 1 ? '特に異常なし' : $entryinfo->recent_health_status }}
                                            </dd>
                                        @endif
                                        @if ($entryinfo->doctor_advice)
                                            <dt>医師の助言</dt>
                                            <dd>{{ $entryinfo->doctor_advice == 1 ? '特になし' : $entryinfo->doctor_advice }}
                                            </dd>
                                        @endif
                                        @if ($entryinfo->medical_history)
                                            <dt>病歴</dt>
                                            <dd>{{ $entryinfo->medical_history == 1 ? '特になし' : $entryinfo->medical_history }}
                                            </dd>
                                        @endif
                                    </dl>
                                </td>

                                <td>
                                    <dl class="uk-description-list uk-description-list-divider">
                                        <dt>アレルギーの有無</dt>
                                        <dd>{{ $entryinfo->food_allergies }}</dd>
                                        @if ($entryinfo->food_allergies == '食物アレルギーがある')
                                            <dt>アレルゲン</dt>
                                            <dd>{{ $entryinfo->allergen }}</dd>
                                            <dt>摂取反応</dt>
                                            <dd>{{ $entryinfo->reaction_to_allergen }}</dd>
                                            <dt>通常対応</dt>
                                            <dd>{{ $entryinfo->usual_response_to_reaction }}</dd>
                                        @endif
                                    </dl>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>

    </div>
    </div>
@endsection
