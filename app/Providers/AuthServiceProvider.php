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
                ->line('ボーイスカウト東京連盟AIS委員会です。以下のボタンをクリックしてメール認証を完了してください。')
                ->action('認証する', $url);
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
