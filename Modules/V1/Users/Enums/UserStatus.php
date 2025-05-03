<?php

namespace Modules\V1\Users\Enums;

use App\Foundation\Enums\EnumValueListing;

enum UserStatus: string
{
    use EnumValueListing;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case BLOCKED = 'blocked';
}
