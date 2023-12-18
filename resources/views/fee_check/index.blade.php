@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if ($_REQUEST['cat'] == 'div')
                        <h1>入金チェック(課程別研修)</h1>
                    @elseif ($_REQUEST['cat'] == 'danken')
                        <h1>入金チェック(団研)</h1>
                    @else
                        <h1>入金チェック(スカウトコース)</h1>
                    @endif
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('flash::message')

        <div class="clearfix"></div>
        @if (isset($entryinfos))
            <div class="card">
                <div class="card-body p-0">
                    @include('fee_check.table')
                </div>
            </div>

    </div>
    @endif
@endsection
