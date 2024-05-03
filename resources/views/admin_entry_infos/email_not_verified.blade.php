@extends('layouts.app')


@section('content')
    <link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">
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
        <div id="flash-message">
            @include('flash::message')
        </div>
        <div class="table-responsive">
            <div class="uk-overflow-auto">
                <table class="uk-table uk-table-divider uk-table-striped" id="entryInfos-table">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <th>氏名</th>
                            <th>地区</th>
                            <th>メモ追加</th>
                            <th>メモ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    {{ $user->name }}<br>
                                    <span class="uk-text-small">{{ $user->email }}</span>
                                </td>
                                <td>{{ $user->district }}</td>
                                <td>
                                    <a href="#" class="" data-bs-toggle="modal"
                                        data-bs-target="#userMemoModal{{ $user->id }}"><span
                                            uk-icon="icon:file-edit"></span></a>
                                </td>
                                <td>
                                    @if ($user->memo)
                                        {{ $user->memo }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @foreach ($users as $user)
                <div class="modal fade" id="userMemoModal{{ $user->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="userMemoModalLabel{{ $user->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="userMemoModalLabel{{ $user->id }}">{{ $user->name }}
                                    さんのメモ
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- 入力ボックスなどのフォーム要素をここに追加 -->
                                <form action="{{ route('save_user_memo') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <label for="memo">メモ:(最大255文字)</label>
                                    <textarea name="memo" id="memo" class="form-control">{{ $user->memo }}</textarea>
                                    <button type="submit" class="btn btn-primary">保存</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <script>
            // Bootstrap v5以降ではdata-bs-toggleとdata-bs-targetを使用する
            $(document).ready(function() {
                $('[data-bs-toggle="modal"]').click(function() {
                    // 対応するボタンがクリックされたときに、そのボタンに対応するモーダルを表示する
                    var target = $($(this).data('bs-target'));
                    target.modal('show');
                });
            });
        </script>

        <script>
            // ページが読み込まれた後に実行されるコード
            document.addEventListener('DOMContentLoaded', function() {
                // 5秒後にflashメッセージを閉じる関数を呼び出す
                setTimeout(function() {
                    closeFlashMessage();
                }, 5000); // 5000ミリ秒（5秒）後に実行

                // flashメッセージを閉じる関数
                function closeFlashMessage() {
                    // flashメッセージを包む要素を取得
                    var flashMessage = document.getElementById('flash-message');

                    // flashメッセージが存在するか確認してから閉じる
                    if (flashMessage) {
                        // flashメッセージを非表示にするスタイルを追加
                        flashMessage.style.display = 'none';
                    }
                }
            });
        </script>


    </div>
    <script src="{{ asset('js/dataTables.min.js') }}"></script>
    <script>
        let table = new DataTable('#entryInfos-table');
    </script>
@endsection
