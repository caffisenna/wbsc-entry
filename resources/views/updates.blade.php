@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>更新情報</h2>
        <ul class="uk-list uk-list-bullet">
            <li><span class="uk-text-small uk-text-bold">2024/04/06</span><br>
                地区AIS委員会と地区コミッショナー画面で参加認定のステータスを表示するように修正を行いました。</li>
            <li><span class="uk-text-small uk-text-bold">2024/03/16</span><br>
                生年月日に2005年の選択肢を追加しました。</li>
            <li><span class="uk-text-small uk-text-bold">2024/03/09</span><br>
                [地区コミ] 参加決定通知の送信先に団委員長宛のCCが設定されている場合、参加者の詳細が表示できない不具合(500 Server Error)が解消しました</li>
            <li><span class="uk-text-small uk-text-bold">2024/03/06</span><br>
                申込書をPDF出力した際、不必要な <span class=" uk-text-italic">ビーバー課程特例</span> の文字列が表示される不具合が解消しました</li>
            <li><span class="uk-text-small uk-text-bold">2024/03/05</span><br>
                スカウトコースの課題アップロードボタンが表示されない不具合が解消しました</li>
            <li><span class="uk-text-small uk-text-bold">2024/03/01</span><br>
                2024年度の研修申込受付を開始しました</li>
        </ul>

    </div>
@endsection
