<?php

namespace Modules\V1\Wallets\Controllers\Admin\Actions;

use App\Http\Actions\Action;
use App\Http\Responses\ErrorCode;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Modules\V1\Wallets\Enums\WithdrawalCacheKeys;
use Modules\V1\Wallets\Enums\WithdrawalCacheTTLs;
use Modules\V1\Wallets\Models\Withdrawal;
use Modules\V1\Wallets\Resources\API\WithdrawalResource;

class GetAllWithdrawals extends Action
{
    public function execute(): JsonResponse
    {
        /** @var int $page */
        $page = $this->request->input('page', 1);
        /** @var int $perPage */
        $perPage = $this->request->input('per_page', $this->per_page);
        try {
            $key = WithdrawalCacheKeys::WITHDRAWAL_LIST_CACHE_KEY->value . ":page:$page:perPage:$perPage";

            $withdrawals = Cache::remember(
                key: $key,
                ttl: WithdrawalCacheTTLs::WITHDRAWAL_LIST_CACHE_TTL->value,
                callback: function () use ($perPage, $page) {
                    return Withdrawal::query()
                                     ->orderBy('created_at', 'desc')
                                     ->paginate($perPage, ['*'], 'page', $page);
                }
            );
        } catch (Exception $ex) {
            $this->logFailedReasonMessage(__('wallets.get_wallet_failed'), $ex->getMessage());

            return $this->errorResponse(
                errorCode: ErrorCode::WALLET_WITHDRAWAL_FETCH_FAILED,
                message: __('wallets.get_wallet_failed')
            );
        }

        if (count($withdrawals) === 0) {
            return $this->dataCollectionResponse($withdrawals);
        }

        return $this->resourceResponse(WithdrawalResource::collection($withdrawals));
    }

    protected function rules(): array
    {
        return [];
    }
}
