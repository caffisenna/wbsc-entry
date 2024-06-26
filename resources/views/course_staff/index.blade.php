@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1>申込状況 {{ Auth::user()->is_course_staff }}</h1>
                </div>
                <div class="col-sm-8">
                    {{ now()->format('Y-m-d H:i') }}<br>
                    申込人数 : {{ $entryInfos->count() }}名 (
                    @foreach ($genderCounts as $key => $value)
                        {{ $key }}性 : {{ $value }}人
                    @endforeach )

                    <br>平均年齢 : {{ $averageAge }}歳<br>
                    <h3>所属内訳</h3>
                    <table class="uk-table uk-table-divider uk-table-striped uk-table-small">
                        <tr>
                            <th class="uk-width-small">隊</th>
                            <th class="">人数</th>
                        </tr>

                        @foreach (['ビーバー隊', 'カブ隊', 'ボーイ隊', 'ベンチャー隊', 'ローバー隊', '団'] as $troop)
                            @if ($troopCounts->has($troop))
                                <tr>
                                    <td>{{ $troop }}</td>
                                    <td>{{ $troopCounts[$troop] }}人</td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="card">
            <div class="card-body p-0">
                @include('course_staff.table')
            </div>

        </div>
    </div>
@endsection
