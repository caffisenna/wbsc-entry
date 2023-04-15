@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>課程別研修 編集</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($divisionList, ['route' => ['divisionLists.update', $divisionList->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="">
                    @include('division_lists.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('更新する', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('divisionLists.index') }}" class="btn btn-default">Cancel</a>
            </div>

           {!! Form::close() !!}

        </div>
    </div>
@endsection
