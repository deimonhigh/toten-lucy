(function () {
  "use strict";

  angular.module("appToten").service("apiService", apiService);
  apiService.$inject = ['$http', 'localStorageService', '$q', 'config', '$timeout'];

  function apiService($http, localStorageService, $q, config, $timeout) {
    //region STORAGE
    var _getStorage = function (storage) {
      var storage = localStorageService.get(storage);
      return storage ? JSON.parse(atob(storage)) : false;
    };

    var _setStorage = function (storage, data) {
      localStorageService.set(storage, btoa(JSON.stringify(data)));
    };

    var _delStorage = function (storage) {
      localStorageService.remove(storage);
    };

    var _clearStorage = function () {
      localStorageService.keys().map(function (chave) {
        localStorageService.remove(chave);
      });
    };
    //endregion

    //region CEP e CNPJ
    var _cep = function (cep) {
      var deferred = $q.defer();

      cep = cep.replace(/\.|-/g, "");

      $http.get('https://viacep.com.br/ws/' + cep + '/json/')
           .then(function (retorno) {
             deferred.resolve(retorno.data);
           }, function (erro) {
             deferred.reject(erro.data);
           });
      return deferred.promise;
    };

    var _cnpj = function (cnpj) {
      if (cnpj == undefined) {
        return;
      }
      var deferred = $q.defer();
      cnpj = cnpj.replace(/\.|\/|-/g, "");
      var url = '//www.receitaws.com.br/v1/cnpj/' + cnpj + '?callback=JSON_CALLBACK';

      $http({
              method: 'jsonp',
              url: url,
              timeout: 1000
            })
        .then(function (retorno) {
          deferred.resolve(retorno.data);
        }, function (erro) {
          deferred.reject(erro.data);
        });
      return deferred.promise;
    };
    //endregion

    //region GEOLOCATION
    var _geocoder = function (endereco) {
      var deferred = $q.defer();
      $timeout(function () {
        $http.get('https://maps.googleapis.com/maps/api/geocode/json?address=' + encodeURI(endereco) + '&key=' + config.apiKeyGoogle)
             .then(function (retorno) {
               deferred.resolve(retorno.data);
             }, function (erro) {
               deferred.reject(erro.data);
             });
      }, 250);
      return deferred.promise;
    };

    var _reverseGeocoder = function (lat, long) {
      var deferred = $q.defer();
      $timeout(function () {
        $http.get('https://maps.googleapis.com/maps/api/geocode/json?latlng=' + lat + ',' + long + '&key=' + config.apiKeyGoogle)
             .then(function (retorno) {
               deferred.resolve(retorno.data);
             }, function (erro) {
               deferred.reject(erro.data);
             });
      }, 250);
      return deferred.promise;
    };
    //endregion

    //region Token
    var _token = function (dados) {
      var deferred = $q.defer();

      var enviar = {
        "grant_type": config.grant_type,
        "client_id": config.client_id,
        "client_secret": config.client_secret,
        "scope": config.scope,
        "username": dados.user,
        "password": dados.pass
      }

      $http.post(config.apiToken, enviar, config.header)
           .then(function (retorno) {
             deferred.resolve(retorno.data);
           }, function (erro) {
             deferred.reject(erro.data);
           });
      return deferred.promise;

    };
    //endregion

    //region Metodos API
    var _get = function (url, header) {

      var deferred = $q.defer();

      var separator = url.indexOf('?') === -1 ? '?' : '&';
      url = url + separator + 'noCache=' + new Date().valueOf();

      $http.get(config.apiUrl + url, header)
           .then(function (retorno) {
             deferred.resolve(retorno.data);
           }, function (erro) {
             deferred.reject(erro.data);
           });
      return deferred.promise;
    };

    var _post = function (url, data, header) {
      var deferred = $q.defer();

      var separator = url.indexOf('?') === -1 ? '?' : '&';
      url = url + separator + 'noCache=' + new Date().valueOf();

      $http.post(config.apiUrl + url, data, header)
           .then(function (retorno) {
             deferred.resolve(retorno.data);
           }, function (erro) {
             deferred.reject(erro.data);
           });
      return deferred.promise;
    };

    var _deletar = function (url, id) {
      var deferred = $q.defer();

      url = url.match(/\/$/) ? url : url + '/';

      var separator = url.indexOf('?') === -1 ? '?' : '&';
      url = url + id + separator + 'noCache=' + new Date().valueOf();

      $http.post(config.apiUrl + url, {})
           .then(function (retorno) {
             deferred.resolve(retorno.data);
           }, function (erro) {
             deferred.reject(erro.data);
           });

      return deferred.promise;

    };

    var _procurar = function (url, titulo) {
      var deferred = $q.defer();

      url = url.match(/\/$/) ? url : url + '/';

      var separator = url.indexOf('?') === -1 ? '?' : '&';
      url = url + titulo + separator + 'noCache=' + new Date().valueOf().toString();

      $http.get(config.apiUrl + url.toString())
           .then(function (retorno) {
             deferred.resolve(retorno.data);
           }, function (erro) {
             deferred.reject(erro.data);
           });
      return deferred.promise;
    };
    //endregion

    //region Metodos API - Multiple
    var _getAll = function (urls) {
      return $q.all(
        urls
          .map(function (url) {
            return $http.get(config.apiUrl + url)
          })
      );
    };

    var _postAll = function (urls, data) {
      return $q.all(
        urls
          .map(function (url, i) {
            return $http.post(config.apiUrl + url, data[i]);
          })
      );
    };
    //endregion

    //region SaveAs Method - REQUIRE FileSaver.js
    var _saveAs = function (url, data) {
      __postArrayBuffer(url, data).then(function (res) {
        var file = new Blob([res], {type: 'application/pdf'});
        saveAs(file, 'cuide-se_bem.pdf');
      });
    };

    var _getSaveAs = function (url, name) {
      _get(url).then(function (res) {
        var blob = new Blob([res], {
          type: 'text/plain;charset=utf-8'
        });
        saveAs(blob, filename);
      })
    };
    //endregion

    return {
      "getStorage": _getStorage,
      "setStorage": _setStorage,
      "delStorage": _delStorage,
      "clearStorage": _clearStorage,
      "cep": _cep,
      "cnpj": _cnpj,
      "geocoder": _geocoder,
      "reverseGeocoder": _reverseGeocoder,
      "get": _get,
      "post": _post,
      "procurar": _procurar,
      "deletar": _deletar,
      "getAll": _getAll,
      "postAll": _postAll,
      "saveAs": _saveAs,
      "getSaveAs": _getSaveAs,
      "token": _token
    }

  }

})();