<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Controller as Controller;

class RestController extends Controller
{
  protected function jsonResponse(array $payload = [], $statusCode = 200, $errorCode = 0)
  {
    $payload = $payload ?: [];
    $payload['errorCode'] = $errorCode;

    return response()->json($payload, $statusCode);
  }

  protected function nonOk($message = "Ocorreu um erro inesperado", $statusCode = 404, $code = 0)
  {
    return $this->jsonResponse(['error' => $message], $statusCode, $code);
  }

  protected function Ok($message = "Sucesso!", $statusCode = 200, $code = 0)
  {
    return $this->jsonResponse(['result' => $message], $statusCode, $code);
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

