<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Model\Vendedor;
use App\Http\Controllers\Presentation\VendedorAdapter;
use App\Http\Controllers\RestController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiVendedorController extends BaseController
{
  /**
   * Display the specified resource.
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   * @internal param Vendedor|\App\Vendedor $vendedor
   */
  public function validate(Request $request)
  {
    try {
      $request = (object)$request->all();
      $vendedor = Vendedor::where('identificacao', $request->identificacao)->firstOrFail();

      if (!Hash::check($request->senha, $vendedor->senha)) {
        throw new \Exception("Identificação ou senha inválidos.");
      }

      return $this->Ok(VendedorAdapter::toView($vendedor));
    }
    catch (\Exception $e) {
      if ($this->isModelNotFoundException($e)) {
        return $this->modelNotFound();
      }
      return $this->nonOk($e->getMessage());
    }

  }

}
