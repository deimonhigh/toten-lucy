angular
  .module("appToten")
  .factory("autenticacaoInterceptor", [
    'localStorageService', 'config', 'base64Factory', '$location', function (localStorageService, config, base64Factory, $location) {
      return {
        request: function (requisicao) {

          try {
            var storage = localStorageService.get('auth');

            if (
              storage == null || requisicao.url.indexOf('.html') > -1
            ) {
              throw "Invalid"
            }

            var autorizacaoDados = JSON.parse(base64Factory.decode(storage));

            if (autorizacaoDados) {
              if (requisicao.url.indexOf("api") > -1 && requisicao.url.indexOf('oauth') == -1) {
                requisicao.headers["Authorization"] = "Bearer " + autorizacaoDados.access_token;
              }
            }

            return requisicao;
          }
          catch (e) {
            if (requisicao.url.indexOf("apigopharma") == -1) {
              return requisicao;
            }
          }

        }
      }
    }
  ]);