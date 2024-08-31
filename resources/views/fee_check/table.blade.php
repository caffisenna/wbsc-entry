<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">

<div class="table-responsive">
    表示はふりがな順です
    <table class="uk-table uk-table-divider" id="entryInfos-table">
        <thead>
            <tr>
                @unless ($_REQUEST['cat'] == 'danken')
                    <th>SC期数</th>
                    <th>課程別回数</th>
                @else
                    <th>団研期数</th>
                @endunless
                <th>氏名</th>
                <th>地区</th>
                <th>所属</th>
                <th>AIS委員会確認</th>
                <th>参加費確認</th>
                <th>督促</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($entryinfos as $entryinfo)
                <tr>
                    @if ($_REQUEST['cat'] == 'danken')
                        <td>団研{{ $entryinfo->danken }}期</td>
                    @else
                        @unless ($entryinfo->sc_number == 'done')
                            <td>SC{{ $entryinfo->sc_number }}期</td>
                        @else
                            <td><span class="uk-text-danger uk-text-small">課程別のみ</span></td>
                        @endunless
                        <td>{{ $entryinfo->division_number }}回</td>
                    @endif
                    @if ($_REQUEST['cat'] == 'sc' || $_REQUEST['cat'] == 'danken')
                        @if (isset($entryinfo->cancel))
                            <td bgcolor="#ccc" uk-tooltip="{{ $entryinfo->cancel }}">
                                <span class="uk-text-danger">[欠]{{ $entryinfo->user->name }}<br>
                                    <span class=" uk-text-small">{{ $entryinfo->furigana }}</span>
                            </td>
                        @else
                            <td>
                                {{ $entryinfo->user->name }}<br><span
                                    class=" uk-text-small">{{ $entryinfo->furigana }}</span>
                            </td>
                        @endif
                    @else
                        @if ($entryinfo->cancel_div)
                            <td bgcolor="#ccc" uk-tooltip="{{ $entryinfo->cancel_div }}">
                                <span class="uk-text-danger">[欠]{{ $entryinfo->user->name }}<br>
                                    <span class=" uk-text-small">{{ $entryinfo->furigana }}</span>
                            </td>
                        @else
                            <td>
                                {{ $entryinfo->user->name }}<br><span
                                    class=" uk-text-small">{{ $entryinfo->furigana }}</span>
                            </td>
                        @endif
                    @endif
                    <td>{{ $entryinfo->district }}</td>
                    <td>{{ $entryinfo->dan }}</td>
                    <td>
                        @if (isset($entryinfo->ais_checked_at))
                            済
                        @endif
                    </td>
                    <td>
                        @if (isset($entryinfo->{$_REQUEST['cat'] . '_fee_checked_at'}))
                            <span class="uk-small">{{ $entryinfo->{$_REQUEST['cat'] . '_fee_checked_at'} }}</span>
                            <br>
                            <a href="{{ route('resetFeeCheckDate', ['uuid' => $entryinfo->uuid, 'cat' => $_REQUEST['cat']]) }}"
                                onclick="return confirm('{{ $entryinfo->user->name }}さんの入金記録を取り消しますか?')">
                                <span uk-icon="icon: ban" class="uk-text-danger"></span>
                            </a>
                        @else
                            <a href="{{ route('fee_check', ['id' => $entryinfo->id, 'cat' => $_REQUEST['cat']]) }}"
                                class=" uk-button uk-button-primary uk-button-small"
                                onclick="return confirm('{{ $entryinfo->user->name }}さんの入金をチェックしますか?')">確認</a>
                        @endif
                    </td>
                    <td>
                        @php
                            $cat = $_REQUEST['cat'];
                            $fee_checked_at = $entryinfo->{$cat . '_fee_checked_at'};
                        @endphp

                        @if (empty($fee_checked_at))
                            <a href="{{ route('sendReminderEmailForFee', ['uuid' => $entryinfo->uuid, 'cat' => $cat]) }}"
                                class="uk-text-warning">
                                <span uk-icon="icon: mail; ratio:2"
                                    onclick="return confirm('{{ $entryinfo->user->name }}さんに督促メールを送信します?')"></span>
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<script>
    let table = new DataTable('#entryInfos-table');
</script>
