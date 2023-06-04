<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>スカウトコース申込システム | HOMEててて</title>

    <!-- Styles welcome.cssに追い出した-->
    <link rel="stylesheet" href="{{ url('/css/welcome.css') }}" />

    <!-- UIkit CSS -->
    <link rel="stylesheet" href="{{ url('/uikit/uikit.min.css') }}" />

    <!-- UIkit JS -->
    <script src="{{ url('/uikit/uikit.min.js') }}"></script>
    <script src="{{ url('/uikit/uikit-icons.min.js') }}"></script>

    {{-- bg image --}}
    <style type="text/css">
        body {
            background-image: url("images/bg.jpg");
            /* 画像 */
            background-size: cover;
            /* 全画面 */
            background-attachment: fixed;
            /* 固定 */
            background-position: center center;
            /* 縦横中央 */
        }

        .txt-bg {
            display: inline;
            /* font-size: 2.5rem; */
            /* font-weight: 600; */
            /* line-height: 1.4em; */
            padding: 5px;
            background: linear-gradient(transparent 0%, #fffefe 50%);
            -webkit-box-decoration-break: clone;
            box-decoration-break: clone;
        }

        .mt-8 {
            opacity: 0.95 !important;
        }
    </style>
</head>

<body class="antialiased">
    <div class="relative flex items-top justify-center min-h-screen sm:items-center py-4 sm:pt-0">
        @if (Route::has('login'))
            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                @auth
                    <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">ログイン12</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">ユーザー登録</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                <img src="{{ url('/images/tokyo-logo.png') }}" alt="" width="200px" height="">
            </div>

            <div class="mt-8 dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <div class="flex items-center">
                            <span uk-icon="file-text"></span>
                            <div class="ml-4 text-lg leading-7 font-semibold"><a href="#"
                                    class="underline text-gray-900 dark:text-white">使い方</a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                <ol>
                                    <li>ユーザー登録をする</li>
                                    <li>メール認証をする</li>
                                    <li>ログインする</li>
                                    <li>申込データを入力する</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                        <div class="flex items-center">
                            <span uk-icon="user"></span>
                            <div class="uk-text-large" style="color: white;">アカウント</div>
                        </div>

                        <div class="">
                            <div class="mt-2">
                                @auth
                                    <a href="{{ url('/home') }}" class="uk-text-default" style="color: white;">Home</a>
                                @else
                                    <span uk-icon="sign-in" style="color: white"></span><a href="{{ route('login') }}"
                                        class="uk-text-default" style="color: white;">ログイン</a>

                                    @if (Route::has('register'))
                                        <br>
                                        <span uk-icon="user" style="color: white"></span><a href="{{ route('register') }}"
                                            class="uk-text-default" style="color: white;">ユーザー登録</a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <span uk-icon="comment"></span>
                            <div class="ml-4 text-lg leading-7 font-semibold"><a href="#"
                                    class="underline text-gray-900 dark:text-white">何かメニュー2</a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                何か一言
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-l">
                        <div class="flex items-center">
                            <span uk-icon="link"></span>
                            <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">リンク
                            </div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                <a href="https://www.scout.tokyo/member/training/">東京連盟加盟員サイト</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
                <div class="text-center text-sm text-gray-500 sm:text-left">
                    <div class="flex items-center">
                    </div>
                </div>

            </div>
            <p class="uk-text-large uk-text-emphasis txt-bg">ボーイスカウト東京連盟 WB研修所申込システム</p>
        </div>
    </div>
</body>

</html>
