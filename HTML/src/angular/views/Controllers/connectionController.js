(function (angular) {
  "use strict";
  angular.module('appGoPharma')
         .controller('connectionController', connectionController);

  connectionController.$inject = ['$scope'];

  function connectionController($scope) {
    var vm = $scope;

    vm.logado = true;

    vm.listagemMenu = [
      {
        "aria": "Perfil e configurações",
        "url": "pesquisas"
      },
      {
        "aria": "Meus benefícios",
        "url": "pesquisas"
      },
      {
        "aria": "Compartilhe",
        "url": "pesquisas"
      },
      {
        "aria": "Fale Conosco",
        "url": "pesquisas"
      },
      {
        "aria": "Avalie-nos na AppStore",
        "url": "pesquisas"
      },
    ]
  }

})(angular);