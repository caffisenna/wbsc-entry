@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if ($q == 'sc')
                        <h1 class="uk-text-default">スカウトコース課題アップロード</h1>
                    @elseif ($q == 'division')
                        <h1 class="uk-text-default">課程別研修課題アップロード</h1>
                    @endif
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')
        @if ($q == 'sc')
            <p class="uk-text-danger">課程別研修の課題ではありません。</p>
        @elseif ($q == 'division')
            <p class="uk-text-danger">スカウトコースの課題ではありません。</p>
        @endif
        <p class="uk-text-danger">必ずトレーナー認定済みの課題をPDF形式でアップしてください。</p>

        <div class="clearfix"></div>
        <div class="card">
            <div class="card-body p-0">
                <form method="POST" action="/user/upload" enctype="multipart/form-data">

                    {{ csrf_field() }}

                    <input type="file" id="file" name="file" class="form-control">
                    <input type="hidden" name="uuid" value="{{ $uuid }}">
                    <input type="hidden" name="q" value="{{ $q }}">
                    <button type="submit" class="uk-button uk-button-primary">アップロード</button>
                </form>
            </div>

        </div>
    </div>
@endsection
