<p>{{ $entryInfo->user->name }} 様</p>

<p>ボーイスカウト東京連盟 指導者訓練 参加申込システム {{ config('app.name') }}から自動送信しています。</p>

<p>{{ now()->format('Y-m-d H:i') }} 現在、貴殿の参加費が振り込まれておりません。<br>
    至急下記口座までお振り込みくださいますようお願い致します。</p>

<p>
    参加コース:<br>
    <strong>
        @if ($cat == 'sc')
            スカウトコース {{ $entryInfo->sc_number }}期
        @elseif($cat == 'div')
            課程別研修 {{ $entryInfo->div_number }}回
        @elseif($cat == 'danken')
            団委員研修所 {{ $entryInfo->danken }}期
        @endif
    </strong>
</p>

<p>
    口座:<br>
    <strong>
        三菱UFJ銀行 新宿中央支店 普通口座 6402216<br>
        口座名: 一般社団法人日本ボーイスカウト東京連盟
    </strong>
</p>

<p><strong>振込名義と金額は参加決定通知をご確認ください。</strong></p>

<p>本メールと行き違いでお振り込みの場合はご容赦ください。</p>

<p>恐れ入りますがもしこの登録にお心当たりが無い場合は、<a href="mailto:wb-system@scout.tokyo">wb-system@scout.tokyo</a>までご連絡ください。</p>
<p></p>

----<br>
<a href="{{ config('app.url') }}">ボーイスカウト東京連盟 指導者訓練 参加申込システム {{ config('app.name') }}</a><br>
<a href="mailto:wb-system@scout.tokyo">wb-system@scout.tokyo</a>
