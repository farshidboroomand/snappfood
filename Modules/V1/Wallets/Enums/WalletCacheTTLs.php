<?php

namespace Modules\V1\Wallets\Enums;

use App\Foundation\Enums\EnumValueListing;

enum WalletCacheTTLs: int
{
    use EnumValueListing;
    case WALLET_LIST_CACHE_TTL = 86400; // 24 hours
}
