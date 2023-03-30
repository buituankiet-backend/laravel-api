<?php

namespace App\Subscribers\Models;

use App\Events\Models\EventsUser;
use App\Listeners\SendWelcomeEmail;
use Illuminate\Contracts\Events\Dispatcher;

class UserSubscribers {
    public function subscriber(Dispatcher $events) {
            $events->listen(EventsUser::class, SendWelcomeEmail::class);
    }
}
