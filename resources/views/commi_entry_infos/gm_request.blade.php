@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1>指導者研修申込 団委員長承認依頼</h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        <p class="uk-text">{{ $userinfo->user->name }}さん({{ $userinfo->dan }})について、団委員長に承認依頼のメールを送付します。<br>
            下記フォームに団委員長の氏名、メールアドレスを入力してください。<br>
            メール以外で送信する場合は、ページ下部をご参照下さい。</p>

        <h3>メールで依頼する</h3>
        <div class="uk-card uk-card-default uk-card-body uk-width-1-2@m">
            <form method="POST" action="{{ route('gm_request_send') }}">
                @csrf
                <div class="uk-margin">
                    <p class="uk-text-danger">送信先:{{ $userinfo->dan }}</p>
                    <label class="uk-form-label" for="form-stacked-text">氏名</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="form-stacked-text" type="text" name="name" required
                            placeholder="{{ $userinfo->dan }}の団委員長氏名">
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">email</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="form-stacked-text" type="text" name="email" required
                            placeholder="{{ $userinfo->dan }}の団委員長メールアドレス">
                    </div>
                </div>

                <input type="hidden" name="uuid" value="{{ $userinfo->uuid }}">
                @if ($userinfo->gm_sent_at)
                    <span class="uk-text-warning uk-text-small">{{ $userinfo->gm_sent_at }}に送信済み</span>
                @endif
                <input type="submit" value="{{ $userinfo->gm_sent_at ? '再度依頼する' : '依頼する' }}"
                    class="uk-button uk-button-primary uk-width-1-1@m">
                <button class="uk-button uk-button-default uk-modal-close uk-width-1-1@m" type="button"
                    onclick="history.back()">キャンセル</button>
            </form>
        </div>

        <h3>メール以外の方法で依頼する</h3>
        <ol>
            <li><button onclick="copyToClipboard()" class="uk-button uk-button-primary">団承認のURLをコピー</button>をクリックする
            </li>
            <li>URLがクリップボードにコピーされるので、チャットアプリなどに貼り付けて送信する</li>
        </ol>
        <span class="uk-text-danger">コピーしたURLはメーリングリストやグループチャットなどで送付することは厳禁とします。<br>
            必ず該当者本人にのみ通知できるようにご注意ください。</span>

    </div>
@endsection

<script>
    function copyToClipboard() {
        // コピーする文字列を取得
        var text = "{{ url("/confirm/gm?uuid=$userinfo->uuid") }}";

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
        alert("団承認のURLをクリップボードにコピーしました: " + text);
    }
</script>
