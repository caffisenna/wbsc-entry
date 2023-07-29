@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1>パスワードリセット</h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        <p class="uk-text-warning">{{ $user->name }} さんのパスワードをリセットします。 </p>

        <h3>注意</h3>
        <ul class="uk-list uk-list-bullet">
            <li>リセットをする前に必ず<button onclick="copyToClipboard()" class="uk-button uk-button-primary">パスワードをコピー</button>してください
            </li>
            <li>新しいパスワードを発行したらクリップボードにコピーしたパスワードを当該ユーザーに通知してください</li>
            <li>ページをリロードすると候補のパスワードを再生成します</li>
            <li>任意のパスワードを設定できます。以下のテキストボックスに入力して<span class="uk-text-primary">リセットする</span>をクリックしてください</li>
            <li>パスワード長は8文字以上です(任意入力の場合、英数字の混在は判定しません)</li>
        </ul>

        <h3>新しいパスワード</h3>
        <form method="POST" action="{{ route('pass_reset') }}" class=" uk-form-custom">
            @csrf

            {{-- new_passwordのinputフィールド --}}
            {{-- <label for="new_password">新しいパスワード:</label> --}}
            <input type="hidden" name="id" value="{{ $user->id }}">
            <input type="hidden" name="confirm" value="true">
            <input type="text" name="new_password" id="new_password" value="{{ $user->new_password }}"
                class="form-control">
            {{-- submitボタン --}}
            <button type="submit" class="uk-button uk-button-primary">リセットする</button>
        </form>

    </div>
@endsection


<script>
    function copyToClipboard() {
        // コピーする文字列を取得
        var text = "{{ $user->new_password }}";

        // テキストエリアを作成してコピー用のテキストを設定
        var textarea = document.createElement("textarea");
        textarea.value = text;
        document.body.appendChild(textarea);

        // テキストエリアの選択範囲を設定
        textarea.select();

        // コピー操作を実行
        document.execCommand("copy");

        // テキストエリアを削除
        document.body.removeChild(textarea);

        // コピー完了のメッセージを表示（任意）
        alert("新しいパスワードをクリップボードにコピーしました: " + text);
    }
</script>
