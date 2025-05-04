<?php

namespace Modules\V1\Wallets\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\V1\Wallets\Controllers\API\Actions\GetUsersWallet;

class WalletController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/wallets/{wallet_id}",
     *     operationId="getUserWallet",
     *     tags={"Wallets"},
     *     summary="Fetch a user's wallet by wallet ID",
     *     description="Returns wallet details along with user information.",
     *     @OA\Parameter(
     *         name="wallet_id",
     *         in="path",
     *         required=true,
     *         description="UUID of the wallet",
     *         @OA\Schema(type="string", format="uuid", example="9e3342a5-621f-4d03-9a96-cd113fbba05f")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Wallet fetched successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="walletId", type="string", example="9e3342a5-621f-4d03-9a96-cd113fbba05f"),
     *                 @OA\Property(property="balance", type="number", format="float", example=1000000),
     *                 @OA\Property(property="availableBalance", type="number", format="float", example=800000),
     *                 @OA\Property(property="blockedAmount", type="number", format="float", example=200000),
     *                 @OA\Property(property="currency", type="string", example="IRT"),
     *                 @OA\Property(
     *                     property="user",
     *                     type="object",
     *                     @OA\Property(property="userId", type="string", example="f0576399-38fc-4846-bc16-a09d16a44437"),
     *                     @OA\Property(property="firstName", type="string", example="Noah"),
     *                     @OA\Property(property="lastName", type="string", example="Lakin"),
     *                     @OA\Property(property="email", type="string", format="email", example="noah.lakin@example.com")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Wallet not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error while retrieving wallet"
     *     )
     * )
     */
    public function getUserWallet(GetUsersWallet $action): JsonResponse
    {
        return $this->handleAction($action);
    }
}
