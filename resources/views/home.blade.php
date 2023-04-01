@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @isset($count)
                <h2>スカウトコース申込状況</h2>
                <table class="uk-table uk-table-divider uk-table-striped">
                    <tr>
                        <th>期数</th>
                        <th>人数</th>
                    </tr>
                    @foreach ($count as $val)
                        <tr>
                            <td>{{ $val->sc_number }}</td>
                            <td>{{ $val->count_sc_number }}</td>
                        </tr>
                    @endforeach
                </table>

                <h2>課程別研修申込状況</h2>
                <table class="uk-table uk-table-divider uk-table-striped">
                    <tr>
                        <th>回数</th>
                        <th>人数</th>
                    </tr>
                    @foreach ($div_count as $val)
                        <tr>
                            <td>{{ $val->division_number }}</td>
                            <td>{{ $val->count_division_number }}</td>
                        </tr>
                    @endforeach
                </table>
            @endisset
        </div>
    </div>
@endsection
