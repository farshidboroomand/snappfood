<?php

namespace Modules\V1\Users\Enums;

use App\Foundation\Enums\EnumValueListing;

enum UserCacheTTLs: int
{
    use EnumValueListing;
    case USER_LIST_CACHE_TTL = 86400; // 24 hours
}
