<?php

namespace Modules\V1\Wallets\Enums;

use App\Foundation\Enums\EnumValueListing;

enum WithdrawalStatus: string
{
    use EnumValueListing;
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
