# AISES 指導者研修申込システム　

## Overview
当システムは、ボーイスカウト東京連盟で開催される指導者研修の申込手続きを円滑化するために開発されました。

主な対象は、WB研修所スカウトコース、同課程別研修、および団委員研修所です。

本システムは、参加者、所属団、トレーナー、地区コミッショナー、地区AIS委員会、県連AIS委員会、事務局など、すべての関係者の利便性向上を実現します。


### 参加者の機能
- メール認証
- 参加者自身による参加申込
- 写真のアップロード
- 課題のアップロード
- 健康情報の入力
- 進捗確認

### 団の機能
- オンライン承認

### トレーナーの機能
- 課題のオンライン認定

### 地区コミッショナーの機能
- 推薦処理
- 副申請書作成
- 団へ承認依頼の送信
- トレーナーへ認定依頼の送信
- 進捗確認
- 地区内優先順位の設定

### 地区AIS委員長の機能
- 進捗確認
- 地区内にスコープを絞った全ての機能
- 申込書の一括ダウンロード
- 課題の一括ダウンロード

### コーススタッフの機能
- 参加者一覧の表示
- 申込書の一括ダウンロード
- 課題の一括ダウンロード
- 欠席情報の入力

### 管理者機能
- 上記ロールにおける全ての機能
- 参加認定 or 否認
  - 参加決定通知の自動送信
  - 任意で団にもCCで同送
- 修了認定
- コース設定
- 入金管理

### 共通機能
- 進捗の都度、関係者へメールやslackで通知


## Develop environments

### Framework
[Laravel]('https://github.com/laravel/framework)

### Language:
PHP 8.2.19 (cli) (built: May  7 2024 14:19:14) (NTS)
Copyright (c) The PHP Group
Zend Engine v4.2.19, Copyright (c) Zend Technologies
    with Zend OPcache v8.2.19, Copyright (c), by Zend Technologies

### RDBMS
mysql  Ver 8.0.37 for macos14.5 on arm64 (Source distribution)

### Laravel Valet
[Laravel Valet]('https://laravel.com/docs/11.x/valet') 4.6.1

## System Requirements
1. PHP ver8.2 or later
2. [composer]('https://getcomposer.org/)
3. RDBMS (MySQL8 or later)


## Installation
1. `git clone git@github.com:caffisenna/wbsc-entry.git`
2. run `composer install`

- course_lists、danken_lists、division_listsにレコードが必要です。適当なダミーデータをtinker等で挿入してください
- userテーブルでは `is_admin` を `1` とすると管理者になります

## Documentation
No documents avaliable.

## Contributor
- PM: 平田恭一
- User Guide Editor: 谷道龍彦
- 東京連盟事務局: 竹内奈穂子 小松泰子
- Coder: [只野太一 @caffisenna]('https://github.com/caffisenna/')
- AWS Manager: [jomtech]('https://github.com/jomtech)
- Issue creator: [Radish-TR]('https://github.com/caffisenna/wbsc-entry/issues/106')

## Disclaimer
- 本システムを利用することで発生する不具合、損害、損失等について、開発者及びボーイスカウト東京連盟は一切の責任を負いません。利用者は自己責任において本システムを利用してください。
- 本システムは事前の告知なく仕様などが変更される場合があります。
- 本システムに関するサポート及び質問に対する回答は提供されません。バグの修正や機能追加等の対応も行われない場合があります。
- issueが立てられた場合の対応は開発チームにて協議を行います。
- ボーイスカウト東京連盟以外の第三者が本システムを利用する場合、その結果について開発者及びボーイスカウト東京連盟は一切の責任を負いません。


## MIT License

Copyright (c) 2023 [ボーイスカウト東京連盟]('https://scout.tokyo')

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

本システムはボーイスカウト東京連盟AIS委員会の委託により作成されました。
著作権はボーイスカウト東京連盟に帰属しています。
