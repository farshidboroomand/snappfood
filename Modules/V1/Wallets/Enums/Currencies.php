<?php

namespace Modules\V1\Wallets\Enums;

use App\Foundation\Enums\EnumValueListing;

enum Currencies: string
{
    use EnumValueListing;
    case RIAL = 'IRR';
}
