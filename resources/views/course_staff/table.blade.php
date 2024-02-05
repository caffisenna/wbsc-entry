<div class="table-responsive">
    <table class="uk-table uk-table-divider uk-table-small uk-table-striped" id="entryInfos-table">
        <thead>
            <tr>
                <th>氏名</th>
                <th>写真</th>
                <th>参加</th>
                <th>年齢</th>
                <th>研修歴</th>
                <th>健康</th>
                <th>申込書</th>
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
                                <img src="{{ url('/storage/picture/') }}/{{ $entryInfo->face_picture }}" alt=""
                                    width="50px" height="">
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
                            @unless ($entryInfo->entry_info->health_memo == '特になし' || $entryInfo->entry_info->health_illness == '特になし')
                                <span class="uk-text-danger uk-text-small">健康情報あり</span>
                            @else
                            @endunless
                        </td>
                        <td>
                            <div class='btn-group'>
                                <a href="{{ route('course_staff_pdf', ['id' => $entryInfo->entry_info->user_id]) }}"
                                    class='btn btn-default'>
                                    <span uk-icon="download"></span>PDF
                                </a>
                            </div>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
