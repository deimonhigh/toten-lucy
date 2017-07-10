(function (angular) {
  "use strict";
  angular.module('appToten')
         .controller('loginController', loginController);

  loginController.$inject = ['$scope', '$rootScope', 'apiService'];

  function loginController($scope, $rootScope, apiService) {
    var vm = $scope;
    var root = $rootScope;

    vm.login = function (dados) {
      apiService
        .token(dados)
        .then(function (res) {
          if (res.error) {
            alert('Usuário ou senha inválidos.');
            return;
          }
          res.email = dados.user;
          apiService.setStorage('auth', res);
          root.loadConfig(dados.user, true);
        }, function () {
          alert('Usuário ou senha inválidos.')
        });
    };
  }

})
(angular);