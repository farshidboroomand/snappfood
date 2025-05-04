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
            'id'           => $this->id,
            'user_id'      => $this->user_id,
            'sheba_number' => $this->whenNotNull($this->sheba_number),
            'national_id'  => $this->whenNotNull($this->national_id),
        ];
    }
}
