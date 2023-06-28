<p>{{ $name }} 様</p>
<p>ボーイスカウト東京連盟 {{ env('APP_NAME') }}から自動送信しています。</p>
@if ($cat == 'sc')
    <p>東京連盟事務局にてWB研修所スカウトコースの参加費お振り込みを確認致しました。</p>
@else
    <p>東京連盟事務局にてWB研修所課程別研修の参加費お振り込みを確認致しました。</p>
@endif

<h3>登録情報の確認方法</h3>
ご自身のメールアドレスとパスワードで<a href="{{ url('/') }}">システム</a>にログインしてご確認ください。<br>

<p>恐れ入りますがもしこの登録にお心当たりが無い場合は、<a href="mailto:wb-system@scout.tokyo">wb-system@scout.tokyo</a>までご連絡ください。</p>
<p></p>

----<br>
ボーイスカウト東京連盟 {{ env('APP_NAME') }}<br>
<a href="mailto:wb-system@scout.tokyo">wb-system@scout.tokyo</a>
