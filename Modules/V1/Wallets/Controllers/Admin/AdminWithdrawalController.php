<?php

namespace Modules\V1\Wallets\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\V1\Wallets\Controllers\Admin\Actions\ChangeWithdrawalRequestStatus;
use Modules\V1\Wallets\Controllers\Admin\Actions\GetAllWithdrawals;

class AdminWithdrawalController extends Controller
{
    /**
     * @OA\Get(
     *     path="/admin/v1/withdrawals",
     *     operationId="getAllAdminWithdrawals",
     *     tags={"Admin Withdrawals"},
     *     summary="Get all withdrawal requests (Admin)",
     *     description="Returns a paginated list of all withdrawal requests for admin review.",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         description="Page number for pagination",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         description="Number of results per page",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of withdrawal requests",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="withdrawalId", type="string", example="c7b1e76e-bc33-4c76-bd13-9e8a9dc63aa2"),
     *                     @OA\Property(property="amount", type="integer", example=500000),
     *                     @OA\Property(property="status", type="string", example="pending"),
     *                     @OA\Property(property="note", type="string", example="Urgent request"),
     *                     @OA\Property(property="fromShebaNumber", type="string", example="IR0000314596741760846999"),
     *                     @OA\Property(property="toShebaNumber", type="string", example="IR0000314596741760846888"),
     *                     @OA\Property(property="createdAt", type="string", format="date-time", example="2025-05-04T10:20:30Z")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error while fetching withdrawals"
     *     )
     * )
     */
    public function getAllRequestedWithdrawals(GetAllWithdrawals $action): JsonResponse
    {
        return $this->handleAction($action);
    }

    /**
     * @OA\Post(
     *     path="/admin/v1/withdrawals/{withdrawal_id}",
     *     operationId="changeWithdrawalRequestStatus",
     *     tags={"Admin Withdrawals"},
     *     summary="Change the status of a withdrawal request (Admin)",
     *     description="Allows an admin to confirm or cancel a withdrawal request.",
     *     @OA\Parameter(
     *         name="withdrawal_id",
     *         in="path",
     *         required=true,
     *         description="UUID of the withdrawal to update",
     *         @OA\Schema(type="string", format="uuid", example="a123e456-e89b-12d3-a456-426614174000")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status"},
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 enum={"confirmed", "canceled"},
     *                 description="New status of the withdrawal",
     *                 example="confirmed"
     *             ),
     *             @OA\Property(
     *                 property="note",
     *                 type="string",
     *                 description="Reason for cancellation (required if status is 'canceled')",
     *                 example="Duplicate request or invalid details"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Withdrawal status updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Withdrawal confirmed."),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="withdrawalId", type="string", example="a123e456-e89b-12d3-a456-426614174000"),
     *                 @OA\Property(property="status", type="string", example="confirmed"),
     *                 @OA\Property(property="note", type="string", example=null),
     *                 @OA\Property(property="confirmedAt", type="string", format="date-time", example="2025-05-04T11:00:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request or already confirmed/canceled",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="This withdrawal is already confirmed.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Withdrawal not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Withdrawal not found.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="status", type="array", @OA\Items(type="string", example="The selected status is invalid.")),
     *                 @OA\Property(property="note", type="array", @OA\Items(type="string", example="The note field is required when status is canceled."))
     *             )
     *         )
     *     )
     * )
     */
    public function changeRequestedWithdrawalStatus(ChangeWithdrawalRequestStatus $action): JsonResponse
    {
        return $this->handleAction($action);
    }
}
