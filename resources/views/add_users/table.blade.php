<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="add_users-table">
            <thead>
                <tr>
                    <th>氏名</th>
                    <th>Email</th>
                    <th>種別</th>
                    <th>地区</th>
                    <th colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($addUsers as $addUser)
                    <tr>
                        <td>{{ $addUser->name }}</td>
                        <td>{{ $addUser->email }}</td>
                        <td>{{ $addUser->role }}</td>
                        <td>{{ $addUser->district }}</td>
                        <td style="width: 120px">
                            {!! Form::open(['route' => ['add_users.destroy', $addUser->id], 'method' => 'delete']) !!}
                            <div class='btn-group'>
                                <a href="{{ route('add_users.edit', [$addUser->id]) }}" class='btn btn-default btn-xs'>
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

    <div class="card-footer clearfix">
        <div class="float-right">
            {{-- @include('adminlte-templates::common.paginate', ['records' => $addUsers]) --}}
        </div>
    </div>
</div>
