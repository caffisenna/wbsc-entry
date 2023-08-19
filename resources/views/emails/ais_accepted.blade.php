<p>ボーイスカウト東京連盟 指導者訓練 参加申込システム {{ config('app.name') }}から自動送信しています。</p>

<p>
    {{ $name }} 様が申し込みをされました研修所について、参加が決定いたしましたのでお知らせいたします。<br>
    下記URLより参加案内を確認のうえ、ご参加ください。<br>
    また、万が一、参加を取りやめる場合は、速やかに東京連盟事務局までご連絡ください。
</p>

@if (isset($sc_number))
    【参加案内】<br>
    {{-- SC29のリンク --}}
    @if ($sc_number == 29)
        <a
            href="https://drive.google.com/file/d/1ceuZh1tsKWXnSwZ91SRPRwJO8waF8r0q/view?usp=drive_link">SC{{ $sc_number }}期の参加案内を表示する</a>
    @elseif($sc_number == 30)
        {{-- SC30のリンク --}}
        <a href="#">SC{{ $sc_number }}期の参加案内を表示する</a>
    @endif
@endif

@if (isset($division_number))
    【課程別】<br>
    @if ($division_number == 'BVS14')
        <a href="#">BVS14のPDFリンク</a>
    @elseif ($division_number == 'CS14')
        <a href="#">CS14回のPDFリンク</a>
    @elseif ($division_number == 'BS14')
        <a href="#">BS14回のPDFリンク</a>
    @elseif ($division_number == 'VS14')
        <a href="#">VS14回のPDFリンク</a>
    @endif
@endif

<p>恐れ入りますがもしこの登録にお心当たりが無い場合は、<a href="mailto:wb-system@scout.tokyo">wb-system@scout.tokyo</a>までご連絡ください。</p>
----<br>
<a href="{{ config('app.url') }}">ボーイスカウト東京連盟 指導者訓練 参加申込システム {{ config('app.name') }}</a><br>
<a href="mailto:wb-system@scout.tokyo">wb-system@scout.tokyo</a>
