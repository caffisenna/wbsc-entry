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
                        <td>{{ $user->name }}
                            @if ($user->entry_info->cancel !== null || $user->entry_info->cancel_div !== null)
                                <span class="uk-text-danger">[欠席]</span>
                            @endif
                            <br>
                            <span class="uk-text-small">{{ $user->entry_info->dan }}</span>
                        </td>
                        <td>
                            @if ($user->entry_info->sc_number !== null)
                                @if ($user->entry_info->sc_number !== 'done')
                                    SC{{ $user->entry_info->sc_number }}期:
                                    @if ($user->entry_info->sc_fee_checked_at !== null)
                                        {{ $user->entry_info->sc_fee_checked_at }}
                                    @else
                                        <span class="uk-text-danger">未納</span>
                                    @endif
                                @else
                                    SC修了済み
                                @endif
                                <br>
                            @endif
                            @if ($user->entry_info->division_number !== null)
                                {{ $user->entry_info->division_number }}回:
                                @if ($user->entry_info->div_fee_checked_at !== null)
                                    {{ $user->entry_info->div_fee_checked_at }}
                                @else
                                    <span class="uk-text-danger">未納</span>
                                @endif
                                <br>
                            @endif
                            @if ($user->entry_info->danken !== null)
                                団研{{ $user->entry_info->danken }}期:
                                @if ($user->entry_info->danken_fee_checked_at !== null)
                                    {{ $user->entry_info->danken_fee_checked_at }}
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
