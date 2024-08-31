<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="updates-table">
            <thead>
                <tr>
                    <th>掲載日</th>
                    <th>更新内容</th>
                    @if (Auth::user()->is_admin == 1 && empty(Auth::user()->is_ais))
                        <th colspan="3">操作</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($updates as $update)
                    <tr>
                        <td class="uk-table-shrink uk-text-nowrap uk-text-small">{{ $update->created_at->format('Y-m-d') }}</td>
                        <td class="uk-table-expand">{!! $update->updates_body !!}</td>
                        @if (Auth::user()->is_admin == 1 && empty(Auth::user()->is_ais))
                            <td>
                                {!! Form::open(['route' => ['updates.destroy', $update->id], 'method' => 'delete']) !!}
                                <div class='btn-group'>
                                    <a href="{{ route('updates.edit', [$update->id]) }}" class='btn btn-default btn-xs'>
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
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $updates])
        </div>
    </div>
</div>
