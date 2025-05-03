<?php

namespace Modules\V1\Users\Enums;

use App\Foundation\Enums\EnumValueListing;

enum UserCacheKeys: string
{
    use EnumValueListing;
    case USER_LIST_CACHE_KEY = 'all_registered_users_cache_key';
}
