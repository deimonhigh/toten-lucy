(function (angular) {
  "use strict";
  angular.module('appToten')
         .controller('produtoController', produtoController);

  produtoController.$inject = ['$scope', '$rootScope', 'apiService', '$timeout'];

  function produtoController($scope, $rootScope, apiService, $timeout) {
    var vm = $scope;
    var root = $rootScope;

    vm.qnt = 0;

    vm.minus = function () {
      if (vm.qnt - 1 < 0) {
        vm.qnt = 0;
      } else {
        vm.qnt -= 1;
      }

      if (vm.qnt == 0) {
        vm.removerItem(item);
      }
    };

    vm.more = function () {
      vm.qnt += 1;
    };

    vm.selectColor = function (item) {
      vm.cores.map(function (obj) {
        obj.selected = false;
      });

      item.selected = true;
    }

    vm.cores = [
      {
        "cor": "#EBD800",
        "selected": true
      },
      {
        "cor": "#000000",
        "selected": false
      },
      {
        "cor": "#F1F1F1",
        "selected": false
      }
    ]

  }

})
(angular);