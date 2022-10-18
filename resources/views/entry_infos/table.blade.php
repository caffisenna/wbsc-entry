    <div class="table-responsive">
        <table class="uk-table uk-table-divider" id="entryInfos-table">
            <thead>
                <tr>
                    <th>SC期数</th>
                    <th>課程別期数</th>
                    <th>団委員長確認</th>
                    <th>地区コミ確認</th>
                    <th>委員会確認</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $entryInfo->sc_number }}</td>
                    <td>{{ $entryInfo->division_number }}</td>
                    <td>
                        @if (isset($entryInfo->gm_checked_at))
                            {{ $entryInfo->gm_checked_at->format('Y-m-d') }}
                        @endif
                    </td>
                    <td>
                        @if (isset($entryInfo->commi_checked_at))
                            {{ $entryInfo->commi_checked_at->format('Y-m-d') }}
                        @endif
                    </td>
                    <td>
                        @if (isset($entryInfo->ais_checked_at))
                            {{ $entryInfo->ais_checked_at->format('Y-m-d') }}
                        @endif
                    </td>
                    <td width="120">
                        {!! Form::open(['route' => ['entryInfos.destroy', $entryInfo->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ url('/user/pdf') }}" class='btn btn-default'>
                                <span uk-icon="download"></span>PDF
                            </a>
                            <a href="{{ route('entryInfos.show', [$entryInfo->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('entryInfos.edit', [$entryInfo->id]) }}" class='btn btn-default btn-xs'>
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
            </tbody>
        </table>
    </div>
