(function () {
  "use strict";

  angular.module("appGoPharma").service("apiService", apiService);
  apiService.$inject = ['$http', 'localStorageService', '$q', '$httpParamSerializer', 'base64Factory', 'config', '$timeout', '$cordovaGeolocation', '$mdDialog', '$state', '$location'];

  function apiService($http, localStorageService, $q, $httpParamSerializer, base64Factory, config, $timeout, $cordovaGeolocation, $mdDialog, $state, $location) {
    var urls = {
      "auth": config.AMBIENTE.Gopharma_HOM.URL_OAUTH,
      "url": config.AMBIENTE.Gopharma_HOM.URL,
      "url_s": config.AMBIENTE.Gopharma_HOM.URL_S,
      "url_download": config.AMBIENTE.Gopharma_HOM.URLDownload
    };

    //region STORAGE
    var _getStorage = function (storage) {
      return localStorageService.get(storage) ? JSON.parse(base64Factory.decode(localStorageService.get(storage))) : {};
    };

    var _setStorage = function (storage, data) {
      localStorageService.set(storage, base64Factory.encode(JSON.stringify(data)));
    };

    var _delStorage = function (storage) {
      localStorageService.remove(storage);
    };

    var _clearStorage = function () {
      localStorageService.keys().map(function (chave) {
        if (chave != base64Factory.encode('auth')) {
          localStorageService.remove(chave);
        }
      });
    };
    //endregion

    //region GEOLOCATION
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

    var _userLocation = function () {
      var posOptions = {
        "timeout": 3000,
        "enableHighAccuracy": false,
        "maximumAge": 75000
      };

      var defer = $q.defer();

      $cordovaGeolocation
        .getCurrentPosition(posOptions)
        .then(function (position) {
          defer.resolve({
                          "lat": position.coords.latitude,
                          "long": position.coords.longitude
                        });

        }, function (err) {
          defer.reject(err);
        });

      return defer.promise;
    };
    //endregion

    var uri = $location.absUrl().replace(/(index\.html.*)/, '');

    var _token = function () {
      var deferred = $q.defer();

      $http.post(urls.auth, $httpParamSerializer(config.accessToken), config.header)
           .then(function (retorno) {
             deferred.resolve(retorno.data);
           }, function (erro) {
             deferred.reject(erro.data);
           });
      return deferred.promise;

    };

    var _get = function (url, header) {

      var deferred = $q.defer();

      var separator = url.indexOf('?') === -1 ? '?' : '&';
      url = url + separator + 'noCache=' + new Date().valueOf();

      if (!header) {
        header = {
          "headers": {
            "Content-Type": "application/json"
          }
        }
      } else {
        header = config.header;
      }

      $http.get(urls.url_s + url, header)
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

      if (!header) {
        header = {
          "headers": {
            "Content-Type": "application/json"
          }
        }
      }
      else {
        header = config.header;
      }

      $http.post(urls.url_s + url, data, header)
           .then(function (retorno) {
             deferred.resolve(retorno.data);
           }, function (erro) {
             deferred.reject(erro.data);
           });
      return deferred.promise;
    };

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

    var _deletar = function (url, id) {
      var deferred = $q.defer();

      url = url.match(/\/$/) ? url : url + '/';

      var separator = url.indexOf('?') === -1 ? '?' : '&';
      url = url + id + separator + 'noCache=' + new Date().valueOf();

      $http.post(urls.url_s + url, {})
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

      $http.get(urls.url_s + url.toString())
           .then(function (retorno) {
             deferred.resolve(retorno.data);
           }, function (erro) {
             deferred.reject(erro.data);
           });
      return deferred.promise;
    };

    var _getAll = function (urls) {
      return $q.all(
        urls
          .map(function (url) {
            return $http.get(urls.url_s + url)
          })
      );
    };

    var _postAll = function (urls, data) {
      return $q.all(
        urls
          .map(function (url, i) {
            return $http.post(urls.url_s + url, data[i]);
          })
      );
    };

    var _connect = function () {
      if (navigator.connection == undefined) {
        return false;
      }

      var networkState = navigator.connection.type;

      return networkState.toUpperCase() != "NONE" && networkState.toUpperCase() != "UNKNOWN";
    }

    var _errorCall = function (erro, msg) {
      console.debug(erro);

      var mensagem = msg && typeof msg == "string" ? msg : 'Parece que ocorreu um erro ao se comunicar com novos serviços, deseja reiniciar?.';

      var confirm = $mdDialog.confirm()
                             .title('Ops!')
                             .textContent(mensagem)
                             .ariaLabel('Erro na chamada')
                             .ok('Sim')
                             .cancel('Não');

      $mdDialog.show(confirm).then(function () {
        if (!msg) {
          $state.reload();
        }

      }, function () {
        if (!msg) {
          navigator.app.exitApp();
        }
      });
    }

    var _customMessage = function (erro, title) {
      title = title ? title : 'Ops!';

      var defer = $q.defer();
      var confirm = $mdDialog.confirm()
                             .title(title)
                             .textContent(erro)
                             .ariaLabel('Erro na chamada')
                             .ok('Ok');

      $mdDialog.show(confirm).then(function (res) {
        defer.resolve(res);
      }, function (err) {
        defer.reject(err);
      });

      return defer.promise;
    }

    var _noInternet = function () {
      $mdDialog.show({
                       controller: 'enderecoModalController',
                       templateUrl: uri + "views/connect/noInternet.html",
                       parent: angular.element(document.body),
                       clickOutsideToClose: false
                     })
               .then(function () {
                 $state.reload();
               });
    }

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
      "token": _token,
      "errorCall": _errorCall,
      "userLocation": _userLocation,
      "connect": _connect,
      "customMessage": _customMessage,
      "noInternet": _noInternet
    }

  }

})();