<?php

namespace App\Observers;

use Modules\User\Entities\User;

class UserObserver
{
    /**
     * Handle the User creating event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function creating(User $user)
    {
        $user->api_token = bin2hex(openssl_random_pseudo_bytes(30));
    }
}