(function () {
  "use strict";

  angular.module("appToten").service("mercadoPago", mercadoPago);

  mercadoPago.$inject = ['$window', '$document', '$q', 'apiService'];

  function mercadoPago($window, $document, $q, apiService) {
    var mp = {};

    $window.$MPC_executed = false;
    $window.$MPC = false;
    $window.$MPC_loading = false;
    $window.Mercadopago = {};

    var _loadMP = function () {
      if ($window.$MPC_executed) {
        return $q.resolve($window.$MPC);
      }
      if (!$window.$MPC_loading) {
        $window.$MPC_loading = true;
        var deferred = $q.defer();
        (function () {
          var script = $document[0].createElement('script');
          script.async = true;
          script.src = 'https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js';
          script.onload = function () {
            deferred.resolve($window.Mercadopago);
            mp = $window.Mercadopago;
          };
          var firstScriptFound = $document[0].getElementsByTagName('script')[0];
          firstScriptFound.parentNode.insertBefore(script, firstScriptFound);
        }());
        return mp = deferred.promise;
      }
      return $q.when(mp);
    };

    var _mPago = function () {
      return $window.Mercadopago;
    };

    var _mPagoExist = function () {
      return Object.keys($window.Mercadopago).length > 0;
    };

    var _setAccessKey = function () {
      return apiService.get('config/accessKey').then(function (res) {
        _mPago()
          .setPublishableKey(res.result);
        return $q.when(_mPago());
      });
    };

    var _getIdTypes = function () {
      var defer = $q.defer();

      _mPago()
        .getIdentificationTypes(function (status, response) {
          defer.resolve({
                          'status': status,
                          'response': response
                        });
        });

      return defer.promise;
    };

    var _getBin = function (bin) {
      var defer = $q.defer();

      _mPago()
        .getPaymentMethod(
          {
            "bin": bin.toString().substring(0, 6)
          },
          function (status, response) {
            defer.resolve({
                            'status': status,
                            'response': response
                          });
          });

      return defer.promise;
    };

    var _getInstallments = function (bin, amount) {
      var defer = $q.defer();

      _mPago()
        .getInstallments(
          {
            "bin": bin.toString().substring(0, 6),
            "amount": amount
          },
          function (status, response) {
            defer.resolve({
                            'status': status,
                            'response': response
                          });
          });

      return defer.promise;
    };

    var _getPaymentsMethods = function () {
      var defer = $q.defer();

      _mPago()
        .getAllPaymentMethods(function (status, response) {
          defer.resolve({
                          'status': status,
                          'response': response
                        });
        });

      return defer.promise;
    };

    var _createToken = function (form) {
      var defer = $q.defer();

      _mPago()
        .createToken(form, function (status, response) {
          defer.resolve({
                          'status': status,
                          'response': response
                        });
        });

      return defer.promise;
    };

    return {
      "mp": _mPagoExist,
      "mPago": _mPago,
      "loadMP": _loadMP,
      "setAccessKey": _setAccessKey,
      "getInstallments": _getInstallments,
      "getBin": _getBin,
      "getPaymentsMethods": _getPaymentsMethods,
      "createToken": _createToken,
      "getIdTypes": _getIdTypes
    };

  }

})();