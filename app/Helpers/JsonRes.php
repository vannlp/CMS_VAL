<?php
namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;

class JsonRes {
    protected $message;
    protected $status;

    /**
     * Returns a JSON response with a message.
     *
     * @param string $message The message to return.
     * @param int $status The HTTP status code.
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseWithMessage(string $message = '', int $status = 200)
    {
        return response()->json([
            'message' => $message,
            'status' => $status,
        ], $status);
    }

    /**
     * Returns a JSON response with data.
     *
     * @param string $message The message to return.
     * @param mixed $data The data to return.
     * @param int $status The HTTP status code.
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseWithData(string $message = '', $data = [], int $status = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'status' => $status,
        ], $status);
    }

    /**
     * Returns a paginated JSON response with data.
     *
     * @param string $message The message to return.
     * @param \Illuminate\Pagination\LengthAwarePaginator $paginator The paginator instance.
     * @param int $status The HTTP status code.
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseWithPagination(string $message = '', LengthAwarePaginator $paginator, int $status = 200)
    {
        $data = [
            'current_page' => $paginator->currentPage(),
            'data' => $paginator->items(),
            'first_page_url' => $paginator->url(1),
            'from' => $paginator->firstItem(),
            'last_page' => $paginator->lastPage(),
            'last_page_url' => $paginator->url($paginator->lastPage()),
            'next_page_url' => $paginator->nextPageUrl(),
            'per_page' => $paginator->perPage(),
            'prev_page_url' => $paginator->previousPageUrl(),
            'to' => $paginator->lastItem(),
            'total' => $paginator->total(),
            'message' => $message,
            'status' => $status,
        ];

        return response()->json($data, $status);
    }
}