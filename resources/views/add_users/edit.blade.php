@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>
                        アカウント編集
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($addUser, ['route' => ['add_users.update', $addUser->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('add_users.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('更新', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('add_users.index') }}" class="btn btn-default"> キャンセル </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
