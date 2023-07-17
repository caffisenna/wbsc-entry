@extends('layouts.app')

@section('content')
    <style>
        img {
            border: solid 1px #777777;
        }
    </style>
    <div class="container">

        <h2>【使い方ガイド】 トレーナー編</h2>
        <p class="">参加者がアップロードした課題についてトレーナー認定の方法をご紹介します。以下の手順に従って認定作業を行ってください。</p>

        <h3>地区コミッショナーからの依頼</h3>
        <p class="">地区コミッショナーから課題認定の依頼メールが各担当トレーナー宛てに届きます。<br>
            そのメール文中にある <span class="uk-text-danger">認定方法</span> のリンクをクリックしてください。<br>
            メール以外のツール(各種メッセージアプリ)で届く場合もございますので、地区コミッショナーへご確認ください。
        </p>
        <pre>
トレーナー花子 様

東京連盟指導者訓練参加申込システム AISESから自動送信しています。

地区コミッショナーからの依頼により、東京太郎様の課題認定の依頼をお送り致します。

認定方法
https://wbsc.scout.tokyo/confirm/trainer?uuid=********************にアクセスしてください。

</pre>

        <h3>参加者情報の確認</h3>
        <p class="uk-text-default">メールのリンクをクリックすると参加者情報の確認画面にジャンプします。<br>
            参加者が入力した情報とスカウトコース、課程別研修の課題の確認をすることができます。<br>
            それぞれの内容をよくご確認ください。</p>
        <img src="{{ url('/images/howto/howto-06.jpg') }}">

        <h3>課題の確認方法</h3>
        <p class="uk-text-default">
            参加者情報の画面下部、[認定ステータス] に参加者がアップロードした課題が表示されます。<br>
            参加者の課題がアップロードされていなければ <span class="uk-text-danger">未提出</span> と表示されるので参加者、もしくは地区コミッショナーへご確認ください。<br>
            課題がアップロードされていればPDFファイルへのリンクになっていますので、内容をご確認ください。
        </p>
        <img src="{{ url('/images/howto/howto-07.jpg') }}">

        <h3>課題の認定方法</h3>
        <p class="uk-text-default">
            スカウトコース、課程別研修それぞれに [認定する] ボタンがあるのでクリックします。(上図参照)<br>
            既に認定済みの課題は認定日とトレーナー氏名が表示されます。
        </p>
        <p class="uk-text-default">
            上図で[認定する]ボタンをクリックすると、画面がポップアップします。<br>
            新しく現れた画面でトレーナー氏名、認定日を入力してください。<br>
            入力が完了したら画面内の [認定する]ボタンをクリックします。<br>
            下図はスカウトコース課題認定の画面ですが、課程別研修の手続きも同様です。
        </p>
        <h4 class="uk-text-warning">ご注意</h4>
        <p class="uk-text-default">
            認定画面ではスカウトコース、課程別研修の課題認定を同一のURLから行うことができます。<br>
            それぞれの課題を別のトレーナーが分担して指導している場合は、他の方の認定作業をしないようにご注意ください。<br>
            詳しくは地区コミッショナー、地区AIS委員長と確認をしてください。
        </p>
        <img src="{{ url('/images/howto/howto-08.jpg') }}">

        <h3>課題の認定確認</h3>
        <p class="uk-text-default">課題の認定が完了すると元の画面に戻ります。<br>
            完了した旨の確認メッセージが表示され、画面下部の認定ステータスでは認定した課題について認定日と認定トレーナー氏名が打刻されていることを確認してください。<br>
            以上でトレーナー認定手続きは完了です。ブラウザーを終了してください。
        </p>
        <img src="{{ url('/images/howto/howto-09.jpg') }}">

    </div>
@endsection
