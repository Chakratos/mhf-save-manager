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
    
    public static function SendDownloadResource($resource, $filename = "bug.csv")
    {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Pragma: no-cache');
        echo stream_get_contents($resource);
        exit();
    }
    
    public static function SendBackToOrigin()
    {
        if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) && parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) == parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST)) {
            header( 'Cache-Control: no-cache, must-revalidate' );
            header(sprintf('Location: %s',$_SERVER['HTTP_REFERER']), true, 301);
        } else {
            header( 'Cache-Control: no-cache, must-revalidate', true, 301);
            header(sprintf('Location: %s://%s', $_SERVER['REQUEST_SCHEME'], $_SERVER['HTTP_HOST']));
        }
        exit();
    }
}
