<table>
    <thead>
        <tr>
            @foreach ($headings as $head)
                <th>{{ $head }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $val)
            {{-- 年齢を計算 --}}
            @php
                $birthday = $val->birthday;
                $currentDate = now();
                $age = $currentDate->diff($birthday)->y + $currentDate->diff($birthday)->m / 12;
                $age = number_format($age, 1); // 少数第一位までフォーマット
            @endphp
            <tr>
                <td>{{ $val->id }}</td>
                @if ($val->danken)
                    <td>団研{{ $val->danken }}</td>
                @else
                    <td>SC{{ $val->sc_number == 'done' ? '修了済み' : $val->sc_number }}</td>
                    <td>{{ $val->division_number }}</td>
                @endif
                <td>{{ $val->prefecture }}</td>
                <td>{{ $val->district }}</td>
                <td>{{ $val->dan }}</td>
                <td>{{ $val->troop }}</td>
                <td>{{ $val->troop_role }}</td>
                <td>{{ $val->user->name }}</td>
                <td>{{ $val->furigana }}</td>
                <td>{{ $val->cell_phone }}</td>
                <td>{{ $val->user->email }}</td>
                <td>{{ $val->gender }}</td>
                <td>{{ $val->birthday }}</td>
                <td>{{ $age }}</td>
                <td>{{ $val->bs_basic_course }}</td>
                <td>{{ $val->scout_camp }}</td>
                <td>
                    @if ($val->wb_basic1_category)
                        {{ $val->wb_basic1_category }} {{ $val->wb_basic1_number }} {{ $val->wb_basic1_date }}
                    @endif
                    @if ($val->wb_basic2_category)
                        <br>{{ $val->wb_basic2_category }} {{ $val->wb_basic2_number }} {{ $val->wb_basic2_date }}
                    @endif
                    @if ($val->wb_basic3_category)
                        <br>{{ $val->wb_basic3_category }} {{ $val->wb_basic3_number }} {{ $val->wb_basic3_date }}
                    @endif
                </td>
                <td>
                    @if ($val->wb_adv1_category)
                        {{ $val->wb_adv1_category }} {{ $val->wb_adv1_number }} {{ $val->wb_adv1_date }}
                    @endif
                    @if ($val->wb_adv2_category)
                        <br>{{ $val->wb_adv2_category }} {{ $val->wb_adv2_number }} {{ $val->wb_adv2_date }}
                    @endif
                    @if ($val->wb_adv3_category)
                        <br>{{ $val->wb_adv3_category }} {{ $val->wb_adv3_number }} {{ $val->wb_adv3_date }}
                    @endif
                </td>
                <td>
                    {{ $val->service_hist1_role }} {{ $val->service_hist1_term }}
                    @if ($val->service_hist2_role)
                        <br>{{ $val->service_hist2_role }} {{ $val->service_hist2_term }}
                    @endif
                    @if ($val->service_hist3_role)
                        <br>{{ $val->service_hist3_role }} {{ $val->service_hist3_term }}
                    @endif
                    @if ($val->service_hist4_role)
                        <br>{{ $val->service_hist4_role }} {{ $val->service_hist4_term }}
                    @endif
                    @if ($val->service_hist5_role)
                        <br>{{ $val->service_hist5_role }} {{ $val->service_hist5_term }}
                    @endif
                </td>
                <td>
                    @if (isset($val->health_info->treating_disease))
                        {{ $val->health_info->treating_disease == '1' ? '特になし' : $val->health_info->treating_disease }}
                    @else
                        未入力
                    @endif
                </td>
                <td>
                    @if (isset($val->health_info->health_status_last_3_months))
                        {{ $val->health_info->health_status_last_3_months }}
                    @else
                        未入力
                    @endif
                </td>
                <td>
                    @if (isset($val->health_info->recent_health_status))
                        {{ $val->health_info->recent_health_status == '1' ? '特に異常なし' : $val->health_info->recent_health_status }}
                    @else
                        未入力
                    @endif
                </td>
                <td>
                    @if (isset($val->health_info->doctor_advice))
                        {{ $val->health_info->doctor_advice == '1' ? '特になし' : $val->health_info->doctor_advice }}
                    @else
                        未入力
                    @endif
                </td>
                <td>
                    @if (isset($val->health_info->medical_history))
                        {{ $val->health_info->medical_history == '1' ? '特になし' : $val->health_info->medical_history }}
                    @else
                        未入力
                    @endif
                </td>
                <td>
                    @if (isset($val->health_info->food_allergies))
                        {{ $val->health_info->food_allergies }}
                    @else
                        未入力
                    @endif
                </td>
                <td>
                    @if (isset($val->health_info->allergen))
                        {{ $val->health_info->allergen }}
                    @else
                        未入力
                    @endif
                </td>
                <td>
                    @if (isset($val->health_info->reaction_to_allergen))
                        {{ $val->health_info->reaction_to_allergen }}
                    @else
                        未入力
                    @endif
                </td>
                <td>
                    @if (isset($val->health_info->usual_response_to_reaction))
                        {{ $val->health_info->usual_response_to_reaction }}
                    @else
                        未入力
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
