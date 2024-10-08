<style>
    .table-container {
        height: 600px;
        /* テーブルの高さを指定 */
        overflow: auto;
        /* スクロール可能にする */
    }

    .fixed-header-table {
        width: 100%;
        border-collapse: collapse;
    }

    .fixed-header-table thead {
        position: sticky;
        top: 0;
        background-color: #f8f9fa;
        /* ヘッダーの背景色 */
        z-index: 1;
    }

    .fixed-header-table th,
    .fixed-header-table td {
        border: 1px solid #dee2e6;
        padding: 8px;
        text-align: left;
    }
</style>
<div class="table-responsive">
    <div class="table-container">
        <table class="uk-table uk-table-divider uk-table-small uk-table-striped fixed-header-table" id="entryInfos-table">
            <thead>
                <tr>
                    <th>氏名</th>
                    <th>写真</th>
                    <th>参加</th>
                    <th>参加認定</th>
                    <th>年齢</th>
                    <th>研修歴</th>
                    <th>食物アレルギー</th>
                    <th>入金日</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entryInfos as $entryInfo)
                    {{-- 申込情報がブランクなら無視 --}}
                    @php
                        $birthday = $entryInfo->entry_info->birthday;
                        $currentDate = now();
                        $age = $currentDate->diff($birthday)->y + $currentDate->diff($birthday)->m / 12;
                        $age = number_format($age, 1); // 少数第一位までフォーマット
                    @endphp
                    @if (isset($entryInfo->entry_info))
                        <tr>
                            @if (isset($entryInfo->entry_info->cancel) || isset($entryInfo->entry_info->cancel_div))
                                <td bgcolor="#ccc"
                                    uk-tooltip="{{ $entryInfo->entry_info->cancel }}<br>{{ $entryInfo->entry_info->cancel_div }}">
                                @else
                                <td>
                            @endif
                            <a
                                href="{{ route('course_staff.show', [$entryInfo->entry_info->uuid]) }}">{{ $entryInfo->name }}</a>
                            @if ($entryInfo->entry_info->additional_comment)
                                <span uk-icon="comment" class="uk-text-danger"></span>
                            @endif
                            <br>
                            {{ $entryInfo->entry_info->district }} {{ $entryInfo->entry_info->dan }}<br>
                            {{ $entryInfo->entry_info->troop }} {{ $entryInfo->entry_info->troop_role }}
                            </td>
                            <td>
                                @if ($entryInfo->face_picture)
                                    <img src="{{ url('/storage/picture/') }}/{{ $entryInfo->face_picture }}"
                                        alt="" width="50px" height="">
                                @endif
                            </td>
                            <td>
                                @if ($entryInfo->entry_info->danken)
                                    {{-- 団研 --}}
                                    団研{{ $entryInfo->entry_info->danken }}期
                                @else
                                    {{-- スカウトコース --}}
                                    @if ($entryInfo->entry_info->sc_number == 'done')
                                        <span
                                            class="uk-text-warning">{{ $entryInfo->entry_info->sc_number_done }}期(済)</span><br>
                                    @else
                                        SC{{ $entryInfo->entry_info->sc_number }}期<br>
                                    @endif
                                    {{-- 課程別研修 --}}
                                    @if ($entryInfo->entry_info->division_number == 'etc')
                                        <span class="uk-text-warning">それ以外</span>
                                    @else
                                        {{ $entryInfo->entry_info->division_number }}回
                                    @endif
                                @endif
                            </td>
                            <td>
                                {{-- 参加認定 --}}
                                {!! $entryInfo->entry_info->sc_accepted_at ? 'SC<span class="uk-text-success">〇</span><br>' : '' !!}
                                {!! $entryInfo->entry_info->sc_rejected_at ? 'SC<span class="uk-text-danger">×</span><br>' : '' !!}
                                {!! $entryInfo->entry_info->div_accepted_at ? '課程別<span class="uk-text-success">〇</span><br>' : '' !!}
                                {!! $entryInfo->entry_info->div_rejected_at ? '課程別<span class="uk-text-danger">×</span><br>' : '' !!}
                                {!! $entryInfo->entry_info->danken_accepted_at ? '団研<span class="uk-text-success">〇</span>' : '' !!}
                                {!! $entryInfo->entry_info->danken_rejected_at ? '団研<span class="uk-text-danger">×</span>' : '' !!}
                            </td>
                            <td>
                                {{ $age }}歳
                            </td>
                            <td>
                                @if ($entryInfo->entry_info->wb_basic1_category)
                                    {{ $entryInfo->entry_info->wb_basic1_category }}
                                @elseif ($entryInfo->entry_info->wb_adv1_category)
                                    {{ $entryInfo->entry_info->wb_adv1_category }}
                                @endif
                            </td>
                            <td>
                                @if (isset($entryInfo->health_info))
                                    {!! $entryInfo->health_info->food_allergies == '食物アレルギーがある'
                                        ? '<span class="uk-text-danger">あり</span>'
                                        : '' !!}
                                @endif
                            </td>
                            <td>
                                {{ @$entryInfo->entry_info->sc_fee_checked_at }}
                                {{ @$entryInfo->entry_info->div_fee_checked_at }}
                                {{ @$entryInfo->entry_info->danken_fee_checked_at }}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
