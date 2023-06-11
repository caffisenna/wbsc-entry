@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>WB研修所申込一覧 @if (Auth::user()->is_staff)
                            {{ Auth::user()->is_staff }}地区
                        @endif
                    </h1>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="card">
            <div class="card-body p-0">
                @include('admin_entry_infos.table')
            </div>

        </div>
    </div>
@endsection
