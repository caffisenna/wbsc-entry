@extends('layouts.app')

@section('content')
    <div class="container">
        @include('flash::message')

        @isset($count)
            <h2>スカウトコース 参加認定</h2>
            <ul class="uk-list uk-list-bullet">
                @foreach ($count as $val)
                    @if (isset($val->sc_number))
                        @unless ($val->sc_number == 'done')
                            <li><a href="{{ route('approve_participation', ['cat' => 'sc', 'number' => $val->sc_number]) }}">スカウトコース
                                    {{ $val->sc_number }}期</a></li>
                        @endunless
                    @endif
                @endforeach
            </ul>

            <h2>課程別研修 参加認定</h2>
            <ul class="uk-list uk-list-bullet">


                @foreach ($div_count as $val)
                    @if ($val->division_number != '' && $val->division_number != 'etc')
                        <li> <a href="{{ route('approve_participation', ['cat' => 'div', 'number' => $val->division_number]) }}">課程別研修
                                {{ $val->division_number }}回</a>
                        </li>
                    @endif
                @endforeach
            </ul>

            <h2>団委員研修所 参加認定</h2>
            <ul>
                <li><a href="{{ route('approve_participation', ['cat' => 'danken', 'number' => $danken_count->number]) }}">団委員研修所
                        {{ $danken_count->number }}
                        期</a></li>
            </ul>
        @endisset
    </div>
@endsection
