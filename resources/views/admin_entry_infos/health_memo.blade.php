@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-10">
                    <h1>健康情報入力者</h1>
                </div>
                <div class="col-sm-8">
                    <p class="uk-text uk-text-default"><span class="uk-text-warning">特になし</span>以外をピックアップしています</p>
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
                            <th>所属</th>
                            <th>現在治療中の病気</th>
                            <th>健康上の特記事項</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entryinfos as $entryinfo)
                            <tr>
                                <td>{{ $entryinfo->id }}</td>
                                <td>{{ $entryinfo->user->name }}</td>
                                <td>{{ $entryinfo->district }}地区 {{ $entryinfo->dan }}団</td>
                                <td>{{ $entryinfo->health_illness }}</td>
                                <td>{{ $entryinfo->health_memo }}</td>
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
