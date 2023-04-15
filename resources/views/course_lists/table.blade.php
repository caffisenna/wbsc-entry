<div class="table-responsive">
    <table class="table" id="courseLists-table">
        <thead>
            <tr>
                <th>期数</th>
                <th>所長</th>
                <th>場所</th>
                <th>期間</th>
                <th>説明会</th>
                <th>締め切り</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courseLists as $courseList)
                <tr>
                    <td>{{ $courseList->number }}期</td>
                    <td>{{ $courseList->director }}</td>
                    <td>{{ $courseList->place }}</td>
                    <td>{{ $courseList->day_start->format('Y-m-d') }}<br>
                        {{ $courseList->day_end->format('Y-m-d') }}</td>
                    <td>{{ $courseList->guidance_date->format('Y-m-d') }}</td>
                    <td>{{ $courseList->deadline->format('Y-m-d') }}</td>
                    <td width="120">
                        {!! Form::open(['route' => ['courseLists.destroy', $courseList->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('courseLists.edit', [$courseList->id]) }}" class='btn btn-default btn-xs'>
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
            @endforeach
        </tbody>
    </table>
</div>
