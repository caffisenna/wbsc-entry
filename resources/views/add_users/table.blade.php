<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="add_users-table">
            <thead>
                <tr>
                    <th>氏名</th>
                    <th>Email</th>
                    <th>種別</th>
                    <th>password</th>
                    <th colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($addUsers as $addUser)
                    @unless ($addUser->email == 'caffi.senna@gmail.com')
                        <tr>
                            <td>{{ $addUser->name }}</td>
                            <td>{{ $addUser->email }}</td>
                            <td>{{ $addUser->role }}</td>
                            <td><a href="{{ url("/admin/add_users/password_reset?id=$addUser->id") }}"
                                    class="uk-button uk-button-primary uk-button-small">reset</a></td>
                            <td style="width: 120px">
                                {!! Form::open(['route' => ['add_users.destroy', $addUser->id], 'method' => 'delete']) !!}
                                <div class='btn-group'>
                                    <a href="{{ route('add_users.edit', [$addUser->id]) }}" class='btn btn-default btn-xs'>
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
                    @endunless
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
