<?php

namespace Modules\V1\Users\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\V1\Users\Models\UserProfile;

/**
 * @mixin UserProfile
 */
class UserProfileResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'userId'      => $this->user_id,
            'shebaNumber' => $this->whenNotNull($this->sheba_number),
            'nationalId'  => $this->whenNotNull($this->national_id),
        ];
    }
}
