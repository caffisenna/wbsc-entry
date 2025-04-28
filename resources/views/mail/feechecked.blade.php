<p>ボーイスカウト東京連盟 指導者訓練 参加申込システム {{ config('app.name') }}から自動送信しています。</p>
<p>{{ $name }} 様</p>
@if ($cat == 'sc')
    <p>東京連盟事務局にてWB研修所スカウトコース(または団委員研修所)の参加費のご入金を確認致しました。</p>
@else
    <p>東京連盟事務局にてWB研修所課程別研修の参加費のご入金を確認致しました。</p>
@endif

<h3>登録情報の確認方法</h3>
ご自身のメールアドレスとパスワードで<a href="{{ url('/') }}">システム</a>にログインしてご確認ください。<br>

<p>このメールにお心当たりが無い場合は、<a href="mailto:wb-system-contact@scout.tokyo">wb-system-contact@scout.tokyo</a>までご連絡ください。</p>
<p></p>

----<br>
<a href="{{ config('app.url') }}">ボーイスカウト東京連盟 指導者訓練 参加申込システム {{ config('app.name') }}</a><br>
<a href="mailto:wb-system-contact@scout.tokyo">wb-system-contact@scout.tokyo</a>
