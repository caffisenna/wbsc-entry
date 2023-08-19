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
            {{-- 年齢を計算 --}}
            @php
                $birthday = $val->birthday;
                $currentDate = now();
                $age = $currentDate->diff($birthday)->y + $currentDate->diff($birthday)->m / 12;
                $age = number_format($age, 1); // 少数第一位までフォーマット
            @endphp
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
                <td>{{ $val->gender }}</td>
                <td>{{ $val->birthday }}</td>
                <td>{{ $age }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
