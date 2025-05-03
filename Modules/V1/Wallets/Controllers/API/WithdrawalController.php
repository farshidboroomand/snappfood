<?php

namespace Modules\V1\Wallets\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\V1\Wallets\Controllers\API\Actions\CreateShebaRequest;

class WithdrawalController extends Controller
{
    public function createWithdrawalRequest(CreateShebaRequest $action): JsonResponse
    {
        return $this->handleAction($action);
    }
}
