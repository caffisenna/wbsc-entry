    <div class="table-responsive">
        <table class="uk-table uk-table-divider" id="entryInfos-table">
            <tr>
                <th>SC期数</th>
                <td>{{ $entryInfo->sc_number }}</td>
            </tr>
            <tr>
                <th>課程別回数</th>
                <td>{{ $entryInfo->division_number }}</td>
            </tr>
            <tr>
                <th>課題提出</th>
                <td>
                    <ul class="uk-list">
                        @if ($entryInfo->assignment_sc == 'up')
                            <li><a href="/storage/assignment/sc/{{ $entryInfo->uuid }}.pdf">スカウトコース課題 アップロード済み</a></li>
                        @else
                            <li><a href="/user/upload/?uuid={{ $entryInfo->uuid }}&q=sc"
                                    class="uk-button uk-button-default uk-button-small uk-width-1-2"
                                    uk-icon="icon: upload">スカウトコース</a></li>
                        @endif
                        @if ($entryInfo->assignment_division == 'up')
                            <li><a href="/storage/assignment/division/{{ $entryInfo->uuid }}.pdf">課程別研修課題 アップロード済み</a></li>
                        @else
                            <li><a href="/user/upload/?uuid={{ $entryInfo->uuid }}&q=division"
                                    class="uk-button uk-button-default uk-button-small uk-width-1-2"
                                    uk-icon="icon: upload">課程別</a></li>
                        @endif
                    </ul>
                </td>
            </tr>
            <tr>
                <th>団認定</th>
                <td>
                    @if (isset($entryInfo->gm_checked_at))
                        {{ $entryInfo->gm_checked_at->format('Y-m-d') }}
                    @else
                        <span class="uk-text-danger">未認定</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>地区認定</th>
                <td>
                    @if (isset($entryInfo->commi_checked_at))
                        {{ $entryInfo->commi_checked_at->format('Y-m-d') }}
                    @else
                        <span class="uk-text-danger">未認定</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>AIS委員会認定</th>
                <td>
                    @if (isset($entryInfo->ais_checked_at))
                        {{ $entryInfo->ais_checked_at->format('Y-m-d') }}
                    @else
                        <span class="uk-text-danger">未認定</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>操作</th>
                <td>
                    <div class='btn-group'>
                        <a href="{{ url('/user/pdf') }}" class='btn btn-default'>
                            <span uk-icon="download"></span>PDF
                        </a>
                        <a href="{{ route('entryInfos.show', [$entryInfo->id]) }}"
                            class='uk-button uk-button-default uk-button-small'>
                            確認
                        </a>
                        <a href="{{ route('entryInfos.edit', [$entryInfo->id]) }}"
                            class='uk-button uk-button-default uk-button-small'><span
                                uk-icon="icon: file-edit"></span></a>
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        </table>
    </div>
