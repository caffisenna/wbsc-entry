<p>ボーイスカウト東京連盟 指導者訓練 参加申込システム {{ config('app.name') }}から自動送信しています。</p>

<p>{{ $gm_name }} 様</p>

<p>地区コミッショナーからの依頼により、貴団所属の {{ $name }}様の指導者訓練参加承認の依頼をお送りします。</p>

<h3>承認方法</h3>
<a href="{{ url('/confirm/gm?uuid=') }}{{ $uuid }}">{{ url('/confirm/gm?uuid=') }}{{ $uuid }}</a>にアクセスして参加承認を行ってください。<br>
<p>ご参考: <a href="https://wbsc.scout.tokyo/howto_gm">団承認の仕方</a></p>

<p>このメールにお心当たりが無い場合は、<a href="mailto:wb-system-contact@scout.tokyo">wb-system-contact@scout.tokyo</a>までご連絡ください。</p>
<p></p>

----<br>
<a href="{{ config('app.url') }}">ボーイスカウト東京連盟 指導者訓練 参加申込システム {{ config('app.name') }}</a><br>
<a href="mailto:wb-system-contact@scout.tokyo">wb-system-contact@scout.tokyo</a>
