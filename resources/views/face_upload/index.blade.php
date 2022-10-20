@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="uk-text-default">顔写真アップロード</h1>
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
                <form method="POST" action="/user/face_upload" enctype="multipart/form-data">

                    {{ csrf_field() }}

                    <input type="file" id="file" name="file" class="form-control">
                    <button type="submit" class="uk-button uk-button-primary">アップロード</button>
                </form>
            </div>


            @if (isset(Auth::user()->face_picture))
                <h3>プレビュー</h3>
                <p class="uk-text-warning">別の写真にするときは再アップロードすると上書きされます。</p>
                <img src="{{ url('/storage/picture/') }}{{ '/' . Auth::user()->face_picture }}" alt=""
                    width="200px" height="">
            @endif
        </div>
        @error('file')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
@endsection
