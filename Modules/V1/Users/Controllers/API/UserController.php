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
     *     operationId="getAllUsers",
     *     tags={"Users"},
     *     summary="Get a paginated list of users",
     *     description="Returns a paginated list of all registered users.",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of items per page",
     *         required=false,
     *         @OA\Schema(type="integer", default=15)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="user_id", type="string", format="uuid", example="2bb3ded7-00be-4763-8016-9d072ba374d3"),
     *                     @OA\Property(property="first_name", type="string", example="Charlie"),
     *                     @OA\Property(property="last_name", type="string", example="Stehr"),
     *                     @OA\Property(property="email", type="string", format="email", example="clemmie.bartell@example.org"),
     *                     @OA\Property(property="mobile", type="string", example="+1-240-842-4579")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to retrieve users"
     *     )
     * )
     */
    public function userList(GetAllUsers $action): JsonResponse
    {
        return $this->handleAction($action);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/users",
     *     operationId="createUser",
     *     tags={"Users"},
     *     summary="Create a new user",
     *     description="Creates a new user with the given information.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"first_name", "last_name", "email", "mobile", "password"},
     *             @OA\Property(property="first_name", type="string", example="farshid"),
     *             @OA\Property(property="last_name", type="string", example="boroomand"),
     *             @OA\Property(property="email", type="string", format="email", example="farshid@gmail.com"),
     *             @OA\Property(property="mobile", type="string", example="9124049032"),
     *             @OA\Property(property="password", type="string", example="secret123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="userId", type="string", format="uuid", example="4ebe61f9-97de-4505-a4af-338559cce665"),
     *                 @OA\Property(property="firstName", type="string", example="farshid"),
     *                 @OA\Property(property="lastName", type="string", example="boroomand"),
     *                 @OA\Property(property="email", type="string", format="email", example="farshid@gmail.com"),
     *                 @OA\Property(property="mobile", type="string", example="9124049032")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation failed",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="first_name",
     *                     type="array",
     *                     @OA\Items(type="string", example="The first name field is required.")
     *                 ),
     *                 @OA\Property(
     *                     property="last_name",
     *                     type="array",
     *                     @OA\Items(type="string", example="The last name field is required.")
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="array",
     *                     @OA\Items(type="string", example="The email field is required.")
     *                 ),
     *                 @OA\Property(
     *                     property="mobile",
     *                     type="array",
     *                     @OA\Items(type="string", example="The mobile field is required.")
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="array",
     *                     @OA\Items(type="string", example="The password field is required.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function createUser(CreateNewUser $action): JsonResponse
    {
        return $this->handleAction($action);
    }
}
