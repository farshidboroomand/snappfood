<?php

namespace Modules\V1\Users\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\V1\Users\Models\User;

/**
 * @mixin User
 */
class UserResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'userId'    => $this->id,
            'firstName' => $this->first_name,
            'lastName'  => $this->last_name,
            'email'     => $this->whenNotNull($this->email),
            'mobile'    => $this->whenNotNull($this->mobile),
        ];
    }
}
