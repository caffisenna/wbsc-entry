<div class="table-responsive">
    表示はふりがな順です
    <table class="uk-table uk-table-divider" id="entryInfos-table">
        <tr>
            <th>SC期数</th>
            <th>課程別回数</th>
            <th>氏名</th>
            <th>地区</th>
            <th>所属</th>
            <th>AIS委員会認定</th>
            <th>参加費確認</th>
        </tr>
        @foreach ($entryinfos as $entryinfo)
            <tr>
                <td>SC{{ $entryinfo->sc_number }}期</td>
                <td>{{ $entryinfo->division_number }}回</td>
                <td>{{ $entryinfo->user->name }}<br><span class=" uk-text-small">{{ $entryinfo->furigana }}</span></td>
                <td>{{ $entryinfo->district }}</td>
                <td>{{ $entryinfo->dan }}</td>
                <td>
                    @if (isset($entryinfo->ais_checked_at))
                        済
                    @endif
                </td>
                <td>
                    @if (isset($entryinfo->fee_checked_at))
                        済
                    @else
                        <a href="{{ url('/admin/fee_check/?id=') }}{{ $entryinfo->id }}"
                            class=" uk-button uk-button-primary"
                            onclick="return confirm('{{ $entryinfo->user->name }}さんの入金をチェックします?')">入金確認</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</div>
