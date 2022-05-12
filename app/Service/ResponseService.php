<?php


namespace MHFSaveManager\Service;


class ResponseService
{
    public static function SendNotFound($message = "Ressource not found")
    {
        http_response_code(404);
        header('Content-Type: application/json');
        exit(json_encode(['message' => $message]));
    }
    
    public static function SendOk($message = "Success") {
        http_response_code(200);
        header('Content-Type: application/json');
        exit(json_encode(['message' => $message]));
    }
    
    public static function SendServerError($message = "Internal Server Error") {
        http_response_code(500);
        header('Content-Type: application/json');
        exit(json_encode(['message' => $message]));
    }
    
    public static function SendUnprocessableEntity($message = "Could not process entity!") {
        http_response_code(422);
        header('Content-Type: application/json');
        exit(json_encode(['message' => $message]));
    }
    
    public static function SendDownload($path)
    {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($path));
        header('Pragma: no-cache');
        readfile($path);
        exit();
    }
}
