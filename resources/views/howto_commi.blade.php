@extends('layouts.app')

@section('content')
    <style>
        img {
            border: solid 1px #777777;
        }
    </style>
    <div class="container">
        <h2>【使い方ガイド】 地区コミッショナー編</h2>
        <p class="uk-text-default">
            当システムでは地区コミッショナーをハブ(起点)として以下の手続きを進めて頂きます。<br>
            各コースの申込期限までに全ての手続き完了させることが必要ですので、地区コミッショナーの皆様から各団委員長、担当トレーナーへの通知と手続きの確認をお願い致します。<br>
            各項目毎に作業方法をご案内します。
        </p>
        <ul class="uk-list uk-list-bullet">
            <li><a href="#lock">参加者データのロックと編集権限</a></li>
            <li><a href="#login">システムへのログイン</a></li>
            <li><a href="#trainer">★トレーナーへ課題認定の依頼★</a></li>
            <li><a href="#gm">★団承認の依頼★</a></li>
            <li><a href="#substitute">団委員長の代理</a></li>
            <li><a href="#commi">地区コミッショナーの推薦</a></li>
            <li><a href="#add_comment">副申請書の作成</a></li>
            <li><a href="#details">参加者詳細画面</a></li>
            <li><a href="#order">地区内優先順位</a></li>
        </ul>

        <h3><a id="lock">参加者データのロックと編集権限</a></h3>
        <p class="">以下の条件で参加者自身による編集機能がロックされます。</p>
        <ul class="uk-list uk-list-bullet">
            <li>申込期限を迎えた</li>
            <li>団承認が行われた</li>
            <li>課題のトレーナー認定が行われた(課題の削除もできなくなります)</li>
        </ul>
        <p class="">以降の修正は地区AIS委員長に申請し、地区AIS委員長の方で修正を行います。<br>
            地区コミッショナーのアカウントは編集機能はありませんので、必要な場合は地区AIS委員長へご相談ください。</p>

        <h3><a id="login">システムへのログイン</a></h3>
        <p class="uk-text-default">
            地区コミッショナー専用のアカウントでシステムにログインしてください。<br>
            ログインに成功すると、当該地区の参加者一覧が表示されます。
        </p>
        <img src="{{ url('/images/howto/howto-10.jpg') }}">
        <h4>機能解説</h4>
        <ul class="uk-list">
            <li>【氏名・所属団】クリックすると参加者の詳細情報を表示します。アップロードされた課題も詳細画面で表示が可能です。</li>
            <li>【参加】申込をしているスカウトコースと課程別研修の期数・回数です</li>
            <li>【トレーナー認定】トレーナーによる認定が行われているかのステータス表示</li>
            <li>【団委員長】団承認が行われているかのステータス表示</li>
            <li>【地区コミ】地区コミッショナーによる推薦手続きが行われているかのステータス表示</li>
            <li>【副申請書】副申請書の作成状況と新規作成ボタン</li>
            <li>【申込書】PDFボタンを押下すると申込内容書類をPDFでダウンロード</li>
        </ul>

        <h3><a id="trainer"></a>トレーナーへ課題認定を依頼する</h3>
        <p class="">一覧画面から <span class="uk-text-primary">[認定依頼]</span> ボタンをクリックすると画面が遷移します。<br>
            次の画面で担当トレーナーの氏名、メールアドレスを入力して <span class="uk-text-primary">[依頼する]</span> をクリックしてください。<br>
            <span class="uk-text-small uk-text-warning">トレーナーの認定と団承認のタイミングはどちらが先でも大丈夫な設計になっています。</span>
        </p>
        <img src="{{ url('/images/howto/howto-11.jpg') }}" width="600px">
        <p class="">以下のような文面で担当トレーナーへメールが送信されます。<br>
            トレーナーの認定が完了すると一覧画面のステータスが変化しますので適宜ご確認ください。</p>
        <pre>
トレーナー花子 様

東京連盟指導者訓練参加申込システム AISESから自動送信しています。

地区コミッショナーからの依頼により、東京太郎様の課題認定の依頼をお送り致します。

認定方法
https://wbsc.scout.tokyo/confirm/trainer?uuid=********************にアクセスしてください。

            </pre>

        <h4>メール以外の方法で送信する</h4>
        上図のトレーナー認定の依頼画面下部にある <span class="uk-text-primary">[トレーナー認定のURLをコピー]</span> をクリックすると認定用のURLがクリップボードにコピーされます。<br>
        各種メッセージアプリに貼り付けて送信することも可能ですので、適宜ご利用ください。<br>
        <span
            class="uk-text-warning">コピーしたURLはそのまま貼り付けてください。一文字でも欠けていたり、間違っていると認定画面へのアクセスができません。ご自身でそのURLにアクセスできるかお試しすることをお薦めします。</span>

        <h3><a id="gm">団委員長へ承認依頼をする</a></h3>
        <p class="">一覧画面から <span class="uk-text-primary">[承認依頼]</span> ボタンをクリックすると画面が遷移します。<br>
            団委員長への承認依頼もトレーナー認定と同じステップで進めます。団委員長の氏名、メールアドレスを入力して <span class="uk-text-primary">[依頼する]</span> をクリックしてください。<br>
            メール以外の方法でも送信できますので、適宜承認用URLをコピーして各種メッセージアプリで送信してください。<br>
            <span class="uk-text-small uk-text-warning">トレーナーの認定と団承認のタイミングはどちらが先でも大丈夫な設計になっています。</span>
        </p>
        <img src="{{ url('/images/howto/howto-12.jpg') }}" width="600px">
        <p class="">団委員長に送信されるメール文面は以下のようになります。<br>
            団委員長の承認が完了すると一覧画面のステータスが変化しますので適宜ご確認ください。
        </p>
        <pre>
荻窪太郎 様

ボーイスカウト東京連盟 AISESから自動送信しています。

地区コミッショナーからの依頼により、東京太郎様の参加承認URLをお送り致します。

認定方法
https://wbsc.scout.tokyo/confirm/gm?uuid=**********************にアクセスしてください。

            </pre>

        <h4 class="uk-text-warning"><a id="substitute"></a>団委員長の代理</h4>
        <p class="uk-text-default">
            web承認の場合、団承認手続きは代理も認められます。様々な理由で団委員長がweb承認手続きができない場合は代理の方で手続きをするように各団、地区AIS委員長と調整をお願い致します。
        </p>

        <h3><a id="commi">地区コミッショナーの推薦</a></h3>
        <p class="">一覧の [推薦] ボタンをクリックすると確認ダイアログが表示されます。(表示方法はお使いのブラウザで異なります)<br>
            推薦する場合は [OK] をクリックしてください。
        </p>
        <img src="{{ url('/images/howto/howto-13.jpg') }}">
        <p class="">確認メッセージが表示され、地区コミッショナー推薦が完了となります。</p>
        <img src="{{ url('/images/howto/howto-14.jpg') }}" width="600px">

        <h3><a id="add_comment">副申請書の作成</a></h3>
        <p class="">一覧画面から <span class="uk-text-primary">[副申請書]</span> をクリックすると画面が遷移します。</p>
        <img src="{{ url('/images/howto/howto-15.jpg') }}" width="600px">
        <p class="">テキストボックスに副申請書の文章を入力してください。上限は800文字程度です。<br>
            既に文章を入力している場合は前回入力した内容が表示されます。
        </p>
        <img src="{{ url('/images/howto/howto-16.jpg') }}" width="600px">
        <p class=""><span class="uk-text-primary">[作成する]</span> をクリックすると完了メッセージが表示されます。</p>
        <img src="{{ url('/images/howto/howto-17.jpg') }}" width="600px">
        <p class="">副申請書が作成されている参加者には、一覧画面で<span uk-icon="comment"
                class="uk-text-danger"></span>アイコンが表示されるので参考にしてください。</p>

        <h3><a id="details">参加者詳細画面</a></h3>
        <p class="">一覧画面で参加者の氏名をクリックすると詳細を呼び出すことができます。<br>
            基本的に参加者自身が入力した内容を表示し、各種の認定や承認ステータスを確認することができます。<br>
            画面下部の項目について、以下に解説します。
        </p>
        <img src="{{ url('/images/howto/howto-18.jpg') }}" width="600px">
        <ul class="uk-list">
            <li>【団承認URL】 団承認の画面に直接アクセスができます</li>
            <li>【トレーナー認定URL】 課題認定の画面に直接アクセスができます</li>
            <li>【課題認定】課題の認定が完了していれば担当トレーナーの氏名を表示</li>
            <li>【団承認】団承認が完了していれば団委員長(もしくは代理)の氏名を表示</li>
            <li>【スカウトコース課題】スカウトコースの課題がアップロードされていれば課題PDFファイルへのリンクを表示</li>
            <li>【課程別研修課題】課程別研修の課題がアップロードされていれば課題PDFファイルへのリンクを表示</li>
            <li>【副申請書】副申請書が入力されていれば内容を表示</li>
        </ul>

        <h3><a id="order">地区内優先順位</a></h3>
        <p class="">再度メニューから <span class="uk-text-primary">[優先順位]</span> をクリックすると画面が遷移します。</p>
        <img src="{{ url('/images/howto/howto-19.gif') }}" width="600px">
        <p class="">このように行をドラッグすると入れ換えをすることができます。<br>
            画面で表示されている順番に優先順位がデータベースに保存されます。<br>
            <span class="uk-text-warning">同じ順位は設定できません。</span>
        </p>

    </div>
@endsection
