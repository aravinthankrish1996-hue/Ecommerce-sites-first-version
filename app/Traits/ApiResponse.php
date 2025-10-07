<?php

namespace App\Traits;

use Carbon\Carbon;

trait ApiResponse
{
    /**
     * Respond with a success message.
     */
    protected function success($data, string $message = 'null', int $code = 200)
    {
        return response()->json([
            'status'  => 'success', // Use lowercase
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    /**
     * Respond with an error message.
     */
    protected function error(string $message = null, int $code, $data = null)
    {
        return response()->json([
            'status'  => 'error', // Use lowercase
            'message' => $message,
            'data'    => $data
        ], $code);
    }
}