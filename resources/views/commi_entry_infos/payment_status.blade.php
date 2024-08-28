@extends('layouts.app')
{{-- {{ dd($users) }} --}}
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>参加費納入状況</h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix">事務局での入金確認状況</div>

        <table class="uk-table uk-table-striped uk-table-small">
            <thead>
                <tr>
                    <th>氏名</th>
                    <th>コース</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->user->name }}
                            @if ($user->cancel !== null || $user->cancel_div !== null)
                                <span class="uk-text-danger">[欠席]</span>
                            @endif
                            <br>
                            <span class="uk-text-small">{{ $user->dan }}</span>
                        </td>
                        <td>
                            @if ($user->sc_number !== null)
                                @if ($user->sc_number !== 'done')
                                    SC{{ $user->sc_number }}期:
                                    @if ($user->sc_fee_checked_at !== null)
                                        {{ $user->sc_fee_checked_at }}
                                    @else
                                        <span class="uk-text-danger">未納</span>
                                    @endif
                                @else
                                    SC修了済み
                                @endif
                                <br>
                            @endif
                            @if ($user->division_number !== null)
                                {{ $user->division_number }}回:
                                @if ($user->div_fee_checked_at !== null)
                                    {{ $user->div_fee_checked_at }}
                                @else
                                    <span class="uk-text-danger">未納</span>
                                @endif
                                <br>
                            @endif
                            @if ($user->danken !== null)
                                団研{{ $user->danken }}期:
                                @if ($user->danken_fee_checked_at !== null)
                                    {{ $user->danken_fee_checked_at }}
                                @else
                                    <span class="uk-text-danger">未納</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
