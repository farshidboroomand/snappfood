<?php

namespace Modules\V1\Users\Controllers\API\Actions;

use App\Http\Actions\Action;
use App\Http\Responses\ErrorCode;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Modules\V1\Users\Enums\UserCacheKeys;
use Modules\V1\Users\Enums\UserCacheTTLs;
use Modules\V1\Users\Models\User;
use Modules\V1\Users\Resources\API\UserResource;

class GetAllUsers extends Action
{
    public function execute(): JsonResponse
    {
        try {
            $users = Cache::remember(
                key: UserCacheKeys::USER_LIST_CACHE_KEY->value,
                ttl: UserCacheTTLs::USER_LIST_CACHE_TTL->value,
                callback: function () {
                    return User::query()->paginate($this->per_page);
                }
            );
        } catch (Exception $ex) {
            $this->logFailedReasonMessage(__('auth.users.get_list_failed'), $ex->getMessage());

            return $this->errorResponse(
                errorCode: ErrorCode::AUTH_USER_REGISTER_FAILED,
                message: __('auth.users.get_list_failed')
            );
        }

        if (count($users) === 0) {
            return $this->dataCollectionResponse($users);
        }

        return $this->resourceResponse(UserResource::collection($users));
    }

    protected function rules(): array
    {
        return [];
    }
}
