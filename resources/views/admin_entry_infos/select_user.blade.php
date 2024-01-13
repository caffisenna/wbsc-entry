@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-10">
                    <h1>ユーザー選択</h1>
                </div>
                <div class="col-sm-8">
                    申込データが存在しないユーザー一覧です。<br>
                    下記の一覧から申し込みデータを作成するユーザーを選択してデータ入力を行ってください。<br>
                    事務局にてデータを作成するなどの用途に使用します。
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
                            <th>申込ID</th>
                            <th>氏名</th>
                            <th>ユーザー作成日</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td class="uk-table-expand">
                                    <a href="{{ route('admin_entryInfos.create', ['id' => $user->id]) }}"
                                        class="uk-link">{{ $user->name }}</a>
                                </td>
                                <td><span class="uk-text-small">{{ $user->created_at->format('Y-m-d') }}</span></td>
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
