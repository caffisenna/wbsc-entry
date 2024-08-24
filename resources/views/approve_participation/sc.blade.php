@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>スカウトコース{{ $_REQUEST['number'] }}期 参加認定</h2>
        <h3>注意</h3>
            <ul class="uk-list uk-list-bullet">
                <li>スカウトコース/団研の欠席情報がある参加者はリストに出ません</li>
                <li>承認すると参加者と団委員長(メールアドレスがある場合)に通知メールが送信されます</li>
                <li>承認もしくは否認を取り消す際は参加者には通知されません</li>
            </ul>
        <div class="row">
            @include('flash::message')
            <table class="uk-table uk-table-divider uk-table-small">
                <tr>
                    <th>NO</th>
                    <th>氏名</th>
                    <th>役務</th>
                    <th>BS講習会/スカキャン</th>
                    <th>主な研修歴</th>
                    <th>課題</th>
                </tr>
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
                    <tr class="uk-text-small">
                        <td>{{ $total_number }}</td>
                        <td><a href="{{ route('admin_entryInfos.show', $member->uuid) }}">{{ $member->user->name }}</a>
                            ({{ $age }}才)
                            <br>
                            @if (empty($member->sc_accepted_at) && empty($member->sc_rejected_at))
                                <a href="{{ route('accept', ['cat' => 'sc', 'flag' => 'accept', 'uuid' => $member->uuid]) }}"
                                    class="uk-button uk-button-primary"
                                    onclick="return confirm('{{ $member->user->name }}さんのスカウトコースの参加を承認しますか?')">承認</a>
                                <a href="{{ route('accept', ['cat' => 'sc', 'flag' => 'reject', 'uuid' => $member->uuid]) }}"
                                    class="uk-button uk-button-danger"
                                    onclick="return confirm('{{ $member->user->name }}さんのスカウトコースの参加を否認しますか?')">否認</a>
                            @else
                                @isset($member->sc_accepted_at)
                                    {{ $member->sc_accepted_at }} 参加承認済み
                                @endisset
                                @isset($member->sc_rejected_at)
                                    {{ $member->sc_rejected_at }} <span class="uk-text-danger">参加否認済み</span>
                                @endisset
                                <a href="{{ route('accept', ['cat' => 'sc', 'revert' => 'true', 'uuid' => $member->uuid]) }}"
                                    class="uk-button uk-button-danger"
                                    onclick="return confirm('{{ $member->user->name }}さんのスカウトコースの参加承認・否認を初期化しますか?')">承認・否認クリアー</a>
                            @endif
                        </td>
                        <td>{{ $member->district }} {{ $member->dan }}<br>
                            {{ $member->troop }} {{ $member->troop_role }}</td>
                        <td>【講習会】 {{ $member->bs_basic_course }}<br>
                            【スカキャン】 {{ $member->scout_camp }}</td>
                        <td>{{ $member->wb_basic1_category }}<br>
                            {{ $member->wb_basic1_number }}</td>
                        <td>
                            {!! $member->assignment_sc
                                ? '<span class="uk-text-success">UP済み</span>'
                                : '<span class="uk-text-warning">未UP</span>' !!}<br>
                            {!! $member->trainer_sc_checked_at
                                ? '<span class="uk-text-success">認定済み</span>'
                                : '<span class="uk-text-warning">未認定</span>' !!}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
