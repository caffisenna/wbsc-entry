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
                    <th>SC</th>
                    <th>課程別</th>
                    <th>団委員長</th>
                    <th>トレーナー認定</th>
                    <th>地区コミ</th>
                    <th>委員会確認</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entryInfos as $entryInfo)
                    {{-- 申込情報がブランクなら無視 --}}
                    @if (isset($entryInfo->entry_info))
                        <tr>
                            <td>
                                <a href="{{ route('admin_entryInfos.show', [$entryInfo->id]) }}"
                                    class='uk-link'>{{ $entryInfo->name }}
                                    @if ($entryInfo->entry_info->additional_comment)
                                        <span uk-icon="commenting" class="uk-text-danger"></span>
                                    @endif
                                </a>
                            </td>
                            <td>{{ $entryInfo->entry_info->district }}</td>
                            <td>{{ $entryInfo->entry_info->dan }}</td>
                            <td>
                                @if ($entryInfo->entry_info->sc_number != 'done')
                                    {{ $entryInfo->entry_info->sc_number }}期<br>
                                    @if ($entryInfo->entry_info->assignment_sc)
                                        <span class=" uk-text-success">課題済</span>
                                    @else
                                        <span class=" uk-text-danger">未提出</span>
                                    @endif
                                @elseif($entryInfo->entry_info->sc_number_done)
                                    <span
                                        class="uk-text-warning">{{ $entryInfo->entry_info->sc_number_done }}<br>(修了済み)</span>
                                @endif
                            </td>
                            <td>{{ $entryInfo->entry_info->division_number }}回<br>
                                @if ($entryInfo->entry_info->assignment_division)
                                    <span class=" uk-text-success">課題済</span>
                                @else
                                    <span class=" uk-text-danger">未提出</span>
                                @endif
                            </td>
                            <td>
                                @if (isset($entryInfo->entry_info->gm_checked_at))
                                    {{ $entryInfo->entry_info->gm_checked_at->format('Y-m-d') }}
                                @else
                                    <span class=" uk-text-danger">未</span>
                                @endif
                            </td>
                            <td>
                                SC:@if (isset($entryInfo->entry_info->trainer_sc_checked_at))
                                    <span class=" uk-text-success">済</span>
                                @else
                                    <span class=" uk-text-danger">未</span>
                                @endif
                                <br>
                                課程別:@if (isset($entryInfo->entry_info->trainer_division_checked_at))
                                    <span class=" uk-text-success">済</span>
                                @else
                                    <span class=" uk-text-danger">未</span>
                                @endif
                            </td>
                            <td>
                                @if (isset($entryInfo->entry_info->commi_checked_at))
                                    {{ $entryInfo->entry_info->commi_checked_at->format('Y-m-d') }}
                                @else
                                    <span class=" uk-text-danger">未</span>
                                @endif
                            </td>
                            <td>
                                @if (isset($entryInfo->entry_info->ais_checked_at))
                                    {{ $entryInfo->entry_info->ais_checked_at->format('Y-m-d') }}
                                @else
                                    <a href="{{ url('/admin/ais_check/?id=') }}{{ $entryInfo->entry_info->id }}"
                                        class=" uk-button uk-button-primary uk-button-small"
                                        onclick="return confirm('{{ $entryInfo->name }}さん 地区AIS委員長として確認OKですか?')">確認</a>
                                @endif
                            </td>
                            <td>
                                {!! Form::open(['route' => ['admin_entryInfos.destroy', $entryInfo->entry_info->id], 'method' => 'delete']) !!}
                                <div class='btn-group'>
                                    <a href="{{ url('/admin/pdf/?id=') }}{{ $entryInfo->entry_info->user_id }}"
                                        class='uk-button uk-button-default uk-button-small'>
                                        <span uk-icon="download"></span>PDF
                                    </a>
                                    <a href="{{ route('admin_entryInfos.edit', [$entryInfo->id]) }}"
                                        class='btn btn-default'>
                                        <i class="far fa-edit"></i>
                                    </a>
                                    {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                        'type' => 'submit',
                                        'class' => 'btn btn-danger',
                                        'onclick' => "return confirm('{$entryInfo->name}さんの情報を削除しますか?')",
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
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#entryInfos-table').DataTable();
    });
</script>
