@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>
                        更新内容作成
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'updates.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('updates.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('updates.index') }}" class="btn btn-default"> キャンセル </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
