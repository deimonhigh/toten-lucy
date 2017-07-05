(function (angular) {
  "use strict";
  angular.module('appToten')
         .controller('loginController', loginController);

  loginController.$inject = ['$scope', '$rootScope', 'apiService', '$state'];

  function loginController($scope, $rootScope, apiService, $state) {
    var vm = $scope;
    var root = $rootScope;

    vm.login = function (dados) {
      apiService
        .token(dados)
        .then(function (res) {
          res.email = dados.user;
          apiService.setStorage('auth', res);
          config(dados.user);
        }, function () {
          alert('Usuário ou senha inválidos.')
        });
    };

    var config = function (email) {
      if (!apiService.getStorage('auth')) {
        config();
        return;
      }

      var dados = {
        "email": email
      };

      apiService
        .post('config', dados)
        .then(function (res) {
          apiService.setStorage('tema', res.result);
          configGeral();
        }, function () {
          configGeral();
        });
    };
    var configGeral = function () {
      var send = {
        id: 1
      };

      apiService
        .post('config', send)
        .then(function (res) {
          var tema = apiService.getStorage('tema');
          if (!tema) {
            tema = {};
          }

          var temaSalvar = res.result;
          temaSalvar.banner = tema ? tema.banner : null;
          temaSalvar.produto_id = tema ? tema.produto_id : null;
          temaSalvar.listaPreco = tema ? tema.listaPreco : null;
          temaSalvar.cor = tema ? tema.cor : null;
          temaSalvar.empresa = tema ? tema.empresa : null;

          apiService.setStorage('tema', temaSalvar);
          root.$broadcast('temaLoaded');
          $state.go('home');
        }, function (err) {
        });

    };
  }

})
(angular);