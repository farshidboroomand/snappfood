<?php

namespace Modules\V1\Users\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\V1\Users\Controllers\API\Actions\UpdateUserProfile;

class UserProfileController extends Controller
{
    /**
     * @OA\Patch(
     *     path="/api/v1/users/{user_id}/profiles/{profile_id}",
     *     operationId="updateUserProfile",
     *     tags={"Users"},
     *     summary="Update a user profile",
     *     description="Allows updating the user's sheba number and national ID.",
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         description="UUID of the user",
     *         @OA\Schema(type="string", format="uuid", example="2bb3ded7-00be-4763-8016-9d072ba374d3")
     *     ),
     *     @OA\Parameter(
     *         name="profile_id",
     *         in="path",
     *         required=true,
     *         description="UUID of the user profile",
     *         @OA\Schema(type="string", format="uuid", example="a4b73c3c-5d3b-4f6b-9f58-0935b65430c2")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="sheba_number",
     *                 type="string",
     *                 example="IR123456789012345678901234",
     *                 description="Iranian sheba number (must be 24 characters, start with IR)"
     *             ),
     *             @OA\Property(
     *                 property="national_id",
     *                 type="string",
     *                 example="1234567890",
     *                 description="Iranian national ID (exactly 10 digits)"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profile updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="profileId", type="string", format="uuid", example="a4b73c3c-5d3b-4f6b-9f58-0935b65430c2"),
     *                 @OA\Property(property="userId", type="string", format="uuid", example="2bb3ded7-00be-4763-8016-9d072ba374d3"),
     *                 @OA\Property(property="shebaNumber", type="string", example="IR123456789012345678901234"),
     *                 @OA\Property(property="nationalId", type="string", example="1234567890")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Profile not found"
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
     *                     property="sheba_number",
     *                     type="array",
     *                     @OA\Items(type="string", example="The sheba number format is invalid.")
     *                 ),
     *                 @OA\Property(
     *                     property="national_id",
     *                     type="array",
     *                     @OA\Items(type="string", example="The national id must be 10 digits.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function updateUserProfile(UpdateUserProfile $action): JsonResponse
    {
        return $this->handleAction($action);
    }
}
