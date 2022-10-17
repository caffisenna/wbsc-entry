@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>WB研修所申込書 {{ Auth::user()->name }}さん</h1>
                </div>
                <div class="col-sm-6">
                    @if (empty($entryInfo))
                        <a class="btn btn-primary float-right" href="{{ route('entryInfos.create') }}">
                            申込書作成
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        @if (isset($entryInfo))
            <div class="card">
                <div class="card-body p-0">
                    @include('entry_infos.table')
                </div>

            </div>
    </div>
    @endif
@endsection
