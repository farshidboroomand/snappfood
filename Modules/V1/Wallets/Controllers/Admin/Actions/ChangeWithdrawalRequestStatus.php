<?php

namespace Modules\V1\Wallets\Controllers\Admin\Actions;

use App\Http\Actions\Action;
use App\Http\Responses\ErrorCode;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Modules\V1\Wallets\Enums\WithdrawalStatus;
use Modules\V1\Wallets\Models\Withdrawal;
use Modules\V1\Wallets\Resources\API\WithdrawalResource;

class ChangeWithdrawalRequestStatus extends Action
{
    public function execute(): JsonResponse
    {
        /** @var array<string, string> $inputs */
        $inputs = $this->validator->validated();
        /** @var string $withdrawalId */
        $withdrawalId = $this->request->route('withdrawal_id');
        /** @var Withdrawal $withdrawal */
        $withdrawal = Withdrawal::query()->where('id', $withdrawalId)->first();

        if ($withdrawal == null) {
            return $this->clientErrorResponse(__('wallets.withdrawals.not_found'));
        }

        if ($withdrawal->status === WithdrawalStatus::CONFIRMED) {
            return $this->clientErrorResponse(__('wallets.withdrawals.already_confirmed'));
        }

        if ($withdrawal->status === WithdrawalStatus::CANCELED) {
            return $this->clientErrorResponse(__('wallets.withdrawals.already_canceled'));
        }

        try {
            DB::transaction(static function () use ($withdrawal, $inputs) {
                switch (WithdrawalStatus::from($inputs['status'])->value) {
                    case WithdrawalStatus::CONFIRMED->value:
                        $withdrawal->status = WithdrawalStatus::CONFIRMED;
                        $withdrawal->confirmed_at = now();
                        break;
                    case WithdrawalStatus::CANCELED->value:
                        $withdrawal->status = WithdrawalStatus::CANCELED;
                        $withdrawal->note = $inputs['note'] ?? null;
                        $withdrawal->canceled_at = now();
                        break;
                }

                $withdrawal->save();
            });
        } catch (Exception $ex) {
            $this->logFailedReasonMessage(__('wallets.withdrawals.cannot_be_updated'), $ex->getMessage());

            return $this->errorResponse(
                errorCode: ErrorCode::WALLET_WITHDRAWAL_UPDATE_STATUS_FAILED,
                message: __('wallets.withdrawals.cannot_be_updated')
            );
        }

        return $this->resourceResponse(
            new WithdrawalResource($withdrawal),
            $withdrawal->status === WithdrawalStatus::CONFIRMED->value ? __('wallets.withdrawals.confirmed') : __('wallets.withdrawals.cancelled')
        );
    }

    protected function rules(): array
    {
        return [
            'withdrawal_id' => [
                'exists:withdrawals,id'
            ],
            'status' => [
                'required',
                'in:' . implode(',', [
                    WithdrawalStatus::CONFIRMED->value,
                    WithdrawalStatus::CANCELED->value,
                ]),
            ],
            'note' => [
                'string',
                'required_if:status,' . WithdrawalStatus::CANCELED->value
            ]
        ];
    }
}
