@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1>指導者訓練申込状況 {{ Auth::user()->name }}</h1>
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
                @include('commi_entry_infos.table')
            </div>

        </div>
    </div>
@endsection
