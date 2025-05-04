<?php

namespace Modules\V1\Users\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\V1\Users\Controllers\API\Actions\CreateNewUser;
use Modules\V1\Users\Controllers\API\Actions\GetAllUsers;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/users",
     *     tags={"Users"},
     *     summary="List users",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function userList(GetAllUsers $action): JsonResponse
    {
        return $this->handleAction($action);
    }

    public function createUser(CreateNewUser $action): JsonResponse
    {
        return $this->handleAction($action);
    }
}
