@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>
                        アカウント作成
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'add_users.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('add_users.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('作成する', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('add_users.index') }}" class="btn btn-default"> キャンセル </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
