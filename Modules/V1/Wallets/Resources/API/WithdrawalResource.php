<?php

namespace Modules\V1\Wallets\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\V1\Wallets\Models\Withdrawal;

/**
* @mixin Withdrawal
*/
class WithdrawalResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'amount'            => (int)$this->amount,
            'from_sheba_number' => $this->from_sheba_number,
            'to_sheba_number'   => $this->to_sheba_number,
            'note'              => $this->note,
            'status'            => $this->status,
            'created_at'        => $this->created_at
        ];
    }
}
