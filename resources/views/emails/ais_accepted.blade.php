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
        <a href="https://drive.google.com/file/d/1YpsKgXc8BV4c5c6Yuq3KpQS5rpMF9OoU/view?usp=sharing">SC{{ $sc_number }}期の参加案内を表示する</a><br>
        <a href="https://drive.google.com/file/d/19QyP6jOibHQSQNOc1lRuqE8zFFoTDVzn/view?usp=sharing">携行品一覧</a>
    @endif
@endif

@if (isset($division_number))
    【課程別研修】<br>
    @if ($division_number == 'BVS14')
        <a href="https://drive.google.com/file/d/13zOJ4_Ak5jvthmUq-ztKLfGx5pvv3j5f/view?usp=drive_link">参加決定通知書(BVS課程東京第14回)</a>
    @elseif ($division_number == 'CS14')
        <a href="https://drive.google.com/drive/folders/1yRejlonJMk7mFF48TNj9ar3xHfJBoSgg?usp=sharing">参加決定通知書、関係資料(CS課程東京第14回)</a>
    @elseif ($division_number == 'BS14')
        <a href="https://drive.google.com/file/d/11IdLh6wqeo8xxcKSDdg7-AlfmQ4GZtdj/view?usp=drive_link">参加決定通知書(BS課程東京第14回)</a>
    @elseif ($division_number == 'VS14')
        <a href="https://drive.google.com/file/d/15vZdQ7LvOznTVw3wkjJB1fMz7bbQacZT/view?usp=drive_link">参加決定通知書(VS課程東京第14回)</a><br>
        <a href="{{ url('/download/VS14_worksheet.docx') }}">事前課題(wordファイル)</a>
    @endif
@endif

<p>恐れ入りますがもしこの登録にお心当たりが無い場合は、<a href="mailto:wb-system@scout.tokyo">wb-system@scout.tokyo</a>までご連絡ください。</p>
----<br>
<a href="{{ config('app.url') }}">ボーイスカウト東京連盟 指導者訓練 参加申込システム {{ config('app.name') }}</a><br>
<a href="mailto:wb-system@scout.tokyo">wb-system@scout.tokyo</a>
