<?php

namespace Modules\V1\Users\Observers;

namespace Modules\V1\Users\Observers;

use Illuminate\Support\Facades\Cache;
use Modules\V1\Users\Enums\UserCacheKeys;
use Modules\V1\Users\Events\UserCreated;
use Modules\V1\Users\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        Cache::forget(UserCacheKeys::USER_LIST_CACHE_KEY->value);

        event(new UserCreated($user));
    }
}
