<?php

namespace Modules\V1\Users\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $mobile
 * @property string $password
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
            'email'     => $this->email,
            'mobile'    => $this->mobile
        ];
    }
}
