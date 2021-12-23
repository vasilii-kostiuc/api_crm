<?php
/**
 * api_crm.loc - ResponseService.php
 *
 * Created by Admin
 * Created on: 20.12.2021 22:44
 */

namespace App\Services\Response;


class ResponseService {

    private static function responseParams(bool $status, int $code = 200, array $errors = [], array $data = []) {
        return [
            'status' => $status,
            'code' => $code,
            'errors' => $errors,
            'data' => (object)$data,
        ];
    }

    public static function sendJsonResponse(bool $status, int $code = 200, array $errors = [], array $data = []) {
        return response()->json(
            self::responseParams($status, $code, $errors, $data),
            $code
        );
    }

    public static function succes($data = []) {
        return self::sendJsonResponse(true, 200, [], $data);
    }

    public static function notFound($data = []) {
        return self::sendJsonResponse(false, 404, [], []);
    }
}
