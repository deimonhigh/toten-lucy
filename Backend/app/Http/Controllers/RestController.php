<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Controller as Controller;

class RestController extends Controller
{
  protected function jsonResponse(array $payload = [], $statusCode = 200)
  {
    $payload = $payload ? $payload : [];

    return \Response::json($payload, $statusCode, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
  }

  protected function nonOk($message = "Ocorreu um erro inesperado", $statusCode = 404)
  {
    return $this->jsonResponse(['error' => $message], $statusCode);
  }

  protected function Ok($message = "Sucesso!", $statusCode = 200)
  {
    return $this->jsonResponse(['result' => $message], $statusCode);
  }

  protected function modelNotFound($message = "Registro não encontrado", $statusCode = 404)
  {
    return $this->jsonResponse(['error' => $message], $statusCode);
  }

  protected function isModelNotFoundException(\Exception $e)
  {
    return $e instanceof ModelNotFoundException;
  }
}

