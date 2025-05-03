<?php

namespace Modules\V1\Users\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\V1\Users\Controllers\API\Actions\UpdateUserProfile;

class UserProfileController extends Controller
{
    public function updateUserProfile(UpdateUserProfile $action): JsonResponse
    {
        return $this->handleAction($action);
    }
}
