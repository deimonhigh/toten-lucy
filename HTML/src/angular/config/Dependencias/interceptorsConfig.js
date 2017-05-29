﻿
//=require loadingInterceptor.js
//=require autenticacaoInterceptor.js

(function (angular) {
  angular
    .module("appToten")
    .config([
              '$httpProvider',
              function ($httpProvider) {
                $httpProvider.interceptors.push("autenticacaoInterceptor");
                $httpProvider.interceptors.push("loadingInterceptor");
              }
            ]);
})(angular);
