<?php

namespace Modules\V1\Wallets\Enums;

use App\Foundation\Enums\EnumValueListing;

enum TransactionTypeEnum: string
{
    use EnumValueListing;
    case INCREASE = 'Increase';
    case DECREASE = 'Decrease';
    case BLOCKED = 'Blocked';
    case RELEASED = 'Released';
    case UNBLOCKED = 'Unblocked';
}
