@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>課程別研修 {{ $_REQUEST['number'] }}回 参加認定</h2>
        <h3>注意</h3>
        <ul class="uk-list uk-list-bullet">
            <li>課程別研修の欠席情報がある参加者はリストに出ません</li>
            <li>承認すると参加者と団委員長(メールアドレスがある場合)に通知メールが送信されます</li>
            <li>承認もしくは否認を取り消す際は参加者には通知されません</li>
        </ul>
        <div class="row">
            @include('flash::message')
            <table class="uk-table uk-table-divider">
                <tr>
                    <th>NO</th>
                    <th>氏名</th>
                    <th>役務</th>
                    <th>SC修了日</th>
                    <th>課題</th>
                </tr>
                {{-- 連番設定 --}}
                @php $total_number = 0; @endphp

                @foreach ($members as $member)
                    {{-- 年齢計算 --}}
                    @php
                        $birthday = $member->birthday;
                        $currentDate = now();
                        $age = $currentDate->diff($birthday)->y + $currentDate->diff($birthday)->m / 12;
                        $age = number_format($age, 1); // 少数第一位までフォーマット
                        $total_number = $total_number + 1;
                    @endphp
                    <tr class="">
                        <td>{{ $total_number }}</td>
                        <td><a href="{{ route('admin_entryInfos.show', $member->user_id) }}">{{ $member->user->name }}</a>
                            ({{ $age }}才)
                            <br>
                            @if (empty($member->div_accepted_at) && empty($member->div_rejected_at))
                                <a href="{{ route('accept', ['cat' => 'div', 'flag' => 'accept', 'uuid' => $member->uuid]) }}"
                                    class="uk-button uk-button-primary"
                                    onclick="return confirm('{{ $member->user->name }}さんの課程別研修の参加を承認しますか?')">承認</a>
                                <a href="{{ route('accept', ['cat' => 'div', 'flag' => 'reject', 'uuid' => $member->uuid]) }}"
                                    class="uk-button uk-button-danger"
                                    onclick="return confirm('{{ $member->user->name }}さんの課程別研修の参加を否認しますか?')">否認</a>
                            @else
                                @isset($member->div_accepted_at)
                                    {{ $member->div_accepted_at }} 参加承認済み
                                @endisset
                                @isset($member->div_rejected_at)
                                    {{ $member->div_rejected_at }} <span class="uk-text-danger">参加否認済み</span>
                                @endisset
                                <a href="{{ route('accept', ['cat' => 'div', 'revert' => 'true', 'uuid' => $member->uuid]) }}"
                                    class="uk-button uk-button-danger"
                                    onclick="return confirm('{{ $member->user->name }}さんの課程別研修の参加承認・否認を初期化しますか?')">承認・否認クリアー</a>
                            @endif
                        </td>
                        <td>{{ $member->district }} {{ $member->dan }}<br>
                            {{ $member->troop }} {{ $member->troop_role }}</td>
                        <td>
                            {{-- $member->certification_sc には pass / ng が入る --}}
                            @if ($member->sc_number_done !== null)
                                {{ $member->sc_number_done }} 修了済み
                            @elseif($member->certification_sc === 'pass')
                                SC{{ $member->sc_number }}期 修了
                            @elseif($member->certification_sc === 'ng')
                                <span class="uk-text-danger">SC{{ $member->sc_number }}期 否認定</span>
                            @endif
                        </td>
                        <td>
                            {!! $member->assignment_division
                                ? '<span class="uk-text-success">UP済み</span>'
                                : '<span class="uk-text-warning">未UP</span>' !!}<br>
                            {!! $member->trainer_division_checked_at
                                ? '<span class="uk-text-success">認定済み</span>'
                                : '<span class="uk-text-warning">未認定</span>' !!}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
