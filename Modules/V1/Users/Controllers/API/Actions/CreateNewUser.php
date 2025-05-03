<?php

namespace Modules\V1\Users\Controllers\API\Actions;

use App\Http\Actions\Action;
use App\Http\Responses\ErrorCode;
use Exception;
use Illuminate\Http\JsonResponse;
use Modules\V1\Users\Models\User;
use Modules\V1\Users\Resources\API\UserResource;

class CreateNewUser extends Action
{
    public function execute(): JsonResponse
    {
        /** @var array<string, string> $inputs */
        $inputs = $this->validator->validated();

        try {
            /** @var User $user */
            $user = User::create([
                'mobile'     => $inputs['mobile'],
                'first_name' => $inputs['first_name'],
                'last_name'  => $inputs['last_name'],
                'email'      => $inputs['email'],
                'password'   => $inputs['password'],
            ]);
        } catch (Exception $ex) {
            $this->logFailedReasonMessage(__('auth.users.register_failed'), $ex->getMessage());

            return $this->errorResponse(
                errorCode: ErrorCode::AUTH_USER_REGISTER_FAILED,
                message: __('auth.users.register_failed')
            );
        }
        return $this->resourceResponse(new UserResource($user));
    }

    protected function rules(): array
    {
        return [
            'first_name' => [
                'required',
                'string',
                'max:50'
            ],
            'last_name' => [
                'required',
                'string',
                'max:50'
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],
            'mobile' => [
                'unique:users,mobile',
                'required',
            ],
            'password' => [
                'required',
                'string'
            ]
        ];
    }
}
