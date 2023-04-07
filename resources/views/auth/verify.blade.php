@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7" style="margin-top: 2%">
                <div class="box">
                    <h3 class="box-title" style="">メール認証</h3>

                    <div class="box-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                入力されたメールアドレスに確認メールを送信しました。メールをご確認ください。<br>
                                認証が完了しないと申込書を作成できません。
                            </div>
                        @endif
                        <p>
                            届いたメールに認証ボタンがありますので、それをクリックして登録を完了してください。<br>
                            もしメールが届いていない場合は下記のリンクから認証メールを再送してください。
                        </p>

                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('resend-form').submit();">
                            認証メールを再送する
                        </a>
                        <form id="resend-form" action="{{ route('verification.resend') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                    <p class="uk-text">もし認証済みでこの画面が表示されているようならば<a href="{{ url('/home') }}">HOME</a>へ進んでください。</p>
                </div>
            </div>
        </div>
    </div>
@endsection
