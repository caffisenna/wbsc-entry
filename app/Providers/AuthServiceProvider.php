<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // 日本語化
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('メール認証のお知らせ')
                ->line('このメールは、ボーイスカウト東京連盟 指導者訓練 参加申込システム AISESから自動送信しています。')
                ->line('AISESで申し込み手続きをするには、以下のボタンをクリックしてメール認証を完了してください。')
                ->action('認証する', $url)
                ->line('メール認証が完了したら、ユーザーマニュアルを参照の上、申込書を作成してください。')
                ->line('もし、このメールにお心当たりが無い場合は、wb-system-contact@scout.tokyo までご連絡ください。');
        });

        Gate::define('admin', function (\App\Models\User $user) {
            return $user->is_admin;
        });

        // AIS委員
        Gate::define('ais', function (\App\Models\User $user) {
            return $user->is_ais;
        });

        // 県連
        Gate::define('commi', function (\App\Models\User $user) {
            return $user->is_commi;
        });

        // コーススタッフ
        Gate::define('course_staff', function (\App\Models\User $user) {
            return $user->is_course_staff;
        });
    }
}
