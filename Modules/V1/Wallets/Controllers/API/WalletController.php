<?php

namespace Modules\V1\Wallets\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\V1\Wallets\Controllers\API\Actions\GetUsersWallet;

class WalletController extends Controller
{
    public function getUserWallet(GetUsersWallet $action): JsonResponse
    {
        return $this->handleAction($action);
    }
}
