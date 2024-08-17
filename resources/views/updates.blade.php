@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>更新情報</h2>
        <ul class="uk-list uk-list-bullet">
            <li><span class="uk-text-small uk-text-bold">2024/08/17</span><br>
                スカウトコースもしくは課程別研修に申し込もうとすると「申込可能な団委員研修所がありません」とメッセージが表示され、先に進めない不具合を解消しました。
            </li>
            <li><span class="uk-text-small uk-text-bold">2024/08/09</span><br>
                コーススタッフのアカウントで団委員研修所の参加者一覧を出力した際のExcelファイルのカラムずれを解消しました。
            </li>
            <li><span class="uk-text-small uk-text-bold">2024/08/08</span><br>
                地区コミッショナーのメニューに「参加費納入状況」を追加しました。
            </li>
            <li><span class="uk-text-small uk-text-bold">2024/08/08</span><br>
                管理者、地区AIS委員長の管理画面で団委員研修所の申込期限が表示されない不具合を解消しました。
            </li>
            <li><span class="uk-text-small uk-text-bold">2024/08/08</span><br>
                トレーナー認定画面で団委員研修所の課題認定後の表示の不具合を解消しました。
            </li>
            <li><span class="uk-text-small uk-text-bold">2024/08/04</span><br>
                団委員長による参加承認画面で、参加者が団委員研修所に参加する場合、参加コースが正しく表示されない不具合を解消しました。(スカウトコースと課程別研修が表示されていた)
            </li>
            <li><span class="uk-text-small uk-text-bold">2024/06/19</span><br>
                AIS委員長の権限で閲覧したとき、健康情報が未入力だと500 Server Errorが発生していた不具合を解消しました。
            </li>
            <li><span class="uk-text-small uk-text-bold">2024/06/16</span><br>
                地区コミッショナーの権限で参加費納入状況が確認できるようになりました </li>
            <li><span class="uk-text-small uk-text-bold">2024/06/15</span><br>
                団委員研修所に申し込む際、「スカウトコースを選択してください」とエラーメッセージが表示される不具合を解消しました。</li>
            <li><span class="uk-text-small uk-text-bold">2024/06/09</span><br>
                <a
                    href="https://drive.google.com/file/d/1uCx6kkW5r1GNwHIme8xZ5QgPTTvURrGZ/view?usp=sharing">参加者マニュアル</a>を更新しました。
            </li>
            <li><span class="uk-text-small uk-text-bold">2024/06/05</span><br>
                障害対応のため6月1日〜4日の期間でAISESのサービスを停止しました。</li>
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
