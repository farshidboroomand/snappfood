<?php

namespace Modules\V1\Wallets\Controllers\API\Actions;

use App\Http\Actions\Action;
use App\Http\Responses\ErrorCode;
use Exception;
use Illuminate\Http\JsonResponse;
use Modules\V1\Wallets\Models\Wallet;
use Modules\V1\Wallets\Resources\API\WalletResource;

class GetUsersWallet extends Action
{
    public function execute(): JsonResponse
    {
        /** @var string $walletId */
        $walletId = $this->request->route('wallet_id');

        try {
            $wallet = Wallet::query()->with(['user' => static function ($query) {
                $query->select('id', 'first_name', 'last_name', 'email');
            }])->where('id', $walletId)->first();
        } catch (Exception $ex) {
            $this->logFailedReasonMessage(__('wallets.get_wallet_failed'), $ex->getMessage());

            return $this->errorResponse(
                errorCode: ErrorCode::WALLET_FETCH_FAILED,
                message: __('wallets.get_wallet_failed')
            );
        }
        if ($wallet === null) {
            return $this->clientErrorResponse(__('wallets.not_found'));
        }

        return $this->resourceResponse(new WalletResource($wallet));
    }

    protected function rules(): array
    {
        return [
            'wallet_id' => [
                'exists:wallets,id'
            ]
        ];
    }
}
