@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('こんにちは')
@endif
@endif

{{-- Intro Lines --}}
{{-- @foreach ($introLines as $line)
{{ $line }}

@endforeach --}}
あなたのアカウントに対してパスワードのリセット申請がありましたのでメールをお送りします。<br>

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
{{-- @foreach ($outroLines as $line)
{{ $line }}

@endforeach --}}
このリセットリンクの有効期限は60分間です。時間内に上記のボタンよりパスワードリセット手続きを行ってください。<br>
もしパスワードをリセットしない場合はこのメールを無視してください。

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('よろしくお願いいたします。')<br>
{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "もし上記のボタンが動作しないときは以下のリンクをコピーしてブラウザに貼り付けてください。",
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent
