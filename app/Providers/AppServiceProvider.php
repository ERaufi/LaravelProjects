<?php

namespace App\Providers;

use App\Events\NewThingAddedEvent;
use App\Listeners\NewThingAddedListener;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    protected $listen = [
        NewThingAddedEvent::class => [
            NewThingAddedListener::class,
        ],
    ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    //

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->view('auth.verify-custom', [
                    'user' => $notifiable,
                    'url' => $url,
                ]);
        });
    }
}
