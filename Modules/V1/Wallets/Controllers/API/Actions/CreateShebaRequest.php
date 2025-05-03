<?php

namespace Modules\V1\Wallets\Controllers\API\Actions;

use App\Http\Actions\Action;
use App\Http\Responses\ErrorCode;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Modules\V1\Wallets\Models\Wallet;
use Modules\V1\Wallets\Models\Withdrawal;
use Modules\V1\Wallets\Resources\API\WithdrawalResource;

class CreateShebaRequest extends Action
{
    public function execute(): JsonResponse
    {
        /** @var array<string, string> $inputs */
        $inputs = $this->validator->validated();

        /** @var string $walletId */
        $walletId = $this->request->route('wallet_id');
        /** @var Wallet $wallet */
        $wallet = Wallet::query()->where('id', $walletId)->first();

        if ($wallet->hasSufficientBalance() === false) {
            return $this->clientErrorResponse(__('wallets.insufficient_balance'));
        }

        if ($wallet->available_balance < $inputs['price']) {
            return $this->clientErrorResponse(__('wallets.insufficient_balance'));
        }

        if ($inputs['from_sheba_number'] === $inputs['to_sheba_number']) {
            return $this->clientErrorResponse(__('wallets.withdrawals.sheba_numbers_are_the_same'));
        }

        try {
            $withdrawalRequest = DB::transaction(static function () use ($wallet, $inputs) {
                return Withdrawal::create([
                   'user_id'           => $wallet->user_id,
                   'wallet_id'         => $wallet->id,
                   'from_sheba_number' => $inputs['from_sheba_number'],
                   'to_sheba_number'   => $inputs['to_sheba_number'],
                   'amount'            => $inputs['price'],
                   'note'              => $inputs['note'] ?? null
                ]);
            });
        } catch (Exception $ex) {
            $this->logFailedReasonMessage(__('wallets.withdrawals.cannot_be_created'), $ex->getMessage());

            return $this->errorResponse(
                errorCode: ErrorCode::WALLET_WITHDRAWAL_REQUEST_CREATE_FAILED,
                message: __('wallets.withdrawals.cannot_be_created')
            );
        }

        return $this->resourceResponse(new WithdrawalResource($withdrawalRequest));
    }

    protected function rules(): array
    {
        return [
            'wallet_id' => [
                'exists:wallets,id'
            ],
            'price' => [
                'required',
                'integer',
                'min: 10000'
            ],
            'from_sheba_number' => [
                'required',
                'string',
                'regex:/^IR[0-9]{22}$/',
                'size:24'
            ],
            'to_sheba_number' => [
                'required',
                'string',
                'regex:/^IR[0-9]{22}$/',
                'size:24'
            ],
            'note' => [
                'string',
                'max:250'
            ]
        ];
    }
}
