<?php

namespace Modules\V1\Users\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\V1\Users\Controllers\API\Actions\CreateNewUser;

class UserController extends Controller
{
    public function createUser(CreateNewUser $action): JsonResponse
    {
        return $this->handleAction($action);
    }
}
