@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-10">
                    <h1>指導者研修申込一覧 @if (Auth::user()->is_ais)
                            {{ Auth::user()->is_ais }}地区
                        @endif
                        @if ($request['certificate'] == 'true')
                            <span class="uk-text-danger">修了認定</span>
                        @endif
                        @if ($request['q'])
                            <span class="uk-text-danger">SC{{ $request['q'] }}期</span>
                        @elseif($request['div'])
                            @if ($request['div'] == 'etc')
                                <span class="uk-text-danger">課程別研修(東京以外)</span>
                            @else
                                <span class="uk-text-danger">課程別{{ $request['div'] }}回</span>
                            @endif
                        @elseif($request['danken'] == 'danken')
                            <span class="uk-text-danger">団研</span>
                        @endif
                    </h1>
                </div>
                <div class="col-sm-6">
                    @if (isset($course_info))
                        申込締め切り: <span class="uk-text-danger">{{ $course_info->deadline->format('Y-m-d') }}</span><br>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="card">
            <div class="card-body p-0">
                {{-- 修了認定フラグがtrueの時 --}}
                @if ($request['certificate'] == 'true')
                    @include('admin_entry_infos.certificate')
                @else
                    @include('admin_entry_infos.table')
                @endif
            </div>

        </div>
    </div>
@endsection
