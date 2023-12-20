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
                @if ($val->danken)
                    <td>団研{{ $val->danken }}期</td>
                @elseif($val->sc_number)
                    <td>SC{{ $val->sc_number }}期</td>
                @elseif($val->division_number)
                    <td>課程別{{ $val->division_number }}回</td>
                @endif
                <td>{{ $val->user->name }}</td>
                <td>{{ $val->dan }}</td>
                <td>{{ $val->district }}</td>
                <td>{{ $val->troop }}</td>
                <td>{{ $val->troop_role }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
