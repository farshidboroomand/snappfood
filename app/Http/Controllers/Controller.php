<?php

namespace App\Http\Controllers;

use App\Http\Actions\Action;
use App\Http\Responses\StatusCode;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use ValidatesRequests;

    /**
     * @OA\Info(
     *     title="Snappfood API",
     *     version="V1",
     *     description="API documentation for the Snappfood.",
     *     @OA\Contact(
     *         email="farshidboroomand@gmail.com.com"
     *     )
     * )
     */
    protected function handleAction(Action $action): JsonResponse
    {
        if (!$action->validate()) {
            return new JsonResponse(
                array_filter([
                    'errors' => $action->getValidationErrors(),
                ]),
                StatusCode::UNPROCESSABLE_ENTITY->value
            );
        }

        return $action->execute();
    }
}
