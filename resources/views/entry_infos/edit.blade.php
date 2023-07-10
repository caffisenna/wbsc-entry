@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>申込データ修正</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($entryInfo, ['route' => ['entryInfos.update', $entryInfo->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('entry_infos.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('更新する', ['class' => 'btn btn-primary' , 'onclick' => 'window.onbeforeunload=null']) !!}
                <a href="{{ route('entryInfos.index') }}" class="btn btn-default">キャンセル</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
