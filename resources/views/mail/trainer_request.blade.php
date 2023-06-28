<p>{{ $trainer_name }} 様</p>
<p>ボーイスカウト東京連盟 {{ env('APP_NAME') }}から自動送信しています。</p>
<p>地区コミッショナーからの依頼により、{{ $name }}様の課題認定の依頼をお送り致します。</p>

<h3>認定方法</h3>
<a href="{{ url('/confirm/trainer?uuid=') }}{{ $uuid }}">{{ url('/confirm/trainer?uuid=') }}{{ $uuid }}</a>にアクセスしてください。<br>

<p>恐れ入りますがもしこの登録にお心当たりが無い場合は、<a href="mailto:wb-system@scout.tokyo">wb-system@scout.tokyo</a>までご連絡ください。</p>
<p></p>

----<br>
ボーイスカウト東京連盟 {{ env('APP_NAME') }}<br>
<a href="mailto:wb-system@scout.tokyo">wb-system@scout.tokyo</a>
