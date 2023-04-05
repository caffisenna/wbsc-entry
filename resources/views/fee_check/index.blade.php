@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>入金チェック</h1>
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
