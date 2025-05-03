<?php

namespace Modules\V1\Wallets\Enums;

use App\Foundation\Enums\EnumValueListing;

enum WithdrawalCacheKeys: string
{
    use EnumValueListing;
    case WITHDRAWAL_LIST_CACHE_KEY = 'all_users_requested_withdrawals_cache_key';
}
