<div class="table-responsive">
    <table class="uk-table uk-table-divider uk-table-small" id="entryInfos-table">
        <thead>
            <tr>
                <th>氏名</th>
                <th>参加</th>
                <th>トレーナー認定</th>
                <th>課題認定者</th>
                <th>団委員長</th>
                <th>地区コミ</th>
                <th>AIS委員会</th>
                <th>申込書</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($entryInfos as $entryInfo)
                {{-- 申込情報がブランクなら無視 --}}
                @if (isset($entryInfo->entry_info))
                    <tr>
                        <td><a
                                href="{{ route('commi_entryInfos.show', [$entryInfo->id]) }}">{{ $entryInfo->name }}</a><br>
                            {{ $entryInfo->entry_info->dan }}
                        </td>
                        <td>{{ $entryInfo->entry_info->sc_number }}期<br>
                            {{ $entryInfo->entry_info->division_number }}回</td>
                        @if (empty($entryInfo->entry_info->trainer_sc_checked_at) ||
                                empty($entryInfo->entry_info->trainer_sc_name) ||
                                empty($entryInfo->entry_info->trainer_division_checked_at) ||
                                empty($entryInfo->entry_info->trainer_division_name))
                            <td>
                                <a href="{{ url('/commi/trainer_request?id=') }}{{ $entryInfo->entry_info->uuid }}"
                                    uk-toggle class="uk-link uk-button uk-button-primary uk-button-small">認定依頼</a>
                            </td>
                        @else
                            <td>
                                <span class="uk-text-success">認定済み</span>
                            </td>
                        @endif
                        <td>
                            SC:{{ $entryInfo->entry_info->trainer_sc_name }}<br>
                            課程別:{{ $entryInfo->entry_info->trainer_division_name }}
                        </td>
                        <td>
                            @if (isset($entryInfo->entry_info->gm_checked_at))
                                {{ $entryInfo->entry_info->gm_checked_at->format('Y-m-d') }}
                            @else
                                未承認
                            @endif
                        </td>
                        <td>
                            @if (isset($entryInfo->entry_info->commi_checked_at))
                                {{ $entryInfo->entry_info->commi_checked_at->format('Y-m-d') }}
                            @else
                                <a href="{{ url('/commi/commi_check/?id=') }}{{ $entryInfo->entry_info->id }}"
                                    class=" uk-button uk-button-primary uk-button-small"
                                    onclick="return confirm('{{ $entryInfo->name }}さんを承認しますか?')">承認する</a>
                            @endif
                        </td>
                        <td>
                            @if (isset($entryInfo->entry_info->ais_checked_at))
                                {{ $entryInfo->entry_info->ais_checked_at->format('Y-m-d') }}
                            @else
                                未承認
                            @endif
                        </td>
                        <td>
                            <div class='btn-group'>
                                <a href="{{ url('/commi/pdf/?id=') }}{{ $entryInfo->entry_info->user_id }}"
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
