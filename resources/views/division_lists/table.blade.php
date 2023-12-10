<div class="table-responsive">
    <table class="uk-table uk-table-divider uk-table-striped" id="divisionLists-table">
        <thead>
            <tr>
                <th>課程</th>
                <th>回数</th>
                <th>主任所員</th>
                <th>場所</th>
                <th>開催日</th>
                <th>申込締切</th>
                <th>ドライブ</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($divisionLists as $divisionList)
                <tr>
                    <td>{{ $divisionList->division }}</td>
                    <td>{{ $divisionList->number }}</td>
                    <td>{{ $divisionList->director }}</td>
                    <td>{{ $divisionList->place }}</td>
                    <td>{{ $divisionList->day_start->format('Y-m-d') }}</td>
                    <td>{{ $divisionList->deadline->format('Y-m-d') }}</td>
                    <td><a href="{{ $divisionList->drive_url }}"><span uk-icon="cloud-upload"></span></a></td>
                    <td width="120">
                        {!! Form::open(['route' => ['divisionLists.destroy', $divisionList->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('divisionLists.edit', [$divisionList->id]) }}"
                                class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-xs',
                                'onclick' => "return confirm('Are you sure?')",
                            ]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
