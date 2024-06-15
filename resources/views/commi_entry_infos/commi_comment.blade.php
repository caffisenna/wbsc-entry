@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>副申請書の作成</h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        <p class="uk-text">{{ $userinfo->user->name }}さんについて、副申請書を作成します。</p>

        <div class="uk-card uk-card-default uk-card-body uk-width-1-2@m">

            <form method="POST" action="{{ route('commi_comment_post') }}">
                @csrf
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">副申請書の内容(上限400文字程度)</label>
                    <div class="uk-form-controls">
                        <textarea id="comment" name="comment" cols="30" rows="10" class="uk-textarea">
@if ($userinfo->additional_comment)
{{ $userinfo->additional_comment }}
@endif
</textarea>
                        {{-- <input class="uk-input" id="form-stacked-text" type="text" name="name" required> --}}
                        <div id="char-count">0 / 400</div>
                        <div class="progress">
                            <div id="progress-bar" class="progress-bar" style="width: 0%;"></div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="uuid" value="{{ $userinfo->uuid }}">
                <input type="submit" value="作成する" class="uk-button uk-button-primary uk-width-1-1@m">
                <button class="uk-button uk-button-default uk-modal-close uk-width-1-1@m" type="button"
                    onclick="history.back()">キャンセル</button>

            </form>
        </div>

    </div>

    <style>
        .progress {
            position: relative;
            height: 20px;
            background-color: #f3f3f3;
            border-radius: 5px;
            margin-top: 10px;
        }

        .progress-bar {
            height: 100%;
            background-color: #4caf50;
            border-radius: 5px;
            transition: width 0.3s, background-color 0.3s;
        }

        .progress-bar.over-limit {
            background-color: #f44336;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const textarea = document.getElementById('comment');
            const charCount = document.getElementById('char-count');
            const progressBar = document.getElementById('progress-bar');
            const maxChars = 400;

            textarea.addEventListener('input', function () {
                let currentLength = textarea.value.length;

                // If the current length exceeds maxChars, truncate the input
                if (currentLength > maxChars) {
                    textarea.value = textarea.value.substring(0, maxChars);
                    currentLength = maxChars;
                }

                charCount.textContent = `${currentLength} / ${maxChars}`;
                const percentage = (currentLength / maxChars) * 100;
                progressBar.style.width = `${percentage}%`;

                // Update progress bar color based on character limit
                if (currentLength > maxChars) {
                    progressBar.classList.add('over-limit');
                } else {
                    progressBar.classList.remove('over-limit');
                }
            });
        });
    </script>
@endsection
