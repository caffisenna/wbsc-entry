    <div class="table-responsive">
        <table class="uk-table uk-table-divider" id="entryInfos-table">
            <thead>
                <tr>
                    <th>SC期数</th>
                    <th>課程別期数</th>
                    <th>確認</th>
                    <th>課題提出</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $entryInfo->sc_number }}</td>
                    <td>{{ $entryInfo->division_number }}</td>
                    <td>
                        @if (isset($entryInfo->gm_checked_at))
                            団:{{ $entryInfo->gm_checked_at->format('Y-m-d') }}<br>
                        @else
                            団:未<br>
                        @endif

                        @if (isset($entryInfo->commi_checked_at))
                            地区:{{ $entryInfo->commi_checked_at->format('Y-m-d') }}<br>
                        @else
                            地区:未<br>
                        @endif

                        @if (isset($entryInfo->ais_checked_at))
                            AIS:{{ $entryInfo->ais_checked_at->format('Y-m-d') }}
                        @else
                            AIS:未<br>
                        @endif
                    </td>
                    <td>
                        <ul class="uk-list">
                            @if ($entryInfo->assignment_sc == 'up')
                                <li><a href="/storage/assignment/sc/{{ $entryInfo->uuid }}.pdf">SC課題表示</a></li>
                            @else
                                <li><a href="/user/upload/?uuid={{ $entryInfo->uuid }}&q=sc"
                                        class="uk-button uk-button-default uk-button-small uk-width-1-1"
                                        uk-icon="icon: upload">スカウトコース</a></li>
                            @endif
                            @if ($entryInfo->assignment_division == 'up')
                                <li><a href="/storage/assignment/division/{{ $entryInfo->uuid }}.pdf">課程別研修表示</a></li>
                            @else
                                <li><a href="/user/upload/?uuid={{ $entryInfo->uuid }}&q=division"
                                        class="uk-button uk-button-default uk-button-small uk-width-1-1"
                                        uk-icon="icon: upload">課程別</a></li>
                            @endif
                        </ul>
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
