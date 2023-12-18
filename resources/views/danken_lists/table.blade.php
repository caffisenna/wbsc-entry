<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="danken-lists-table">
            <thead>
                <tr>
                    <th>回数</th>
                    <th>主任講師</th>
                    <th>場所</th>
                    <th>開始日</th>
                    <th>終了日</th>
                    <th>締切</th>
                    <th>共有ドライブ</th>
                    <th colspan="3">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dankenLists as $dankenLists)
                    <tr>
                        <td>{{ $dankenLists->number }}</td>
                        <td>{{ $dankenLists->director }}</td>
                        <td>{{ $dankenLists->place }}</td>
                        <td>{{ $dankenLists->day_start->format('Y-m-d') }}</td>
                        <td>{{ $dankenLists->day_end->format('Y-m-d') }}</td>
                        <td>{{ $dankenLists->deadline->format('Y-m-d') }}</td>
                        <td><a href="{{ $dankenLists->drive_url }}"><span uk-icon="cloud-upload"></span></a></td>
                        <td style="width: 120px">
                            {!! Form::open(['route' => ['dankenLists.destroy', $dankenLists->id], 'method' => 'delete']) !!}
                            <div class='btn-group'>
                                <a href="{{ route('dankenLists.edit', [$dankenLists->id]) }}" class='btn btn-default btn-xs'>
                                    <i class="far fa-edit"></i>
                                </a>
                                {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'onclick' => "return confirm('削除しますか?')",
                                ]) !!}
                            </div>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">

        </div>
    </div>
</div>
