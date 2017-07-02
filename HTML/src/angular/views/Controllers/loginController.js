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

    var config = function (dados) {
      if (!apiService.getStorage('auth')) {
        return;
      }
      apiService
        .get('config/' + dados)
        .then(function (res) {
          apiService.setStorage('tema', res.result);
          root.$broadcast('temaLoaded');
          $state.go('home');
        }, function () {

        });
    };

  }

})
(angular);