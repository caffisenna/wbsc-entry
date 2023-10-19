<link rel="stylesheet" type="text/css" href="{{ url('/datatables/jquery.dataTables.css') }}">
<script type="text/javascript" charset="utf8" src="{{ url('/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ url('/datatables/dataTables.fixedHeader.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#entryInfos-table thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#entryInfos-table thead');

        var table = $('#entryInfos-table').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            initComplete: function() {
                var api = this.api();

                // For each column
                api
                    .columns()
                    .eq(0)
                    .each(function(colIdx) {
                        // Set the header cell to contain the input element
                        var cell = $('.filters th').eq(
                            $(api.column(colIdx).header()).index()
                        );
                        var title = $(cell).text();
                        $(cell).html('<input type="text" placeholder="' + title +
                            '" style="width:60px" />');

                        // On every keypress in this input
                        $(
                                'input',
                                $('.filters th').eq($(api.column(colIdx).header()).index())
                            )
                            .off('keyup change')
                            .on('keyup change', function(e) {
                                e.stopPropagation();

                                // Get the search value
                                $(this).attr('title', $(this).val());
                                var regexr =
                                    '({search})'; //$(this).parents('th').find('select').val();

                                var cursorPosition = this.selectionStart;
                                // Search the column for that value
                                api
                                    .column(colIdx)
                                    .search(
                                        this.value != '' ?
                                        regexr.replace('{search}', '(((' + this.value +
                                            ')))') :
                                        '',
                                        this.value != '',
                                        this.value == ''
                                    )
                                    .draw();

                                $(this)
                                    .focus()[0]
                                    .setSelectionRange(cursorPosition, cursorPosition);
                            });
                    });
            },
        });
    });
</script>
<div class="table-responsive">
    表示はふりがな順です
    <table class="uk-table uk-table-divider" id="entryInfos-table">
        <thead>
            <tr>
                <th>SC期数</th>
                <th>課程別回数</th>
                <th>氏名</th>
                <th>地区</th>
                <th>所属</th>
                <th>AIS委員会確認</th>
                <th>参加費確認</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($entryinfos as $entryinfo)
                <tr>
                    @unless ($entryinfo->sc_number == 'done')
                        <td>SC{{ $entryinfo->sc_number }}期</td>
                    @else
                        <td><span class="uk-text-danger uk-text-small">課程別のみ</span></td>
                    @endunless

                    <td>{{ $entryinfo->division_number }}回</td>
                    <td>{{ $entryinfo->user->name }}<br><span class=" uk-text-small">{{ $entryinfo->furigana }}</span>
                    </td>
                    <td>{{ $entryinfo->district }}</td>
                    <td>{{ $entryinfo->dan }}</td>
                    <td>
                        @if (isset($entryinfo->ais_checked_at))
                            済
                        @endif
                    </td>
                    <td>
                        @if ($_REQUEST['cat'] == 'sc' && isset($entryinfo->sc_fee_checked_at))
                            <span class="uk-small">{{ $entryinfo->sc_fee_checked_at }}</span>
                        @elseif ($_REQUEST['cat'] == 'div' && isset($entryinfo->div_fee_checked_at))
                            <span class="uk-small">{{ $entryinfo->div_fee_checked_at }}</span>
                        @else
                            <a href="{{ url('/admin/fee_check/?id=') }}{{ $entryinfo->id }}&cat={{ $_REQUEST['cat'] }}"
                                class=" uk-button uk-button-primary"
                                onclick="return confirm('{{ $entryinfo->user->name }}さんの入金をチェックします?')">入金確認</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#entryInfos-table').DataTable();
    });
</script>
