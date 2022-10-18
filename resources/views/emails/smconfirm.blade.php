{{-- {{ dd($user) }} --}}
<p>{{ $user->entryform->prefecture }}連盟 {{ $user->entryform->district }}地区 {{ $user->entryform->dan_name }}団<br>
{{ $user->name }}さん</p>

<p>第55回ローバー100kmハイクへのエントリーに関しまして、団の承認が行われたことをお知らせします。</p>

<p>承認日: {{ $user->entryform->sm_confirmation }}</p>

<pre>
==================================================
ボーイスカウト東京連盟RS100kmハイク
100kmハイクシステム
https://register.rs100.info
register.rs100km@gmail.com
==================================================
</pre>
