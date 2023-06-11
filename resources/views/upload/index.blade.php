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
        <ul class="uk-list">
            <li>所定の書式を<a href="https://www.scout.tokyo/member/training/">東京連盟のwebサイト</a>からダウンロードしてください</li>
            <li><span class="uk-text-danger">トレーナーから指導を受け、その内容を「まとめ用紙」に記載してください</span></li>
            <li>表紙を含む「まとめ用紙」をPDF形式でアップロードしてください</li>
            <li>トレーナーの認定はオンラインで別途行います。(表紙にトレーナー等の署名有無は問いません)</li>
        </ul>

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
            @error('file')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

        </div>
    </div>
@endsection
