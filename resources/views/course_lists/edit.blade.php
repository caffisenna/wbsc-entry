@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>コース編集</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($courseList, ['route' => ['courseLists.update', $courseList->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('course_lists.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('更新する', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('courseLists.index') }}" class="btn btn-default">キャンセル</a>
            </div>

           {!! Form::close() !!}

        </div>
    </div>
@endsection
