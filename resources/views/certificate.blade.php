@extends('layouts.app')

@section('content')
    <div class="container">
        @include('flash::message')
        <div class="row">
            @isset($count)
                <h2>スカウトコース 修了認定</h2>
                <table class="uk-table uk-table-divider uk-table-striped">
                    <tr>
                        <th>期数</th>
                        <th>修了認定</th>
                    </tr>
                    @foreach ($count as $val)
                        @if (isset($val->sc_number))
                            @unless ($val->sc_number == 'done')
                                <tr>
                                    <td>スカウトコース{{ $val->sc_number }} 期</td>
                                    <td>
                                        <a href="{{ url('admin/admin_entryInfos?certificate=true&q=' . $val->sc_number) }}">修了認定</a>
                                    </td>
                                </tr>
                            @endunless
                        @endif
                    @endforeach
                </table>

                <h2>課程別研修 修了認定</h2>
                <table class="uk-table uk-table-divider uk-table-striped">
                    <tr>
                        <th>回数</th>
                        <th>修了認定</th>
                    </tr>
                    @foreach ($div_count as $val)
                        <tr>
                            <td>課程別研修 {{ $val->division_number }} 回</td>
                            <td><a
                                    href="{{ url('admin/admin_entryInfos?certificate=true&div=' . $val->division_number) }}">修了認定</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endisset
        </div>
    </div>
@endsection
