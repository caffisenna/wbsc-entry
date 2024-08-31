@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>お知らせ</h1>
                </div>
                <div class="col-sm-6">
                    @if (Auth::user()->is_admin == 1 && empty(Auth::user()->is_ais))
                    <a class="btn btn-primary float-right" href="{{ route('updates.create') }}">
                        新規追加
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            @include('updates.table')
        </div>
    </div>
@endsection
