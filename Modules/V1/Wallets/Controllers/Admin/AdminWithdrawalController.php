<?php

namespace Modules\V1\Wallets\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\V1\Wallets\Controllers\Admin\Actions\ChangeWithdrawalRequestStatus;
use Modules\V1\Wallets\Controllers\Admin\Actions\GetAllWithdrawals;

class AdminWithdrawalController extends Controller
{
    public function getAllRequestedWithdrawals(GetAllWithdrawals $action): JsonResponse
    {
        return $this->handleAction($action);
    }

    public function changeRequestedWithdrawalStatus(ChangeWithdrawalRequestStatus $action): JsonResponse
    {
        return $this->handleAction($action);
    }
}
