<?php

namespace App\Http\Actions;

use App\Http\Responses\ErrorCode;
use App\Http\Responses\PaginationResponse;
use App\Http\Responses\StatusCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidatorObject;

abstract class Action
{
    protected Request | FormRequest $request;

    protected array $validationErrors = [];

    protected ValidatorObject $validator;

    protected int $per_page;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->per_page = $request->per_page ?? 15;
    }

    final public function validate(): bool
    {
        $route = $this->request->route();
        if ($route !== null) {
            $this->request->merge($route->parameters());
        }

        $this->validator = Validator::make(
            $this->request->all(),
            $this->rules(),
            $this->messages()
        );

        $paginationValidator = Validator::make(
            $this->request->all(),
            [
                'paginated' => 'boolean',
                'per_page'  => 'integer|min:1',
            ]
        );

        if ($this->validator->passes() && $paginationValidator->passes()) {
            return true;
        }

        $this->validationErrors = array_merge(
            $this->validator->getMessageBag()->messages(),
            $paginationValidator->getMessageBag()->messages()
        );

        return false;
    }

    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }

    abstract public function execute(): JsonResponse;

    protected function rules(): array
    {
        return [];
    }

    protected function messages(): array
    {
        return [];
    }

    protected function resourceResponse(
        JsonResource $resource,
        ?string $message = null,
        ?array $meta = [],
        StatusCode $statusCode = StatusCode::OK
    ): JsonResponse {
        return new JsonResponse(
            array_filter([
                'message' => $message,
                'data'    => $resource,
                'meta'    => array_filter((array)$meta),
            ]),
            $statusCode->value
        );
    }

    protected function dataCollectionResponse(
        Collection $collection,
        ?array $meta = [],
        StatusCode $statusCode = StatusCode::OK,
        bool $paginated = false,
        ?int $page = null,
        ?int $perPage = null,
    ): JsonResponse {
        $page = $page ?? $this->request->input('page', 1);
        $perPage = $perPage ?? $this->request->input('per_page', 15);

        if ($paginated || $this->request->input('paginated', false)) {
            return (new PaginationResponse(
                $collection->forPage($page, $perPage),
                $collection->count(),
                $perPage,
                $page,
                (array)$meta,
                $statusCode
            ))->toJsonResponse();
        }

        return new JsonResponse(
            array_filter([
                'data' => $collection,
                'meta' => array_filter((array)$meta),
            ]),
            $statusCode->value,
        );
    }

    protected function emptyResponse(StatusCode $statusCode = StatusCode::NO_CONTENT): JsonResponse
    {
        return new JsonResponse(null, $statusCode->value);
    }

    protected function clientErrorResponse(
        string $message,
        StatusCode $statusCode = StatusCode::BAD_REQUEST
    ): JsonResponse {
        return new JsonResponse(
            [
                'message' => $message,
            ],
            $statusCode->value
        );
    }

    protected function validationErrorResponse(
        array $errors,
        ?string $message = null,
        StatusCode $statusCode = StatusCode::UNPROCESSABLE_ENTITY
    ): JsonResponse {
        return new JsonResponse(
            array_filter([
                'message' => $message,
                'errors'  => $errors,
            ]),
            $statusCode->value
        );
    }

    protected function errorResponse(
        ErrorCode $errorCode,
        ?string $message = null,
        StatusCode $statusCode = StatusCode::INTERNAL_SERVER_ERROR
    ): JsonResponse {
        return new JsonResponse(
            array_filter([
                'message' => $message ?? __('errors.internal_error'),
                'code'    => $errorCode->value,
            ]),
            $statusCode->value
        );
    }
}
