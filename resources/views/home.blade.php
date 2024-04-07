@extends('layouts.app')

@section('content')
    <div class="container">
        @include('flash::message')
        <div class="row">
            @isset($count)
                <h2>スカウトコース @if (Auth::user()->is_ais)
                        {{ Auth::user()->is_ais }}地区
                    @endif
                </h2>
                <table class="uk-table uk-table-divider uk-table-striped">
                    <tr>
                        <th>期数</th>
                        <th>人数</th>
                        <th>一覧DL</th>
                        <th>申込書DL</th>
                        <th>課題DL</th>
                        <th>顔写真</th>
                        <th>健康情報</th>
                    </tr>
                    @foreach ($count as $val)
                        @if (isset($val->sc_number))
                            @unless ($val->sc_number == 'done')
                                <tr>
                                    <td><a
                                            href="{{ route('admin_entryInfos.index', ['q' => $val->sc_number]) }}">SC{{ $val->sc_number }}</a>
                                    </td>
                                    <td>{{ $val->count_sc_number }}名</td>
                                    <td><a href="{{ route('admin_export', ['sc' => $val->sc_number]) }}" class=""><span
                                                uk-icon="download"></span>一覧</a>
                                    </td>
                                    <td><a href="{{ route('multi_pdf', ['q' => $val->sc_number, 'assignment' => 'false', 'cat' => 'sc']) }}"
                                            class="" onclick="return confirm('申込書を一括ダウンロードします。時間がかかるので連打しないでください')"><span
                                                uk-icon="download"></span>申込書</a></td>
                                    <td><a href="{{ route('multi_pdf', ['q' => $val->sc_number, 'assignment' => 'true', 'cat' => 'sc']) }}"
                                            class=""><span uk-icon="download"></span>課題</a>
                                    </td>
                                    <td><a href="{{ route('dl_face_pictures', ['cat' => 'sc', 'number' => $val->sc_number]) }}"><span
                                                uk-icon="download"></span>顔写真</a></td>
                                    <td><a href="#"><span uk-icon="download"></span>健康情報</a></td>
                                </tr>
                            @endunless
                        @endif
                    @endforeach
                </table>

                <h2>課程別研修</h2>
                <table class="uk-table uk-table-divider uk-table-striped">
                    <tr>
                        <th>回数</th>
                        <th>人数</th>
                        <th>一覧DL</th>
                        <th>申込書DL</th>
                        <th>課題DL</th>
                        <th>顔写真</th>
                    </tr>
                    @foreach ($div_count as $val)
                        @unless ($val->division_number == null)
                            <tr>
                                <td>
                                    @if ($val->division_number == 'etc')
                                        <a href="{{ route('admin_entryInfos.index', ['div' => $val->division_number]) }}">それ以外</a>
                                    @else
                                        <a
                                            href="{{ route('admin_entryInfos.index', ['div' => $val->division_number]) }}">{{ $val->division_number }}</a>
                                    @endif
                                </td>
                                <td>{{ $val->count_division_number }}名</td>
                                <td><a href="{{ route('admin_export') }}?division={{ $val->division_number }}"
                                        class=""><span uk-icon="download"></span>一覧</a>
                                </td>
                                <td><a href="{{ route('multi_pdf', ['q' => $val->division_number, 'assignment' => 'false', 'cat' => 'division']) }}"
                                        class="" onclick="return confirm('申込書を一括ダウンロードします。時間がかかるので連打しないでください')"><span
                                            uk-icon="download"></span>申込書</a></td>
                                <td><a href="{{ route('multi_pdf', ['q' => $val->division_number, 'assignment' => 'true', 'cat' => 'division']) }}"
                                        class="" onclick="return confirm('課題を一括ダウンロードします。時間がかかるので連打しないでください')"><span
                                            uk-icon="download"></span>課題</a></td>
                                <td><a href="{{ route('dl_face_pictures', ['cat' => 'div', 'number' => $val->division_number]) }}"><span
                                            uk-icon="download"></span>顔写真</a></td>
                            </tr>
                        @endunless
                    @endforeach
                </table>

                @if (isset($danken_count))
                    <h2>団研</h2>
                    <table class="uk-table uk-table-divider uk-table-striped">
                        <tr>
                            <th>団研</th>
                            <th>人数</th>
                            <th>一覧DL</th>
                            <th>申込書DL</th>
                            <th>課題DL</th>
                            <th>顔写真</th>
                        </tr>
                        @foreach ($danken_count as $val)
                            <tr>
                                <td><a
                                        href="{{ route('admin_entryInfos.index', ['danken' => 'true']) }}">団研{{ $val->danken }}</a>
                                </td>
                                <td>{{ $val->count_danken }}名</td>
                                <td><a href="{{ route('admin_export', ['cat' => 'danken']) }}" class=""><span
                                            uk-icon="download"></span>一覧</a>
                                </td>
                                <td><a href="{{ route('multi_pdf', ['q' => 'danken', 'assignment' => 'false', 'cat' => 'danken']) }}"
                                        class="" onclick="return confirm('申込書を一括ダウンロードします。時間がかかるので連打しないでください')"><span
                                            uk-icon="download"></span>申込書</a></td>
                                <td><a href="{{ route('multi_pdf', ['q' => 'danken', 'assignment' => 'true', 'cat' => 'danken']) }}"
                                        class="" onclick="return confirm('課題を一括ダウンロードします。時間がかかるので連打しないでください')"><span
                                            uk-icon="download"></span>課題</a></td>
                                <td><a href="{{ route('dl_face_pictures', ['cat' => 'danken']) }}"><span
                                            uk-icon="download"></span>顔写真</a></td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            @endisset
        </div>
    </div>
@endsection
