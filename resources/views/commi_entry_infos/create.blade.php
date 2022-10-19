@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>申込書作成</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'entryInfos.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('entry_infos.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('登録する', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('entryInfos.index') }}" class="btn btn-default">キャンセル</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
