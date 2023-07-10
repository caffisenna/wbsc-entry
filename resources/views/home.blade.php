@extends('layouts.app')

@section('content')
    <div class="container">
        @include('flash::message')
        <div class="row">
            @isset($count)
                <h2>スカウトコース申込状況 @if (Auth::user()->is_staff)
                        {{ Auth::user()->is_staff }}地区
                    @endif
                </h2>
                <table class="uk-table uk-table-divider uk-table-striped">
                    <tr>
                        <th>期数</th>
                        <th>人数</th>
                        <th>一覧DL</th>
                        <th>申込書DL</th>
                        <th>課題DL</th>
                    </tr>
                    @foreach ($count as $val)
                        @if (isset($val->sc_number))
                            @unless ($val->sc_number == 'done')
                                <tr>
                                    <td><a
                                            href="{{ url('admin/admin_entryInfos?q=' . $val->sc_number) }}">SC{{ $val->sc_number }}</a>
                                    </td>
                                    <td>{{ $val->count_sc_number }}名</td>
                                    <td><a href="{{ route('admin_export') }}?sc={{ $val->sc_number }}"
                                            class="uk-button uk-button-primary"><span uk-icon="download"></span>Excel</a>
                                    </td>
                                    <td><a href="{{ url('/admin/multi_pdf?q=') . $val->sc_number . '&assignment=false&cat=sc' }}"
                                            class="uk-button uk-button-primary"
                                            onclick="return confirm('申込書を一括ダウンロードします。時間がかかるので連打しないでください')"><span
                                                uk-icon="download"></span>一括DL</a></td>
                                    <td><a href="{{ url('/admin/multi_pdf?q=') . $val->sc_number . '&assignment=true&cat=sc' }}"
                                            class="uk-button uk-button-primary"><span uk-icon="download"></span>一括DL</a>
                                    </td>
                                </tr>
                            @endunless
                        @endif
                    @endforeach
                </table>

                <h2>課程別研修申込状況</h2>
                <table class="uk-table uk-table-divider uk-table-striped">
                    <tr>
                        <th>回数</th>
                        <th>人数</th>
                        <th>一覧DL</th>
                        <th>申込書DL</th>
                        <th>課題DL</th>
                    </tr>
                    @foreach ($div_count as $val)
                        <tr>
                            <td>
                                @if ($val->division_number == 'etc')
                                    <a href="{{ url('admin/admin_entryInfos?div=' . $val->division_number) }}">その他</a>
                                @else
                                    <a
                                        href="{{ url('admin/admin_entryInfos?div=' . $val->division_number) }}">{{ $val->division_number }}</a>
                                @endif
                            </td>
                            <td>{{ $val->count_division_number }}</td>
                            <td><a href="{{ route('admin_export') }}?division={{ $val->division_number }}"
                                    class="uk-button uk-button-primary"><span uk-icon="download"></span>Excel</a>
                            </td>
                            <td><a href="{{ url('/admin/multi_pdf?q=') . $val->division_number . '&assignment=false&cat=division' }}"
                                    class="uk-button uk-button-primary"
                                    onclick="return confirm('申込書を一括ダウンロードします。時間がかかるので連打しないでください')"><span
                                        uk-icon="download"></span>一括DL</a></td>
                            <td><a href="{{ url('/admin/multi_pdf?q=') . $val->division_number . '&assignment=true&cat=division' }}"
                                    class="uk-button uk-button-primary"
                                    onclick="return confirm('課題を一括ダウンロードします。時間がかかるので連打しないでください')"><span
                                        uk-icon="download"></span>一括DL</a></td>
                        </tr>
                    @endforeach
                </table>
            @endisset
        </div>
    </div>
@endsection
