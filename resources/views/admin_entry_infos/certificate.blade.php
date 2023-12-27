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
    <div class="uk-overflow-auto">
        <table class="uk-table" id="entryInfos-table">
            <thead>
                <tr>
                    <th>氏名</th>
                    <th>地区</th>
                    <th>団</th>
                    <th>認定</th>
                    <th>非認定</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entryInfos as $entryInfo)
                    {{-- 申込情報がブランクなら無視 --}}
                    @if (isset($entryInfo->entry_info))
                        <tr>
                            @if (isset($_REQUEST['q']) || isset($_REQUEST['danken']))
                                <td
                                    @if ($entryInfo->entry_info->cancel) bgcolor="#ccc" uk-tooltip="{{ $entryInfo->entry_info->cancel }}" @endif>
                                    <a href="{{ route('admin_entryInfos.show', [$entryInfo->id]) }}" class='uk-link'>
                                        @if ($entryInfo->entry_info->cancel)
                                            <span class="uk-text-danger">[欠]</span>
                                        @endif
                                        {{ $entryInfo->name }}
                                    </a>
                                </td>
                            @elseif(isset($_REQUEST['div']))
                                <td
                                    @if ($entryInfo->entry_info->cancel_div) bgcolor="#ccc" uk-tooltip="{{ $entryInfo->entry_info->cancel_div }}" @endif>
                                    <a href="{{ route('admin_entryInfos.show', [$entryInfo->id]) }}" class='uk-link'>
                                        @if ($entryInfo->entry_info->cancel_div)
                                            <span class="uk-text-danger">[欠]</span>
                                        @endif
                                        {{ $entryInfo->name }}
                                    </a>
                                </td>
                            @endif

                            <td>{{ $entryInfo->entry_info->district }}</td>
                            <td>{{ $entryInfo->entry_info->dan }}</td>
                            {{-- 認定がpass、ngが入っていなければボタンを表示 --}}
                            @unless (
                                $entryInfo->entry_info->certification_sc ||
                                    $entryInfo->entry_info->certification_div ||
                                    $entryInfo->entry_info->certification_danken)
                                <td>
                                    {{-- 地区AIS委員長はボタンを隠す --}}
                                    @if (Auth::user()->is_ais == null)
                                        <a href="{{ url('/admin/certificate/?status=pass&uuid=') }}{{ $entryInfo->entry_info->uuid }}&cat={{ $request['cat'] }}"
                                            class='uk-button uk-button-primary uk-button-small'
                                            onclick="return confirm('{{ $entryInfo->name }}さんを認定しますか?')">
                                            <span uk-icon="check"></span>認定
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    {{-- 地区AIS委員長はボタンを隠す --}}
                                    @if (Auth::user()->is_ais == null)
                                        <a href="{{ url('/admin/certificate/?status=ng&uuid=') }}{{ $entryInfo->entry_info->uuid }}&cat={{ $request['cat'] }}"
                                            class='uk-button uk-button-danger uk-button-small'
                                            onclick="return confirm('{{ $entryInfo->name }}さんを否認しますか?')">
                                            <span uk-icon="close"></span>非認定
                                        </a>
                                    @endif
                                </td>
                            @else
                                {{-- 認定結果を表示 --}}
                                @if ($entryInfo->entry_info->certification_sc == 'pass')
                                    <td><span class="uk-text-success">認定済み</span></td>
                                    <td></td>
                                @elseif ($entryInfo->entry_info->certification_sc == 'ng')
                                    <td><span class="uk-text-danger">否認済み</span></td>
                                    <td></td>
                                @elseif ($entryInfo->entry_info->certification_div == 'pass')
                                    <td><span class="uk-text-success">認定済み</span></td>
                                    <td></td>
                                @elseif ($entryInfo->entry_info->certification_div == 'ng')
                                    <td><span class="uk-text-danger">否認済み</span></td>
                                    <td></td>
                                @elseif ($entryInfo->entry_info->certification_danken == 'pass')
                                    <td><span class="uk-text-success">認定済み</span></td>
                                    <td></td>
                                @elseif ($entryInfo->entry_info->certification_danken == 'ng')
                                    <td><span class="uk-text-danger">否認済み</span></td>
                                    <td></td>
                                @endif
                            @endunless
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#entryInfos-table').DataTable();
    });
</script>
