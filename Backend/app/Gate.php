<?php

namespace App;

class Gate
{
  private static $denied = [
      'admin/categorias',
      'admin/lojas',
      'admin/usuarios',
      'admin/produtos/importarProdutosView',
      'admin/lojas/frete',
      'admin/lojas/frete/upload',
      'admin/produtos/habilitar',
  ];

  public static function access($uri)
  {
    if (!\Auth::user()->type) {
      return in_array($uri->action['prefix'], self::$denied);
    } else {
      return false;
    }
  }

  public static function hasAccess($target)
  {
    if (!\Auth::user()->type) {
      return !in_array($target, self::$denied);
    } else {
      return true;
    }
  }
}
