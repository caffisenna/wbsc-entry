<p>ボーイスカウト東京連盟 指導者訓練 参加申込システム {{ config('app.name') }}から自動送信しています。</p>

<p>{{ $trainer_name }} 様</p>

<p>地区コミッショナーからの依頼により、{{ $name }}様の課題認定の依頼をお送り致します。</p>

<h3>認定方法</h3>
<a href="{{ url('/confirm/trainer?uuid=') }}{{ $uuid }}">{{ url('/confirm/trainer?uuid=') }}{{ $uuid }}</a>にアクセスしてください。<br>
<p>ご参考: <a href="https://wbsc.scout.tokyo/howto_trainer">トレーナー認定の仕方</a></p>

<p>恐れ入りますがもしこの登録にお心当たりが無い場合は、<a href="mailto:wb-system-contact@scout.tokyo">wb-system-contact@scout.tokyo</a>までご連絡ください。</p>
<p></p>

----<br>
<a href="{{ config('app.url') }}">ボーイスカウト東京連盟 指導者訓練 参加申込システム {{ config('app.name') }}</a><br>
<a href="mailto:wb-system-contact@scout.tokyo">wb-system-contact@scout.tokyo</a>
