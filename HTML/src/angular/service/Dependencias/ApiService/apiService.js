(function () {
  "use strict";

  angular.module("appToten").service("apiService", apiService);
  apiService.$inject = ['$http', 'localStorageService', '$q', 'config', '$timeout'];

  function apiService($http, localStorageService, $q, config, $timeout) {
    var apiToken = config.dev ? config.apiTokenDev : config.apiToken;
    var apiUrl = config.dev ? config.apiUrlDev : config.apiUrl;
    var client_secret = config.dev ? config.client_secret_dev : config.client_secret;

    //region STORAGE
    var _getStorage = function (storage) {
      var storageResult = localStorageService.get(storage);
      return storageResult ? JSON.parse(atob(storageResult)) : false;
    };

    var _setStorage = function (storage, data) {
      data = !!data ? data : {};
      localStorageService.set(storage, btoa(JSON.stringify(data)));
    };

    var _delStorage = function (storage) {
      localStorageService.remove(storage);
    };

    var _clearStorage = function () {
      localStorageService.clearAll();
    };
    //endregion

    //region CEP e CNPJ
    var _cep = function (cep) {
      cep = cep.replace(/[^0-9]/g, "");

      var defer = $q.defer();
      $http.get('https://viacep.com.br/ws/' + cep + '/json/')
           .then(function (retorno) {
             defer.resolve(retorno.data);
           }, function (erro) {
             defer.reject(erro.data);
           });

      return defer.promise;
    };

    var _cnpj = function (cnpj) {
      if (cnpj == undefined) {
        return;
      }
      cnpj = cnpj.replace(/[^0-9]/g, "");
      var url = '//www.receitaws.com.br/v1/cnpj/' + cnpj + '?callback=JSON_CALLBACK';

      var defer = $q.defer();
      $http({
              method: 'jsonp',
              url: url,
              timeout: 1000
            })
        .then(function (retorno) {
          defer.resolve(retorno.data);
        }, function (erro) {
          defer.reject(erro.data);
        });

      return defer.promise;
    };
    //endregion

    //region GEOLOCATION
    var _geocoder = function (endereco) {
      var defer = $q.defer();
      $http.get('https://maps.googleapis.com/maps/api/geocode/json?address=' + encodeURI(endereco) + '&key=' + config.apiKeyGoogle)
           .then(function (retorno) {
             defer.resolve(retorno.data);
           }, function (erro) {
             defer.reject(erro.data);
           });

      return defer.promise;
    };

    var _reverseGeocoder = function (lat, long) {
          var defer = $q.defer();
          $http.get('https://maps.googleapis.com/maps/api/geocode/json?latlng=' + lat + ',' + long + '&key=' + config.apiKeyGoogle)
               .then(function (retorno) {
                 defer.resolve(retorno.data);
               }, function (erro) {
                 defer.reject(erro.data);
               });

          return defer.promise;
        }
    ;
    //endregion

    //region Token
    var _token = function (dados) {
      var defer = $q.defer();
      var dadosToken = {
        "grant_type": config.grant_type,
        "client_id": config.client_id,
        "client_secret": client_secret,
        "scope": config.scope,
        "username": dados.user,
        "password": dados.pass
      };

      $http.post(apiToken, dadosToken, config.header)
           .then(function (retorno) {
             defer.resolve(retorno.data);
           }, function (erro) {
             defer.reject(erro.data);
           });

      return defer.promise;
    };
    //endregion

    //region Metodos API
    var _get = function (url, header) {
      var separator = url.indexOf('?') === -1 ? '?' : '&';
      url = url + separator + 'noCache=' + new Date().valueOf();

      var defer = $q.defer();
      $http.get(apiUrl + url, header)
           .then(function (retorno) {
             defer.resolve(retorno.data);
           }, function (erro) {
             defer.reject(erro.data);
           });

      return defer.promise;
    };

    var _post = function (url, data, header) {
      var defer = $q.defer();
      $http.post(apiUrl + url, data, header)
           .then(function (retorno) {
             defer.resolve(retorno.data);
           }, function (erro) {
             defer.reject(erro.data);
           });

      return defer.promise;
    };

    var _delete = function (url, id) {
      url = url.match(/\/$/) ? url : url + '/';
      var separator = url.indexOf('?') === -1 ? '?' : '&';
      url = url + id + separator + 'noCache=' + new Date().valueOf();

      var defer = $q.defer();
      $http.post(apiUrl + url, {})
           .then(function (retorno) {
             defer.resolve(retorno.data);
           }, function (erro) {
             defer.reject(erro.data);
           });

      return defer.promise;
    };

    var _search = function (url, titulo) {
      url = url.match(/\/$/) ? url : url + '/';
      var separator = url.indexOf('?') === -1 ? '?' : '&';
      url = url + titulo + separator + 'noCache=' + new Date().valueOf().toString();

      var defer = $q.defer();
      $http.get(apiUrl + url.toString())
           .then(function (retorno) {
             defer.resolve(retorno.data);
           }, function (erro) {
             defer.reject(erro.data);
           });

      return defer.promise;
    };
    //endregion

    //region Metodos API - Multiple
    var _getAll = function (urls) {
      return $q.all(
        urls
          .map(function (url) {
            return $http.get(apiUrl + url)
          })
      );
    };

    var _postAll = function (urls, data) {
      return $q.all(
        urls
          .map(function (url, i) {
            return $http.post(apiUrl + url, data[i]);
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
      "search": _search,
      "delete": _delete,
      "getAll": _getAll,
      "postAll": _postAll,
      "saveAs": _saveAs,
      "getSaveAs": _getSaveAs,
      "token": _token
    }

  }

})();