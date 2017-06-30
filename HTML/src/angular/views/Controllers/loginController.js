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
          tema(dados.user);
        }, function (err) {
          console.log(err);
          alert('Usuário ou senha inválidos.')
        });
    };

    var tema = function (dados) {
      if (!apiService.getStorage('auth')) {
        tema();
        return;
      }
      apiService
        .post('config/' + dados)
        .then(function (res) {
          apiService.setStorage('tema', res.result);
          root.$broadcast('temaLoaded');
          $state.go('home');
        }, function (err) {
          
        });
    };

  }

})
(angular);