@extends('layouts.app')

@section('content')
    <style>
        img {
            border: solid 1px #777777;
        }
    </style>
    <div class="container">
        <h2>【使い方ガイド】 団委員長編</h2>
        <p class="">指導者研修への参加には団の承認が必要となります。以下の手順に従って承認作業を行ってください。<br>
            <span class="uk-text-warning">
                なお、団承認手続きは代行も認められています。団委員長の承認手続きが難しい場合は団内でご協議頂き、事前に地区コミッショナーと地区AIS委員長と情報を共有してください。
            </span>
        </p>

        <h3>地区コミッショナーからの依頼</h3>
        <p class="">参加者の情報が入力されると、地区コミッショナーから参加承認の依頼メールが各団委員長宛てに届きます。<br>
            そのメール文中にある <span class="uk-text-danger">認定方法</span> のリンクをクリックしてください。<br>
            メール以外のツール(各種メッセージアプリ)で届く場合もございますので、地区コミッショナーへご確認ください。
        </p>
        <pre>
荻窪太郎 様

ボーイスカウト東京連盟 AISESから自動送信しています。

地区コミッショナーからの依頼により、東京太郎様の参加承認URLをお送り致します。

認定方法
https://wbsc.scout.tokyo/confirm/gm?uuid=**********************にアクセスしてください。

</pre>

        <h3>参加者情報の確認</h3>
        <p class="uk-text-default">メールのリンクをクリックすると参加者情報の確認画面にジャンプします。<br>
            参加者が入力した情報とスカウトコース、課程別研修の課題の確認をすることができます。<br>
            それぞれの内容をよくご確認ください。</p>
        <img src="{{ url('/images/howto/howto-01.jpg') }}"><br>
        <p class="uk-text-small">画面をスクロールして申込内容を確認してください</p>
        <hr>
        <img src="{{ url('/images/howto/howto-02.jpg') }}"><br>
        <p class="uk-text-small">画面の最下部に提出済みの課題のリンクがあります。<br>
            課題がその時点でアップロードされていない場合はリンクが表示されず<span class="uk-text-danger">未提出</span>となります。</p>

        <h3>承認手続き</h3>
        <p class="uk-text-default">申込内容と課題の確認が完了したら画面上部の <span class="uk-text-primary">承認する</span> ボタンをクリックします。</p>
        <img src="{{ url('/images/howto/howto-03.jpg') }}">
        <hr>
        <p class="uk-text-small">承認ボタンをクリックすると画面がポップアップします。<br>
            団委員長のお名前と承認日を入力して、画面下部の <span class="uk-text-primary">承認する</span> ボタンをクリックしてください。<br>
            承認日はカレンダーアイコンをクリックして日付をクリックすると簡単に入力することができます。</p>
        <img src="{{ url('/images/howto/howto-04.jpg') }}">

        <h3>承認完了</h3>
        <p class="uk-text-defult">
            承認手続きが完了すると元の画面に戻ります。完了した旨のメッセージが表示され、下部にお名前と承認日が打刻されていることを確認してください。<br>
            以上で団承認手続きは完了です。ブラウザーを終了してください。
        </p>
        <img src="{{ url('/images/howto/howto-05.jpg') }}">

    </div>
@endsection
