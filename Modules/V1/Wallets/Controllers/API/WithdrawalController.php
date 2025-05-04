<?php

namespace Modules\V1\Wallets\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\V1\Wallets\Controllers\API\Actions\CreateShebaRequest;

class WithdrawalController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/wallets/{wallet_id}/withdrawals/sheba",
     *     operationId="createShebaWithdrawal",
     *     tags={"Wallets"},
     *     summary="Create a withdrawal request to a sheba number",
     *     description="Creates a withdrawal request from the user's wallet to a given sheba number.",
     *
     *     @OA\Parameter(
     *         name="wallet_id",
     *         in="path",
     *         required=true,
     *         description="UUID of the wallet",
     *         @OA\Schema(type="string", format="uuid", example="d4211cc3-c2a2-4eeb-8d4d-bf0c4fc64547")
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"price", "from_sheba_number", "to_sheba_number"},
     *             @OA\Property(property="price", type="integer", example=100000),
     *             @OA\Property(property="from_sheba_number", type="string", example="IR0000314596741760846999"),
     *             @OA\Property(property="to_sheba_number", type="string", example="IR0000314596741760846888"),
     *             @OA\Property(property="note", type="string", example="Transfer for monthly expenses")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Withdrawal request created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="withdrawalId", type="string", example="cfffe99a-53fc-4abf-87c3-f7c5e58d022a"),
     *                 @OA\Property(property="amount", type="integer", example=100000),
     *                 @OA\Property(property="status", type="string", example="pending"),
     *                 @OA\Property(property="note", type="string", example="Transfer for monthly expenses"),
     *                 @OA\Property(property="fromShebaNumber", type="string", example="IR0000314596741760846999"),
     *                 @OA\Property(property="toShebaNumber", type="string", example="IR0000314596741760846888")
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Client error (e.g., insufficient balance or sheba mismatch)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Insufficient balance")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Validation failed",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="price", type="array", @OA\Items(type="string", example="The price must be at least 10000.")),
     *                 @OA\Property(property="from_sheba_number", type="array", @OA\Items(type="string", example="The from sheba number format is invalid.")),
     *                 @OA\Property(property="to_sheba_number", type="array", @OA\Items(type="string", example="The to sheba number format is invalid."))
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function createWithdrawalRequest(CreateShebaRequest $action): JsonResponse
    {
        return $this->handleAction($action);
    }
}
