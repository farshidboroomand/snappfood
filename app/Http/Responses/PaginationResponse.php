<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Enumerable;

class PaginationResponse
{
    /**
     * The last available page.
     *
     * @var int
     */
    protected int $lastPage;

    /**
     * @param Enumerable<int, mixed>|array<string, mixed> $items
     * @param int                                         $total
     * @param int                                         $perPage
     * @param int                                         $currentPage
     * @param array<string, mixed>                        $meta
     * @param StatusCode                                  $statusCode
     */
    public function __construct(
        protected Enumerable|array $items,
        protected int $total,
        protected int $perPage,
        protected int $currentPage = 1,
        protected array $meta = [],
        protected StatusCode $statusCode = StatusCode::OK
    ) {
        $this->lastPage = max((int)ceil($total / $perPage), 1);
    }

    /**
     * @param LengthAwarePaginator<mixed> $paginator
     * @param array<string, mixed>        $meta
     * @param StatusCode                  $statusCode
     *
     * @return PaginationResponse
     */
    public static function loadFromLengthAwarePaginator(
        LengthAwarePaginator $paginator,
        array $meta,
        StatusCode $statusCode
    ): PaginationResponse {
        return new PaginationResponse(
            $paginator->getCollection(),
            $paginator->total(),
            $paginator->perPage(),
            $paginator->currentPage(),
            $meta,
            $statusCode
        );
    }

    /**
     * if you use Model->pagination(), $withPagination must be true for handel pagination
     *
     * @param bool $withPagination
     *
     * @return JsonResponse
     */
    public function toJsonResponse(bool $withPagination = false): JsonResponse
    {
        if ($withPagination || is_array($this->items)) {
            $data = $this->items;
        } else {
            $data = request()->has('page') ? array_values($this->items->toArray()) : $this->items->toArray();
        }

        return new JsonResponse([
            'data' => $data,
            'meta' => array_merge($this->meta, [
                'pagination' => [
                    'total_items'  => $this->total,
                    'total_pages'  => $this->lastPage,
                    'current_page' => $this->currentPage,
                    'per_page'     => $this->perPage,
                ],
            ]),
        ], $this->statusCode->value);
    }

    public function toJsonResponsePagination(): JsonResponse
    {
        return new JsonResponse([
            'data' => $this->items,
            'meta' => array_merge(
                array_filter(
                    $this->meta,
                    function ($key) {
                        return ($key !== 'pagination');
                    },
                    ARRAY_FILTER_USE_KEY
                ),
                [
                    'pagination' => [
                        'total_items'       => $this->total,
                        'total_pages'       => $this->lastPage,
                        'current_page'      => $this->currentPage,
                        'per_page'          => $this->perPage,
                        'previous_page_url' => $this->meta['pagination']['previous_page_url'],
                        'next_page_url'     => $this->meta['pagination']['next_page_url'],
                        'path'              => $this->meta['pagination']['path'],
                    ],
                ]
            ),
        ], $this->statusCode->value);
    }
}
