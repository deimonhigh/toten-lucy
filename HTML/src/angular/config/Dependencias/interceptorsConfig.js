//=require autenticacaoInterceptor.js
//=require errorInterceptor.js

(function (angular) {
  angular
    .module("appToten")
    .config([
              '$httpProvider',
              function ($httpProvider) {
                $httpProvider.interceptors.push("autenticacaoInterceptor");
                $httpProvider.interceptors.push("errorInterceptor");
              }
            ]);
})(angular);

