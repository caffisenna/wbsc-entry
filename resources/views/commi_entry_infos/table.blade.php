<div class="table-responsive">
    <table class="uk-table uk-table-divider uk-table-small" id="entryInfos-table">
        <thead>
            <tr>
                <th>氏名</th>
                <th>写真</th>
                <th>SC</th>
                <th>課程別</th>
                <th>団研</th>
                <th>トレーナー</th>
                <th>団委員長</th>
                <th>地区コミ</th>
                <th>副申請書</th>
                <th>申込書</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($entryInfos as $entryInfo)
                {{-- 申込情報がブランクなら無視 --}}
                @if (isset($entryInfo->entry_info))
                    @if ($entryInfo->entry_info->cancel)
                        <tr class="uk-text-muted">
                        @else
                        <tr>
                    @endif
                    @if (isset($entryInfo->entry_info->cancel) || isset($entryInfo->entry_info->cancel_div))
                        <td bgcolor="#ccc"
                            uk-tooltip="{{ $entryInfo->entry_info->cancel }}<br>{{ $entryInfo->entry_info->cancel_div }}">
                        @else
                        <td>
                    @endif
                    @if (isset($entryInfo->entry_info->cancel) || isset($entryInfo->entry_info->cancel_div))
                        <span class="uk-text-danger">[欠]</span>
                    @endif
                    <a href="{{ route('commi_entryInfos.show', [$entryInfo->id]) }}">{{ $entryInfo->name }}</a>
                    @if ($entryInfo->entry_info->additional_comment)
                        <span uk-icon="comment" class="uk-text-danger"></span>
                    @endif
                    <br>
                    {{ $entryInfo->entry_info->dan }}
                    </td>
                    <td>
                        @if ($entryInfo->face_picture)
                            <img src="{{ url('/storage/picture/') }}/{{ $entryInfo->face_picture }}" alt=""
                                width="50px" height="">
                        @endif
                    </td>
                    <td>
                        {{-- スカウトコース --}}
                        @if ($entryInfo->entry_info->sc_number == 'done')
                            <span class="uk-text-warning">{{ $entryInfo->entry_info->sc_number_done }}(済)</span><br>
                        @elseif($entryInfo->entry_info->sc_number)
                            SC{{ $entryInfo->entry_info->sc_number }}<br>
                            @isset($entryInfo->entry_info->trainer_sc_name)
                                <span class="uk-text-success uk-text-small">課題認定OK</span>
                            @else
                                <span class="uk-text-danger uk-text-small">課題未認定</span>
                            @endisset
                        @endif
                    </td>
                    <td>
                        {{-- 課程別研修 --}}
                        @if ($entryInfo->entry_info->division_number == 'etc')
                            <span class="uk-text-warning">それ以外</span>
                        @elseif($entryInfo->entry_info->division_number)
                            {{ $entryInfo->entry_info->division_number }}
                            @if ($entryInfo->entry_info->bvs_exception == 'on')
                                <br><span class="uk-text-small uk-text-warning">BVS特例</span>
                            @endif
                            <br>{{ $entryInfo->entry_info->trainer_division_name }}
                            {!! $entryInfo->entry_info->trainer_division_name
                                ? "<span class='uk-text-success uk-text-small'>課題認定OK</span>"
                                : "<span class='uk-text-danger uk-text-small'>課題未認定" !!}
                        @endif
                    </td>
                    <td>
                        {{-- 団研 --}}
                        @if ($entryInfo->entry_info->danken)
                            団研{{ $entryInfo->entry_info->danken }}<br>
                            @isset($entryInfo->entry_info->danken_division_name)
                                <span class="uk-text-success uk-text-small">課題認定OK</span>
                            @else
                                <span class="uk-text-danger uk-text-small">課題未認定</span>
                            @endisset
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('trainer_request', ['id' => $entryInfo->entry_info->uuid]) }}"
                            class="uk-link uk-button uk-button-primary uk-button-small">認定依頼</a>
                    </td>

                    <td>
                        @if (isset($entryInfo->entry_info->gm_checked_at))
                            {{ $entryInfo->entry_info->gm_checked_at->format('Y-m-d') }}
                        @else
                            <a href="{{ route('gm_request', ['id' => $entryInfo->entry_info->uuid]) }}"
                                class="uk-link uk-button uk-button-primary uk-button-small">承認依頼</a>
                        @endif
                    </td>
                    <td>
                        @if (isset($entryInfo->entry_info->commi_checked_at))
                            {{ $entryInfo->entry_info->commi_checked_at->format('Y-m-d') }}
                        @else
                            <a href="{{ route('commi_check', ['id' => $entryInfo->entry_info->id]) }}"
                                class=" uk-button uk-button-primary uk-button-small"
                                onclick="return confirm('{{ $entryInfo->name }}さんを推薦しますか?')">推薦</a>
                        @endif
                    </td>
                    <td><a href="{{ route('commi_comment', ['id' => $entryInfo->id]) }}"
                            class="uk-button uk-button-small uk-button-primary">副申請書</a></td>
                    <td>
                        <div class='btn-group'>
                            <a href="{{ route('commi_pdf', ['id' => $entryInfo->entry_info->user_id]) }}"
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
