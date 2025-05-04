<?php

namespace Modules\V1\Wallets\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\V1\Users\Resources\API\UserResource;
use Modules\V1\Wallets\Models\Wallet;

/**
* @mixin Wallet
*/
class WalletResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'wallet_id' => $this->id,
            'user'      => $this->whenLoaded('user', function () {
                return new UserResource($this->user);
            }),
        ];
    }
}
