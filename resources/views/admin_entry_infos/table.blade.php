<div class="table-responsive">
    <table class="uk-table uk-table-divider" id="entryInfos-table">
        <thead>
            <tr>
                <th>氏名</th>
                <th>SC期数</th>
                <th>課程別期数</th>
                <th>団委員長確認</th>
                <th>地区コミ確認</th>
                <th>委員会確認</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($entryInfos as $entryInfo)
            {{-- 申込情報がブランクなら無視 --}}
                @if (isset($entryInfo->entry_info))
                    <tr>
                        <td>{{ $entryInfo->name }}</td>
                        <td>{{ $entryInfo->entry_info->sc_number }}</td>
                        <td>{{ $entryInfo->entry_info->division_number }}</td>
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
                                未承認
                            @endif
                        </td>
                        <td>
                            @if (isset($entryInfo->entry_info->ais_checked_at))
                                {{ $entryInfo->entry_info->ais_checked_at->format('Y-m-d') }}
                            @else
                                <a href="#" class=" uk-button uk-button-primary">承認する</a>
                            @endif
                        </td>
                        <td width="120">
                            {!! Form::open(['route' => ['admin_entryInfos.destroy', $entryInfo->id], 'method' => 'delete']) !!}
                            <div class='btn-group'>
                                <a href="{{ url('/admin/pdf/?id=') }}{{ $entryInfo->entry_info->user_id }}"
                                    class='btn btn-default'>
                                    <span uk-icon="download"></span>PDF
                                </a>
                                <a href="{{ route('admin_entryInfos.show', [$entryInfo->id]) }}"
                                    class='btn btn-default btn-xs'>
                                    <i class="far fa-eye"></i>
                                </a>
                                <a href="{{ route('admin_entryInfos.edit', [$entryInfo->id]) }}"
                                    class='btn btn-default btn-xs'>
                                    <i class="far fa-edit"></i>
                                </a>
                                {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'onclick' => "return confirm('本当に削除しますか?')",
                                ]) !!}
                            </div>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
