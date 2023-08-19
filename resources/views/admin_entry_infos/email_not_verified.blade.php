@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-10">
                    <h1>メール未認証者</h1>
                </div>
                <div class="col-sm-8">
                    <p class="uk-text uk-text-default"></p>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        <div class="table-responsive">
            <div class="uk-overflow-auto">
                <table class="uk-table uk-table-divider uk-table-striped" id="entryInfos-table">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <th>氏名</th>
                            <th>email</th>
                            <th>登録日</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>

    </div>
    </div>
@endsection
