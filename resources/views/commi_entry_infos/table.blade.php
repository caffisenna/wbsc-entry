<div class="table-responsive">
    <table class="uk-table uk-table-divider uk-table-small" id="entryInfos-table">
        <thead>
            <tr>
                <th>氏名</th>
                <th>写真</th>
                <th>参加</th>
                <th>トレーナー認定</th>
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
                    <tr>
                        <td><a href="{{ route('commi_entryInfos.show', [$entryInfo->id]) }}">{{ $entryInfo->name }}</a>
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
                        @if (empty($entryInfo->entry_info->trainer_sc_checked_at) ||
                                empty($entryInfo->entry_info->trainer_sc_name) ||
                                empty($entryInfo->entry_info->trainer_division_checked_at) ||
                                empty($entryInfo->entry_info->trainer_division_name))
                            <td>
                                <a href="{{ url('/commi/trainer_request?id=') }}{{ $entryInfo->entry_info->uuid }}"
                                    class="uk-link uk-button uk-button-primary uk-button-small">認定依頼</a>
                            </td>
                        @else
                            <td>
                                <span class="uk-text-success">認定済み</span>
                            </td>
                        @endif
                        <td>
                            @if (isset($entryInfo->entry_info->gm_checked_at))
                                {{ $entryInfo->entry_info->gm_checked_at->format('Y-m-d') }}
                            @else
                                <a href="{{ url('/commi/gm_request?id=') }}{{ $entryInfo->entry_info->uuid }}"
                                    class="uk-link uk-button uk-button-primary uk-button-small">承認依頼</a>
                            @endif
                        </td>
                        <td>
                            @if (isset($entryInfo->entry_info->commi_checked_at))
                                {{ $entryInfo->entry_info->commi_checked_at->format('Y-m-d') }}
                            @else
                                <a href="{{ url('/commi/commi_check/?id=') }}{{ $entryInfo->entry_info->id }}"
                                    class=" uk-button uk-button-primary uk-button-small"
                                    onclick="return confirm('{{ $entryInfo->name }}さんを推薦しますか?')">推薦する</a>
                            @endif
                        </td>
                        <td><a href="{{ url("/commi/commi_comment?id=$entryInfo->id") }}"
                                class="uk-button uk-button-small uk-button-primary">副申請書</a></td>
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
