<?php

namespace Modules\V1\Wallets\Enums;

use App\Foundation\Enums\EnumValueListing;

enum WalletCacheKeys: string
{
    use EnumValueListing;
    case WALLET_LIST_CACHE_KEY = 'all_users_wallet_list_cache_key';
}
