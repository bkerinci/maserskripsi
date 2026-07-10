<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;

class LogSuccessfulLogin
{
    public function __construct(private Request $request)
    {
    }

    public function handle(Login $event): void
    {
        $user = $event->user;
        $user->last_login_ip = $this->request->ip();
        $user->save();
    }
}
