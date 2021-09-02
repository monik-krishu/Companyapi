<?php

if (!function_exists('APIResponse')) {
    function APIResponse ($statusCode = '', $message = '', $data = '') {
        $response = array();
        $response['status'] = [
            'code' => $statusCode,
            'message' => $message
        ];

        if (!empty($data) && !is_array($data))
            $response['payload'] = (object) $data->toArray();
        elseif (!empty($data))
            $response['payload'] = (object) $data;

        $response = response()->json($response, $statusCode);

        return $response;
    }
}






