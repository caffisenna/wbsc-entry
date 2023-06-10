@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>アカウント一覧</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right" href="{{ route('add_users.create') }}">
                        新規登録
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        <p class="uk-text-warning">管理者、地区AIS委員、地区コミッショナーのアカウントの管理フォーム</p>
        <div class="card">
            @include('add_users.table')
        </div>
    </div>
@endsection
