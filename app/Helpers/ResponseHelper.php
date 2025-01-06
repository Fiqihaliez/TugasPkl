<?php

if (!function_exists('jsonResponse')) {
    /**
     * Helper untuk format JSON response.
     *
     * @param bool $success
     * @param string $message
     * @param mixed $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    function jsonResponse(bool $success, string $message, $data = null, int $status = 200)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    
}
