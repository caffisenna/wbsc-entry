<p>{{ $entryInfo->user->name }} 様</p>

<p>ボーイスカウト東京連盟 指導者訓練 参加申込システム {{ config('app.name') }}から自動送信しています。</p>

<p>
先日、「参加費の振り込みを確認」という旨のメールをお送りいたしましたが、確認したところ実際には入金がされていなかったことが判明いたしました。<br>
誤ったお知らせを差し上げ、混乱を招く結果となりましたこと、心よりお詫び申し上げます。<br>
<br>
お手数をおかけいたしますが、改めてお振り込みをお願い申し上げます。<br>
何かご不明点等ございましたら、お気軽にお知らせください。<br>
<br>
何卒よろしくお願い申し上げます。
</p>

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

<p>恐れ入りますがもしこの登録にお心当たりが無い場合は、<a href="mailto:wb-system-contact@scout.tokyo">wb-system-contact@scout.tokyo</a>までご連絡ください。</p>
<p></p>

----<br>
<a href="{{ config('app.url') }}">ボーイスカウト東京連盟 指導者訓練 参加申込システム {{ config('app.name') }}</a><br>
<a href="mailto:wb-system-contact@scout.tokyo">wb-system-contact@scout.tokyo</a>
