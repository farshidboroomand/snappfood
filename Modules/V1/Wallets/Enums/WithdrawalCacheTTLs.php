<?php

namespace Modules\V1\Wallets\Enums;

use App\Foundation\Enums\EnumValueListing;

enum WithdrawalCacheTTLs: int
{
    use EnumValueListing;
    case WITHDRAWAL_LIST_CACHE_TTL = 86400; // 24 hours
}
