<?php

namespace Modules\V1\Users\Controllers\API\Actions;

use App\Http\Actions\Action;
use App\Http\Responses\ErrorCode;
use Exception;
use Illuminate\Http\JsonResponse;
use Modules\V1\Users\Models\UserProfile;
use Modules\V1\Users\Resources\API\UserProfileResource;

class UpdateUserProfile extends Action
{
    public function execute(): JsonResponse
    {
        /** @var array<string, mixed> $inputs */
        $inputs = $this->validator->validated();
        /** @var string $userId */
        $userId = $this->request->route('user_id');
        /** @var string $profileId */
        $profileId = $this->request->route('profile_id');

        $profile = UserProfile::query()
                              ->where('id', $profileId)
                              ->where('user_id', $userId)
                              ->first();
        if ($profile === null) {
            return $this->clientErrorResponse(__('auth.profile.not_found'));
        }

        if (isset($inputs['sheba_number'])) {
            $profile->sheba_number = $inputs['sheba_number'];
        }

        if (isset($inputs['national_id'])) {
            $profile->national_id = $inputs['national_id'];
        }

        try {
            $profile->save();
        } catch (Exception $ex) {
            $this->logFailedReasonMessage(__('auth.profile.cannot_be_updated'), $ex->getMessage());

            return $this->errorResponse(
                errorCode: ErrorCode::AUTH_USER_PROFILE_UPDATE_FAILED,
                message: __('auth.profile.cannot_be_updated')
            );
        }

        return $this->resourceResponse(new UserProfileResource($profile), __('auth.profile.updated'));
    }

    protected function rules(): array
    {
        return [
            'sheba_number' => [
                'string',
                'regex:/^IR[0-9]{22}$/',
                'size:24'
            ],
            'national_id' => [
                'string',
                'max:10',
                'regex:/^[0-9]{10}$/',
            ]
        ];
    }
}
