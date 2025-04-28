@extends('layouts.app')

@section('content')
    <div class="container">
        @include('flash::message')
        <div class="row">
            <h2>{{ config('app.name') }}について </h2>
            <table class="uk-table uk-table-divider uk-table-justify uk-table-middle uk-table-responsive">
                <tr>
                    <th class="uk-table-expand">アプリケーション名</th>
                    <td>{{ config('app.name') }} (AIS Entry System / アイセス)</td>
                </tr>
                <tr>
                    <th>概要</th>
                    <td>ボーイスカウト東京連盟で開催する指導者訓練の参加申込システムです。<br>
                        現時点ではWB研修所スカウトコース、WB研修所課程別研修の参加申込に対応しています。</td>
                </tr>
                <tr>
                    <th>概要と目的</th>
                    <td>
                        参加者自身による正確なデータ入力をもとに、従来は紙ベースで行っていた指導者研修の申込を完全ペーパーレス化しました。<br>
                        これにより、各所で発生していた書類の滞留や締め切り間際の集中処理などを削減することができます。<br>
                        事務手続きの敏速化が図れるようになる他、申込プロセスの各所で発生していた「今どうなっている」がweb上で確認できるようになり、業務の効率化を支援することが可能になりました。<br>
                        ※課題研修の取り組みは従来と変更はありません。
                    </td>
                </tr>
                <tr>
                    <th>特徴</th>
                    <td>
                        <ul class="uk-list uk-list-bullet">
                            <li>参加者、地区AIS委員長、地区コミッショナー、県連AIS委員会、事務局などの役務に応じたアカウントの発行</li>
                            <li>slackと連携した通知システム</li>
                            <li>各プロセスで関係者にメールによる通知</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th>対象ユーザー</th>
                    <td>
                        <p class="">2023年度は東京連盟に加盟登録がある参加者を対象とします。</p>
                        <ul class="uk-list uk-list-bullet">
                            <li>研修参加者(または代行者)</li>
                            <li>団委員長(または代行者)</li>
                            <li>トレーナー</li>
                            <li>地区コミッショナー</li>
                            <li>地区AIS委員長</li>
                            <li>県連AIS委員会</li>
                            <li>県連事務局</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th>利点と主な機能</th>
                    <td>
                        <p class="">以下のような機能を持ち、各所での業務負担の軽減及び、申込手続きの「見える化」を実現します。</p>
                        <ul class="uk-list uk-list-bullet">
                            <li>web手続きによるペーパーレス化</li>
                            <li>最新申込データのExcel出力</li>
                            <li>団承認のオンライン化</li>
                            <li>トレーナー認定のオンライン化</li>
                            <li>地区コミッショナー推薦のオンライン化(副申請書の作成機能)</li>
                            <li>地区AIS委員長の確認機能</li>
                            <li>各手続きの進捗に応じたメール通知</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th>動作環境</th>
                    <td>
                        <ul class="uk-list uk-list-bullet">
                            <li>モダンブラウザが稼働するWindows PC及びMac、各社タブレット</li>
                            <li>スマートフォンでも動作しますが入力項目が多いため、PCまたはタブレットでの操作・閲覧を推奨します</li>
                            <li>サポート切れのブラウザを使用した場合の動作保証はいたしません</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th>サポート</td>
                    <td>
                        使用方法などのお問い合わせは、各地区のAIS委員長までお願い致します。<br>
                        システムに関する技術的なお問い合わせは <a href="mailto:wb-system-contact@scout.tokyo">専用アドレス</a>
                        にお送りください。
                    </td>
                </tr>
                <tr>
                    <th>開発</th>
                    <td>東京連盟ICT小委員会 <a href="https://github.com/caffisenna/wbsc-entry"><span
                                uk-icon="github"></span>GitHub</a></td>
                </tr>
            </table>
        </div>
    </div>
@endsection
