(function (angular) {
  angular
    .module("appToten")
    .factory('autenticacaoInterceptor', autenticacaoInterceptor);

  autenticacaoInterceptor.$inject = ['$q', '$state', '$injector'];

  function autenticacaoInterceptor($q, $state, $injector) {
    return {
      request: function (requisicao) {
        var api = $injector.get('apiService');
        var autorizacaoDados = api.getStorage('auth');
        if (requisicao.url.indexOf('.html') === -1 && requisicao.url.indexOf("api") > -1 && autorizacaoDados.access_token) {
          requisicao.headers["Authorization"] = "Bearer " + autorizacaoDados.access_token;
        }

        return requisicao || $q.when(requisicao);
      },
      response: function (response) {
        if (response.status === 401) {
          var api = $injector.get('apiService');
          api.clearStorage();
          return $q.reject(response);
        }
        if ([404, 500, 400].indexOf(response.status) > -1) {
          return $q.reject(response);
        }
        return response || $q.when(response);
      }
    }
  }

})(angular);