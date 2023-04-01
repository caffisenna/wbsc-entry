<table>
    <thead>
        <tr>
            @foreach ($headings as $head)
                <th>{{ $head }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $val)
            <tr>

                <td>{{ $val->id }}</td>
                <td>{{ $val->sc_number }}</td>
                <td>{{ $val->division_number }}</td>
                <td>{{ $val->prefecture }}</td>
                <td>{{ $val->district }}</td>
                <td>{{ $val->dan }}</td>
                <td>{{ $val->troop }}</td>
                <td>{{ $val->troop_role }}</td>
                <td>{{ $val->user->name }}</td>
                <td>{{ $val->furigana }}</td>
                <td>{{ $val->cell_phone }}</td>
                <td>{{ $val->user->email }}</td>

            </tr>
        @endforeach
    </tbody>
</table>
